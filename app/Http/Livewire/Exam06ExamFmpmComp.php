<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Exam06ClassSubject;
use App\Models\MyclassSubject;
use App\Models\Exam05Detail;
use App\Models\Myclass;
use App\Models\Subject;
use App\Models\Exam01Name;
use App\Models\Exam02Type;
use App\Models\Exam03Part;
use App\Models\Session;
use App\Models\School;
use App\Models\User;
use App\Models\SubjectType;

class Exam06ExamFmpmComp extends Component
{
    public $activeTab = 0;
    public $classes;
    public $subjects;
    public $subjectTypes;
    public $examDetails;
    public $examNames;
    public $examTypes;
    public $examParts;
    public $sessions;
    public $schools;
    public $users;
    
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
        $this->subjects = Subject::orderBy('name')->get();
        $this->subjectTypes = SubjectType::orderBy('name')->get();
        $this->examNames = Exam01Name::orderBy('name')->get();
        $this->examTypes = Exam02Type::orderBy('name')->get();
        $this->examParts = Exam03Part::orderBy('name')->get();
        $this->sessions = Session::orderBy('name')->get();
        $this->schools = School::orderBy('name')->get();
        $this->users = User::orderBy('name')->get();
        
        // Load existing exam class subjects
        $this->examDetails = Exam06ClassSubject::with([
            'myclass', 
            'subject', 
            'examDetail.examName', 
            'examDetail.examType', 
            'examDetail.examPart'
        ])->get();
    }
    
    public function initializeFormData()
    {
        // Initialize form data structure and load existing records
        $existingRecords = Exam06ClassSubject::with(['myclass', 'subject', 'examDetail'])->get();
        
        foreach ($existingRecords as $record) {
            $key = $record->myclass_id . '_' . $record->subject_id . '_' . $record->exam_detail_id;
            $this->formData[$key] = [
                'full_marks' => $record->full_marks,
                'pass_marks' => $record->pass_marks,
                'time_in_minutes' => $record->time_in_minutes,
                'is_additional' => $record->is_additional,
                'is_combined' => $record->is_combined,
                'is_optional' => $record->is_optional,
                'exam_weightage' => $record->exam_weightage,
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
    
    public function getClassSubjects($classId)
    {
        return MyclassSubject::where('myclass_id', $classId)
            ->with(['subject', 'myclass'])
            ->orderBy('subject_id')
            ->get();
    }
    
    public function getClassSubjectsGroupedByType($classId)
    {
        $classSubjects = MyclassSubject::where('myclass_id', $classId)
            ->with(['subject.subjectType', 'myclass'])
            ->get();
        
        // Group by subject type
        $grouped = $classSubjects->groupBy(function ($item) {
            return $item->subject->subject_type_id;
        });
        
        return $grouped;
    }
    
    public function getExamDetailsForClass($classId)
    {
        return Exam05Detail::where('myclass_id', $classId)
            ->with(['examName', 'examType', 'examPart'])
            ->orderBy('exam_name_id')
            ->orderBy('exam_type_id')
            ->orderBy('exam_part_id')
            ->get()
            ->groupBy('exam_name_id');
    }
    
    public function getExistingRecord($classId, $subjectId, $examDetailId)
    {
        return Exam06ClassSubject::where('myclass_id', $classId)
            ->where('subject_id', $subjectId)
            ->where('exam_detail_id', $examDetailId)
            ->first();
    }
    
    public function getFormDataValue($classId, $subjectId, $examDetailId, $field)
    {
        $key = $classId . '_' . $subjectId . '_' . $examDetailId;
        $record = $this->getExistingRecord($classId, $subjectId, $examDetailId);
        
        if ($record && isset($this->formData[$key][$field])) {
            return $this->formData[$key][$field];
        } elseif ($record) {
            return $record->$field;
        } elseif (isset($this->formData[$key][$field])) {
            return $this->formData[$key][$field];
        }
        
        return '';
    }
    
    public function saveRecord($classId, $subjectId, $examDetailId)
    {
        $key = $classId . '_' . $subjectId . '_' . $examDetailId;
        $data = $this->formData[$key] ?? [];
        
        // Validate required fields
        if (empty($data['full_marks']) || empty($data['pass_marks'])) {
            session()->flash('error', 'Full marks and pass marks are required.');
            return;
        }
        
        $record = Exam06ClassSubject::updateOrCreate(
            [
                'myclass_id' => $classId,
                'subject_id' => $subjectId,
                'exam_detail_id' => $examDetailId
            ],
            [
                'full_marks' => $data['full_marks'],
                'pass_marks' => $data['pass_marks'],
                'time_in_minutes' => $data['time_in_minutes'] ?? 0,
                'is_additional' => $data['is_additional'] ?? false,
                'is_combined' => $data['is_combined'] ?? false,
                'is_optional' => $data['is_optional'] ?? false,
                'exam_weightage' => $data['exam_weightage'] ?? 0,
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
        
        session()->flash('message', 'Record saved successfully.');
        $this->emit('refreshComponent');
    }
    
    public function editRecord($id)
    {
        $record = Exam06ClassSubject::findOrFail($id);
        $this->editingId = $id;
        
        $key = $record->myclass_id . '_' . $record->subject_id . '_' . $record->exam_detail_id;
        $this->formData[$key] = [
            'full_marks' => $record->full_marks,
            'pass_marks' => $record->pass_marks,
            'time_in_minutes' => $record->time_in_minutes,
            'is_additional' => $record->is_additional,
            'is_combined' => $record->is_combined,
            'is_optional' => $record->is_optional,
            'exam_weightage' => $record->exam_weightage,
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
    
    public function updateRecord()
    {
        if (!$this->editingId) return;
        
        $record = Exam06ClassSubject::findOrFail($this->editingId);
        $key = $record->myclass_id . '_' . $record->subject_id . '_' . $record->exam_detail_id;
        $data = $this->formData[$key] ?? [];
        
        $record->update([
            'full_marks' => $data['full_marks'],
            'pass_marks' => $data['pass_marks'],
            'time_in_minutes' => $data['time_in_minutes'] ?? 0,
            'is_additional' => $data['is_additional'] ?? false,
            'is_combined' => $data['is_combined'] ?? false,
            'is_optional' => $data['is_optional'] ?? false,
            'exam_weightage' => $data['exam_weightage'] ?? 0,
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
        session()->flash('message', 'Record updated successfully.');
        $this->emit('refreshComponent');
    }
    
    public function deleteRecord($id)
    {
        Exam06ClassSubject::findOrFail($id)->delete();
        session()->flash('message', 'Record deleted successfully.');
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
        return view('livewire.exam06-exam-fmpm-comp', [
            'classes' => $this->classes,
            'subjects' => $this->subjects,
            'subjectTypes' => $this->subjectTypes,
            'examDetails' => $this->examDetails,
            'examNames' => $this->examNames,
            'examTypes' => $this->examTypes,
            'examParts' => $this->examParts,
            'sessions' => $this->sessions,
            'schools' => $this->schools,
            'users' => $this->users
        ]);
    }
}
