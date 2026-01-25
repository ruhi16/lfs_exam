<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Subject;
use App\Models\SubjectType;
use App\Models\School;
use App\Models\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class Basic06SubjectComp extends Component
{
    use WithPagination;

    public $name, $description, $order_index, $subject_type_id, $school_id, $session_id, $user_id, $approved_by, $is_active, $is_finalized, $status, $remarks, $subjectId;
    public $isOpen = 0;
    public $search = '';

    public function render()
    {
        $subjectTypes = SubjectType::all();
        $schools = School::all();
        $sessions = Session::all();
        $users = User::all();
        
        $subjects = Subject::query();
        
        if ($this->search) {
            $subjects->where(function($subQuery) {
                $subQuery->where('name', 'like', '%' . $this->search . '%')
                         ->orWhere('status', 'like', '%' . $this->search . '%')
                         ->orWhere('remarks', 'like', '%' . $this->search . '%')
                         ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        $subjects = $subjects->paginate(10);

        return view('livewire.basic06-subject-comp', [
            'subjects' => $subjects ?? collect([]),
            'subjectTypes' => $subjectTypes,
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
        $this->subject_type_id = '';
        $this->school_id = '';
        $this->session_id = '';
        $this->user_id = '';
        $this->approved_by = '';
        $this->is_active = true;
        $this->is_finalized = false;
        $this->status = '';
        $this->remarks = '';
        $this->subjectId = null;
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
            'subject_type_id' => 'nullable|integer',
            'school_id' => 'nullable|integer',
            'session_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'approved_by' => 'nullable|integer',
            'is_active' => 'boolean',
            'is_finalized' => 'boolean',
            'status' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        if($this->subjectId){
            // Update existing subject
            $subject = Subject::find($this->subjectId);
            if($subject){
                $subject->update([
                    'name' => $this->name,
                    'description' => $this->description ? $this->description : null,
                    'order_index' => $this->order_index ? $this->order_index : null,
                    'subject_type_id' => $this->subject_type_id ? $this->subject_type_id : null,
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
            // Create new subject
            Subject::create([
                'name' => $this->name,
                'description' => $this->description ? $this->description : null,
                'order_index' => $this->order_index ? $this->order_index : null,
                'subject_type_id' => $this->subject_type_id ? $this->subject_type_id : null,
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

        session()->flash('message', $this->subjectId ? 'Subject Updated Successfully.' : 'Subject Created Successfully.');

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
        $subject = Subject::findOrFail($id);
        $this->subjectId = $id;
        $this->name = $subject->name;
        $this->description = $subject->description;
        $this->order_index = $subject->order_index;
        $this->subject_type_id = $subject->subject_type_id;
        $this->school_id = $subject->school_id;
        $this->session_id = $subject->session_id;
        $this->user_id = $subject->user_id;
        $this->approved_by = $subject->approved_by;
        $this->is_active = $subject->is_active;
        $this->is_finalized = $subject->is_finalized;
        $this->status = $subject->status;
        $this->remarks = $subject->remarks;

        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Subject::find($id)->delete();
        session()->flash('message', 'Subject Deleted Successfully.');
    }
}
