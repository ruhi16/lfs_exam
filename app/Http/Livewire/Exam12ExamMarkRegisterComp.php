<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Exam10MarksEntry;
use App\Models\Myclass;
use App\Models\MyclassSection;
use App\Models\Studentcr;
use App\Models\MyclassSubject;
use App\Models\Exam05Detail;
use App\Models\Subject;
use App\Models\SubjectType;
use App\Models\Exam01Name;
use App\Models\Exam02Type;
use App\Models\Exam03Part;
use App\Models\Exam06ClassSubject;
use App\Models\Exam08Grade;
use App\Models\Session;
use App\Models\School;
use App\Models\User;

class Exam12ExamMarkRegisterComp extends Component
{
    public $activeTab = 0;
    public $classes;
    public $sections;
    public $students;
    public $examClassSubjects;
    public $examDetails;
    public $subjects;
    public $subjectTypes;
    public $examNames;
    public $examTypes;
    public $examParts;
    public $grades;
    public $sessions;
    public $schools;
    public $users;
    public $existingMarksEntries;
    
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
        $this->subjects = Subject::orderBy('name')->get();
        $this->subjectTypes = SubjectType::orderBy('name')->get();
        $this->examNames = Exam01Name::orderBy('name')->get();
        $this->examTypes = Exam02Type::orderBy('name')->get();
        $this->examParts = Exam03Part::orderBy('name')->get();
        $this->grades = Exam08Grade::orderBy('name')->get();
        $this->sessions = Session::orderBy('name')->get();
        $this->schools = School::orderBy('name')->get();
        $this->users = User::orderBy('name')->get();
        
        // Load existing exam class subjects
        $this->examClassSubjects = MyclassSubject::with([
            'myclass', 
            'subject', 
            'subject.subjectType'
        ])->get();
        
