<?php

namespace App\Http\Livewire\Wcui;

use Livewire\Component;

class SchoolInfo extends Component
{
    public $schoolData = [
        'name' => 'Little Stars Nursery School',
        'established' => '2010',
        'students' => '200+',
        'teachers' => '15',
        'programs' => '4',
        'address' => '123 Education Street, City Center',
        'phone' => '+1 234 567 8900',
        'email' => 'info@littlestarsnursery.com',
        'timings' => [
            'Monday - Friday' => '8:00 AM - 5:00 PM',
            'Saturday' => '9:00 AM - 12:00 PM',
            'Sunday' => 'Closed'
        ],
        'facilities' => [
            'Air Conditioned Classrooms',
            'Indoor Play Area',
            'Outdoor Playground',
            'Library Corner',
            'Art & Craft Room',
            'Computer Lab',
            'Medical Room',
            'CCTV Security'
        ]
    ];
    public function render()
    {
        return view('livewire.wcui.school-info');
    }
}
