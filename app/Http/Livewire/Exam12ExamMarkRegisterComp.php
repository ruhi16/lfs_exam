<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MyclassSection;
use App\Models\Myclass;
use App\Models\Section;
use App\Models\Studentcr;
use App\Models\Exam05Detail;
use App\Models\Exam01Name;
use App\Models\Exam03Part;
use App\Models\Exam06ClassSubject;
use App\Models\Exam10MarksEntry;
use App\Models\MyclassSubject;

class Exam12ExamMarkRegisterComp extends Component
{
    public $activeTab = 0;
    public $classes;
    public $sections; // All sections for all classes, or active class? Loading all for now as per original
    public $students; // All students for active class
    public $examDetailsGrouped = [];
    public $classSubjects = []; // Subjects for the active class
    public $examClassSubjectMap = []; // Map [exam_detail_id][subject_id] -> Exam06ClassSubject
    public $marksData = [];
    public $isEditing = false;

    public function mount()
    {
        $this->loadClasses();
        // Initial load for the first class if available
        if ($this->classes && $this->classes->count() > 0) {
            $this->loadClassData($this->classes[0]->id);
        }
    }

    public function loadClasses()
    {
        $this->classes = Myclass::orderBy('name')->get();
    }

    public function setActiveTab($index)
    {
        $this->activeTab = $index;
        $this->isEditing = false;
        if (isset($this->classes[$index])) {
            $this->loadClassData($this->classes[$index]->id);
        }
    }

    public function loadClassData($classId)
    {
        // 1. Load Sections for this class
        $this->sections = MyclassSection::where('myclass_id', $classId)
            ->with('section')
            ->orderBy('section_id')
            ->get();

        // 2. Load Students for this class
        // Optimization: Select specific columns if needed, but eager loading relations is key
        $this->students = Studentcr::where('myclass_id', $classId)
            ->with(['studentdb', 'section']) // Added section to help grouping in view
            ->orderBy('section_id')
            ->orderBy('roll_no')
            ->get();

        // 3. Load Subjects for this class
        $this->classSubjects = MyclassSubject::where('myclass_id', $classId)
            ->with(['subject.subjectType'])
            ->get()
            ->sortByDesc(function ($ms) {
                return $ms->subject->subject_type_id ?? 0;
            });

        // 4. Load Exam Details
        $examDetails = Exam05Detail::where('myclass_id', $classId)
            ->with(['examName', 'examPart', 'examType'])
            ->orderBy('exam_name_id')
            ->orderBy('exam_part_id')
            ->get();

        // Group exam details
        $this->examDetailsGrouped = [];
        foreach ($examDetails as $detail) {
            $this->examDetailsGrouped[$detail->exam_name_id][$detail->exam_part_id][] = $detail;
        }

        // 5. Load Exam Class Subjects (The mapping/pivot)
        // We need this to know valid combinations and full marks
        $ecs = Exam06ClassSubject::where('myclass_id', $classId)->get();
        $this->examClassSubjectMap = [];
        foreach ($ecs as $item) {
            $this->examClassSubjectMap[$item->exam_detail_id][$item->subject_id] = [
                'id' => $item->id,
                'full_marks' => $item->full_marks,
                'pass_marks' => $item->pass_marks
            ];
        }

        // 6. Load Marks
        $this->loadMarksData($classId);
    }

    public function loadMarksData($classId)
    {
        $this->marksData = [];

        // Fetch all marks for this class in one query
        // We can filter by myclass_section_id which are in this class
        $sectionIds = $this->sections->pluck('id');

        $marksEntries = Exam10MarksEntry::whereIn('myclass_section_id', $sectionIds)
            ->get();

        // Map marks to a key: student_id_exam_class_subject_id
        foreach ($marksEntries as $entry) {
            // We use a composite key for direct access in the view
            // Key: {student_id}_{exam_class_subject_id}
            $key = $entry->studentcr_id . '_' . $entry->exam_class_subject_id;
            $this->marksData[$key] = [
                'exam_marks' => $entry->exam_marks,
                'is_absent' => $entry->is_absent,
                // store original values to detect changes if needed, 
                // but for now simple binding is enough
            ];
        }
    }

