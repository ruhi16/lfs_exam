<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;

class SubAdminDashboardComp extends Component
{
    public $user, $subAdminTeacher;

    public function mount($userId = null){
        $this->subAdminTeacher = auth()->user()->teacher;

        $this->user = User::find($userId) ?? auth()->user();
    }


    public function render(){


        return view('livewire.sub-admin-dashboard-comp');
    }
}
