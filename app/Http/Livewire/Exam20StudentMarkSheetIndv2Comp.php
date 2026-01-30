<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Myclass;
use App\Models\MyclassSection;
use App\Models\MyclassSubject;
use App\Models\Studentcr;
use App\Models\Exam05Detail;
use App\Models\Exam06ClassSubject;
use App\Models\Exam01Name;
use App\Models\Exam02Type;
use App\Models\Exam03Part;
use App\Models\SubjectType;
use App\Models\Session;
use App\Models\School;
use App\Models\Exam10MarksEntry;
use App\Models\Exam08Grade;

class Exam20StudentMarkSheetIndv2Comp extends Component
{
    public $activeTab = 0;
    public $classes;
    public $sections;
    public $students;
    public $selectedSectionId = null;
    public $selectedStudentId = null;

    public $examNames = [];
    public $examTypes = [];
    public $examParts = [];
    public $subjectTypes = [];
    public $school;
    public $session;

    // Cached maps to avoid repeated queries
    public $examClassSubjectMap = []; // [exam_detail_id][subject_id] => ['id','full_marks','pass_marks']
    public $marksMap = []; // [exam_class_subject_id] => ['marks','grade_id','is_absent']
    public $gradesMap = []; // [grade_id] => Exam08Grade

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->classes = Myclass::orderBy('id')->get();
        $this->examNames = Exam01Name::orderBy('id')->get();
        $this->examTypes = Exam02Type::orderBy('name')->get();
        $this->examParts = Exam03Part::orderBy('name')->get();
        $this->subjectTypes = SubjectType::orderBy('name')->get();
        $this->school = School::orderBy('id')->first();
        $this->session = Session::orderBy('id')->first();
        $this->gradesMap = Exam08Grade::all()->keyBy('id');

