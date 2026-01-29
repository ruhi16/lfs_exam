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

class Exam12ExamMarkRegisterComp extends Component
{
    public $activeTab = 0;
    public $classes;
    public $sections;
    public $students;
    public $examDetailsGrouped = [];
    public $marksData = [];
    public $isEditing = false;
    
    public function mount()
    {
        $this->loadClasses();
        $this->loadSections();
        $this->loadStudents();
    }
    
    public function loadClasses()
    {
        // Get unique classes from MyclassSection model
        $this->classes = Myclass::with('myclass_sections.section')
            ->orderBy('name')
            ->get();
    }
    
    public function loadSections()
    {
        $this->sections = MyclassSection::with(['myclass', 'section'])
            ->orderBy('myclass_id')
            ->orderBy('section_id')
            ->get();
    }
    
    public function loadStudents()
    {
        $this->students = Studentcr::with(['studentdb', 'myclass', 'section'])
            ->orderBy('myclass_id')
            ->orderBy('section_id')
            ->orderBy('roll_no')
            ->get();
    }
    
    public function setActiveTab($index)
    {
        $this->activeTab = $index;
        $this->loadExamDetailsForClass($this->classes[$index]->id);
    }
    
    public function loadExamDetailsForClass($classId)
    {
        // Get all exam details for this class
        $examDetails = Exam05Detail::where('myclass_id', $classId)
            ->with(['examName', 'examPart'])
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
        
        $this->examDetailsGrouped = $grouped;
        
        // Load existing marks data
        $this->loadMarksData($classId);
    }
    
    public function loadMarksData($classId)
    {
        // Reset marks data
        $this->marksData = [];
        
        // Get sections for this class
        $sections = MyclassSection::where('myclass_id', $classId)
            ->with('section')
            ->get();
        
        foreach ($sections as $section) {
            // Get students for this section
            $students = Studentcr::where('myclass_id', $classId)
                ->where('section_id', $section->section_id)
                ->with('studentdb')
                ->orderBy('roll_no')
                ->get();
            
            foreach ($students as $student) {
                // For each exam detail, check if marks exist
                foreach ($this->examDetailsGrouped as $examNameId => $examParts) {
                    foreach ($examParts as $examPartId => $details) {
                        foreach ($details as $detail) {
                            // Find the exam_class_subject_id for this combination
                            $examClassSubject = Exam06ClassSubject::where('exam_detail_id', $detail->id)
                                ->where('myclass_id', $classId)
                                ->first();
                            
                            if ($examClassSubject) {
                                // Check if marks entry exists
                                $marksEntry = Exam10MarksEntry::where('myclass_section_id', $section->id)
                                    ->where('exam_detail_id', $detail->id)
                                    ->where('studentcr_id', $student->id)
                                    ->first();
                                
                                $key = "{$section->id}_{$detail->id}_{$student->id}";
                                $this->marksData[$key] = [
                                    'exam_marks' => $marksEntry ? $marksEntry->exam_marks : null,
                                    'is_absent' => $marksEntry ? $marksEntry->is_absent : false,
                                    'exam_class_subject_id' => $examClassSubject->id
                                ];
                            }
                        }
                    }
                }
            }
        }
    }
    
    public function updateMarks($sectionId, $examDetailId, $studentId)
    {
        $key = "{$sectionId}_{$examDetailId}_{$studentId}";
        
        if (!isset($this->marksData[$key])) {
            $this->marksData[$key] = [
                'exam_marks' => null,
                'is_absent' => false,
                'exam_class_subject_id' => null
            ];
        }
        
        // Toggle editing mode
        $this->isEditing = !$this->isEditing;
    }
    
    public function saveMarks($sectionId, $examDetailId, $studentId)
    {
        $key = "{$sectionId}_{$examDetailId}_{$studentId}";
        
        if (!isset($this->marksData[$key])) {
            return;
        }
        
        $data = $this->marksData[$key];
        
        // Validate input
        if (!$data['is_absent'] && ($data['exam_marks'] === null || $data['exam_marks'] === '')) {
            session()->flash('error', 'Please enter marks or mark as absent.');
            return;
        }
        
        // Find exam_class_subject_id
        $examDetail = Exam05Detail::find($examDetailId);
        if (!$examDetail) {
            session()->flash('error', 'Invalid exam detail.');
            return;
        }
        
        $examClassSubject = Exam06ClassSubject::where('exam_detail_id', $examDetailId)
            ->where('myclass_id', $this->classes[$this->activeTab]->id)
            ->first();
            
        if (!$examClassSubject) {
            session()->flash('error', 'Exam class subject not found.');
            return;
        }
        
        try {
            // Save or update marks entry
            Exam10MarksEntry::updateOrCreate(
                [
                    'myclass_section_id' => $sectionId,
                    'exam_detail_id' => $examDetailId,
                    'studentcr_id' => $studentId
                ],
                [
                    'exam_marks' => $data['is_absent'] ? null : $data['exam_marks'],
                    'is_absent' => $data['is_absent'],
                    'exam_class_subject_id' => $examClassSubject->id,
                    'session_id' => session('session_id') ?? 1, // Default session
                    'user_id' => auth()->id() ?? 1, // Current user
                    'is_active' => true,
                    'status' => 'active'
                ]
            );
            
            session()->flash('message', 'Marks saved successfully.');
            $this->isEditing = false;
            
            // Reload marks data
            $this->loadMarksData($this->classes[$this->activeTab]->id);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save marks: ' . $e->getMessage());
        }
    }
    
    public function cancelEdit()
    {
        $this->isEditing = false;
        // Reload original data
        $this->loadMarksData($this->classes[$this->activeTab]->id);
    }
    
    public function getMarksValue($sectionId, $examDetailId, $studentId)
    {
        $key = "{$sectionId}_{$examDetailId}_{$studentId}";
        return $this->marksData[$key]['exam_marks'] ?? null;
    }
    
    public function getAbsentStatus($sectionId, $examDetailId, $studentId)
    {
        $key = "{$sectionId}_{$examDetailId}_{$studentId}";
        return $this->marksData[$key]['is_absent'] ?? false;
    }
    
    public function setMarksValue($sectionId, $examDetailId, $studentId, $value)
    {
        $key = "{$sectionId}_{$examDetailId}_{$studentId}";
        if (!isset($this->marksData[$key])) {
            $this->marksData[$key] = ['exam_marks' => null, 'is_absent' => false, 'exam_class_subject_id' => null];
        }
        $this->marksData[$key]['exam_marks'] = $value;
        // If marks are entered, uncheck absent
        if ($value !== null && $value !== '') {
            $this->marksData[$key]['is_absent'] = false;
        }
    }
    
    public function setAbsentStatus($sectionId, $examDetailId, $studentId, $status)
    {
        $key = "{$sectionId}_{$examDetailId}_{$studentId}";
        if (!isset($this->marksData[$key])) {
            $this->marksData[$key] = ['exam_marks' => null, 'is_absent' => false, 'exam_class_subject_id' => null];
        }
        $this->marksData[$key]['is_absent'] = $status;
        // If marked absent, clear marks
        if ($status) {
            $this->marksData[$key]['exam_marks'] = null;
        }
    }
    
    public function render()
    {
        return view('livewire.exam12-exam-mark-register-comp', [
            'classes' => $this->classes,
            'sections' => $this->sections,
            'students' => $this->students,
            'examDetailsGrouped' => $this->examDetailsGrouped,
            'marksData' => $this->marksData,
            'isEditing' => $this->isEditing
        ]);
    }
}