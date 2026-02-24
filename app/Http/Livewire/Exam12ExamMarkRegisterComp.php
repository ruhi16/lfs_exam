<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MyclassSection;
use App\Models\Myclass;
use App\Models\Section;
use App\Models\Studentcr;
use App\Models\Exam05Detail;
use App\Models\Exam01Name;
use App\Models\Exam03Part;
use App\Models\Exam06ClassSubject;
use App\Models\Exam10MarksEntry;
use App\Models\MyclassSubject;


class Exam12ExamMarkRegisterComp extends Component
{
    public $activeTab = 0;
    public $classes;
    public $sections; // All sections for all classes, or active class? Loading all for now as per original
    public $students; // All students for active class
    public $examDetailsGrouped = [];
    public $classSubjects = []; // Subjects for the active class
    public $examClassSubjectMap = []; // Map [exam_detail_id][subject_id] -> Exam06ClassSubject
    public $marksData = [];
    public $isEditing = false;

    public function mount()
    {
        $this->loadClasses();
        // Initial load for the first class if available
        if ($this->classes && $this->classes->count() > 0) {
            $this->loadClassData($this->classes[0]->id);
        }
    }

    public function loadClasses()
    {
        $this->classes = Myclass::orderBy('name')->get();
    }

    public function setActiveTab($index)
    {
        $this->activeTab = $index;
        $this->isEditing = false;
        if (isset($this->classes[$index])) {
            $this->loadClassData($this->classes[$index]->id);
        }
    }

    public function loadClassData($classId)
    {
        // 1. Load Sections for this class
        $this->sections = MyclassSection::where('myclass_id', $classId)
            ->with('section')
            ->orderBy('section_id')
            ->get();

        // 2. Load Students for this class
        // Optimization: Select specific columns if needed, but eager loading relations is key
        $this->students = Studentcr::where('myclass_id', $classId)
            ->with(['studentdb', 'section']) // Added section to help grouping in view
            ->orderBy('section_id')
            ->orderBy('roll_no')
            ->get();

        // 3. Load Subjects for this class
        $this->classSubjects = MyclassSubject::where('myclass_id', $classId)
            ->with(['subject.subjectType'])
            ->get()
            ->sortByDesc(function ($ms) {
                return $ms->subject->subject_type_id ?? 0;
            });

        // 4. Load Exam Details
        $examDetails = Exam05Detail::where('myclass_id', $classId)
            ->with(['examName', 'examPart', 'examType'])
            ->orderBy('exam_name_id')
            ->orderBy('exam_part_id')
            ->get();

        // Group exam details
        $this->examDetailsGrouped = [];
        foreach ($examDetails as $detail) {
            $this->examDetailsGrouped[$detail->exam_name_id][$detail->exam_part_id][] = $detail;
        }

        // 5. Load Exam Class Subjects (The mapping/pivot)
        // We need this to know valid combinations and full marks
        $ecs = Exam06ClassSubject::where('myclass_id', $classId)->get();
        $this->examClassSubjectMap = [];
        foreach ($ecs as $item) {
            $this->examClassSubjectMap[$item->exam_detail_id][$item->subject_id] = [
                'id' => $item->id,
                'full_marks' => $item->full_marks,
                'pass_marks' => $item->pass_marks
            ];
        }

        // 6. Load Marks
        $this->loadMarksData($classId);
    }

    public function loadMarksData($classId)
    {
        $this->marksData = [];

        // Fetch all marks for this class in one query
        // We can filter by myclass_section_id which are in this class
        $sectionIds = $this->sections->pluck('id');

        $marksEntries = Exam10MarksEntry::whereIn('myclass_section_id', $sectionIds)
            ->get();

        // Map marks to a key: student_id_exam_detail_id_exam_class_subject_id
        foreach ($marksEntries as $entry) {
            // Include exam_detail_id for explicit verification as requested
            $key = $entry->studentcr_id . '_' . $entry->exam_detail_id . '_' . $entry->exam_class_subject_id;
            $this->marksData[$key] = [
                'exam_marks' => $entry->exam_marks == -99 ? null : $entry->exam_marks,
                'is_absent' => $entry->exam_marks == -99 || $entry->is_absent,
            ];
        }
    }

