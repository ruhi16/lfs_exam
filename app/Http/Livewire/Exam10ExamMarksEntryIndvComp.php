<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Myclass;
use App\Models\MyclassSection;
use App\Models\Studentcr;
use App\Models\Exam06ClassSubject;
use App\Models\Exam05Detail;
use App\Models\Exam10MarksEntry;
use App\Models\Exam01Name;
use App\Models\Exam02Type;
use App\Models\Exam03Part;
use App\Models\Exam04Mode;
use App\Models\Subject;

class Exam10ExamMarksEntryIndvComp extends Component
{
    public $examDetailId;
    public $myclassSectionId;
    public $myclassSubjectId;
    
    public $examDetail;
    public $myclassSection;
    public $myclassSubject;
    
    public $students = [];
    public $examClassSubjects = [];
    public $examParts = [];
    public $subjects = []; // All available subjects for filtering
    public $examNames = []; // All available exam names
    
    public $selectedSubjectId = null; // Selected subject filter
    public $selectedExamNameId = null; // Selected exam name filter
    public $filteredExamClassSubjects = []; // Filtered subjects
    
    public $formData = [];
    public $isEditingEnabled = true;
    
    protected $listeners = ['refreshComponent' => '$refresh'];
    
    public function mount($exam_detail_id, $myclass_section_id, $myclass_subject_id)
    {
        $this->examDetailId = $exam_detail_id;
        $this->myclassSectionId = $myclass_section_id;
        $this->myclassSubjectId = $myclass_subject_id;
        
        $this->loadInitialData();
    }
    
    public function loadInitialData()
    {
        $this->examDetail = Exam05Detail::with(['examName', 'examType', 'examPart', 'examMode'])->find($this->examDetailId);
        $this->myclassSection = MyclassSection::with(['myclass', 'section'])->find($this->myclassSectionId);
        
        // Load students for the section
        $this->students = Studentcr::where('myclass_id', $this->myclassSection->myclass_id)
            ->where('section_id', $this->myclassSection->section_id)
            ->orderBy('roll_no')
            ->get();
        
        // Load ALL exam class subjects for this class and section (not just the specific exam detail)
        $this->examClassSubjects = Exam06ClassSubject::where('myclass_id', $this->myclassSection->myclass_id)
            ->with(['subject', 'examDetail.examName', 'examDetail.examType'])
            ->get();
        
        // Get unique subjects for the dropdown
        $this->subjects = $this->examClassSubjects->unique('subject_id')->values()->all();
        
        // Get unique exam names for the dropdown
        // Create a collection of unique exam names with their IDs and names
        $uniqueExamDetails = [];
        foreach ($this->examClassSubjects as $subject) {
            if ($subject->examDetail && $subject->examDetail->examName) {
                $uniqueExamDetails[$subject->examDetail->exam_name_id] = $subject->examDetail->examName;
            }
        }
        $this->examNames = $uniqueExamDetails;
        
        // Initially show all subjects
        $this->filteredExamClassSubjects = $this->examClassSubjects;
                    
        // Load exam parts from the exam detail (don't use exam_part_id in queries)
        $this->examParts = collect([
            [
                'id' => $this->examDetail->exam_part_id, 
                'name' => $this->examDetail->examPart->name,
                'exam_detail_id' => $this->examDetailId  // Store the exam detail ID instead
            ]
        ]);
        
        $this->loadExistingData();
    }
    
    public function updatedSelectedSubjectId($subjectId)
    {
        $this->applyFilters();
    }
    
    public function updatedSelectedExamNameId($examNameId)
    {
        $this->applyFilters();
    }
    
    public function applyFilters()
    {
        $filtered = collect($this->examClassSubjects);
        
        if ($this->selectedSubjectId) {
            // Filter exam class subjects by selected subject
            $filtered = $filtered->filter(function ($examClassSubject) {
                return $examClassSubject->subject_id == $this->selectedSubjectId;
            })->values();
        }
        
        if ($this->selectedExamNameId) {
            // Filter exam class subjects by selected exam name
            $filtered = $filtered->filter(function ($examClassSubject) {
                if (is_object($examClassSubject) && $examClassSubject->examDetail) {
                    return $examClassSubject->examDetail->exam_name_id == $this->selectedExamNameId;
                } elseif (is_array($examClassSubject) && isset($examClassSubject['examDetail'])) {
                    return $examClassSubject['examDetail']['exam_name_id'] == $this->selectedExamNameId;
                }
                return false;
            })->values();
        }
        
        $this->filteredExamClassSubjects = $filtered->values();
        
        // Reload existing data for the filtered subjects
        $this->loadExistingData();
    }
    
