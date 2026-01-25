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
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class Basic10ClassSectionComp extends Component
{
    use WithPagination;

    public $name, $description, $order_index, $myclass_id, $section_id, $school_id, $session_id, $teacher_id, $room_id, $user_id, $approved_by, $is_active, $is_finalized, $status, $remarks, $myclassSectionId;
    public $isOpen = 0;
    public $search = '';

    public function render()
    {
        $myclasses = Myclass::all();
        $sections = Section::all();
        $schools = School::all();
        $sessions = Session::all();
        $teachers = Teacher::all();
        $users = User::all();
        
        $myclassSections = MyclassSection::query();
        
        if ($this->search) {
            $myclassSections->where(function($subQuery) {
                $subQuery->where('name', 'like', '%' . $this->search . '%')
                         ->orWhere('status', 'like', '%' . $this->search . '%')
                         ->orWhere('remarks', 'like', '%' . $this->search . '%')
                         ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        $myclassSections = $myclassSections->paginate(10);

        return view('livewire.basic10-class-section-comp', [
            'myclassSections' => $myclassSections ?? collect([]),
            'myclasses' => $myclasses,
            'sections' => $sections,
            'schools' => $schools,
            'sessions' => $sessions,
            'teachers' => $teachers,
            'users' => $users
        ]);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    private function resetInputFields()
    {
        $this->name = '';
        $this->description = '';
        $this->order_index = null;
        $this->myclass_id = '';
        $this->section_id = '';
        $this->school_id = '';
        $this->session_id = '';
        $this->teacher_id = '';
        $this->room_id = '';
        $this->user_id = '';
        $this->approved_by = '';
        $this->is_active = true;
        $this->is_finalized = false;
        $this->status = '';
        $this->remarks = '';
        $this->myclassSectionId = null;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function openModal()
    {
        $this->isOpen = true;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function closeModal()
    {
        $this->isOpen = false;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function store()
    {
        $this->validate([
            'name' => 'required',
            'description' => 'nullable|string',
            'order_index' => 'nullable|integer',
            'myclass_id' => 'nullable|integer',
            'section_id' => 'nullable|integer',
            'school_id' => 'nullable|integer',
            'session_id' => 'nullable|integer',
            'teacher_id' => 'nullable|integer',
            'room_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'approved_by' => 'nullable|integer',
            'is_active' => 'boolean',
            'is_finalized' => 'boolean',
            'status' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        if($this->myclassSectionId){
            // Update existing myclass section
            $myclassSection = MyclassSection::find($this->myclassSectionId);
            if($myclassSection){
                $myclassSection->update([
                    'name' => $this->name,
                    'description' => $this->description ? $this->description : null,
                    'order_index' => $this->order_index ? $this->order_index : null,
                    'myclass_id' => $this->myclass_id ? $this->myclass_id : null,
                    'section_id' => $this->section_id ? $this->section_id : null,
                    'school_id' => $this->school_id ? $this->school_id : null,
                    'session_id' => $this->session_id ? $this->session_id : null,
                    'teacher_id' => $this->teacher_id ? $this->teacher_id : null,
                    'room_id' => $this->room_id ? $this->room_id : null,
                    'user_id' => $this->user_id ? $this->user_id : null,
                    'approved_by' => $this->approved_by ? $this->approved_by : null,
                    'is_active' => $this->is_active,
                    'is_finalized' => $this->is_finalized,
                    'status' => $this->status ? $this->status : null,
                    'remarks' => $this->remarks ? $this->remarks : null,
                ]);
            }
        } else {
            // Create new myclass section
            MyclassSection::create([
                'name' => $this->name,
                'description' => $this->description ? $this->description : null,
                'order_index' => $this->order_index ? $this->order_index : null,
                'myclass_id' => $this->myclass_id ? $this->myclass_id : null,
                'section_id' => $this->section_id ? $this->section_id : null,
                'school_id' => $this->school_id ? $this->school_id : null,
                'session_id' => $this->session_id ? $this->session_id : null,
                'teacher_id' => $this->teacher_id ? $this->teacher_id : null,
                'room_id' => $this->room_id ? $this->room_id : null,
                'user_id' => $this->user_id ? $this->user_id : null,
                'approved_by' => $this->approved_by ? $this->approved_by : null,
                'is_active' => $this->is_active,
                'is_finalized' => $this->is_finalized,
                'status' => $this->status ? $this->status : null,
                'remarks' => $this->remarks ? $this->remarks : null,
            ]);
        }

        session()->flash('message', $this->myclassSectionId ? 'Class Section Updated Successfully.' : 'Class Section Created Successfully.');

        $this->closeModal();
        $this->resetInputFields();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function edit($id)
    {
        $myclassSection = MyclassSection::findOrFail($id);
        $this->myclassSectionId = $id;
        $this->name = $myclassSection->name;
        $this->description = $myclassSection->description;
        $this->order_index = $myclassSection->order_index;
        $this->myclass_id = $myclassSection->myclass_id;
        $this->section_id = $myclassSection->section_id;
        $this->school_id = $myclassSection->school_id;
        $this->session_id = $myclassSection->session_id;
        $this->teacher_id = $myclassSection->teacher_id;
        $this->room_id = $myclassSection->room_id;
        $this->user_id = $myclassSection->user_id;
        $this->approved_by = $myclassSection->approved_by;
        $this->is_active = $myclassSection->is_active;
        $this->is_finalized = $myclassSection->is_finalized;
        $this->status = $myclassSection->status;
        $this->remarks = $myclassSection->remarks;

        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        MyclassSection::find($id)->delete();
        session()->flash('message', 'Class Section Deleted Successfully.');
    }
}
