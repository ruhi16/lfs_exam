<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Myclass;
use App\Models\Exam01Name;
use App\Models\Exam02Type;
use App\Models\Exam03Part;
use App\Models\Exam04Mode;
use App\Models\Exam05Detail;
use App\Models\Session;
use App\Models\School;

class Exam05ExamDetailComp extends Component
{
    public $classes = [];
    public $examNames = [];
    public $examTypes = [];
    public $examParts = [];
    public $examModes = [];
    public $sessions = [];
    public $schools = [];
    
    public $examStructure = [];
    public $selectedModes = [];
    public $selectedDetails = [];
    
    public $isEditing = false;
    public $search = '';
    public $selectedSession = '';
    public $selectedExamName = '';
    
    protected $rules = [
        'selectedModes.*' => 'nullable|exists:exam04_modes,id',
    ];
    
    public function mount()
    {
        $this->loadData();
        $this->loadExamStructure();
    }
    
    public function loadData()
    {
        // Load all required data
        $this->classes = Myclass::where('is_active', true)->orderBy('id')->get();
        $this->examNames = Exam01Name::where('is_active', true)->orderBy('id')->get();
        $this->examTypes = Exam02Type::where('is_active', true)->orderBy('id')->get();
        $this->examParts = Exam03Part::where('is_active', true)->orderBy('id')->get();
        $this->examModes = Exam04Mode::where('is_active', true)->orderBy('id')->get();
        $this->sessions = Session::where('is_active', true)->orderBy('id')->get();
        $this->schools = School::where('is_active', true)->orderBy('id')->get();
    }
    
    public function loadExamStructure()
    {
        // Build the exam structure: exam_name -> exam_type -> exam_part
        $structure = [];
        
        foreach ($this->examNames as $examName) {
            $structure[$examName->id] = [
                'name' => $examName->name,
                'types' => []
            ];
            
            foreach ($this->examTypes as $examType) {
                $structure[$examName->id]['types'][$examType->id] = [
                    'name' => $examType->name,
                    'parts' => []
                ];
                
                foreach ($this->examParts as $examPart) {
                    $structure[$examName->id]['types'][$examType->id]['parts'][$examPart->id] = [
                        'name' => $examPart->name,
                        'details' => []
                    ];
                }
            }
        }
        
        $this->examStructure = $structure;
        
        // Load existing exam details
        $this->loadExistingDetails();
    }
    
    public function loadExistingDetails()
    {
        $query = Exam05Detail::with(['examName', 'examType', 'examPart', 'examMode', 'myclass']);
        
        if ($this->selectedSession) {
            $query->where('session_id', $this->selectedSession);
        }
        
        if ($this->selectedExamName) {
            $query->where('exam_name_id', $this->selectedExamName);
        }
        
        if ($this->search) {
            $query->where(function($q) {
                $q->whereHas('examName', function($subq) {
                    $subq->where('name', 'like', '%' . $this->search . '%');
                })->orWhereHas('examType', function($subq) {
                    $subq->where('name', 'like', '%' . $this->search . '%');
                })->orWhereHas('examPart', function($subq) {
                    $subq->where('name', 'like', '%' . $this->search . '%');
                })->orWhere('name', 'like', '%' . $this->search . '%');
            });
        }
        
        $examDetails = $query->get();
        
        // Reset selections
        $this->selectedModes = [];
        $this->selectedDetails = [];
        
        // Populate existing selections
        foreach ($examDetails as $detail) {
            $key = $detail->myclass_id . '_' . $detail->exam_name_id . '_' . $detail->exam_type_id . '_' . $detail->exam_part_id;
            $this->selectedDetails[$key] = true;
            $this->selectedModes[$key] = $detail->exam_mode_id;
        }
    }
    
    public function updated($field, $value)
    {
        if (in_array($field, ['search', 'selectedSession', 'selectedExamName'])) {
            $this->loadExistingDetails();
        }
    }
    
