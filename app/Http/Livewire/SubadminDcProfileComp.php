<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Teacher;

class SubadminDcProfileComp extends Component
{
    public $user;
    public $teacher;
    public $role;
    
    public function mount()
    {
        // Get authenticated user with relationships
        $this->user = User::with(['role', 'teacher'])
            ->find(auth()->id());
        
        // Get teacher information if user has teacher_id
        if ($this->user->teacher_id) {
            $this->teacher = Teacher::with(['subject', 'session', 'school'])
                ->find($this->user->teacher_id);
        }
        
        $this->role = $this->user->role;
    }

    public function render()
    {
        return view('livewire.subadmin-dc-profile-comp');
    }
}
