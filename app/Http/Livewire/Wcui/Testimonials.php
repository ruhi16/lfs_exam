<?php

namespace App\Http\Livewire\Wcui;

use Livewire\Component;

class Testimonials extends Component
{
    public $currentTestimonial = 0;
    
    public $testimonials = [
        [
            'name' => 'Mrs. Sarah Johnson',
            'child' => 'Emma (Age 4)',
            'text' => 'Little Stars has been wonderful for Emma. The teachers are so caring and the English medium curriculum has really helped her language development.',
            'rating' => 5
        ],
        [
            'name' => 'Mr. David Smith',
            'child' => 'Alex (Age 3)',
            'text' => 'The structured play-based learning approach is perfect for young children. Alex loves going to school every day!',
            'rating' => 5
        ],
        [
            'name' => 'Mrs. Priya Patel',
            'child' => 'Arjun (Age 5)',
            'text' => 'Excellent preparation for primary school. The facilities are clean and safe, and the staff is very professional.',
            'rating' => 5
        ]
    ];

    public function mount()
    {
        // Auto-rotate testimonials every 5 seconds would be handled by JavaScript
    }

    public function nextTestimonial()
    {
        $this->currentTestimonial = ($this->currentTestimonial + 1) % count($this->testimonials);
    }

    public function prevTestimonial()
    {
        $this->currentTestimonial = ($this->currentTestimonial - 1 + count($this->testimonials)) % count($this->testimonials);
    }

    public function render()
    {
        return view('livewire.wcui.testimonials');
    }
}