    public function updateMarks()
    {
        // Enable editing mode
        // We might need to initialize empty slots for wire:model binding
        // But Livewire handles nested array binding even if key doesn't exist (it creates it)
        // However, to display empty inputs properly, the view logic handles the existence check.
        $this->isEditing = true;
    }

    public function cancelEdit()
    {
        $this->isEditing = false;
        // Reload data to discard changes
        if (isset($this->classes[$this->activeTab])) {
            $this->loadMarksData($this->classes[$this->activeTab]->id);
        }
    }

    public function saveMarks()
    {
        $savedCount = 0;
        $errorCount = 0;

        // Iterate through the bound marksData
        foreach ($this->marksData as $key => $data) {
            // Key format: {student_id}_{exam_detail_id}_{exam_class_subject_id}
            $parts = explode('_', $key);
            if (count($parts) != 3) continue;

            $studentId = $parts[0];
            $examDetailId = $parts[1];
            $examClassSubjectId = $parts[2];

            if (!isset($data['is_absent'])) $data['is_absent'] = false;

            // Skip empty entries that were never touched (null marks, not absent)
            if (($data['exam_marks'] === null || $data['exam_marks'] === '') && !$data['is_absent']) {
                continue;
            }

            try {
                $student = $this->students->where('id', $studentId)->first();
                if (!$student) continue;

                $myclassSection = $this->sections->where('section_id', $student->section_id)->first();
                if (!$myclassSection) continue;

                Exam10MarksEntry::updateOrCreate(
                    [
                        'myclass_section_id' => $myclassSection->id,
                        'exam_detail_id' => $examDetailId,
                        'studentcr_id' => $studentId,
                        'exam_class_subject_id' => $examClassSubjectId
                    ],
                    [
                        'exam_marks' => $data['is_absent'] ? -99 : $data['exam_marks'],
                        'is_absent' => $data['is_absent'],
                        'session_id' => session('session_id') ?? 1,
                        'user_id' => auth()->id() ?? 1,
                        'is_active' => true,
                        'status' => 'active'
                    ]
                );
                $savedCount++;
            } catch (\Exception $e) {
                $errorCount++;
            }
        }

        if ($savedCount > 0) {
            session()->flash('message', "{$savedCount} marks saved successfully.");
        }

        $this->isEditing = false;

        // Reload to ensure fresh state
        if (isset($this->classes[$this->activeTab])) {
            $this->loadMarksData($this->classes[$this->activeTab]->id);
        }
    }

    public function generatePdf()
    {
        $activeClass = isset($this->classes[$this->activeTab]) ? $this->classes[$this->activeTab] : null;

        if (!$activeClass) {
            session()->flash('error', 'No class selected for PDF generation.');
            return;
        }

        $data = [
            'activeClass' => $activeClass,
            'sections' => $this->sections,
            'students' => $this->students,
            'examDetailsGrouped' => $this->examDetailsGrouped,
            'classSubjects' => $this->classSubjects,
            'examClassSubjectMap' => $this->examClassSubjectMap,
            'marksData' => $this->marksData,
        ];

        $pdf = \PDF::loadView('exports.exam12-pdf', $data, [], [
            'orientation' => 'L'
        ]);

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->output();
        }, 'exam-marks-' . \Illuminate\Support\Str::slug($activeClass->name) . '.pdf');
    }

    public function render()
    {
        return view('livewire.exam12-exam-mark-register-comp', [
            'activeClass' => isset($this->classes[$this->activeTab]) ? $this->classes[$this->activeTab] : null
        ]);
    }
}