    public function loadExistingData()
    {
        // Clear existing form data
        $this->formData = [];
        
        foreach ($this->students as $student) {
            foreach ($this->filteredExamClassSubjects as $examClassSubject) {
                foreach ($this->examParts as $examPart) {
                    // Use exam_detail_id instead of exam_part_id for the query
                    $cellKey = $this->myclassSectionId . '_' . $student->id . '_' . $examClassSubject->id . '_' . (is_object($examPart) ? $examPart->exam_detail_id : $examPart['exam_detail_id']);
                    
                    // Query using exam_detail_id since exam_part_id doesn't exist in exam10_marks_entries
                    $existingRecord = Exam10MarksEntry::where('myclass_section_id', $this->myclassSectionId)
                        ->where('studentcr_id', $student->id)
                        ->where('exam_class_subject_id', $examClassSubject->id)
                        ->where('exam_detail_id', is_object($examPart) ? $examPart->exam_detail_id : $examPart['exam_detail_id'])
                        ->first();
                    
                    if ($existingRecord) {
                        $this->formData[$cellKey] = [
                            'marks' => $existingRecord->exam_marks,
                            'is_absent' => $existingRecord->is_absent,
                            'status' => $existingRecord->status,
                            'remarks' => $existingRecord->remarks,
                            'session_id' => $existingRecord->session_id,
                            'school_id' => $existingRecord->school_id,
                            'user_id' => $existingRecord->user_id
                        ];
                    } else {
                        $this->formData[$cellKey] = [
                            'marks' => null,
                            'is_absent' => false,
                            'status' => 'active',
                            'remarks' => '',
                            'session_id' => null,
                            'school_id' => null,
                            'user_id' => null
                        ];
                    }
                }
            }
        }
    }
    
    public function clearMarks($cellKey)
    {
        if (isset($this->formData[$cellKey]['is_absent']) && $this->formData[$cellKey]['is_absent']) {
            $this->formData[$cellKey]['marks'] = null;
        }
    }
    
    public function saveEntry($cellKey, $studentId, $examClassSubjectId, $examDetailId)
    {
        $data = $this->formData[$cellKey];
        
        // Validation
        if ($data['is_absent']) {
            $marks = -99; // Special value for absent
        } else {
            $marks = $data['marks'];
            
            // Validate marks range if present
            if ($marks !== null && $marks !== '') {
                $foundSubject = collect($this->filteredExamClassSubjects)->firstWhere('id', $examClassSubjectId);
                $maxMarks = 100; // Default value
                if ($foundSubject) {
                    $maxMarks = is_object($foundSubject) ? ($foundSubject->full_marks ?? 100) : ($foundSubject['full_marks'] ?? 100);
                }
                if ($marks < 0 || $marks > $maxMarks) {
                    session()->flash('error', "Marks must be between 0 and {$maxMarks}");
                    return;
                }
            }
        }
        
        $record = Exam10MarksEntry::updateOrCreate(
            [
                'myclass_section_id' => $this->myclassSectionId,
                'studentcr_id' => $studentId,
                'exam_class_subject_id' => $examClassSubjectId,
                'exam_detail_id' => $examDetailId,  // Use exam_detail_id instead of exam_part_id
            ],
            [
                'exam_marks' => $marks,  // Use exam_marks instead of marks
                'is_absent' => $data['is_absent'],
                'status' => $data['status'],
                'remarks' => $data['remarks'],
                'session_id' => $data['session_id'],
                'school_id' => $data['school_id'],
                'user_id' => $data['user_id'],
            ]
        );
        
        session()->flash('message', 'Marks saved successfully.');
    }
    
    public function saveAllEntries()
    {
        $savedCount = 0;
        
        foreach ($this->formData as $cellKey => $data) {
            // Extract IDs from cellKey (format: myclassSectionId_studentId_examClassSubjectId_examDetailId)
            $ids = explode('_', $cellKey);
            if (count($ids) == 4) {
                [$myclassSectionId, $studentId, $examClassSubjectId, $examDetailId] = $ids;
                
                if ($data['is_absent']) {
                    $marks = -99; // Special value for absent
                } else {
                    $marks = $data['marks'];
                    
                    // Validate marks range if present
                    if ($marks !== null && $marks !== '') {
                        $foundSubject = collect($this->filteredExamClassSubjects)->firstWhere('id', $examClassSubjectId);
                        $maxMarks = 100; // Default value
                        if ($foundSubject) {
                            $maxMarks = is_object($foundSubject) ? ($foundSubject->full_marks ?? 100) : ($foundSubject['full_marks'] ?? 100);
                        }
                        if ($marks < 0 || $marks > $maxMarks) {
                            continue; // Skip invalid marks
                        }
                    }
                }
                
                Exam10MarksEntry::updateOrCreate(
                    [
                        'myclass_section_id' => $myclassSectionId,
                        'studentcr_id' => $studentId,
                        'exam_class_subject_id' => $examClassSubjectId,
                        'exam_detail_id' => $examDetailId,  // Use exam_detail_id instead of exam_part_id
                    ],
                    [
                        'exam_marks' => $marks,  // Use exam_marks instead of marks
                        'is_absent' => $data['is_absent'],
                        'status' => $data['status'],
                        'remarks' => $data['remarks'],
                        'session_id' => $data['session_id'],
                        'school_id' => $data['school_id'],
                        'user_id' => $data['user_id'],
                    ]
                );
                
                $savedCount++;
            }
        }
        
        session()->flash('message', "{$savedCount} entries saved successfully.");
    }
    
    public function toggleEditEnable()
    {
        $this->isEditingEnabled = !$this->isEditingEnabled;
    }
    
    public function render()
    {
        return view('livewire.exam10-exam-marks-entry-indv-comp', [
            'students' => $this->students,
            'examClassSubjects' => $this->examClassSubjects,
            'filteredExamClassSubjects' => $this->filteredExamClassSubjects,
            'examParts' => $this->examParts,
            'formData' => $this->formData,
            'examDetail' => $this->examDetail,
            'myclassSection' => $this->myclassSection,
            'subjects' => $this->subjects,
            'examNames' => $this->examNames,
            'selectedSubjectId' => $this->selectedSubjectId,
            'selectedExamNameId' => $this->selectedExamNameId,
            'isEditingEnabled' => $this->isEditingEnabled
        ]);
    }
}