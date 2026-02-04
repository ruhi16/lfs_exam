<?php

namespace App\Http\Livewire;

use App\Models\Exam01Name;
use App\Models\Exam05Detail;
use App\Models\Myclass;
use App\Models\School;
use App\Models\Section;
use App\Models\Session;
use App\Models\Studentdb;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\User;
use Livewire\Component;

class AdminDcDashboardComp extends Component
{
    public $school;
    public $session;
    public $total_classes;
    public $total_sections;
    public $total_students;
    public $total_teachers;
    public $total_exams;
    public $total_users;
    public $total_subjects;

    public function mount()
    {
        // Counts for cards
        $this->school = School::first();
        $this->session = Session::where('status', 1)->first();
        $this->total_classes = Myclass::count();
        $this->total_sections = Section::count();
        $this->total_students = Studentdb::count();
        $this->total_teachers = Teacher::count();
        $this->total_exams = Exam01Name::count();
        $this->total_users = User::count();
        $this->total_subjects = Subject::count();
    }

    public function render()
    {
        // Data for tables
        $exams_by_class = Exam05Detail::with([
            'examName', 'examType', 'examPart', 'examMode', 'myclass',
            'ansscr_dists',
            'marks_entries'
        ])->get()->groupBy('myclass.name');
        $classes_with_sections = Myclass::with('myclass_sections.section')->get();
        $subjects_with_details = Subject::with('subjectType', 'teachers')->get();
        $teachers_with_details = Teacher::with('user', 'subject')->get();

        return view('livewire.admin-dc-dashboard-comp', [
            'exams_by_class' => $exams_by_class,
            'classes_with_sections' => $classes_with_sections,
            'subjects_with_details' => $subjects_with_details,
            'teachers_with_details' => $teachers_with_details,
        ]);
    }
}

