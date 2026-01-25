<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Myclass;
use App\Models\Section;
use App\Models\Studentcr;
use App\Models\Studentdb;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class UserAccountComponent extends Component
{
    public $user = null;
    public $showStudentModal = false;
    
    // Student assignment properties
    public $selectedClass = '';
    public $selectedSection = '';
    public $studentRoll = '';
    public $studentDob = '';
    public $selectedStudent = '';
    
    // Properties for dropdowns
    public $classes = [];
    public $sections = [];

    protected $rules = [
        'selectedClass' => 'required|exists:myclasses,id',
        'selectedSection' => 'required|exists:sections,id', 
        'studentRoll' => 'required|string|max:20',
        'studentDob' => 'required|date',
    ];

    protected $messages = [
        'selectedClass.required' => 'Class is required for student verification.',
        'selectedSection.required' => 'Section is required for student verification.',
        'studentRoll.required' => 'Roll number is required for student verification.',
        'studentDob.required' => 'Date of birth is required for student verification.',
    ];

    public function mount()
    {
        $this->user = Auth::user();
        $this->loadClasses();
        $this->loadSections();
    }

    public function loadClasses()
    {
        $this->classes = Myclass::where('is_active', true)->orderBy('name')->get();
    }

    public function loadSections()
    {
        $this->sections = Section::orderBy('name')->get();
    }

    public function requestToBeTeacher(){
        $this->user = Auth::user();

        $user = User::find($this->user->id);
        $user->is_requested = true;
        $user->save();
        
        // Refresh the user data
        $this->user = $user;
    }

    public function openStudentModal()
    {
        $this->resetForm();
        $this->showStudentModal = true;
    }

    public function closeStudentModal()
    {
        $this->showStudentModal = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->selectedClass = '';
        $this->selectedSection = '';
        $this->studentRoll = '';
        $this->studentDob = '';
        $this->selectedStudent = '';
        $this->resetValidation();
    }

    public function verifyStudent()
    {
        $this->validate([
            'selectedClass' => 'required',
            'selectedSection' => 'required',
            'studentRoll' => 'required',
            'studentDob' => 'required|date'
        ]);

        try{
            $student = Studentcr::where('myclass_id', $this->selectedClass)
                              ->where('section_id', $this->selectedSection)
                              ->where('roll_no', $this->studentRoll)
                              ->first();

            if ($student && $student->studentdb->dob == $this->studentDob) {
                $this->selectedStudent = $student->id;
                session()->flash('student_verified', 'Student verified successfully!');
            } else {
                session()->flash('student_error', 'No student found with the provided details.');
                $this->selectedStudent = '';
            }
        } catch (\Exception $e) {
            Log::error('Error verifying student: ' . $e->getMessage());
            session()->flash('student_error', 'Error verifying student.');
        }
    }

    public function assignStudentRole()
    {
        $this->validate([
            'selectedClass' => 'required',
            'selectedSection' => 'required',
            'studentRoll' => 'required',
            'studentDob' => 'required|date'
        ]);

        try {
            // First verify the student
            $student = Studentcr::where('myclass_id', $this->selectedClass)
                              ->where('section_id', $this->selectedSection)
                              ->where('roll_no', $this->studentRoll)
                              ->first();

            if (!$student || $student->studentdb->dob != $this->studentDob) {
                session()->flash('student_error', 'No student found with the provided details.');
                return;
            }

            // Get the current user
            $user = User::find(Auth::id());
            
            // Update user with role_id = 1 (User role) and studentdb_id
            $user->role_id = 1; // Predefined as User role
            $user->studentdb_id = $student->studentdb->id; // Set to the studentdb_id of the student
            $user->save();

            // Update the studentdb record with the user_id
            $studentdb = Studentdb::find($student->studentdb->id);
            if ($studentdb) {
                $studentdb->user_id = $user->id; // Set to the current user_id
                $studentdb->save();
            }

            session()->flash('message', 'Student role assigned successfully!');
            $this->closeStudentModal();
            $this->user = $user; // Refresh user data

        } catch (\Exception $e) {
            Log::error('Error assigning student role: ' . $e->getMessage());
            session()->flash('student_error', 'Error assigning student role: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.user-account-component');
    }
}