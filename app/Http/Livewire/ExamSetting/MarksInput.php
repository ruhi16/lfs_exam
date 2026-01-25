<?php

namespace App\Http\Livewire\ExamSetting;

use Livewire\Component;
use App\Services\ExamConfigService;

class MarksInput extends Component
{
    public $examDetailId;
    public $subjectId;
    public $classId;
    public $fullMarks = '';
    public $passMarks = '';
    public $timeAllotted = '';
    public $isEnabled = false;
    public $isFinalized = false;
    public $key; // Unique identifier for this input group

    protected $examConfigService;

    protected $rules = [
        'fullMarks' => 'nullable|numeric|min:0|max:1000',
        'passMarks' => 'nullable|numeric|min:0|max:1000',
        'timeAllotted' => 'nullable|numeric|min:0|max:600',
    ];

    public function boot(ExamConfigService $examConfigService)
    {
        $this->examConfigService = $examConfigService;
    }

    public function mount($examDetailId, $subjectId, $classId, $isEnabled = false, $isFinalized = false, $savedData = [])
    {
        $this->examDetailId = $examDetailId;
        $this->subjectId = $subjectId;
        $this->classId = $classId;
        $this->isEnabled = $isEnabled;
        $this->isFinalized = $isFinalized;
        $this->key = $examDetailId . '_' . $subjectId;

        // Load saved data if available
        if (!empty($savedData)) {
            $this->fullMarks = $savedData['full_marks'] ?? '';
            $this->passMarks = $savedData['pass_marks'] ?? '';
            $this->timeAllotted = $savedData['time_in_minutes'] ?? '';
        }
    }

    public function updatedFullMarks($value)
    {
        $this->validateOnly('fullMarks');
        $this->autoSave();
    }

    public function updatedPassMarks($value)
    {
        $this->validateOnly('passMarks');
        
        // Validate that pass marks doesn't exceed full marks
        if ($this->fullMarks && $value > $this->fullMarks) {
            $this->addError('passMarks', 'Pass marks cannot exceed full marks.');
            return;
        }
        
        $this->autoSave();
    }

    public function updatedTimeAllotted($value)
    {
        $this->validateOnly('timeAllotted');
        $this->autoSave();
    }

    private function autoSave()
    {
        if (!$this->isEnabled || $this->isFinalized) {
            return;
        }

        try {
            $data = [
                'full_marks' => (int) $this->fullMarks,
                'pass_marks' => (int) $this->passMarks,
                'time_in_minutes' => (int) $this->timeAllotted,
            ];

            $this->examConfigService->saveSubjectConfiguration(
                $this->examDetailId,
                $this->classId,
                $this->subjectId,
                $data
            );

            // Emit event to parent about successful save
            $this->emit('marksUpdated', [
                'key' => $this->key,
                'examDetailId' => $this->examDetailId,
                'subjectId' => $this->subjectId,
                'data' => $data
            ]);

            // Show brief success indicator
            $this->emit('showSaveIndicator', $this->key);

        } catch (\Exception $e) {
            $this->emit('showError', 'Error saving data: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.exam-setting.marks-input');
    }
}