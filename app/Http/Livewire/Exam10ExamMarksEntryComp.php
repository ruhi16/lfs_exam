<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Exam10MarksEntry;
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

class Exam10ExamMarksEntryComp extends Component
{
    public $activeTab = 0;
    public $classes;
    public $sections;
    public $examClassSubjects;
    public $existingEntries;
    public $examNames;
    public $examTypes;
    public $examParts;
    public $sessions;
    public $schools;
    public $users;
    public $subjectTypes;
    public $selectedExamNameId = null;
    public $selectedExamTypeId = null;
    
    // Validation flag
    public $isValidationPassed = false;
    
    // Form data
    public $formData = [];
    public $editingId = null;
    public $isEditingEnabled = false;
    
    protected $listeners = ['refreshComponent' => '$refresh'];
    
    public function mount()
    {
        $this->loadData();
        $this->initializeFormData();
        $this->checkValidation();
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

        // Load existing exam marks entries
        $this->examClassSubjects = Exam06ClassSubject::with([
            'myclass', 
            'subject', 
            'examDetail'
        ])->get();
        
        // Load existing marks entries
        $this->existingEntries = Exam10MarksEntry::with([
            'myclassSection.section',
            'examClassSubject.subject',
            'studentcr.studentdb',
            'session'
        ])->get();
    }
    
