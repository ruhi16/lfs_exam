<?php

namespace App\Http\Livewire\ExamSetting;

use Livewire\Component;
use App\Services\ExamConfigService;

class ExamSettingContainer extends Component
{
    public $selectedClassId;
    public $isFinalized = false;
    public $showNotifications = true;

    protected $examConfigService;

    protected $listeners = [
        'classChanged' => 'handleClassChange',
        'classFinalized' => 'handleClassFinalized',
        'showError' => 'handleError',
        'dataUpdated' => 'handleDataUpdate'
    ];

    public function boot(ExamConfigService $examConfigService)
    {
        $this->examConfigService = $examConfigService;
    }

    public function mount()
    {
        // Initialize component
    }

    public function handleClassChange($data)
    {
        $this->selectedClassId = $data['classId'] ?? null;
        $this->isFinalized = $data['isFinalized'] ?? false;
        
        // Clear any previous notifications
        session()->forget(['success', 'error']);
    }

    public function handleClassFinalized($classId)
    {
        if ($classId == $this->selectedClassId) {
            $this->isFinalized = true;
        }
    }

    public function handleError($message)
    {
        session()->flash('error', $message);
    }

    public function handleDataUpdate($data)
    {
        // This can be used for any global state updates if needed
        // Currently just passes through to child components
    }

    public function render()
    {
        return view('livewire.exam-setting.container');
    }
}