        $this->refreshActiveClassData();
    }

    public function setActiveTab($index)
    {
        $this->activeTab = $index;
        $this->selectedSectionId = null;
        $this->selectedStudentId = null;
        $this->marksMap = [];
        $this->examClassSubjectMap = [];
        $this->refreshActiveClassData();
    }

    public function setSelectedSection($sectionId)
    {
        $this->selectedSectionId = $sectionId;
        $this->selectedStudentId = null;
        $this->marksMap = [];
        $this->refreshMarksMap();
    }

    public function setSelectedStudent($studentId)
    {
        $this->selectedStudentId = $studentId;
        $this->refreshMarksMap();
    }

    public function refreshActiveClassData()
    {
        if (!isset($this->classes[$this->activeTab])) {
            $this->sections = [];
            $this->students = [];
            return;
        }
        $classId = $this->classes[$this->activeTab]->id;
        $this->sections = MyclassSection::where('myclass_id', $classId)
            ->with('section')
            ->orderBy('section_id')
            ->get();

        // Load all students for the active class (like Exam12 register)
        $this->students = Studentcr::where('myclass_id', $classId)
            ->with(['studentdb', 'myclass', 'section'])
            ->orderBy('section_id')
            ->orderBy('roll_no')
            ->get();

        // Prefetch exam class-subject mapping for this class
        $ecs = Exam06ClassSubject::where('myclass_id', $classId)->get();
        $this->examClassSubjectMap = [];
        foreach ($ecs as $item) {
            $this->examClassSubjectMap[$item->exam_detail_id][$item->subject_id] = [
                'id' => $item->id,
                'full_marks' => $item->full_marks,
                'pass_marks' => $item->pass_marks
            ];
        }

        // Marks map will be refreshed when a student is selected
    }

    public function getClassSubjectsGroupedByType($classId)
    {
        return MyclassSubject::where('myclass_id', $classId)
            ->with('subject.subjectType')
            ->get()
            ->groupBy(function ($ms) {
                return $ms->subject->subject_type_id;
            });
    }

    public function getExamDetailsForClass($classId)
    {
        return Exam05Detail::where('myclass_id', $classId)
            ->with(['examName', 'examType', 'examPart', 'examMode'])
            ->orderBy('exam_name_id')
            ->orderBy('exam_type_id')
            ->orderBy('exam_part_id')
            ->get()
            ->groupBy('exam_name_id');
    }

    public function getClassSections($classId)
    {
        return MyclassSection::where('myclass_id', $classId)
            ->with(['section'])
            ->orderBy('section_id')
            ->get();
    }

    public function getStudentsInSection($myclassSectionId)
    {
        $myclassSection = MyclassSection::find($myclassSectionId);
        if (!$myclassSection) {
            return collect();
        }
        return Studentcr::where('myclass_id', $myclassSection->myclass_id)
            ->where('section_id', $myclassSection->section_id)
            ->with(['studentdb', 'myclass', 'section'])
            ->orderBy('roll_no')
            ->get();
    }

    public function refreshMarksMap()
    {
        $this->marksMap = [];
        if (!$this->selectedStudentId) {
            return;
        }
        // Determine the myclass_section_id either from selection or from student's section
        $myclassSectionId = $this->selectedSectionId;
        if (!$myclassSectionId) {
            $student = $this->students->firstWhere('id', $this->selectedStudentId);
            if (!$student) {
                return;
            }
            $sec = $this->sections->firstWhere('section_id', $student->section_id);
            if (!$sec) {
                return;
            }
            $myclassSectionId = $sec->id;
        }

        $entries = Exam10MarksEntry::where('myclass_section_id', $myclassSectionId)
            ->where('studentcr_id', $this->selectedStudentId)
            ->get();
        foreach ($entries as $e) {
            $this->marksMap[$e->exam_class_subject_id] = [
                'marks' => $e->exam_marks,
                'grade_id' => $e->grade_id,
                'is_absent' => $e->is_absent
            ];
        }
    }

    public function getMarkEntry($subjectId, $examDetailId)
    {
        $mapping = $this->examClassSubjectMap[$examDetailId][$subjectId] ?? null;
        $examClassSubjectId = $mapping['id'] ?? null;
        if (!$examClassSubjectId) {
            return null;
        }
        return $this->marksMap[$examClassSubjectId] ?? null;
    }

    public function getFullMarks($subjectId, $examDetailId)
    {
        $mapping = $this->examClassSubjectMap[$examDetailId][$subjectId] ?? null;
        return $mapping['full_marks'] ?? null;
    }

    public function getExamDetailsBySubjectType($classId, $subjectTypeId)
    {
        $examDetails = Exam05Detail::where('myclass_id', $classId)
            ->with(['examName', 'examType', 'examPart', 'examMode'])
            ->orderBy('exam_name_id')
            ->orderBy('exam_type_id')
            ->orderBy('exam_part_id')
            ->get();

        $subjectType = SubjectType::find($subjectTypeId);
        if (!$subjectType) {
            return collect();
        }

        $filtered = $examDetails->filter(function ($detail) use ($subjectType) {
            return $detail->examType && (
                strtolower($detail->examType->name) === strtolower($subjectType->name)
                || $detail->exam_type_id == $subjectType->id
            );
        });

        return $filtered->groupBy('exam_name_id');
    }

    public function computeGradeByPercent($percent, $examTypeId)
    {
        if (!$examTypeId) {
            return '';
        }
        $rows = Exam08Grade::where('exam_type_id', $examTypeId)->get();
        foreach ($rows as $row) {
            $min = $row->min_percentage ?? $row->min_marks ?? 0;
            $max = $row->max_percentage ?? $row->max_marks ?? 100;
            if ($percent >= $min && $percent <= $max) {
                return $row->grade ?? $row->name ?? '';
            }
        }
        return '';
    }

    public function render()
    {
        return view('livewire.exam20-student-mark-sheet-indv-comp', [
            'classes' => $this->classes,
            'sections' => $this->sections,
            'students' => $this->students,
            'examNames' => $this->examNames,
            'examTypes' => $this->examTypes,
            'examParts' => $this->examParts,
            'subjectTypes' => $this->subjectTypes,
            'school' => $this->school,
            'session' => $this->session
        ]);
    }
}