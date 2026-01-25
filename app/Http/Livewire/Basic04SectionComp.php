<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Section;
use App\Models\School;
use App\Models\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class Basic04SectionComp extends Component
{
    use WithPagination;

    public $name, $description, $order_index, $code, $school_id, $session_id, $user_id, $approved_by, $is_active, $is_finalized, $status, $remarks, $sectionId;
    public $isOpen = 0;
    public $search = '';

    public function render()
    {
        $schools = School::all();
        $sessions = Session::all();
        $users = User::all();
        
        $sections = Section::query();
        
        if ($this->search) {
            $sections->where(function($subQuery) {
                $subQuery->where('name', 'like', '%' . $this->search . '%')
                         ->orWhere('code', 'like', '%' . $this->search . '%')
                         ->orWhere('status', 'like', '%' . $this->search . '%')
                         ->orWhere('remarks', 'like', '%' . $this->search . '%')
                         ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        $sections = $sections->paginate(10);

        return view('livewire.basic04-section-comp', [
            'sections' => $sections ?? collect([]),
            'schools' => $schools,
            'sessions' => $sessions,
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
        $this->code = '';
        $this->school_id = '';
        $this->session_id = '';
        $this->user_id = '';
        $this->approved_by = '';
        $this->is_active = true;
        $this->is_finalized = false;
        $this->status = '';
        $this->remarks = '';
        $this->sectionId = null;
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
            'code' => 'nullable|string|max:255',
            'school_id' => 'nullable|integer',
            'session_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'approved_by' => 'nullable|integer',
            'is_active' => 'boolean',
            'is_finalized' => 'boolean',
            'status' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        if($this->sectionId){
            // Update existing section
            $section = Section::find($this->sectionId);
            if($section){
                $section->update([
                    'name' => $this->name,
                    'description' => $this->description ? $this->description : null,
                    'order_index' => $this->order_index ? $this->order_index : null,
                    'code' => $this->code ? $this->code : null,
                    'school_id' => $this->school_id ? $this->school_id : null,
                    'session_id' => $this->session_id ? $this->session_id : null,
                    'user_id' => $this->user_id ? $this->user_id : null,
                    'approved_by' => $this->approved_by ? $this->approved_by : null,
                    'is_active' => $this->is_active,
                    'is_finalized' => $this->is_finalized,
                    'status' => $this->status ? $this->status : null,
                    'remarks' => $this->remarks ? $this->remarks : null,
                ]);
            }
        } else {
            // Create new section
            Section::create([
                'name' => $this->name,
                'description' => $this->description ? $this->description : null,
                'order_index' => $this->order_index ? $this->order_index : null,
                'code' => $this->code ? $this->code : null,
                'school_id' => $this->school_id ? $this->school_id : null,
                'session_id' => $this->session_id ? $this->session_id : null,
                'user_id' => $this->user_id ? $this->user_id : null,
                'approved_by' => $this->approved_by ? $this->approved_by : null,
                'is_active' => $this->is_active,
                'is_finalized' => $this->is_finalized,
                'status' => $this->status ? $this->status : null,
                'remarks' => $this->remarks ? $this->remarks : null,
            ]);
        }

        session()->flash('message', $this->sectionId ? 'Section Updated Successfully.' : 'Section Created Successfully.');

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
        $section = Section::findOrFail($id);
        $this->sectionId = $id;
        $this->name = $section->name;
        $this->description = $section->description;
        $this->order_index = $section->order_index;
        $this->code = $section->code;
        $this->school_id = $section->school_id;
        $this->session_id = $section->session_id;
        $this->user_id = $section->user_id;
        $this->approved_by = $section->approved_by;
        $this->is_active = $section->is_active;
        $this->is_finalized = $section->is_finalized;
        $this->status = $section->status;
        $this->remarks = $section->remarks;

        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Section::find($id)->delete();
        session()->flash('message', 'Section Deleted Successfully.');
    }
}
