<?php

namespace App\Http\Livewire\ExamSetting;

use Livewire\Component;
use App\Services\ExamConfigService;

class ExamConfigMatrix extends Component
{
    public $selectedClassId;
    public $examDetails = [];
    public $examNames = [];
    public $examTypes = [];
    public $subjects = [];
    public $subjectTypes = [];
    public $selectedSubjects = [];
    public $savedData = [];
    public $isFinalized = false;

    protected $examConfigService;

    protected $listeners = [
        'classChanged' => 'loadData',
        'subjectToggled' => 'handleSubjectToggle',
        'marksUpdated' => 'handleMarksUpdate',
        'classFinalized' => 'handleClassFinalized'
    ];

    public function boot(ExamConfigService $examConfigService)
    {
        $this->examConfigService = $examConfigService;
    }

    public function mount($selectedClassId = null)
    {
        $this->selectedClassId = $selectedClassId;
        if ($selectedClassId) {
            $this->loadData(['classId' => $selectedClassId]);
        }
    }

    public function loadData($data)
    {
        $this->selectedClassId = $data['classId'] ?? null;
        $this->isFinalized = $data['isFinalized'] ?? false;
        
        if (!$this->selectedClassId) {
            $this->resetData();
            return;
        }

        $this->loadExamDetails();
        $this->loadSubjects();
        $this->loadSubjectTypes();
        $this->loadSavedData();
    }

    public function loadExamDetails()
    {
        $this->examDetails = $this->examConfigService->getExamDetailsForClass($this->selectedClassId);

        // Get unique exam names from the exam details
        $examNamesCollection = $this->examDetails->groupBy('exam_name_id')
            ->map(function ($group) {
                return $group->first()->examName;
            })->values();
        $this->examNames = $examNamesCollection->toArray();

        // Get unique exam types from the exam details  
        $examTypesCollection = $this->examDetails->groupBy('exam_type_id')
            ->map(function ($group) {
                return $group->first()->examType;
            })->values();
        $this->examTypes = $examTypesCollection->toArray();
    }

    public function loadSubjects()
    {
        $this->subjects = $this->examConfigService->getSubjectsForClass($this->selectedClassId);
    }

    public function loadSubjectTypes()
    {
        $this->subjectTypes = $this->examConfigService->getSubjectTypes();
    }

    public function loadSavedData()
    {
        $savedRecords = $this->examConfigService->getSavedDataForClass($this->selectedClassId);
        $this->savedData = $savedRecords->toArray();
        
        // Load existing data into selectedSubjects
        foreach ($savedRecords as $key => $record) {
            $this->selectedSubjects[$key] = true;
        }
    }

    public function handleSubjectToggle($data)
    {
        $examDetailId = $data['examDetailId'];
        $subjectId = $data['subjectId'];
        $isSelected = $data['isSelected'];
        $key = $examDetailId . '_' . $subjectId;

        if ($isSelected) {
            $this->selectedSubjects[$key] = true;
        } else {
            unset($this->selectedSubjects[$key]);
        }

        // Emit event to finalization panel
        $this->emit('dataUpdated', [
            'selectedSubjects' => $this->selectedSubjects,
            'classId' => $this->selectedClassId
        ]);
    }

    public function handleMarksUpdate($data)
    {
        // Update saved data cache
        $key = $data['key'];
        $this->savedData[$key] = array_merge($this->savedData[$key] ?? [], $data['data']);

        // Emit event to finalization panel
        $this->emit('dataUpdated', [
            'selectedSubjects' => $this->selectedSubjects,
            'classId' => $this->selectedClassId
        ]);
    }

    public function handleClassFinalized($classId)
    {
        if ($classId == $this->selectedClassId) {
            $this->isFinalized = true;
        }
    }

    public function getSubjectsByType($subjectTypeId)
    {
        return $this->examConfigService->getSubjectsByType($this->subjects, $subjectTypeId);
    }

    public function getExamDetailsBySubjectType($subjectTypeId)
    {
        return $this->examConfigService->getExamDetailsBySubjectType($this->examDetails, $subjectTypeId);
    }

    public function resetData()
    {
        $this->examDetails = [];
        $this->examNames = [];
        $this->examTypes = [];
        $this->subjects = [];
        $this->selectedSubjects = [];
        $this->savedData = [];
        $this->isFinalized = false;
    }

    public function render()
    {
        return view('livewire.exam-setting.exam-config-matrix');
    }
}