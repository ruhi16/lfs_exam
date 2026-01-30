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
use Illuminate\Support\Facades\Log;

class Exam06ExamMyclassSubjectComp extends Component
{
    public $activeTab = 0;
    public $classes = [];
    public $examStructure = [];
    public $selectedSubjects = [];
    public $isEditing = false;
    
    protected $rules = [
        'selectedSubjects.*.full_marks' => 'nullable|integer|min:0',
        'selectedSubjects.*.pass_marks' => 'nullable|integer|min:0',
        'selectedSubjects.*.is_optional' => 'boolean',
    ];
    
    protected $listeners = ['refreshComponent' => '$refresh'];
    
    public function mount()
    {
        $this->loadClasses();
        $this->selectedSubjects = []; // Initialize empty array
        if (!empty($this->classes)) {
            $this->loadExamStructure($this->classes[0]->id);
            $this->loadSelectedSubjects($this->classes[0]->id);
        }
    }
    
    public function loadClasses()
    {
        $this->classes = Myclass::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();
    }
    
    public function loadExamStructure($classId)
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
        $grouped = [];
        foreach ($examDetails as $detail) {
            $examNameId = $detail->exam_name_id;
            $examTypeId = $detail->exam_type_id;
            $examPartId = $detail->exam_part_id;
            
            // Ensure relationships exist before accessing properties
            $examName = $detail->examName;
            $examType = $detail->examType;
            $examPart = $detail->examPart;
            
            if (!isset($grouped[$examNameId])) {
                $grouped[$examNameId] = [
                    'name' => $examName ? $examName->name : 'Exam ' . $examNameId,
                    'types' => []
                ];
            }
            
            if (!isset($grouped[$examNameId]['types'][$examTypeId])) {
                $grouped[$examNameId]['types'][$examTypeId] = [
                    'name' => $examType ? $examType->name : 'Type ' . $examTypeId,
                    'parts' => []
                ];
            }
            
            if (!isset($grouped[$examNameId]['types'][$examTypeId]['parts'][$examPartId])) {
                $grouped[$examNameId]['types'][$examTypeId]['parts'][$examPartId] = [
                    'name' => $examPart ? $examPart->name : 'Part ' . $examPartId,
                    'details' => []
                ];
            }
            
            $grouped[$examNameId]['types'][$examTypeId]['parts'][$examPartId]['details'][] = $detail;
        }
        
