<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Exam07AnsscrDist;
use App\Models\Exam10MarksEntry;
use App\Models\Studentcr;
use App\Models\MyclassSection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class Subadmin10MarksEntryFormComp extends Component
{
    public $distributionId;
    public $distribution;
    public $students;
    public $marks = []; // Keyed by studentcr_id

    protected $rules = [
        'marks.*.exam_marks' => 'nullable|numeric|min:0',
        'marks.*.is_absent' => 'boolean',
        'marks.*.remarks' => 'nullable|string',
    ];

    public function mount($distributionId)
    {
        $this->distributionId = $distributionId;
        $this->loadData();
    }

    public function loadData()
    {
        $this->distribution = Exam07AnsscrDist::with([
            'examClassSubject.examDetail',
            'myclassSection.section',
            'myclassSection.myclass'
        ])->find($this->distributionId);

        if (!$this->distribution) {
            abort(404, 'Distribution not found');
        }

        // Resolve class and section from MyclassSection, then load students accordingly
        $ms = MyclassSection::find($this->distribution->myclass_section_id);
        $classId = $ms->myclass_id ?? null;
        $sectionId = $ms->section_id ?? null;

        $this->students = Studentcr::where('myclass_id', $classId)
            ->where('section_id', $sectionId)
            ->with('studentdb')
            ->get();

        // Load existing marks
        $existingMarks = Exam10MarksEntry::where('exam_detail_id', $this->distribution->exam_detail_id)
            ->where('exam_class_subject_id', $this->distribution->exam_class_subject_id)
            ->where('myclass_section_id', $this->distribution->myclass_section_id)
            ->get()
            ->keyBy('studentcr_id');

        // Initialize marks array
        foreach ($this->students as $student) {
            $entry = $existingMarks->get($student->id);
            $this->marks[$student->id] = [
                'exam_marks' => $entry ? $entry->exam_marks : null,
                'is_absent' => $entry ? (bool)$entry->is_absent : false,
                'remarks' => $entry ? $entry->remarks : '',
            ];
        }
    }

    public function save()
    {
        $this->validate();

        foreach ($this->marks as $studentId => $data) {
            $isAbsent = $data['is_absent'];
            $examMarks = $isAbsent ? null : ($data['exam_marks'] === '' ? null : $data['exam_marks']);

            Exam10MarksEntry::updateOrCreate(
                [
                    'exam_detail_id' => $this->distribution->exam_detail_id,
                    'exam_class_subject_id' => $this->distribution->exam_class_subject_id,
                    'myclass_section_id' => $this->distribution->myclass_section_id,
                    'studentcr_id' => $studentId,
                ],
                [
                    'exam_marks' => $examMarks,
                    'is_absent' => $isAbsent,
                    'remarks' => $data['remarks'],
                    'status' => $isAbsent ? 'absent' : 'present',
                    'user_id' => Auth::id(),
                    'session_id' => $this->distribution->session_id,
                    'school_id' => $this->distribution->school_id ?? Auth::user()->school_id,
                    'is_active' => true,
                    // Additional fields from migration
                ]
            );
        }

        session()->flash('message', 'Marks saved successfully.');
    }

    public function render()
    {
        return view('livewire.subadmin10-marks-entry-form-comp');
    }
}
