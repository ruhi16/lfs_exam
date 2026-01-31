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
use App\Models\Teacher;
use App\Models\Exam07AnsscrDist;

class Exam10ExamMarksEntryIndv2Comp extends Component
{
    public $examClassSubjectId; // This is the exam_class_subject_id from Exam06ClassSubject
    public $examDetailId;
    public $myclassSectionId;
    public $myclassSubjectId;
    public $teacherId; // Added teacher ID parameter
    
    public $examClassSubject; // The selected exam class subject
    public $examDetail;
    public $myclassSection;
    public $teacher; // Teacher information
    
    public $students = [];
    public $examParts = [];
    
    public $formData = [];
    public $isEditingEnabled = true;
    
    protected $listeners = ['refreshComponent' => '$refresh'];
    
    public function mount($exam_class_subject_id, $exam_detail_id = null, $myclass_section_id = null, $myclass_subject_id = null, $teacher_id = null)
    {
        $this->examClassSubjectId = $exam_class_subject_id;
        $this->teacherId = $teacher_id;
        
        // If other IDs are not provided, get them from the exam class subject
        $this->examClassSubject = Exam06ClassSubject::with([
            'subject', 
            'myclass', 
            'examDetail.examName', 
            'examDetail.examType', 
            'examDetail.examPart', 
            'examDetail.examMode'
            // Removed 'examDetail.teacher' as this relationship doesn't exist
        ])->find($this->examClassSubjectId);
        
        if ($this->examClassSubject) {
            $this->examDetailId = $exam_detail_id ?: $this->examClassSubject->exam_detail_id;
            $this->myclassSectionId = $myclass_section_id ?: $this->examClassSubject->myclass_id; // Assuming this refers to section
            $this->myclassSubjectId = $myclass_subject_id ?: $this->examClassSubject->subject_id;
            
            // First try to get teacher from Exam07AnsscrDist relationship
            if ($this->teacherId) {
                $this->teacher = Teacher::with('user')->find($this->teacherId);
            } elseif ($this->examClassSubject && $this->examDetailId && $this->myclassSectionId) {
                // Look up teacher from Exam07AnsscrDist table
                $ansscrDist = Exam07AnsscrDist::where('exam_class_subject_id', $this->examClassSubjectId)
                    ->where('exam_detail_id', $this->examDetailId)
                    ->where('myclass_section_id', $this->myclassSectionId)
                    ->with('teacher.user')
                    ->first();
                
                if ($ansscrDist && $ansscrDist->teacher) {
                    $this->teacher = $ansscrDist->teacher;
                }
            }
            
            // Fallback: Get teacher from other possible relationships
            if (!$this->teacher) {
                if ($this->examClassSubject->teacher) {
                    $this->teacher = $this->examClassSubject->teacher;
                } else {
                    // Check if teacher_id exists in exam_class_subject table
                    $teacherId = $this->examClassSubject->teacher_id ?? null;
                    if ($teacherId) {
                        $this->teacher = Teacher::with('user')->find($teacherId);
                    }
                }
            }
        }
        
        $this->loadInitialData();
    }
    
    public function loadInitialData()
    {
        if (!$this->examClassSubject) {
            return;
        }
        
        $this->examDetail = Exam05Detail::with(['examName', 'examType', 'examPart', 'examMode'])->find($this->examDetailId);
        $this->myclassSection = MyclassSection::with(['myclass', 'section'])->find($this->myclassSectionId);
        
        // Load students for the section
        $this->students = Studentcr::where('myclass_id', $this->myclassSection->myclass_id)
            ->where('section_id', $this->myclassSection->section_id)
            ->orderBy('roll_no')
            ->get();
        
        // Load exam parts from the exam detail (don't use exam_part_id in queries)
        $this->examParts = collect([
            (object)[
                'id' => $this->examDetail->exam_part_id, 
                'name' => $this->examDetail->examPart->name,
                'exam_detail_id' => $this->examDetailId  // Store the exam detail ID instead
            ]
        ]);
        
        $this->loadExistingData();
    }
    
    public function loadExistingData()
    {
        // Clear existing form data
        $this->formData = [];
        
        foreach ($this->students as $student) {
            foreach ($this->examParts as $examPart) {
                // Use exam_detail_id instead of exam_part_id for the query
                $cellKey = $this->myclassSectionId . '_' . $student->id . '_' . $this->examClassSubjectId . '_' . $examPart->exam_detail_id;
                
                // Query using exam_detail_id since exam_part_id doesn't exist in exam10_marks_entries
                $existingRecord = Exam10MarksEntry::where('myclass_section_id', $this->myclassSectionId)
                    ->where('studentcr_id', $student->id)
                    ->where('exam_class_subject_id', $this->examClassSubjectId)
                    ->where('exam_detail_id', $examPart->exam_detail_id)
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
    
    public function clearMarks($cellKey)
    {
        if (isset($this->formData[$cellKey]['is_absent']) && $this->formData[$cellKey]['is_absent']) {
            $this->formData[$cellKey]['marks'] = null;
        }
    }
    
    public function saveEntry($cellKey, $studentId, $examPartDetailId)
    {
        $data = $this->formData[$cellKey];
        
        // Validation
        if ($data['is_absent']) {
            $marks = -99; // Special value for absent
        } else {
            $marks = $data['marks'];
            
            // Validate marks range if present
            if ($marks !== null && $marks !== '') {
                $maxMarks = $this->examClassSubject->full_marks ?? 100;
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
                'exam_class_subject_id' => $this->examClassSubjectId,
                'exam_detail_id' => $examPartDetailId,  // Use exam_detail_id instead of exam_part_id
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
                [$myclassSectionId, $studentId, $examClassSubjectId, $examPartDetailId] = $ids;
                
                if ($data['is_absent']) {
                    $marks = -99; // Special value for absent
                } else {
                    $marks = $data['marks'];
                    
                    // Validate marks range if present
                    if ($marks !== null && $marks !== '') {
                        $maxMarks = $this->examClassSubject->full_marks ?? 100;
                        if ($marks < 0 || $marks > $maxMarks) {
                            continue; // Skip invalid marks
                        }
                    }
                }
                
                $resolvedExamClassSubjectId = \App\Models\Exam06ClassSubject::resolveForExamDetail($examClassSubjectId, $examPartDetailId);
                if (!$resolvedExamClassSubjectId) {
                    continue;
                }
                Exam10MarksEntry::updateOrCreate(
                    [
                        'myclass_section_id' => $myclassSectionId,
                        'studentcr_id' => $studentId,
                        'exam_class_subject_id' => $resolvedExamClassSubjectId,
                        'exam_detail_id' => $examPartDetailId,  // Use exam_detail_id instead of exam_part_id
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
        return view('livewire.exam10-exam-marks-entry-indv2-comp', [
            'students' => $this->students,
            'examParts' => $this->examParts,
            'formData' => $this->formData,
            'examDetail' => $this->examDetail,
            'myclassSection' => $this->myclassSection,
            'examClassSubject' => $this->examClassSubject,
            'teacher' => $this->teacher,
            'isEditingEnabled' => $this->isEditingEnabled
        ]);
    }
}
