<?php

namespace App\Http\Livewire;

use Livewire\Component;



class UserChangePasswordComponent extends Component
{
    // public $layout = 'layouts.user-dashboard';
    public $showModal = true;


    public function render()
    {
        return view('livewire.user-change-password-component')
            // ->layout('components.layouts.app')
            ;
    }
}
