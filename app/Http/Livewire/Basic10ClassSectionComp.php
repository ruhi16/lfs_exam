<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MyclassSection;
use App\Models\Myclass;
use App\Models\Section;
use App\Models\School;
use App\Models\Session;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class Basic10ClassSectionComp extends Component
{
    public $isEditMode = false;

    public function render()
    {
        // 1. MyClasses (Rows) ordered by id ASC
        $myclasses = Myclass::orderBy('id', 'asc')->get();

        // 2. Sections (Columns)
        // Order by name or order_index if available, let's assume standard order
        $sections = Section::all();

        // 3. Existing relationships
        $matrix = [];
        $existingRecords = MyclassSection::all();
        
        foreach ($existingRecords as $record) {
            $matrix[$record->myclass_id][$record->section_id] = $record;
        }

        return view('livewire.basic10-class-section-comp', [
            'myclasses' => $myclasses,
            'sections' => $sections,
            'matrix' => $matrix,
        ]);
    }

    public function toggleEditMode()
    {
        $this->isEditMode = !$this->isEditMode;
    }

    public function updateMapping($myclassId, $sectionId, $isChecked)
    {
        if (!$this->isEditMode) {
            return;
        }

        if ($isChecked) {
            // Create
            $myclass = Myclass::find($myclassId);
            $section = Section::find($sectionId);
            
            if ($myclass && $section) {
                MyclassSection::updateOrCreate(
                    [
                        'myclass_id' => $myclassId,
                        'section_id' => $sectionId,
                    ],
                    [
                        'name' => $myclass->name . ' - ' . $section->name,
                        'is_active' => true,
                        // Set defaults for other required fields
                    ]
                );
            }
        } else {
            // Delete
            $record = MyclassSection::where('myclass_id', $myclassId)
                ->where('section_id', $sectionId)
                ->first();
            
            if ($record) {
                $record->delete();
            }
        }
    }
}
