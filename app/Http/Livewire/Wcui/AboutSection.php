<?php

namespace App\Http\Livewire\Wcui;

use Livewire\Component;

class AboutSection extends Component
{
    public $features = [
        [
            'icon' => '🎓',
            'title' => 'Quality Education',
            'description' => 'English medium curriculum designed for early learners with modern teaching methods.'
        ],
        [
            'icon' => '👨‍👩‍👧‍👦',
            'title' => 'Caring Environment',
            'description' => 'Safe, nurturing space where children feel loved and supported in their learning journey.'
        ],
        [
            'icon' => '🎨',
            'title' => 'Creative Learning',
            'description' => 'Arts, crafts, music and play-based activities to develop creativity and motor skills.'
        ],
        [
            'icon' => '🏃‍♂️',
            'title' => 'Physical Development',
            'description' => 'Outdoor play areas and activities to promote healthy physical and social development.'
        ]
    ];

    public function render()
    {
        return view('livewire.wcui.about-section');
    }
}
