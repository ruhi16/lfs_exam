<?php

namespace App\Http\Livewire\ExamSetting;

use Livewire\Component;
use App\Services\ExamConfigService;

class SubjectRow extends Component
{
    public $subject;
    public $examDetails;
    public $subjectType;
    public $classId;
    public $selectedSubjects = [];
    public $savedData = [];
    public $isFinalized = false;

    protected $examConfigService;

    public function boot(ExamConfigService $examConfigService)
    {
        $this->examConfigService = $examConfigService;
    }

    public function mount($subject, $examDetails, $subjectType, $classId, $selectedSubjects = [], $savedData = [], $isFinalized = false)
    {
        $this->subject = $subject;
        $this->examDetails = $examDetails;
        $this->subjectType = $subjectType;
        $this->classId = $classId;
        $this->selectedSubjects = $selectedSubjects;
        $this->savedData = $savedData;
        $this->isFinalized = $isFinalized;
    }

    public function toggleSubject($examDetailId, $subjectId)
    {
        // Prevent changes if finalized
        if ($this->isFinalized) {
            session()->flash('error', 'Cannot modify data: Class exam settings are finalized.');
            return;
        }

        $key = $examDetailId . '_' . $subjectId;
        
        if (isset($this->selectedSubjects[$key]) && $this->selectedSubjects[$key]) {
            // If unchecking, delete the data first
            try {
                $this->examConfigService->deleteSubjectConfiguration($examDetailId, $this->classId, $subjectId);
                
                // Remove from selected subjects
                unset($this->selectedSubjects[$key]);
                
                // Emit event to parent
                $this->emit('subjectToggled', [
                    'examDetailId' => $examDetailId,
                    'subjectId' => $subjectId,
                    'isSelected' => false,
                    'selectedSubjects' => $this->selectedSubjects
                ]);
                
            } catch (\Exception $e) {
                session()->flash('error', 'Error removing subject: ' . $e->getMessage());
            }
        } else {
            // If checking, enable the inputs
            $this->selectedSubjects[$key] = true;
            
            // Emit event to parent
            $this->emit('subjectToggled', [
                'examDetailId' => $examDetailId,
                'subjectId' => $subjectId,
                'isSelected' => true,
                'selectedSubjects' => $this->selectedSubjects
            ]);
        }
    }

    public function isSubjectTypeEnabledForExam($examDetail)
    {
        return $this->examConfigService->isSubjectTypeEnabledForExam($this->subjectType->id, $examDetail);
    }

    public function isSubjectSelected($examDetailId, $subjectId)
    {
        $key = $examDetailId . '_' . $subjectId;
        return isset($this->selectedSubjects[$key]) && $this->selectedSubjects[$key];
    }

    public function getSavedDataForKey($key)
    {
        return $this->savedData[$key] ?? [];
    }

    public function render()
    {
        return view('livewire.exam-setting.subject-row');
    }
}