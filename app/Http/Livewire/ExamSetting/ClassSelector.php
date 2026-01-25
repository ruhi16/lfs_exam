<?php

namespace App\Http\Livewire\ExamSetting;

use Livewire\Component;
use App\Services\ExamConfigService;

class ClassSelector extends Component
{
    public $classes = [];
    public $selectedClassId;
    public $isFinalized = false;

    protected $examConfigService;

    public function boot(ExamConfigService $examConfigService)
    {
        $this->examConfigService = $examConfigService;
    }

    public function mount()
    {
        $this->loadClasses();
    }

    public function loadClasses()
    {
        $this->classes = $this->examConfigService->getClassesForUser();
    }

    public function updatedSelectedClassId($value)
    {
        if ($value) {
            // Check if the selected class is finalized
            $this->isFinalized = $this->examConfigService->isClassFinalized($value);
        } else {
            $this->isFinalized = false;
        }

        // Emit event to parent component
        $this->emit('classChanged', [
            'classId' => $value,
            'isFinalized' => $this->isFinalized
        ]);
    }

    public function render()
    {
        return view('livewire.exam-setting.class-selector');
    }
}