<?php

namespace App\Http\Livewire;

use Livewire\Component;

class Contact extends Component{
    public $examNames;
    
    public $examTypes = [];
    public $examParts = [];
    public $examModes = [];
    

    public $selectedExamNames = [];
    public $selectedExamTypes = [];
    public $selectedExamParts = [];
    public $selectedExamModes = [];


    // public $selectedExamName;
    // public $selectedExamType;
    // public $selectedExamPart;
    
    public $entries = [];
    public $newEntry = [
        'exam_name_id' => null,
        'exam_type_id' => null,
        'exam_part_id' => null,
        'exam_mode_id' => null
    ];

    public function mount()
    {
        $this->examNames = \App\Models\Exam01Name::all();
        $this->examTypes = \App\Models\Exam02Type::all();
        $this->examParts = \App\Models\Exam03Part::all();
        $this->examModes = \App\Models\Exam04Mode::all();
        // $this->examNames = ExamName::all();
        $this->entries = collect();
    }

    public function updatedSelectedExamName($value){
        // dd($value);
        // $this->examTypes = ExamType::where('exam_name_id', $value)->get();
        // $this->selectedExamType = null;
        // $this->examParts = [];
        // $this->selectedExamPart = null;
        // $this->examModes = [];
    }

    public function updatedSelectedExamType($value)
    {
        $this->examParts = ExamPart::where('exam_type_id', $value)->get();
        $this->selectedExamPart = null;
        $this->examModes = [];
    }

    public function updatedSelectedExamPart($value)
    {
        $this->examModes = ExamMode::where('exam_part_id', $value)->get();
    }

    public function addEntry()
    {
        $this->validate([
            'newEntry.exam_name_id' => 'required|exists:exam_names,id',
            'newEntry.exam_type_id' => 'required|exists:exam_types,id',
            'newEntry.exam_part_id' => 'required|exists:exam_parts,id',
            'newEntry.exam_mode_id' => 'required|exists:exam_modes,id',
        ]);

        $this->entries->push([
            'exam_name' => ExamName::find($this->newEntry['exam_name_id'])->name,
            'exam_type' => ExamType::find($this->newEntry['exam_type_id'])->name,
            'exam_part' => ExamPart::find($this->newEntry['exam_part_id'])->name,
            'exam_mode' => ExamMode::find($this->newEntry['exam_mode_id'])->name,
            'exam_name_id' => $this->newEntry['exam_name_id'],
            'exam_type_id' => $this->newEntry['exam_type_id'],
            'exam_part_id' => $this->newEntry['exam_part_id'],
            'exam_mode_id' => $this->newEntry['exam_mode_id'],
        ]);

        $this->resetNewEntry();
    }

    public function removeEntry($index)
    {
        $this->entries->forget($index);
    }

    public function resetNewEntry()
    {
        $this->newEntry = [
            'exam_name_id' => null,
            'exam_type_id' => null,
            'exam_part_id' => null,
            'exam_mode_id' => null
        ];
        $this->selectedExamName = null;
        $this->selectedExamType = null;
        $this->selectedExamPart = null;
        $this->examTypes = [];
        $this->examParts = [];
        $this->examModes = [];
    }
    public function saveExamConfiguration($examNameId)
{
    // Get all selected options for this exam name
    $configuration = [
        'exam_name_id' => $examNameId,
        'exam_types' => $this->selectedExamTypes[$examNameId] ?? [],
        'exam_parts' => $this->selectedExamParts[$examNameId] ?? [],
        'exam_modes' => $this->selectedExamModes[$examNameId] ?? [],
    ];
    dd($configuration);
    
    // Save the configuration (implement your save logic here)
    // Example:
    // ExamConfiguration::updateOrCreate(
    //     ['exam_name_id' => $examNameId],
    //     ['configuration' => json_encode($configuration)]
    // );
    
    // Show success message
    session()->flash('message', 'Configuration saved successfully!');
}

    public function saveAll()
    {
        // Process all entries here (save to database, etc.)
        // Example:
        // foreach ($this->entries as $entry) {
        //     YourModel::create($entry);
        // }

        session()->flash('message', 'All entries saved successfully!');
        $this->entries = collect();
    }

    
    public function render()
    {
        return view('livewire.contact');
    }
}
