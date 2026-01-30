<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Myclass;
use App\Models\MyclassSubject;
use App\Models\Subject;
use App\Models\Exam01Name;
use App\Models\Exam02Type;
use App\Models\Exam03Part;
use App\Models\Exam05Detail;
use App\Models\Exam06ClassSubject;

class Exam06ExamMyclassSubjectComp extends Component
{
    // Component properties
    public $activeTab = 0;
    public $classes = [];
    public $examStructure = [];
    public $isEditing = false;
    public $classSubjects = [];
    public $selectedMappings = [];

    // Event listeners
    protected $listeners = [
        'refreshComponent' => '$refresh'
    ];

    /**
     * Initialize component
     */
    public function mount()
    {
        $this->loadInitialData();
    }

    /**
     * Load all initial data
     */
    private function loadInitialData()
    {
        $this->loadClasses();

        if (!empty($this->classes)) {
            $this->loadActiveTabData($this->classes[0]->id);
        }
    }

    /**
     * Load classes from database
     */
    private function loadClasses()
    {
        $this->classes = Myclass::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();
    }

    /**
     * Load data for the active tab
     */
    private function loadActiveTabData($classId)
    {
        $this->loadExamStructure($classId);
        $this->loadClassSubjects($classId);
        $this->loadExistingMappings($classId);
    }

    /**
     * Load existing mappings for the checkboxes
     */
    private function loadExistingMappings($classId)
    {
        $mappings = Exam06ClassSubject::where('myclass_id', $classId)->get();

        $this->selectedMappings = [];

        foreach ($mappings as $mapping) {
            $this->selectedMappings[$mapping->subject_id][$mapping->exam_detail_id] = [
                'checked' => true,
                'full_marks' => $mapping->full_marks,
                'pass_marks' => $mapping->pass_marks,
                'time_in_minutes' => $mapping->time_in_minutes,
            ];
        }
    }

    /**
     * Get mapping data safely
     */
    public function getMappingData($subjectId, $examDetailId, $field, $default = null)
    {
        return $this->selectedMappings[$subjectId][$examDetailId][$field] ?? $default;
    }

    /**
     * Load exam structure for a class
     */
    private function loadExamStructure($classId)
    {
        // Get all exam details for this class
        $examDetails = Exam05Detail::where('myclass_id', $classId)
            ->with(['examName', 'examType', 'examPart'])
            ->where('is_active', true)
            ->orderBy('exam_name_id')
            ->orderBy('exam_type_id')
            ->orderBy('exam_part_id')
            ->get();

        // Group by exam_name -> exam_type -> exam_part
        $this->examStructure = $this->groupExamDetails($examDetails);
    }

    /**
     * Group exam details into hierarchical structure
     */
    private function groupExamDetails($examDetails)
    {
        $grouped = [];

        foreach ($examDetails as $detail) {
            $examNameId = $detail->exam_name_id;
            $examTypeId = $detail->exam_type_id;
            $examPartId = $detail->exam_part_id;

            // Ensure relationships exist
            $examName = $detail->examName;
            $examType = $detail->examType;
            $examPart = $detail->examPart;

            // Initialize exam name group
            if (!isset($grouped[$examNameId])) {
                $grouped[$examNameId] = [
                    'name' => $examName ? $examName->name : 'Exam ' . $examNameId,
                    'types' => []
                ];
            }

            // Initialize exam type group
            if (!isset($grouped[$examNameId]['types'][$examTypeId])) {
                $grouped[$examNameId]['types'][$examTypeId] = [
                    'name' => $examType ? $examType->name : 'Type ' . $examTypeId,
                    'parts' => []
                ];
            }

            // Initialize exam part group
            if (!isset($grouped[$examNameId]['types'][$examTypeId]['parts'][$examPartId])) {
                $grouped[$examNameId]['types'][$examTypeId]['parts'][$examPartId] = [
                    'name' => $examPart ? $examPart->name : 'Part ' . $examPartId,
                    'details' => []
                ];
            }

            // Add the exam detail
            $grouped[$examNameId]['types'][$examTypeId]['parts'][$examPartId]['details'][] = $detail;
        }

        return $grouped;
    }

