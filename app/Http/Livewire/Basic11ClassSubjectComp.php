<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MyclassSubject;
use App\Models\Myclass;
use App\Models\Subject;
use App\Models\School;
use App\Models\Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Basic11ClassSubjectComp extends Component
{
    public $isEditMode = false;

    // We don't need pagination for the matrix view as we want to see the full grid
    // But if there are too many subjects/classes, it might be heavy. 
    // Assuming manageable size for now based on typical school setups.

    public function render()
    {
        // 1. Subjects ordered by subject_type DESC
        // We join subject_types to order by the actual type name or just ID? 
        // Prompt says "Arrange subjects by subject_type in descending order".
        // Assuming subject_type_id or similar. 
        // Let's assume sorting by subject_type_id desc is sufficient as per prompt.
        $subjects = Subject::with('subjectType')
            ->orderBy('subject_type_id', 'desc')
            ->orderBy('name', 'asc') // Secondary sort for clean list
            ->get();

        // 2. MyClasses as columns
        $myclasses = Myclass::orderBy('order_index', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        // 3. Existing relationships
        // We need a quick lookup.
        // Format: [subject_id][myclass_id] = MyclassSubject instance or null
        $matrix = [];
        $existingRecords = MyclassSubject::all();

        foreach ($existingRecords as $record) {
            $matrix[$record->subject_id][$record->myclass_id] = $record;
        }

        return view('livewire.basic11-class-subject-comp', [
            'subjects' => $subjects,
            'myclasses' => $myclasses,
            'matrix' => $matrix,
        ]);
    }

    public function toggleEditMode()
    {
        $this->isEditMode = !$this->isEditMode;
    }

    public function updateMapping($subjectId, $myclassId, $isChecked)
    {
        if (!$this->isEditMode) {
            return;
        }

        if ($isChecked) {
            // Create
            $subject = Subject::find($subjectId);
            $myclass = Myclass::find($myclassId);

            if ($subject && $myclass) {
                MyclassSubject::updateOrCreate(
                    [
                        'subject_id' => $subjectId,
                        'myclass_id' => $myclassId,
                    ],
                    [
                        'name' => $myclass->name . ' - ' . $subject->name,
                        'is_active' => true,
                        // Set defaults for other required fields if any
                        // Assuming optional/nullable fields can be null
                    ]
                );
            }
        } else {
            // Delete
            // Use query to find because we might not have the ID handy in the loop context easily without passing it
            $record = MyclassSubject::where('subject_id', $subjectId)
                ->where('myclass_id', $myclassId)
                ->first();

            if ($record) {
                $record->delete();
            }
        }
    }
}
