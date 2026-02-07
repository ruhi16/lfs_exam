<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\School;
use App\Models\Session;
use App\Models\Myclass;
use App\Models\MyclassSection;
use App\Models\Studentcr;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Exam05Detail;
use App\Models\Section;
use App\Models\Exam10MarksEntry;

class UserDashboardContainerComp extends Component
{
    public string $active = 'overview';

    // Student self-identification state
    public $sel_session_id = null;
    public $sel_class_id = null;
    public $sel_section_id = null;
    public $sel_roll_no = null;
    public $dob = null; // yyyy-mm-dd
    public $showDobField = false;
    public $studentConfirmed = false;

    protected $queryString = ['active'];

    protected $rules = [
        'sel_session_id' => 'required|integer',
        'sel_class_id' => 'required|integer',
        'sel_section_id' => 'required|integer',
        'sel_roll_no' => 'required|integer',
    ];

    public function setActive(string $tab): void
    {
        $this->active = $tab;
    }

    public function mount(): void
    {
        if (!$this->sel_session_id) {
            $current = Session::currentlyActive()->orderBy('id','desc')->first() ?? Session::orderBy('id','desc')->first();
            if ($current) {
                $this->sel_session_id = $current->id;
            }
        }
    }

    // Step 1: Find candidate without DOB
    public function findCandidate(): void
    {
        $this->validate();
        $this->resetErrorBag('dob');

        $candidate = Studentcr::with('studentdb')
            ->where('session_id', $this->sel_session_id)
            ->where('myclass_id', $this->sel_class_id)
            ->where('section_id', $this->sel_section_id)
            ->where('roll_no', $this->sel_roll_no)
            ->first();

        if (!$candidate) {
            $this->addError('sel_roll_no', 'No student record found for the provided details.');
            $this->showDobField = false;
            return;
        }
        $this->showDobField = true;
    }

    // Teacher request
    public function requestToBeTeacher(): void
    {
        $user = auth()->user();
        if (!$user) return;

        if ($user->is_requested) {
            $this->dispatchBrowserEvent('notify', ['type' => 'info', 'message' => 'You have already requested teacher access.']);
            return;
        }

        $user->is_requested = true;
        $user->save();
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Request submitted to become a teacher.']);
    }

    public function revokeTeachership(): void
    {
        $user = auth()->user();
        if (!$user) return;
        if (!$user->is_requested) return;
        $user->is_requested = false;
        $user->teacher_id = 0;
        
        $user->save();
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Teacher request revoked.']);
    }

    // Student self identification
    public function confirmStudent(): void
    {
        $this->validate(array_merge($this->rules, ['dob' => 'required|date']));

        // Find studentcr by selected session, class, section, roll
        $studentcr = Studentcr::where('session_id', $this->sel_session_id)
            ->where('myclass_id', $this->sel_class_id)
            ->where('section_id', $this->sel_section_id)
            ->where('roll_no', $this->sel_roll_no)
            ->first();

        if (!$studentcr) {
            $this->addError('sel_roll_no', 'No student record found for the provided details.');
            return;
        }

        $studentdb = $studentcr->studentdb;
        if (!$studentdb || !$studentdb->dob) {
            $this->addError('dob', 'Student date of birth is not available for verification.');
            return;
        }

        if ($studentdb->dob !== $this->dob) {
            $this->addError('dob', 'Date of birth does not match our records.');
            return;
        }

        // Link user with studentdb and set role as student (1)
        $user = auth()->user();
        if ($user) {
            $user->studentdb_id = $studentdb->id;
            $user->role_id = 1; // student
            $user->teacher_id = -99;
            $user->save();
        }

        $this->studentConfirmed = true;
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Student identity confirmed and account linked.']);
    }

    // Revoke studentship
    public function revokeStudentship(): void
    {
        $user = auth()->user();
        if (!$user) return;
        $user->role_id = 0;
        $user->studentdb_id = 0;
        $user->save();
        $this->studentConfirmed = false;
        $this->dispatchBrowserEvent('notify', ['type' => 'success', 'message' => 'Studentship revoked.']);
    }

