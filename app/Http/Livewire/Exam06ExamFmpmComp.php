<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Myclass;
use App\Models\MyclassSubject;
use App\Models\Subject;
use App\Models\Exam01Name;
use App\Models\Exam02Type;
use App\Models\Exam03Part;
use App\Models\Exam04Mode;
use App\Models\Exam05Detail;
use App\Models\Exam06ClassSubject;
use App\Models\SubjectType;

class Exam06ExamFmpmComp extends Component
{
    public $activeTab = 0;
    public $classes = [];
    public $isEditingEnabled = false;
    public $formData = [];

    // Additional properties for view data
    public $examNames = [];
    public $examTypes = [];
    public $examParts = [];
    public $subjectTypes = [];

    protected $listeners = ['refreshComponent' => '$refresh'];

    public function mount()
    {
        $this->loadClasses();
        $this->loadReferenceData();
    }

    public function loadClasses()
    {
        $this->classes = Myclass::where('is_active', true)
            ->orderBy('order_index')
            ->orderBy('name')
            ->get();

        // Initialize form data for the first class if available
        if (is_object($this->classes) && $this->classes->count() > 0) {
            $this->loadFormDataForClass($this->classes[0]->id);
        }
    }

    public function loadReferenceData()
    {
        $this->examNames = Exam01Name::orderBy('name')->get();
        $this->examTypes = Exam02Type::orderBy('name')->get();
        $this->examParts = Exam03Part::orderBy('name')->get();
        $this->subjectTypes = SubjectType::orderBy('name')->get();
    }

    public function loadFormDataForClass($classId)
    {
        $records = Exam06ClassSubject::where('myclass_id', $classId)->get();

        foreach ($records as $record) {
            $key = $classId . '_' . $record->subject_id . '_' . $record->exam_detail_id;
            $this->formData[$key] = [
                'full_marks' => $record->full_marks,
                'pass_marks' => $record->pass_marks,
                'time_in_minutes' => $record->time_in_minutes
            ];
        }
    }

    public function setActiveTab($index)
    {
        $this->activeTab = $index;
        if (isset($this->classes[$index])) {
            $this->loadFormDataForClass($this->classes[$index]->id);
        }
    }

    public function toggleEditEnable()
    {
        $this->isEditingEnabled = !$this->isEditingEnabled;
    }

    public function getClassSubjects($classId)
    {
        return MyclassSubject::where('myclass_id', $classId)
            ->with(['subject', 'subject.subjectType'])
            ->whereHas('subject')
            ->join('subjects', 'myclass_subjects.subject_id', '=', 'subjects.id')
            ->orderBy('subjects.subject_type_id')
            ->orderBy('myclass_subjects.order_index')
            ->select('myclass_subjects.*')
            ->get();
    }

    public function getClassSubjectsGroupedByType($classId)
    {
        $subjects = $this->getClassSubjects($classId);

        // Group by subject type ID from the related subject
        $grouped = $subjects->groupBy(function ($item) {
            return $item->subject->subject_type_id;
        });

        // Sort: Summative -> Formative -> Others
        return $grouped->sortBy(function ($items, $key) {
            $name = '';

            // Try to find name in pre-loaded subjectTypes
            if ($this->subjectTypes instanceof \Illuminate\Support\Collection) {
                $subjectType = $this->subjectTypes->firstWhere('id', $key);
                $name = $subjectType ? $subjectType->name : '';
            } elseif (is_array($this->subjectTypes)) {
                foreach ($this->subjectTypes as $type) {
                    $tid = is_array($type) ? $type['id'] : $type->id;
                    if ($tid == $key) {
                        $name = is_array($type) ? $type['name'] : $type->name;
                        break;
                    }
                }
            }

            // Fallback if name is still empty (e.g. data not loaded or found)
            if (empty($name)) {
                $subjectType = SubjectType::find($key);
                $name = $subjectType ? $subjectType->name : '';
            }

            // Sort Order:
            // 1. Summative (prefix 1)
            // 2. Formative (prefix 2)
            // 3. Others (prefix 3)
            // Within each group, sort alphabetically by name

            $prefix = '3_';

            if (stripos($name, 'Summative') !== false) {
                $prefix = '1_';
            } elseif (stripos($name, 'Formative') !== false) {
                $prefix = '2_';
            }

            return $prefix . $name;
        });
    }

    public function getExamDetailsForClass($classId)
    {
        return Exam05Detail::where('myclass_id', $classId)
            ->with(['examName', 'examType', 'examPart', 'examMode'])
            ->where('is_active', true)
            ->orderBy('exam_name_id')
            ->orderBy('exam_type_id')
            ->orderBy('exam_part_id')
            ->get()
            ->groupBy('exam_name_id');
    }

    public function getExistingRecord($classId, $subjectId, $examDetailId)
    {
        return Exam06ClassSubject::where('myclass_id', $classId)
            ->where('subject_id', $subjectId)
            ->where('exam_detail_id', $examDetailId)
            ->first();
    }

    public function getFormDataValue($classId, $subjectId, $examDetailId, $field)
    {
        $key = $classId . '_' . $subjectId . '_' . $examDetailId;

        if (isset($this->formData[$key]) && isset($this->formData[$key][$field])) {
            return $this->formData[$key][$field];
        }

        $record = $this->getExistingRecord($classId, $subjectId, $examDetailId);
        if ($record) {
            // Cache it in formData for subsequent access
            if (!isset($this->formData[$key])) {
                $this->formData[$key] = [];
            }
            $this->formData[$key][$field] = $record->$field;
            return $record->$field;
        }

        return '';
    }

    public function saveRecord($classId, $subjectId, $examDetailId)
    {
        $key = $classId . '_' . $subjectId . '_' . $examDetailId;

        if (!isset($this->formData[$key])) {
            session()->flash('error', 'No data to save.');
            return;
        }

        $data = $this->formData[$key];

        try {
            // Check if record exists
            $record = Exam06ClassSubject::where('myclass_id', $classId)
                ->where('subject_id', $subjectId)
                ->where('exam_detail_id', $examDetailId)
                ->first();

            if (!$record) {
                session()->flash('error', 'Cannot create new records here. Please configure mapping in "Class Subjects" first.');
                return;
            }

            $record->update([
                'full_marks' => $data['full_marks'] ?? 0,
                'pass_marks' => $data['pass_marks'] ?? 0,
                'time_in_minutes' => $data['time_in_minutes'] ?? 0,
                'is_active' => true,
                'session_id' => session('session_id') ?? 1,
                'school_id' => session('school_id') ?? 1,
                'user_id' => auth()->id() ?? 1
            ]);

            session()->flash('message', 'Record updated successfully.');
        } catch (\Exception $e) {
            session()->flash('error', 'Error updating record: ' . $e->getMessage());
        }
    }

    public function deleteRecord($recordId)
    {
        try {
            $record = Exam06ClassSubject::find($recordId);
            if ($record) {
                // Clear from form data if exists
                $key = $record->myclass_id . '_' . $record->subject_id . '_' . $record->exam_detail_id;
                if (isset($this->formData[$key])) {
                    unset($this->formData[$key]);
                }

                $record->delete();
                session()->flash('message', 'Record deleted successfully.');
            }
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting record: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.exam06-exam-fmpm-comp', [
            'classes' => $this->classes,
            'examNames' => $this->examNames,
            'examTypes' => $this->examTypes,
            'examParts' => $this->examParts,
            'subjectTypes' => $this->subjectTypes
        ]);
    }
}