    public function updateMarks()
    {
        // Enable editing mode
        // We might need to initialize empty slots for wire:model binding
        // But Livewire handles nested array binding even if key doesn't exist (it creates it)
        // However, to display empty inputs properly, the view logic handles the existence check.
        $this->isEditing = true;
    }

    public function cancelEdit()
    {
        $this->isEditing = false;
        // Reload data to discard changes
        if (isset($this->classes[$this->activeTab])) {
            $this->loadMarksData($this->classes[$this->activeTab]->id);
        }
    }

    public function saveMarks()
    {
        $savedCount = 0;
        $errorCount = 0;

        // Iterate through the bound marksData
        foreach ($this->marksData as $key => $data) {
            // Key format: {student_id}_{exam_class_subject_id}
            $parts = explode('_', $key);
            if (count($parts) != 2) continue;

            $studentId = $parts[0];
            $examClassSubjectId = $parts[1];

            // Validate basic integrity
            // Check if student exists in our loaded list? (Optional optimization)
            // Check if marks are valid?

            if (!isset($data['is_absent'])) $data['is_absent'] = false;

            // Skip empty entries that were never touched (null marks, not absent)
            if ($data['exam_marks'] === null && !$data['is_absent']) {
                continue;
            }

            // If marks is empty string (user cleared it), treat as null
            if ($data['exam_marks'] === '') $data['exam_marks'] = null;

            try {
                // We need more info to save: section_id, exam_detail_id.
                // We can fetch these from the IDs or look them up.
                // Since we need to save quickly, let's lookup necessary IDs.
                // Optimally, we could have stored these in the key or a separate map.

                // Reverse lookup or fetch. 
                // Since we are saving, a few queries here is okay-ish, but batching is better.
                // But updateOrCreate needs specific IDs.

                // Let's get the Exam06ClassSubject to find exam_detail_id
                // We can't easily find it from the map without iterating.
                // Let's do a query. To optimize, we could memoize or pre-load.
                // Given the save happens once, direct query is acceptable for safety.
                $ecs = Exam06ClassSubject::find($examClassSubjectId);
                if (!$ecs) continue;

                $student = $this->students->where('id', $studentId)->first();
                if (!$student) continue;

                // Find the section for this student
                // (We loaded students with section relation)
                // Actually myclass_section_id is needed for Exam10MarksEntry.
                // Student has section_id. MyclassSection links class and section.
                $myclassSection = $this->sections->where('section_id', $student->section_id)->first();
                if (!$myclassSection) continue;

                Exam10MarksEntry::updateOrCreate(
                    [
                        'myclass_section_id' => $myclassSection->id,
                        'exam_detail_id' => $ecs->exam_detail_id,
                        'studentcr_id' => $studentId,
                        'exam_class_subject_id' => $ecs->id
                    ],
                    [
                        'exam_marks' => $data['is_absent'] ? null : $data['exam_marks'],
                        'is_absent' => $data['is_absent'],
                        'session_id' => session('session_id') ?? 1,
                        'user_id' => auth()->id() ?? 1,
                        'is_active' => true,
                        'status' => 'active'
                    ]
                );
                $savedCount++;
            } catch (\Exception $e) {
                $errorCount++;
            }
        }

        if ($savedCount > 0) {
            session()->flash('message', "{$savedCount} marks saved successfully.");
        }

        $this->isEditing = false;

        // Reload to ensure fresh state
        if (isset($this->classes[$this->activeTab])) {
            $this->loadMarksData($this->classes[$this->activeTab]->id);
        }
    }

    public function render()
    {
        return view('livewire.exam12-exam-mark-register-comp', [
            'activeClass' => isset($this->classes[$this->activeTab]) ? $this->classes[$this->activeTab] : null
        ]);
    }
}