    public function getStats()
    {
        return [
            'schools' => School::count(),
            'sessions' => Session::count(),
            'classes' => Myclass::count(),
            'sections' => MyclassSection::count(),
            'students' => Studentcr::count(),
            'subjects' => Subject::count(),
            'teachers' => Teacher::count(),
            'exam_details' => Exam05Detail::count(),
        ];
    }

    public function render()
    {
        $stats = $this->getStats();

        $recent = [
            'schools' => School::latest('id')->take(5)->get(),
            'sessions' => Session::latest('id')->take(5)->get(),
            'classes' => Myclass::latest('id')->take(5)->get(),
            'sections' => MyclassSection::latest('id')->take(5)->get(),
            'students' => Studentcr::latest('id')->take(5)->get(),
            'subjects' => Subject::latest('id')->take(5)->get(),
            'teachers' => Teacher::latest('id')->take(5)->get(),
            'exam_details' => Exam05Detail::latest('id')->take(5)->get(),
        ];

        // Build candidate preview if selection filled
        $candidate = null;
        if ($this->sel_session_id && $this->sel_class_id && $this->sel_section_id && $this->sel_roll_no) {
            $candidate = Studentcr::with('studentdb')
                ->where('session_id', $this->sel_session_id)
                ->where('myclass_id', $this->sel_class_id)
                ->where('section_id', $this->sel_section_id)
                ->where('roll_no', $this->sel_roll_no)
                ->first();
        }

        // Student dashboard data if user is a student
        $isStudent = optional(auth()->user())->role_id == 1;
        $studentDb = null;
        $studentCr = null;
        $studentMarks = collect();
        $classOverall = collect();
        if ($isStudent && optional(auth()->user())->studentdb_id) {
            $studentDb = auth()->user()->studentdb;
            $presentSessionId = $this->sel_session_id ?: (optional(Session::currentlyActive()->orderBy('id','desc')->first())->id ?? null);
            if ($studentDb) {
                $studentCr = Studentcr::where('studentdb_id', $studentDb->id)
                    ->when($presentSessionId, function($q) use ($presentSessionId) { $q->where('session_id', $presentSessionId); })
                    ->orderBy('id','desc')
                    ->first();
                if (!$studentCr) {
                    $studentCr = Studentcr::where('studentdb_id', $studentDb->id)->orderBy('id','desc')->first();
                }
                if ($studentCr) {
                    $studentMarks = Exam10MarksEntry::with(['examDetail','examClassSubject','grade'])
                        ->where('studentcr_id', $studentCr->id)
                        ->orderBy('exam_detail_id')
                        ->get();

                    $classOverall = Exam10MarksEntry::selectRaw('studentcr_id, SUM(CASE WHEN exam_marks >= 0 THEN exam_marks ELSE 0 END) as total_marks, COUNT(*) as exams_count')
                        ->where('session_id', $studentCr->session_id)
                        ->whereHas('studentcr', function($q) use ($studentCr) {
                            $q->where('myclass_id', $studentCr->myclass_id)
                              ->where('section_id', $studentCr->section_id);
                        })
                        ->groupBy('studentcr_id')
                        ->orderByDesc('total_marks')
                        ->get();
                }
            }
        }

        return view('livewire.user-dashboard-container-comp', [
            'active' => $this->active,
            'stats' => $stats,
            'recent' => $recent,
            // Dropdown data for forms
            'sessions' => Session::orderBy('id','desc')->get(['id','name']),
            'classes' => Myclass::orderBy('id','asc')->get(['id','name']),
            'sections' => Section::orderBy('id','asc')->get(['id','name']),
            'candidate' => $candidate,
            'alreadyLinked' => (bool) optional(auth()->user())->studentdb_id,
            'alreadyRequested' => (bool) optional(auth()->user())->is_requested,
            'isStudent' => $isStudent,
            'isTeacherRequestActive' => (bool) optional(auth()->user())->is_requested,
            'studentdb' => $studentDb,
            'studentcr' => $studentCr,
            'studentMarks' => $studentMarks,
            'classOverall' => $classOverall,
        ]);
    }
}
