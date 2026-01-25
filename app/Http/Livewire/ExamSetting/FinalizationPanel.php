<?php

namespace App\Http\Livewire\ExamSetting;

use Livewire\Component;
use App\Services\ExamConfigService;

class FinalizationPanel extends Component
{
    public $selectedClassId;
    public $canFinalize = false;
    public $isFinalized = false;
    public $completionStatus = [];
    public $selectedSubjects = [];
    public $subjectTypes = [];

    protected $examConfigService;

    protected $listeners = [
        'dataUpdated' => 'checkFinalizationStatus',
        'marksUpdated' => 'handleMarksUpdate',
        'subjectToggled' => 'handleSubjectToggle'
    ];

    public function boot(ExamConfigService $examConfigService)
    {
        $this->examConfigService = $examConfigService;
    }

    public function mount($selectedClassId = null, $isFinalized = false)
    {
        $this->selectedClassId = $selectedClassId;
        $this->isFinalized = $isFinalized;
        
        if ($selectedClassId) {
            $this->loadSubjectTypes();
            $this->checkFinalizationStatus();
        }
    }

    public function loadSubjectTypes()
    {
        $this->subjectTypes = $this->examConfigService->getSubjectTypes();
    }

    public function handleMarksUpdate($data)
    {
        $this->checkFinalizationStatus();
    }

    public function handleSubjectToggle($data)
    {
        $this->selectedSubjects = $data['selectedSubjects'] ?? [];
        $this->checkFinalizationStatus();
    }

    public function checkFinalizationStatus()
    {
        if (!$this->selectedClassId || $this->isFinalized) {
            $this->canFinalize = false;
            return;
        }

        // Get saved data to check completion
        $savedData = $this->examConfigService->getSavedDataForClass($this->selectedClassId);
        
        $hasAnyData = $savedData->isNotEmpty();
        $allDataComplete = true;

        // Check if all saved records have complete data
        foreach ($savedData as $record) {
            if (empty($record->full_marks) || 
                empty($record->pass_marks) || 
                empty($record->time_in_minutes)) {
                $allDataComplete = false;
                break;
            }
        }

        $this->canFinalize = $hasAnyData && $allDataComplete;

        // Update completion status for UI feedback
        $this->updateCompletionStatus($savedData);
    }

    private function updateCompletionStatus($savedData)
    {
        $this->completionStatus = [];
        
        foreach ($this->subjectTypes as $subjectType) {
            $typeRecords = $savedData->filter(function($record) use ($subjectType) {
                return $record->subject && $record->subject->subject_type_id == $subjectType->id;
            });

            $complete = $typeRecords->every(function($record) {
                return !empty($record->full_marks) && 
                       !empty($record->pass_marks) && 
                       !empty($record->time_in_minutes);
            });

            $this->completionStatus[$subjectType->id] = [
                'hasData' => $typeRecords->isNotEmpty(),
                'isComplete' => $complete,
                'count' => $typeRecords->count()
            ];
        }
    }

    public function finalizeClass()
    {
        if (!$this->canFinalize) {
            session()->flash('error', 'Cannot finalize: Please ensure all selected subjects have complete data (Full Marks, Pass Marks, and Time).');
            return;
        }

        try {
            $this->examConfigService->finalizeClassConfiguration($this->selectedClassId);
            
            $this->isFinalized = true;
            $this->canFinalize = false;
            
            session()->flash('success', 'Class exam settings have been finalized successfully! Data entry is now locked.');
            
            // Emit event to notify parent components
            $this->emit('classFinalized', $this->selectedClassId);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Error finalizing class: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.exam-setting.finalization-panel');
    }
}