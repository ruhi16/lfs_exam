<?php

namespace App\Http\Livewire\Wcui;

use Livewire\Component;

class Programs extends Component
{
    public $activeTab = 'playgroup';
    
    public $programs = [
        'playgroup' => [
            'name' => 'Playgroup',
            'age' => '1.5 - 2.5 Years',
            'duration' => '2 Hours',
            'description' => 'Introduction to structured play and social interaction.',
            'features' => [
                'Sensory play activities',
                'Basic social skills',
                'Motor skill development',
                'Toilet training support'
            ]
        ],
        'nursery' => [
            'name' => 'Nursery',
            'age' => '2.5 - 3.5 Years',
            'duration' => '3 Hours',
            'description' => 'Foundation learning with focus on language and creativity.',
            'features' => [
                'English language introduction',
                'Art and craft activities',
                'Story telling sessions',
                'Number recognition'
            ]
        ],
        'lkg' => [
            'name' => 'LKG',
            'age' => '3.5 - 4.5 Years',
            'duration' => '4 Hours',
            'description' => 'Structured learning with academic preparation.',
            'features' => [
                'Letter recognition',
                'Basic phonics',
                'Simple mathematics',
                'Environmental awareness'
            ]
        ],
        'ukg' => [
            'name' => 'UKG',
            'age' => '4.5 - 5.5 Years',
            'duration' => '5 Hours',
            'description' => 'School readiness program with comprehensive curriculum.',
            'features' => [
                'Reading and writing',
                'Mathematical concepts',
                'Science introduction',
                'Computer basics'
            ]
        ]
    ];

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
    }
    public function render()
    {
        return view('livewire.wcui.programs');
    }
}
