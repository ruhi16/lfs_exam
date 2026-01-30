<?php

namespace App\Http\Livewire;

use Livewire\Component;

class DebugTestComponent extends Component
{
    public $testData = [];
    public $counter = 0;
    
    public function mount()
    {
        $this->testData = [
            'item_1' => ['name' => 'Test 1', 'value' => 100],
            'item_2' => ['name' => 'Test 2', 'value' => 200],
            'item_3' => ['name' => 'Test 3', 'value' => 300],
        ];
    }
    
    public function increment()
    {
        $this->counter++;
    }
    
    public function render()
    {
        return view('livewire.debug-test-component');
    }
}