    public function toggleExamDetail($classId, $examNameId, $examTypeId, $examPartId)
    {
        $key = $classId . '_' . $examNameId . '_' . $examTypeId . '_' . $examPartId;
        
        if (isset($this->selectedDetails[$key])) {
            // Remove selection
            unset($this->selectedDetails[$key]);
            unset($this->selectedModes[$key]);
        } else {
            // Add selection with default mode
            $this->selectedDetails[$key] = true;
            $firstMode = $this->examModes->first();
            $this->selectedModes[$key] = $firstMode ? $firstMode->id : null;
        }
    }
    
    public function startEditing()
    {
        $this->isEditing = true;
    }
    
    public function cancelEditing()
    {
        $this->isEditing = false;
        $this->loadExistingDetails();
    }
    
    public function saveChanges()
    {
        try {
            // Get existing exam details for current session/filter
            $existingQuery = Exam05Detail::query();
            
            if ($this->selectedSession) {
                $existingQuery->where('session_id', $this->selectedSession);
            }
            
            $existingDetails = $existingQuery->get();
            
            $createdCount = 0;
            $updatedCount = 0;
            $deletedCount = 0;
            
            // Handle deletions - remove details that are no longer selected
            foreach ($existingDetails as $existingDetail) {
                $key = $existingDetail->myclass_id . '_' . $existingDetail->exam_name_id . '_' . $existingDetail->exam_type_id . '_' . $existingDetail->exam_part_id;
                
                if (!isset($this->selectedDetails[$key])) {
                    $existingDetail->delete();
                    $deletedCount++;
                }
            }
            
            // Handle creations/updates
            foreach ($this->selectedDetails as $key => $isSelected) {
                if (!$isSelected) continue;
                
                list($classId, $examNameId, $examTypeId, $examPartId) = explode('_', $key);
                $modeId = $this->selectedModes[$key] ?? null;
                
                if (!$modeId) continue;
                
                // Create or update exam detail
                $examDetail = Exam05Detail::updateOrCreate(
                    [
                        'myclass_id' => $classId,
                        'exam_name_id' => $examNameId,
                        'exam_type_id' => $examTypeId,
                        'exam_part_id' => $examPartId,
                        'session_id' => $this->selectedSession ?: session('session_id') ?? 1
                    ],
                    [
                        'exam_mode_id' => $modeId,
                        'name' => $this->generateExamDetailName($classId, $examNameId, $examTypeId, $examPartId),
                        'is_active' => true,
                        'is_finalized' => false,
                        'school_id' => session('school_id') ?? 1
                    ]
                );
                
                if ($examDetail->wasRecentlyCreated) {
                    $createdCount++;
                } else {
                    $updatedCount++;
                }
            }
            
            session()->flash('message', "Saved successfully: $createdCount created, $updatedCount updated, $deletedCount deleted.");
            $this->isEditing = false;
            
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save: ' . $e->getMessage());
        }
    }
    
    private function generateExamDetailName($classId, $examNameId, $examTypeId, $examPartId)
    {
        $class = $this->classes->firstWhere('id', $classId);
        $examName = $this->examNames->firstWhere('id', $examNameId);
        $examType = $this->examTypes->firstWhere('id', $examTypeId);
        $examPart = $this->examParts->firstWhere('id', $examPartId);
        
        return sprintf('%s - %s - %s - %s', 
            $class->name ?? 'Class',
            $examName->name ?? 'Exam',
            $examType->name ?? 'Type',
            $examPart->name ?? 'Part'
        );
    }
    
    public function render()
    {
        return view('livewire.exam05-exam-detail-comp', [
            'classes' => $this->classes,
            'examNames' => $this->examNames,
            'examTypes' => $this->examTypes,
            'examParts' => $this->examParts,
            'examModes' => $this->examModes,
            'examStructure' => $this->examStructure,
            'selectedModes' => $this->selectedModes,
            'selectedDetails' => $this->selectedDetails,
            'isEditing' => $this->isEditing,
            'search' => $this->search,
            'selectedSession' => $this->selectedSession,
            'selectedExamName' => $this->selectedExamName,
            'sessions' => $this->sessions
        ]);
    }
}