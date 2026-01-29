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
        
        // Only load exam details if classes exist
        if (count($this->classes) > 0 && isset($this->classes[0])) {
            $this->loadExamDetailsForClass($this->classes[0]->id);
        }
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
        if (isset($this->classes[$index])) {
            $this->loadExamDetailsForClass($this->classes[$index]->id);
        }
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
                // For each exam part, check if marks exist (one detail per part)
                foreach ($this->examDetailsGrouped as $examNameId => $examParts) {
                    foreach ($examParts as $examPartId => $details) {
                        // Get the first (and typically only) detail for this part
                        $detail = $details[0];
                        if ($detail) {
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
        // Initialize marks data for all exam details in this section
        $classId = $this->classes[$this->activeTab]->id;
        
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
                // For each exam detail, initialize data structure
                foreach ($this->examDetailsGrouped as $examNameId => $examParts) {
                    foreach ($examParts as $examPartId => $details) {
                        // Get the first (and typically only) detail for this part
                        $detail = $details[0];
                        if ($detail) {
                            $key = "{$section->id}_{$detail->id}_{$student->id}";
                            
                            if (!isset($this->marksData[$key])) {
                                // Find the exam_class_subject_id for this combination
                                $examClassSubject = Exam06ClassSubject::where('exam_detail_id', $detail->id)
                                    ->where('myclass_id', $classId)
                                    ->first();
                                
                                $this->marksData[$key] = [
                                    'exam_marks' => null,
                                    'is_absent' => false,
                                    'exam_class_subject_id' => $examClassSubject ? $examClassSubject->id : null
                                ];
                            }
                        }
                    }
                }
            }
        }
        
        // Toggle editing mode
        $this->isEditing = !$this->isEditing;
    }
    
    public function saveMarks($sectionId, $examDetailId, $studentId)
    {
        $classId = $this->classes[$this->activeTab]->id;
        $savedCount = 0;
        $errorCount = 0;
        
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
                // For each exam detail, save the marks
                foreach ($this->examDetailsGrouped as $examNameId => $examParts) {
                    foreach ($examParts as $examPartId => $details) {
                        // Get the first (and typically only) detail for this part
                        $detail = $details[0];
                        if ($detail) {
                            $key = "{$section->id}_{$detail->id}_{$student->id}";
                            
                            if (isset($this->marksData[$key])) {
                                $data = $this->marksData[$key];
                                
                                // Validate input
                                if (!$data['is_absent'] && ($data['exam_marks'] === null || $data['exam_marks'] === '')) {
                                    $errorCount++;
                                    continue;
                                }
                                
                                // Find exam_class_subject_id
                                $examClassSubject = Exam06ClassSubject::where('exam_detail_id', $detail->id)
                                    ->where('myclass_id', $classId)
                                    ->first();
                                
                                if (!$examClassSubject) {
                                    $errorCount++;
                                    continue;
                                }
                                
                                try {
                                    // Save or update marks entry
                                    Exam10MarksEntry::updateOrCreate(
                                        [
                                            'myclass_section_id' => $section->id,
                                            'exam_detail_id' => $detail->id,
                                            'studentcr_id' => $student->id
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
                                    
                                    $savedCount++;
                                } catch (\Exception $e) {
                                    $errorCount++;
                                }
                            }
                        }
                    }
                }
            }
        }
        
        if ($savedCount > 0) {
            session()->flash('message', "{$savedCount} marks saved successfully.");
        }
        
        if ($errorCount > 0) {
            session()->flash('error', "{$errorCount} entries had errors and were not saved.");
        }
        
        $this->isEditing = false;
        
        // Reload marks data
        $this->loadMarksData($classId);
    }
    
    public function cancelEdit()
    {
        $this->isEditing = false;
        // Reload original data
        if (isset($this->classes[$this->activeTab])) {
            $this->loadMarksData($this->classes[$this->activeTab]->id);
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