        $this->examStructure = $grouped;
    }
    
    public function loadSelectedSubjects($classId)
    {
        // Load existing exam_class_subject mappings
        $existingMappings = Exam06ClassSubject::where('myclass_id', $classId)
            ->get()
            ->keyBy(function ($item) {
                return $item->exam_detail_id . '_' . $item->subject_id;
            });
        
        $this->selectedSubjects = [];
        foreach ($existingMappings as $mapping) {
            // Ensure required fields exist
            if (!$mapping->exam_detail_id || !$mapping->subject_id) {
                continue;
            }
            
            $key = $mapping->exam_detail_id . '_' . $mapping->subject_id;
            $this->selectedSubjects[$key] = [
                'is_selected' => true,
                'full_marks' => $mapping->full_marks ?? 100,
                'pass_marks' => $mapping->pass_marks ?? 33,
                'time_in_minutes' => $mapping->time_in_minutes ?? 180,
                'is_optional' => $mapping->is_optional ?? false,
                'exam_weightage' => $mapping->exam_weightage ?? 100
            ];
        }
    }
    
    public function setActiveTab($index)
    {
        $this->activeTab = $index;
        if (isset($this->classes[$index])) {
            $this->loadExamStructure($this->classes[$index]->id);
            $this->loadSelectedSubjects($this->classes[$index]->id);
        }
    }
    
    public function toggleSubject($examDetailId, $subjectId)
    {
        $key = $examDetailId . '_' . $subjectId;
        
        if (isset($this->selectedSubjects[$key])) {
            unset($this->selectedSubjects[$key]);
        } else {
            $this->selectedSubjects[$key] = [
                'is_selected' => true,
                'full_marks' => 100,
                'pass_marks' => 33,
                'time_in_minutes' => 180,
                'is_optional' => false,
                'exam_weightage' => 100
            ];
        }
    }
    
    public function updated($field, $value)
    {
        // Log the update for debugging
        \Log::info('Livewire field updated: ' . $field . ' = ' . $value);
        // This will be called automatically when any property is updated
        // We can add validation or additional logic here if needed
    }
    
    public function updateSubjectData($examDetailId, $subjectId, $field, $value)
    {
        $key = $examDetailId . '_' . $subjectId;
        if (isset($this->selectedSubjects[$key])) {
            $this->selectedSubjects[$key][$field] = $value;
        }
    }
    
    public function startEditing()
    {
        $this->isEditing = true;
        // Ensure we have the latest data but preserve existing selections
        $existingSelections = $this->selectedSubjects;
        if (isset($this->classes[$this->activeTab])) {
            $this->loadExamStructure($this->classes[$this->activeTab]->id);
            $this->loadSelectedSubjects($this->classes[$this->activeTab]->id);
            // Merge back any existing selections that might have been cleared
            $this->selectedSubjects = array_merge($this->selectedSubjects, $existingSelections);
        }
    }
    
    public function cancelEditing()
    {
        $this->isEditing = false;
        // Reload original data
        if (isset($this->classes[$this->activeTab])) {
            $this->loadSelectedSubjects($this->classes[$this->activeTab]->id);
        }
    }
    
    public function saveChanges()
    {
        if (!isset($this->classes[$this->activeTab])) {
            session()->flash('error', 'No active class selected.');
            return;
        }
        
        $classId = $this->classes[$this->activeTab]->id;
        $savedCount = 0;
        $deletedCount = 0;
        
        try {
            // Get all existing mappings for this class
            $existingMappings = Exam06ClassSubject::where('myclass_id', $classId)->get();
            
            // Delete mappings that are no longer selected
            foreach ($existingMappings as $mapping) {
                $key = $mapping->exam_detail_id . '_' . $mapping->subject_id;
                if (!isset($this->selectedSubjects[$key])) {
                    $mapping->delete();
                    $deletedCount++;
                }
            }
            
            // Create/update selected mappings
            foreach ($this->selectedSubjects as $key => $data) {
                if ($data['is_selected']) {
                    list($examDetailId, $subjectId) = explode('_', $key);
                    
                    Exam06ClassSubject::updateOrCreate(
                        [
                            'exam_detail_id' => $examDetailId,
                            'myclass_id' => $classId,
                            'subject_id' => $subjectId
                        ],
                        [
                            'full_marks' => $data['full_marks'],
                            'pass_marks' => $data['pass_marks'],
                            'time_in_minutes' => $data['time_in_minutes'],
                            'is_optional' => $data['is_optional'],
                            'exam_weightage' => $data['exam_weightage'],
                            'is_active' => true,
                            'session_id' => session('session_id') ?? 1,
                            'school_id' => session('school_id') ?? 1,
                            'user_id' => auth()->id() ?? 1
                        ]
                    );
                    $savedCount++;
                }
            }
            
            session()->flash('message', "Changes saved successfully. ${savedCount} created/updated, ${deletedCount} removed.");
            $this->isEditing = false;
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save changes: ' . $e->getMessage());
        }
    }
    
    public function render()
    {
        $classSubjects = collect();
        if (isset($this->classes[$this->activeTab]) && $this->classes[$this->activeTab]) {
            $classId = $this->classes[$this->activeTab]->id;
            $classSubjects = MyclassSubject::where('myclass_id', $classId)
                ->with(['subject', 'subject.subjectType'])
                ->whereHas('subject') // Ensure subject exists
                ->orderBy('order_index')
                ->get();
        }
        
        return view('livewire.exam06-exam-myclass-subject-comp', [
            'classes' => $this->classes,
            'examStructure' => $this->examStructure,
            'classSubjects' => $classSubjects,
            'selectedSubjects' => $this->selectedSubjects,
            'activeTab' => $this->activeTab,
            'isEditing' => $this->isEditing
        ]);
    }
}
