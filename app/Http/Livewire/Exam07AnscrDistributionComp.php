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
            'examDetail'
        ])->get();
        
        // Load existing distributions
        $this->existingDistributions = Exam07AnsscrDist::with([
            'myclassSection.section',
            'examDetail.examName',
            'examDetail.examType',
            'examDetail.examPart',
            'teacher.user',
            'session'
        ])->get();
    }
    
    public function initializeFormData()
    {
        // Initialize form data structure and load existing records
        $existingRecords = Exam07AnsscrDist::with([
            'myclassSection', 
            'examClassSubject', 
            'teacher'
        ])->get();
        
        foreach ($existingRecords as $record) {
            $key = $record->myclass_section_id . '_' . $record->exam_class_subject_id;
            $this->formData[$key] = [
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
            ->whereHas('subject', function($query) use ($summativeType) {
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
            ->whereHas('subject', function($query) use ($formativeType) {
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
            ->get()
            ->groupBy('exam_name_id');
    }
    
    public function getExamDetailsForClassAndSubjectType($classId, $subjectTypeName)
    {
        $query = Exam05Detail::where('myclass_id', $classId);
        
        if (strtolower($subjectTypeName) === 'summative') {
            $query->whereHas('examType', function($q) {
                $q->where('name', 'like', '%Summative%');
            });
        } elseif (strtolower($subjectTypeName) === 'formative') {
            $query->whereHas('examType', function($q) {
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
    
    public function getExamClassSubjectsForSubject($subjectId)
    {
        return Exam06ClassSubject::where('subject_id', $subjectId)
            ->with(['myclass', 'subject', 'examDetail'])
            ->get();
    }
    
    public function getExistingDistribution($myclassSectionId, $examDetailId)
    {
        return Exam07AnsscrDist::where('myclass_section_id', $myclassSectionId)
            ->where('exam_detail_id', $examDetailId)
            ->first();
    }
    
    public function getFormDataValue($myclassSectionId, $examDetailId, $field)
    {
        $key = $myclassSectionId . '_' . $examDetailId;
        $record = $this->getExistingDistribution($myclassSectionId, $examDetailId);
        
        if ($record && isset($this->formData[$key][$field])) {
            return $this->formData[$key][$field];
        } elseif ($record) {
            return $record->$field;
        } elseif (isset($this->formData[$key][$field])) {
            return $this->formData[$key][$field];
        }
        
        return '';
    }
    
    public function saveDistribution($myclassSectionId, $examDetailId)
    {
        $key = $myclassSectionId . '_' . $examDetailId;
        $data = $this->formData[$key] ?? [];
        
        // Validate required fields
        if (empty($data['teacher_id'])) {
            session()->flash('error', 'Teacher selection is required.');
            return;
        }
        
        $record = Exam07AnsscrDist::updateOrCreate(
            [
                'myclass_section_id' => $myclassSectionId,
                'exam_detail_id' => $examDetailId
            ],
            [
                'teacher_id' => $data['teacher_id'],
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
            ]
        );
        
        session()->flash('message', 'Distribution saved successfully.');
        $this->emit('refreshComponent');
    }
    
    public function editDistribution($id)
    {
        $record = Exam07AnsscrDist::findOrFail($id);
        $this->editingId = $id;
        
        $key = $record->myclass_section_id . '_' . $record->exam_detail_id;
        $this->formData[$key] = [
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
    
    public function updateDistribution()
    {
        if (!$this->editingId) return;
        
        $record = Exam07AnsscrDist::findOrFail($this->editingId);
        $key = $record->myclass_section_id . '_' . $record->exam_detail_id;
        $data = $this->formData[$key] ?? [];
        
        $record->update([
            'teacher_id' => $data['teacher_id'],
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
        
        $this->editingId = null;
        session()->flash('message', 'Distribution updated successfully.');
        $this->emit('refreshComponent');
    }
    
    public function deleteDistribution($id)
    {
        Exam07AnsscrDist::findOrFail($id)->delete();
        session()->flash('message', 'Distribution deleted successfully.');
        $this->emit('refreshComponent');
    }
    
    public function cancelEdit()
    {
        $this->editingId = null;
    }
    
    public function toggleEditEnable()
    {
        $this->isEditingEnabled = !$this->isEditingEnabled;
    }
    
    public function render()
    {
        // Load subjects for the active class
        $activeClass = $this->classes[$this->activeTab] ?? null;
        
        if ($activeClass) {
            $this->summativeSubjects = $this->getSummativeSubjects($activeClass->id);
            $this->formativeSubjects = $this->getFormativeSubjects($activeClass->id);
        }
        
        return view('livewire.exam07-anscr-distribution-comp', [
            'classes' => $this->classes,
            'sections' => $this->sections,
            'summativeSubjects' => $this->summativeSubjects,
            'formativeSubjects' => $this->formativeSubjects,
            'teachers' => $this->teachers,
            'examClassSubjects' => $this->examClassSubjects,
            'sessions' => $this->sessions,
            'schools' => $this->schools,
            'users' => $this->users,
            'subjectTypes' => $this->subjectTypes,
            'examNames' => $this->examNames,
            'examTypes' => $this->examTypes,
            'examParts' => $this->examParts
        ]);
    }
}