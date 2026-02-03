<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Exam07AnsscrDist;
use App\Models\Myclass;
use App\Models\MyclassSection;
use App\Models\MyclassSubject;
use App\Models\SubjectType;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\Exam06ClassSubject;
use App\Models\Session;
use App\Models\School;
use App\Models\User;
use App\Models\Exam05Detail;
use App\Models\Exam01Name;
use App\Models\Exam02Type;
use App\Models\Exam03Part;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;

class Exam07AnscrDistributionComp extends Component
{
    public $activeTab = 0;
    public $classes;
    public $sections;
    public $summativeSubjects;
    public $formativeSubjects;
    public $teachers;
    public $examClassSubjects;
    public $existingDistributions;
    public $examNames;
    public $examTypes;
    public $examParts;
    public $sessions;
    public $schools;
    public $users;
    public $subjectTypes;

    // Form data
    public $formData = [];
    public $editingId = null;
    public $isEditingEnabled = false;

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->loadData();
        $this->initializeFormData();
    }

    public function loadData()
    {
        // Load classes as Eloquent Collection (objects)
        $this->classes = Myclass::orderBy('name')->get();
        $this->sections = MyclassSection::with(['section', 'myclass'])->orderBy('myclass_id')->get();
        $this->subjectTypes = SubjectType::orderBy('name')->get();
        $this->examNames = Exam01Name::orderBy('name')->get();
        $this->examTypes = Exam02Type::orderBy('name')->get();
        $this->examParts = Exam03Part::orderBy('name')->get();
        $this->sessions = Session::orderBy('name')->get();
        $this->schools = School::orderBy('name')->get();
        $this->users = User::orderBy('name')->get();
        $this->teachers = Teacher::with('user')->orderBy('id')->get();

        // Load existing answer script distributions
        $this->examClassSubjects = Exam06ClassSubject::with([
            'myclass',
            'subject',
            'examDetail.examName',
            'examDetail.examType',
            'examDetail.examPart',
            'examDetail.examMode'
        ])->get();

        // Load existing distributions
        $this->existingDistributions = Exam07AnsscrDist::with([
            'myclassSection.section',
            'examClassSubject.myclass',
            'examClassSubject.subject',
            'examClassSubject.examDetail',
            'teacher.user',
            'session'
        ])->get();

        Log::info('Data loaded', [
            'classes_count' => $this->classes->count(),
            'examClassSubjects_count' => $this->examClassSubjects->count(),
            'existingDistributions_count' => $this->existingDistributions->count()
        ]);
    }

    public function initializeFormData()
    {
        // Initialize form data structure with existing records
        foreach ($this->existingDistributions as $record) {
            $examClassSubject = $record->examClassSubject;
            if ($examClassSubject && $record->myclassSection) {
                $cellKey = $record->myclass_section_id . '_' . $examClassSubject->id . '_' . $examClassSubject->exam_detail_id;
                $this->formData[$cellKey] = [
                    'teacher_id' => $record->teacher_id,
                    'order_index' => $record->order_index,
                    'is_optional' => $record->is_optional,
                    'session_id' => $record->session_id,
                    'school_id' => $record->school_id,
                    'user_id' => $record->user_id,
                    'approved_by' => $record->approved_by,
                    'is_active' => $record->is_active,
                    'is_finalized' => $record->is_finalized,
                    'status' => $record->status,
                    'remarks' => $record->remarks
                ];
            }
        }
    }

    public function setActiveTab($index)
    {
        $this->activeTab = $index;
    }

    public function getClassSections($classId)
    {
        return MyclassSection::where('myclass_id', $classId)
            ->with(['section'])
            ->orderBy('section_id')
            ->get();
    }

    public function getSummativeSubjects($classId)
    {
        // Get Summative subject type (assuming ID 2 based on database)
        $summativeType = SubjectType::where('name', 'Summative')->first();

        if (!$summativeType) {
            return collect();
        }

        return MyclassSubject::where('myclass_id', $classId)
            ->whereHas('subject', function ($query) use ($summativeType) {
                $query->where('subject_type_id', $summativeType->id);
            })
            ->with(['subject', 'myclass'])
            ->orderBy('subject_id')
            ->get();
    }

    public function getFormativeSubjects($classId)
    {
        // Get Formative subject type
        $formativeType = SubjectType::where('name', 'Formative')->first();

        if (!$formativeType) {
            return collect();
        }

        return MyclassSubject::where('myclass_id', $classId)
            ->whereHas('subject', function ($query) use ($formativeType) {
                $query->where('subject_type_id', $formativeType->id);
            })
            ->with(['subject', 'myclass'])
            ->orderBy('subject_id')
            ->get();
    }

    public function getExamDetailsForClass($classId)
    {
        return Exam05Detail::where('myclass_id', $classId)
            ->with(['examName', 'examType', 'examPart', 'examMode'])
            ->orderBy('exam_name_id')
            ->orderBy('exam_type_id')
            ->orderBy('exam_part_id')
            ->get();
    }

    public function getExamDetailsForClassAndSubjectType($classId, $subjectTypeName)
    {
        $query = Exam05Detail::where('myclass_id', $classId);

        if (strtolower($subjectTypeName) === 'summative') {
            $query->whereHas('examType', function ($q) {
                $q->where('name', 'like', '%Summative%');
            });
        } elseif (strtolower($subjectTypeName) === 'formative') {
            $query->whereHas('examType', function ($q) {
                $q->where('name', 'like', '%Formative%');
            });
        }

        return $query->with(['examName', 'examType', 'examPart', 'examMode'])
            ->orderBy('exam_name_id')
            ->orderBy('exam_type_id')
            ->orderBy('exam_part_id')
            ->get()
            ->groupBy('exam_name_id');
    }

    public function saveDistribution($myclassSectionId, $examDetailId, $examClassSubjectId)
    {
        Log::info('=== SAVE DISTRIBUTION DEBUG ===', [
            'myclassSectionId' => $myclassSectionId,
            'examDetailId' => $examDetailId,
            'examClassSubjectId' => $examClassSubjectId,
            'full_formData' => $this->formData,
            'formData_keys' => array_keys($this->formData)
        ]);

        // Find the corresponding exam_class_subject_id
        $examClassSubject = Exam06ClassSubject::find($examClassSubjectId);

        if (!$examClassSubject) {
            session()->flash('error', 'No exam class subject found for this exam detail.');
            return;
        }

        Log::info('Found examClassSubject', [
            'id' => $examClassSubject->id,
            'subject_id' => $examClassSubject->subject_id,
            'myclass_id' => $examClassSubject->myclass_id,
            'exam_detail_id' => $examClassSubject->exam_detail_id
        ]);

        $examClassSubjectId = $examClassSubject->id;

        // Create cell key using section_id + examClassSubject->id + examDetailId
        $cellKey = $myclassSectionId . '_' . $examClassSubject->id . '_' . $examDetailId;

        Log::info('Cell key calculation', [
            'cellKey' => $cellKey,
            'myclassSectionId' => $myclassSectionId,
            'examClassSubjectId' => $examClassSubject->id,
            'examDetailId' => $examDetailId
        ]);

        $data = $this->formData[$cellKey] ?? [];

        Log::info('Form data for cell', [
            'cellKey' => $cellKey,
            'data' => $data,
            'teacher_id_raw' => $data['teacher_id'] ?? 'NOT SET',
            'teacher_id_type' => gettype($data['teacher_id'] ?? null),
            'all_form_data_keys' => array_keys($this->formData)
        ]);

        // Validate required fields
        $teacherId = $data['teacher_id'] ?? null;

        Log::info('Teacher validation check', [
            'teacherId' => $teacherId,
            'isNull' => $teacherId === null,
            'isEmptyString' => $teacherId === '',
            'isZeroString' => $teacherId === '0',
            'isZeroInt' => $teacherId === 0,
            'isNotNumeric' => !is_numeric($teacherId),
            'willFail' => ($teacherId === null || $teacherId === '' || $teacherId === '0' || $teacherId === 0 || !is_numeric($teacherId))
        ]);

        if ($teacherId === null || $teacherId === '' || $teacherId === '0' || $teacherId === 0 || !is_numeric($teacherId)) {
            Log::warning('Teacher validation FAILED', [
                'teacherId' => $teacherId,
                'type' => gettype($teacherId),
                'cellKey' => $cellKey,
                'availableFormDataKeys' => array_keys($this->formData)
            ]);

            session()->flash('error', 'Please select a valid teacher from the dropdown before saving. (Debug: teacher_id=' . var_export($teacherId, true) . ')');
            return;
        }

        // Convert to integer for database storage
        $teacherId = (int) $teacherId;

        try {
            // Check if record already exists for this specific combination
            $existingRecord = Exam07AnsscrDist::where('myclass_section_id', $myclassSectionId)
                ->where('exam_class_subject_id', $examClassSubjectId)
                ->first();

            if ($existingRecord) {
                // Update existing record
                $existingRecord->update([
                    'teacher_id' => $teacherId,
                    'order_index' => $data['order_index'] ?? 0,
                    'is_optional' => $data['is_optional'] ?? false,
                    'session_id' => $data['session_id'] ?? null,
                    'school_id' => $data['school_id'] ?? null,
                    'user_id' => $data['user_id'] ?? null,
                    'approved_by' => $data['approved_by'] ?? null,
                    'is_active' => $data['is_active'] ?? true,
                    'is_finalized' => $data['is_finalized'] ?? false,
                    'status' => $data['status'] ?? 'active',
                    'remarks' => $data['remarks'] ?? ''
                ]);

                session()->flash('message', 'Distribution updated successfully.');
            } else {
                // Create new record
                $name = 'Dist-' . $myclassSectionId . '-' . $examClassSubjectId . '-' . $examDetailId;
                Exam07AnsscrDist::create([
                    'name' => $name,
                    'myclass_section_id' => $myclassSectionId,
                    'exam_class_subject_id' => $examClassSubjectId,
                    'exam_detail_id' => $examDetailId,
                    'teacher_id' => $teacherId,
                    'order_index' => $data['order_index'] ?? 0,
                    'is_optional' => $data['is_optional'] ?? false,
                    'session_id' => $data['session_id'] ?? null,
                    'school_id' => $data['school_id'] ?? null,
                    'user_id' => $data['user_id'] ?? null,
                    'approved_by' => $data['approved_by'] ?? null,
                    'is_active' => $data['is_active'] ?? true,
                    'is_finalized' => $data['is_finalized'] ?? false,
                    'status' => $data['status'] ?? 'active',
                    'remarks' => $data['remarks'] ?? ''
                ]);

                session()->flash('message', 'Distribution created successfully.');
            }

            // Refresh the existing distributions to show updated data
            $this->existingDistributions = Exam07AnsscrDist::with([
                'myclassSection.section',
                'examClassSubject',
                'teacher.user',
                'session'
            ])->get();

            $this->initializeFormData();

            $this->emit('refreshComponent');
        } catch (\Exception $e) {
            Log::error('Save Distribution Error', ['exception' => $e->getMessage()]);
            session()->flash('error', 'Failed to save distribution: ' . $e->getMessage());
        }
    }

    public function toggleEditEnable()
    {
        $this->isEditingEnabled = !$this->isEditingEnabled;
    }

    public function getSubjects($classId)
    {
        return MyclassSubject::where('myclass_id', $classId)
            ->with(['subject', 'myclass'])
            ->get()
            ->sortByDesc(function ($subject) {
                return $subject->subject->subject_type_id ?? 0;
            });
    }

    public function render()
    {
        // Load subjects for the active class
        $activeClass = $this->classes[$this->activeTab] ?? null;
        $classSubjects = collect();
        $examDetails = collect();

        if ($activeClass && $activeClass instanceof Myclass) {
            $classSubjects = $this->getSubjects($activeClass->id);
            $examDetails = $this->getExamDetailsForClass($activeClass->id);
        }

        return view('livewire.exam07-anscr-distribution-comp', [
            'classes' => $this->classes,
            'sections' => $this->sections,
            'classSubjects' => $classSubjects,
            'teachers' => $this->teachers,
            'examClassSubjects' => $this->examClassSubjects,
            'sessions' => $this->sessions,
            'schools' => $this->schools,
            'users' => $this->users,
            'subjectTypes' => $this->subjectTypes,
            'examNames' => $this->examNames,
            'examTypes' => $this->examTypes,
            'examParts' => $this->examParts,
            'existingDistributions' => $this->existingDistributions,
            'examDetails' => $examDetails
        ]);
    }
}