    /**
     * Load class subjects ordered by subject_type descending
     */
    private function loadClassSubjects($classId)
    {
        $this->classSubjects = MyclassSubject::where('myclass_id', $classId)
            ->with(['subject', 'subject.subjectType'])
            ->whereHas('subject')
            ->join('subjects', 'myclass_subjects.subject_id', '=', 'subjects.id')
            ->orderByDesc('subjects.subject_type_id')
            ->orderBy('myclass_subjects.order_index')
            ->select('myclass_subjects.*')
            ->get();
    }

    /**
     * Switch to a different class tab
     */
    public function setActiveTab($index)
    {
        if (!isset($this->classes[$index])) {
            return;
        }

        $this->activeTab = $index;
        $this->loadActiveTabData($this->classes[$index]->id);
    }

    /**
     * Enable editing mode
     */
    public function startEditing()
    {
        $this->isEditing = true;
        $this->refreshData();
    }

    /**
     * Cancel editing
     */
    public function cancelEditing()
    {
        $this->isEditing = false;
        $this->refreshData();
    }

    private function refreshData()
    {
        $this->loadClasses();
        if (!empty($this->classes) && isset($this->classes[$this->activeTab])) {
            // Handle both object (Collection) and array (Hydrated) access
            $class = $this->classes[$this->activeTab];
            $classId = is_object($class) ? $class->id : $class['id'];
            $this->loadActiveTabData($classId);
        }
    }

    /**
     * Save changes for all classes
     */
    public function saveChanges()
    {
        if (!isset($this->classes[$this->activeTab])) {
            session()->flash('error', 'No active class selected.');
            return;
        }

        $this->saveClassData($this->classes[$this->activeTab]->id);
    }

    /**
     * Save changes for a specific class only
     */
    public function saveClassData($classId)
    {
        if (!$classId) {
            session()->flash('error', 'Invalid class selected.');
            return;
        }

        try {
            foreach ($this->selectedMappings as $subjectId => $examDetails) {
                foreach ($examDetails as $examDetailId => $data) {
                    // Check if 'checked' key exists and is true
                    $isSelected = isset($data['checked']) && $data['checked'];

                    if ($isSelected) {
                        // Create or Update
                        $examDetail = Exam05Detail::find($examDetailId);
                        if ($examDetail) {
                            Exam06ClassSubject::updateOrCreate(
                                [
                                    'myclass_id' => $classId,
                                    'subject_id' => $subjectId,
                                    'exam_detail_id' => $examDetailId,
                                ],
                                [
                                    'exam_name_id' => $examDetail->exam_name_id,
                                    'exam_type_id' => $examDetail->exam_type_id,
                                    'exam_part_id' => $examDetail->exam_part_id,
                                    'full_marks' => $data['full_marks'] ?? null,
                                    'pass_marks' => $data['pass_marks'] ?? null,
                                    'time_in_minutes' => $data['time_in_minutes'] ?? null,
                                    'is_active' => true,
                                ]
                            );
                        }
                    } else {
                        // Delete
                        Exam06ClassSubject::where('myclass_id', $classId)
                            ->where('subject_id', $subjectId)
                            ->where('exam_detail_id', $examDetailId)
                            ->delete();
                    }
                }
            }

            // Get class name for the message
            $className = Myclass::find($classId)->name ?? 'Unknown Class';

            session()->flash('message', "Class data saved successfully for: {$className}");
            $this->isEditing = false;

            // Refresh data to ensure consistency
            $this->loadActiveTabData($classId);
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save class data: ' . $e->getMessage());
        }
    }

    /**
     * Render the component
     */
    public function render()
    {
        // Ensure classes are loaded
        if (empty($this->classes)) {
            $this->loadClasses();
        }

        // Ensure active tab data is loaded if classes exist
        if (!empty($this->classes) && isset($this->classes[$this->activeTab])) {
            $class = $this->classes[$this->activeTab];
            $classId = is_object($class) ? $class->id : $class['id'];

            // Reload if structure or subjects are missing (handles hydration issues)
            if (empty($this->examStructure) || empty($this->classSubjects)) {
                $this->loadActiveTabData($classId);
            }
        }

        return view('livewire.exam06-exam-myclass-subject-comp', [
            'classes' => $this->classes,
            'examStructure' => $this->examStructure,
            'classSubjects' => $this->classSubjects,
            'activeTab' => $this->activeTab,
            'isEditing' => $this->isEditing
        ]);
    }
}