    public function initializeFormData()
    {
        // Initialize form data structure and load existing records
        $existingRecords = Exam10MarksEntry::with([
            'myclassSection', 
            'examClassSubject',
            'studentcr'
        ])->get();
        
        foreach ($existingRecords as $record) {
            $key = $record->myclass_section_id . '_' . $record->studentcr_id . '_' . $record->exam_class_subject_id . '_' . $record->exam_detail_id;
            $this->formData[$key] = [
                'marks' => $record->exam_marks == -99 ? null : $record->exam_marks,
                'is_absent' => $record->exam_marks == -99 || $record->is_absent,
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
    

    public function getStudentsInSection($myclassSectionId)
    {
        // First get the MyclassSection record to get myclass_id and section_id
        $myclassSection = MyclassSection::find($myclassSectionId);
        
        if (!$myclassSection) {
            return collect();
        }
        
        // Query students using the separate myclass_id and section_id columns
        return \App\Models\Studentcr::where('myclass_id', $myclassSection->myclass_id)
            ->where('section_id', $myclassSection->section_id)
            ->with(['studentdb', 'myclass', 'section'])
            ->orderBy('roll_no')
            ->get();
    }
    
    public function setSelectedExamName($examNameId)
    {
        $this->selectedExamNameId = $examNameId;
        $this->selectedExamTypeId = null; // Reset exam type when exam name changes
        $this->checkValidation();
    }
    
    public function setSelectedExamType($examTypeId)
    {
        $this->selectedExamTypeId = $examTypeId;
        $this->checkValidation();
    }
    
    public function checkValidation()
    {
        $this->isValidationPassed = !empty($this->selectedExamNameId) && !empty($this->selectedExamTypeId);
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
    
    public function getExamClassSubjectsForClass($classId)
    {
        $query = Exam06ClassSubject::where('myclass_id', $classId)
            ->with(['myclass', 'subject', 'examDetail.examName', 'examDetail.examType', 'examDetail.examPart']);
        
        if ($this->selectedExamNameId) {
            $query->whereHas('examDetail', function($q) {
                $q->where('exam_name_id', $this->selectedExamNameId);
            });
        }
        
        if ($this->selectedExamTypeId) {
            $query->whereHas('examDetail', function($q) {
                $q->where('exam_type_id', $this->selectedExamTypeId);
            });
        }
        
        return $query->orderBy('subject_id')->get();
    }
    
    public function getExamPartsForClass($classId)
    {
        $query = Exam05Detail::where('myclass_id', $classId)
            ->with(['examName', 'examType', 'examPart', 'examMode']);
        
        if ($this->selectedExamNameId) {
            $query->where('exam_name_id', $this->selectedExamNameId);
        }
        
        if ($this->selectedExamTypeId) {
            $query->where('exam_type_id', $this->selectedExamTypeId);
        }
        
        return $query->orderBy('exam_part_id')->get();
    }
    
    public function getUniqueExamClassSubjectsForClass($classId)
    {
        $query = Exam06ClassSubject::where('myclass_id', $classId)
            ->with(['myclass', 'subject', 'examDetail.examName', 'examDetail.examType', 'examDetail.examPart']);
        
        if ($this->selectedExamNameId) {
            $query->whereHas('examDetail', function($q) {
                $q->where('exam_name_id', $this->selectedExamNameId);
            });
        }
        
        if ($this->selectedExamTypeId) {
            $query->whereHas('examDetail', function($q) {
                $q->where('exam_type_id', $this->selectedExamTypeId);
            });
        }
        
        // Get unique subjects by grouping them
        $subjects = $query->get()->unique('subject_id')->values();
        return $subjects->sortBy('subject.name');
    }
    
    public function getExistingEntry($myclassSectionId, $examClassSubjectId)
    {
        return Exam10MarksEntry::where('myclass_section_id', $myclassSectionId)
            ->where('exam_class_subject_id', $examClassSubjectId)
            ->first();
    }
    
    public function getFormDataValue($myclassSectionId, $examClassSubjectId, $field)
    {
        $key = $myclassSectionId . '_' . $examClassSubjectId;
        $record = $this->getExistingEntry($myclassSectionId, $examClassSubjectId);
        
        if ($record && isset($this->formData[$key][$field])) {
            return $this->formData[$key][$field];
        } elseif ($record) {
            return $record->$field;
        } elseif (isset($this->formData[$key][$field])) {
            return $this->formData[$key][$field];
        }
        
        return '';
    }
    
    public function saveEntry($myclassSectionId, $examClassSubjectId)
    {
        $key = $myclassSectionId . '_' . $examClassSubjectId;
        $data = $this->formData[$key] ?? [];
        
        // Calculate grade automatically based on marks (simplified logic)
        $gradeId = null;
        if (!empty($data['marks']) && !($data['is_absent'] ?? false)) {
            $marks = $data['marks'];
            if ($marks >= 90) {
                $gradeId = 1; // A+ grade
            } elseif ($marks >= 80) {
                $gradeId = 2; // A grade
            } elseif ($marks >= 70) {
                $gradeId = 3; // B grade
            } elseif ($marks >= 60) {
                $gradeId = 4; // C grade
            } elseif ($marks >= 50) {
                $gradeId = 5; // D grade
            } else {
                $gradeId = 6; // F grade
            }
        }
        
        $record = Exam10MarksEntry::updateOrCreate(
            [
                'myclass_section_id' => $myclassSectionId,
                'exam_class_subject_id' => $examClassSubjectId
            ],
            [
                'exam_marks' => ($data['is_absent'] ?? false) ? -99 : $data['marks'],
                'grade_id' => $gradeId,
                'is_absent' => $data['is_absent'] ?? false,
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
        
        session()->flash('message', 'Entry saved successfully.');
        $this->emit('refreshComponent');
    }
    
    public function editEntry($id)
    {
        $record = Exam10MarksEntry::findOrFail($id);
        $this->editingId = $id;

        $key = $record->myclass_section_id . '_' . $record->exam_class_subject_id;
        $this->formData[$key] = [
            'marks' => $record->exam_marks == -99 ? null : $record->exam_marks,
            'is_absent' => $record->exam_marks == -99 || $record->is_absent,
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
    
    public function updateEntry()
    {
        if (!$this->editingId) return;
        
        $record = Exam10MarksEntry::findOrFail($this->editingId);
        $key = $record->myclass_section_id . '_' . $record->exam_class_subject_id;
        $data = $this->formData[$key] ?? [];
        
        // Calculate grade automatically based on marks (simplified logic)
        $gradeId = null;
        if (!empty($data['marks']) && !($data['is_absent'] ?? false)) {
            $marks = $data['marks'];
            if ($marks >= 90) {
                $gradeId = 1; // A+ grade
            } elseif ($marks >= 80) {
                $gradeId = 2; // A grade
            } elseif ($marks >= 70) {
                $gradeId = 3; // B grade
            } elseif ($marks >= 60) {
                $gradeId = 4; // C grade
            } elseif ($marks >= 50) {
                $gradeId = 5; // D grade
            } else {
                $gradeId = 6; // F grade
            }
        }
        
        $record->update([
            'exam_marks' => ($data['is_absent'] ?? false) ? -99 : $data['marks'],
            'grade_id' => $gradeId,
            'is_absent' => $data['is_absent'] ?? false,
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
        session()->flash('message', 'Entry updated successfully.');
        $this->emit('refreshComponent');
    }
    
    public function deleteEntry($id)
    {
        Exam10MarksEntry::findOrFail($id)->delete();
        session()->flash('message', 'Entry deleted successfully.');
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
    
    public function saveAllEntries()
    {
        $savedCount = 0;
        
        foreach ($this->formData as $key => $data) {
            // Parse the key to get section_id, student_id, exam_class_subject_id and exam_part_id
            $parts = explode('_', $key);
            if (count($parts) === 4) {
                [$sectionId, $studentId, $examClassSubjectId, $examPartId] = $parts;
                
                // Calculate grade automatically based on marks (simplified logic)
                $gradeId = null;
                if (!empty($data['marks']) && !($data['is_absent'] ?? false)) {
                    $marks = $data['marks'];
                    if ($marks >= 90) {
                        $gradeId = 1; // A+ grade
                    } elseif ($marks >= 80) {
                        $gradeId = 2; // A grade
                    } elseif ($marks >= 70) {
                        $gradeId = 3; // B grade
                    } elseif ($marks >= 60) {
                        $gradeId = 4; // C grade
                    } elseif ($marks >= 50) {
                        $gradeId = 5; // D grade
                    } else {
                        $gradeId = 6; // F grade
                    }
                }
                
                // Save to Exam10MarksEntry table
                $record = Exam10MarksEntry::updateOrCreate(
                    [
                        'myclass_section_id' => $sectionId,
                        'studentcr_id' => $studentId,
                        'exam_class_subject_id' => $examClassSubjectId,
                        'exam_detail_id' => $examPartId
                    ],
                    [
                        'exam_marks' => ($data['is_absent'] ?? false) ? -99 : $data['marks'],
                        'grade_id' => $gradeId,
                        'is_absent' => $data['is_absent'] ?? false,
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
                
                $savedCount++;
            }
        }
        
        session()->flash('message', "$savedCount record(s) saved successfully.");
        $this->emit('refreshComponent');
    }
    
    public function clearMarks($cellKey)
    {
        if (isset($this->formData[$cellKey])) {
            $this->formData[$cellKey]['marks'] = null;
        }
    }
    
    public function render()
    {
        return view('livewire.exam10-exam-marks-entry-comp', [
            'classes' => $this->classes,
            'sections' => $this->sections,
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