<?php

namespace App\Http\Livewire;

use Livewire\Component;

class SimpleTestComponent extends Component
{
    public $simpleData = [];
    
    public function mount()
    {
        // Initialize with simple test data
        $this->simpleData = [
            'math' => ['subject' => 'Mathematics', 'marks' => 85],
            'science' => ['subject' => 'Science', 'marks' => 92],
            'english' => ['subject' => 'English', 'marks' => 78]
        ];
    }
    
    public function render()
    {
        return view('livewire.simple-test-component');
    }
}