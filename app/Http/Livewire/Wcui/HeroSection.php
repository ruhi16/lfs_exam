<?php

namespace App\Http\Livewire\Wcui;

use Livewire\Component;

class HeroSection extends Component
{
    public $currentSlide = 0;
    public $slides = [
        [
            'title' => 'Welcome to Little Stars Nursery',
            'subtitle' => 'Where Learning Begins with Love',
            'description' => 'Nurturing young minds in a safe, caring environment with quality English medium education.',
            'image' => '/images/hero-1.jpg'
        ],
        [
            'title' => 'Play, Learn & Grow',
            'subtitle' => 'Building Tomorrow\'s Leaders',
            'description' => 'Comprehensive early childhood education with focus on creativity and character development.',
            'image' => '/images/hero-2.jpg'
        ],
        [
            'title' => 'Excellence in Early Education',
            'subtitle' => 'Experienced & Caring Teachers',
            'description' => 'Qualified educators dedicated to each child\'s individual growth and development.',
            'image' => '/images/hero-3.jpg'
        ]
    ];

    public function mount()
    {
        $this->currentSlide = 0;
    }

    public function nextSlide()
    {
        $this->currentSlide = ($this->currentSlide + 1) % count($this->slides);
    }

    public function prevSlide()
    {
        $this->currentSlide = ($this->currentSlide - 1 + count($this->slides)) % count($this->slides);
    }

    public function goToSlide($index)
    {
        $this->currentSlide = $index;
    }

    public function render()
    {
        return view('livewire.wcui.hero-section');
    }
}
