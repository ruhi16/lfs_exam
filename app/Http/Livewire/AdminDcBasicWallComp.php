<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\School;
use App\Models\Session;
use App\Models\Myclass;
use App\Models\Section;
use App\Models\Subject;
use Illuminate\Support\Facades\Hash;

class AdminDcBasicWallComp extends Component
{
    public $activeTab = 'school';
    
    public function render()
    {
        return view('livewire.admin-dc-basic-wall-comp');
    }
    
    public function switchTab($tab)
    {
        $this->activeTab = $tab;
    }
}