        // Load existing marks entries
        $this->existingMarksEntries = Exam10MarksEntry::with([
            'examDetail.examName',
            'examDetail.examType',
            'examDetail.examPart',
            'examClassSubject',
            'myclassSection.section',
            'studentcr',
            'grade',
            'session'
        ])->get();
    }
    
    public function initializeFormData()
    {
        // Initialize form data structure and load existing records
        $existingRecords = Exam10MarksEntry::with([
            'examDetail', 
            'examClassSubject', 
            'myclassSection',
            'studentcr'
        ])->get();
        
        foreach ($existingRecords as $record) {
            $key = $record->myclass_section_id . '_' . $record->exam_detail_id . '_' . $record->studentcr_id;
            $this->formData[$key] = [
                'exam_marks' => $record->exam_marks,
                'grade_id' => $record->grade_id,
                'is_absent' => $record->is_absent,
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
    
    public function getStudentsInSection($myclassSectionId)
    {
        // First get the MyclassSection record to get myclass_id and section_id
        $myclassSection = MyclassSection::find($myclassSectionId);
        
        if (!$myclassSection) {
            return collect();
        }
        
        // Query students using the separate myclass_id and section_id columns
        return Studentcr::where('myclass_id', $myclassSection->myclass_id)
            ->where('section_id', $myclassSection->section_id)
            ->with(['studentdb', 'myclass', 'section'])
            ->orderBy('roll_no')
            ->get();
    }
    
    public function getClassSubjectsGroupedByType($classId)
    {
        $classSubjects = MyclassSubject::whereHas('myclass', function($query) use ($classId) {
            $query->where('id', $classId);
        })
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
            ->with(['examName', 'examType', 'examPart', 'examMode'])
            ->orderBy('exam_name_id')
            ->orderBy('exam_type_id')
            ->orderBy('exam_part_id')
            ->get()
            ->groupBy('exam_name_id');
    }
    
    public function getExamDetailsGroupedByExamName($classId)
    {
        return Exam05Detail::where('myclass_id', $classId)
            ->with(['examName', 'examType', 'examPart', 'examMode'])
            ->orderBy('exam_name_id')
            ->orderBy('exam_part_id')
            ->get()
            ->groupBy('exam_name_id');
    }
    
    public function getExamDetailsGroupedByExamNameAndPart($classId)
    {
        $examDetails = Exam05Detail::where('myclass_id', $classId)
            ->with(['examName', 'examType', 'examPart', 'examMode'])
            ->orderBy('exam_name_id')
            ->orderBy('exam_part_id')
            ->get();
        
        // Group by exam_name_id first, then by exam_part_id
        $grouped = [];
        foreach ($examDetails as $detail) {
            $examNameId = $detail->exam_name_id;
            $examPartId = $detail->exam_part_id;
            
            if (!isset($grouped[$examNameId])) {
                $grouped[$examNameId] = [];
            }
            
            if (!isset($grouped[$examNameId][$examPartId])) {
                $grouped[$examNameId][$examPartId] = [];
            }
            
            $grouped[$examNameId][$examPartId][] = $detail;
        }
        
        return $grouped;
    }
    
    public function getExamDetailsForStudent($classId)
    {
        $examDetails = Exam05Detail::where('myclass_id', $classId)
            ->with(['examName', 'examType', 'examPart', 'examMode'])
            ->orderBy('exam_name_id')
            ->orderBy('exam_part_id')
            ->get()
            ->groupBy('exam_name_id');
        
        return $examDetails;
    }
    
    public function getExamClassSubjectsForClass($classId)
    {
        return MyclassSubject::whereHas('myclass', function($query) use ($classId) {
            $query->where('id', $classId);
        })
        ->with(['subject.subjectType', 'myclass'])
        ->orderBy('subject_id')
        ->get();
    }
    
    public function getExamClassSubjectsGroupedByType($classId)
    {
        $classSubjects = $this->getExamClassSubjectsForClass($classId);
        
        // Group by subject type
        $grouped = $classSubjects->groupBy(function ($item) {
            return $item->subject->subject_type_id;
        });
        
        // Sort by subject_type_id to ensure Summative (usually id 1) comes before Formative (usually id 2)
        $sortedGrouped = collect();
        
        // First add Summative subjects (assuming id 1)
        if ($grouped->has(1)) {
            $sortedGrouped[1] = $grouped[1];
        }
        
        // Then add Formative subjects (assuming id 2)
        if ($grouped->has(2)) {
            $sortedGrouped[2] = $grouped[2];
        }
        
        // Add any other subject types
        foreach ($grouped as $subjectTypeId => $subjects) {
            if ($subjectTypeId != 1 && $subjectTypeId != 2) {
                $sortedGrouped[$subjectTypeId] = $subjects;
            }
        }
        
        return $sortedGrouped;
    }
    
    public function getExamClassSubjectsGroupedByExamType($classId)
    {
        $classSubjects = $this->getExamClassSubjectsForClass($classId);
        
        // Group by exam type
        $grouped = $classSubjects->groupBy(function ($item) {
            return $item->examDetail->exam_type_id;
        });
        
        // Sort by exam_type_id
        return $grouped->sortKeys();
    }
    
    public function getExamClassSubjectId($examDetailId, $myclassId, $subjectId)
    {
        // Find the exam_class_subject_id using Exam06ClassSubject model based on exam_detail_id, myclass_id, and subject_id
        $examClassSubject = Exam06ClassSubject::where('exam_detail_id', $examDetailId)
            ->where('myclass_id', $myclassId)
            ->where('subject_id', $subjectId)
            ->first();
            
        return $examClassSubject ? $examClassSubject->id : null;
    }
    
    public function getMarksDataArray($myclassSectionId)
    {
        // Get all marks entries for the given myclass_section_id
        $marksEntries = Exam10MarksEntry::where('myclass_section_id', $myclassSectionId)
            ->with(['examDetail', 'studentcr'])
            ->get();
            
        $marksData = [];
        
        foreach ($marksEntries as $entry) {
            $studentcrId = $entry->studentcr_id;
            $examDetailId = $entry->exam_detail_id;
            $subjectId = $entry->examDetail->subject_id;
            
            // Initialize the array structure if it doesn't exist
            if (!isset($marksData[$studentcrId])) {
                $marksData[$studentcrId] = [];
            }
            
            if (!isset($marksData[$studentcrId][$examDetailId])) {
                $marksData[$studentcrId][$examDetailId] = [];
            }
            
            // Store the marks data
            $marksData[$studentcrId][$examDetailId][$subjectId] = [
                'exam_marks' => $entry->exam_marks,
                'grade_id' => $entry->grade_id,
                'is_absent' => $entry->is_absent,
                'session_id' => $entry->session_id,
                'school_id' => $entry->school_id,
                'user_id' => $entry->user_id,
                'approved_by' => $entry->approved_by,
                'is_active' => $entry->is_active,
                'is_finalized' => $entry->is_finalized,
                'status' => $entry->status,
                'remarks' => $entry->remarks,
                'exam_class_subject_id' => $entry->exam_class_subject_id,
                'created_at' => $entry->created_at,
                'updated_at' => $entry->updated_at
            ];
        }
        
        return $marksData;
    }
    
    public function debugMarksData($myclassSectionId)
    {
        $marksData = $this->getMarksDataArray($myclassSectionId);
        return [
            'section_id' => $myclassSectionId,
            'total_students' => count($marksData),
            'sample_data' => array_slice($marksData, 0, 1)
        ];
    }
    
    public function getExistingMarksEntry($myclassSectionId, $examDetailId, $studentcrId)
    {
        return Exam10MarksEntry::where('myclass_section_id', $myclassSectionId)
            ->where('exam_detail_id', $examDetailId)
            ->where('studentcr_id', $studentcrId)
            ->first();
    }
    
    public function getFormDataValue($myclassSectionId, $examDetailId, $studentcrId, $field)
    {
        $key = $myclassSectionId . '_' . $examDetailId . '_' . $studentcrId;
        $record = $this->getExistingMarksEntry($myclassSectionId, $examDetailId, $studentcrId);
        
        if ($record && isset($this->formData[$key][$field])) {
            return $this->formData[$key][$field];
        } elseif ($record) {
            return $record->$field;
        } elseif (isset($this->formData[$key][$field])) {
            return $this->formData[$key][$field];
        }
        
        return '';
    }
    
    public function saveMarksEntry($myclassSectionId, $examDetailId, $studentcrId)
    {
        $key = $myclassSectionId . '_' . $examDetailId . '_' . $studentcrId;
        $data = $this->formData[$key] ?? [];
        
        // Validate required fields
        if (!isset($data['exam_marks']) && empty($data['is_absent'])) {
            session()->flash('error', 'Marks or absent status is required.');
            return;
        }
        
        $record = Exam10MarksEntry::updateOrCreate(
            [
                'myclass_section_id' => $myclassSectionId,
                'exam_detail_id' => $examDetailId,
                'studentcr_id' => $studentcrId
            ],
            [
                'exam_marks' => $data['exam_marks'] ?? null,
                'grade_id' => $data['grade_id'] ?? null,
                'is_absent' => $data['is_absent'] ?? false,
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
        
        session()->flash('message', 'Marks entry saved successfully.');
        $this->emit('refreshComponent');
    }
    
    public function editMarksEntry($id)
    {
        $record = Exam10MarksEntry::findOrFail($id);
        $this->editingId = $id;
        
        $key = $record->myclass_section_id . '_' . $record->exam_detail_id . '_' . $record->studentcr_id;
        $this->formData[$key] = [
            'exam_marks' => $record->exam_marks,
            'grade_id' => $record->grade_id,
            'is_absent' => $record->is_absent,
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
    
    public function updateMarksEntry()
    {
        if (!$this->editingId) return;
        
        $record = Exam10MarksEntry::findOrFail($this->editingId);
        $key = $record->myclass_section_id . '_' . $record->exam_detail_id . '_' . $record->studentcr_id;
        $data = $this->formData[$key] ?? [];
        
        $record->update([
            'exam_marks' => $data['exam_marks'] ?? null,
            'grade_id' => $data['grade_id'] ?? null,
            'is_absent' => $data['is_absent'] ?? false,
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
        session()->flash('message', 'Marks entry updated successfully.');
        $this->emit('refreshComponent');
    }
    
    public function deleteMarksEntry($id)
    {
        Exam10MarksEntry::findOrFail($id)->delete();
        session()->flash('message', 'Marks entry deleted successfully.');
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
        return view('livewire.exam12-exam-mark-register-comp', [
            'classes' => $this->classes,
            'sections' => $this->sections,
            'students' => $this->students,
            'examClassSubjects' => $this->examClassSubjects,
            'examDetails' => $this->examDetails,
            'subjects' => $this->subjects,
            'subjectTypes' => $this->subjectTypes,
            'examNames' => $this->examNames,
            'examTypes' => $this->examTypes,
            'examParts' => $this->examParts,
            'grades' => $this->grades,
            'sessions' => $this->sessions,
            'schools' => $this->schools,
            'users' => $this->users
        ]);
    }
}
