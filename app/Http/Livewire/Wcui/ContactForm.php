<?php

namespace App\Http\Livewire\Wcui;

use Livewire\Component;

class ContactForm extends Component
{public $name = '';
    public $email = '';
    public $phone = '';
    public $child_age = '';
    public $program = '';
    public $message = '';
    public $success = false;
    public $showForm = true;

    protected $rules = [
        'name' => 'required|min:2',
        'email' => 'required|email',
        'phone' => 'required|min:10',
        'child_age' => 'required',
        'program' => 'required',
        'message' => 'required|min:10'
    ];

    protected $messages = [
        'name.required' => 'Parent/Guardian name is required.',
        'email.required' => 'Email address is required.',
        'phone.required' => 'Phone number is required.',
        'child_age.required' => 'Child age is required.',
        'program.required' => 'Please select a program.',
        'message.required' => 'Message is required.'
    ];

    public function submit()
    {
        $this->validate();

        // Here you would typically save to database or send email
        // For demo purposes, we'll just show success message
        
        $this->success = true;
        $this->showForm = false;
        
        // Reset form after a delay (this would be handled by JavaScript in real app)
        $this->reset(['name', 'email', 'phone', 'child_age', 'program', 'message']);
    }

    public function resetForm()
    {
        $this->success = false;
        $this->showForm = true;
    }
    public function render()
    {
        return view('livewire.wcui.contact-form');
    }
}
