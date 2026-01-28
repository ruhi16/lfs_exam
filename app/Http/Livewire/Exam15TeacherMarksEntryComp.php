<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Teacher;
use App\Models\Exam07AnsscrDist;
use App\Models\Myclass;
use App\Models\MyclassSection;
use App\Models\Exam01Name;
use App\Models\Exam02Type;
use App\Models\Exam03Part;
use App\Models\Subject;

class Exam15TeacherMarksEntryComp extends Component
{
    public $selectedTeacherId = null;
    public $teachers;
    public $answerScripts = [];

    public function mount()
    {
        $this->loadTeachers();
    }

    public function loadTeachers()
    {
        $this->teachers = Teacher::where('id', '>', 5)
            ->with('user')
            ->orderBy('id')
            ->get();
    }

    public function updatedSelectedTeacherId($teacherId)
    {
        $this->loadAnswerScripts($teacherId);
    }

    public function loadAnswerScripts($teacherId)
    {
        if (!$teacherId) {
            $this->answerScripts = [];
            return;
        }

        $this->answerScripts = Exam07AnsscrDist::where('teacher_id', $teacherId)
            ->with([
                'myclassSection.myclass',
                'myclassSection.section',
                'examDetail.examName',
                'examDetail.examType',
                'examDetail.examPart',
                'examDetail.examMode',
                'examClassSubject.subject',
                'examDetail'  // Include exam detail for the link
            ])
            ->get()
            ->map(function ($item) {
                // Add URL for marks entry
                $item->marks_entry_url = route('marksEntryOld', [
                    'exam_detail_id' => $item->exam_detail_id,
                    'myclass_section_id' => $item->myclass_section_id,
                    'myclass_subject_id' => $item->exam_class_subject_id
                ]);
                return $item;
            })
            ->toArray(); // Convert to array for easier handling in Blade
    }

    public function render()
    {
        return view('livewire.exam15-teacher-marks-entry-comp', [
            'teachers' => $this->teachers,
            'answerScripts' => $this->answerScripts
        ]);
    }
}