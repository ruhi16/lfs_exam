<?php

namespace App\Http\Livewire;

use Livewire\Component;

class UsersProfileDetaisComponent extends Component
{

    public $name;
    public $nickName;
    public $email;
    public $mobile;
    public $address;
    public $designaation;
    public $subject;
    public $status;
    public $prof_image_reference;


    public function mount(){
        $user = auth()->user();
        
        // Check if user is a student (role_id = 1) or teacher
        if ($user->role_id == 1 && $user->studentdb_id) {
            // User is a student, show student information
            $this->name = $user->name;
            $this->nickName = '';
            $this->email = $user->email;
            $this->mobile = $user->studentdb->mobile ?? '';
            $this->address = ($user->studentdb->vill1 ?? '') . ', ' . ($user->studentdb->post ?? '') . ', ' . ($user->studentdb->pstn ?? '');
            $this->designaation = 'Student';
            $this->subject = $user->studentdb->myclass->name ?? 'Not Assigned';
            $this->status = 'Active';
            $this->prof_image_reference = '/images/student-default.png'; // Default student image
        } else {
            // User is a teacher, show teacher information
            $this->name = $user->teacher->name ?? $user->name;
            $this->nickName = $user->teacher->nickName ?? '';
            $this->email = $user->teacher->email ?? $user->email;
            $this->mobile = $user->teacher->mobno ?? '';
            // $this->address = $user->teacher->address;
            $this->designaation = $user->teacher->desig ?? 'Teacher';
            $this->subject = $user->teacher->subject->name ?? 'Not Connected'; 
            $this->status = $user->teacher->status ?? 'Active';
            $this->prof_image_reference = $user->teacher->img_ref ?? '/images/teacher-default.png';
        }
    }



    public function render()
    {
        return view('livewire.users-profile-detais-component');
    }
}