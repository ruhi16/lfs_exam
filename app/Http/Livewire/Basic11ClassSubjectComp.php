<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\MyclassSubject;
use App\Models\Myclass;
use App\Models\Subject;
use App\Models\School;
use App\Models\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class Basic11ClassSubjectComp extends Component
{
    use WithPagination;

    public $name, $description, $order_index, $is_optional, $myclass_id, $subject_id, $school_id, $session_id, $user_id, $approved_by, $is_active, $is_finalized, $status, $remarks, $myclassSubjectId;
    public $isOpen = 0;
    public $search = '';

    public function render()
    {
        $myclasses = Myclass::all();
        $subjects = Subject::all();
        $schools = School::all();
        $sessions = Session::all();
        $users = User::all();
        
        $myclassSubjects = MyclassSubject::query();
        
        if ($this->search) {
            $myclassSubjects->where(function($subQuery) {
                $subQuery->where('name', 'like', '%' . $this->search . '%')
                         ->orWhere('status', 'like', '%' . $this->search . '%')
                         ->orWhere('remarks', 'like', '%' . $this->search . '%')
                         ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        $myclassSubjects = $myclassSubjects->paginate(10);

        return view('livewire.basic11-class-subject-comp', [
            'myclassSubjects' => $myclassSubjects ?? collect([]),
            'myclasses' => $myclasses,
            'subjects' => $subjects,
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
        $this->is_optional = false;
        $this->myclass_id = '';
        $this->subject_id = '';
        $this->school_id = '';
        $this->session_id = '';
        $this->user_id = '';
        $this->approved_by = '';
        $this->is_active = true;
        $this->is_finalized = false;
        $this->status = '';
        $this->remarks = '';
        $this->myclassSubjectId = null;
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
            'is_optional' => 'boolean',
            'myclass_id' => 'nullable|integer',
            'subject_id' => 'nullable|integer',
            'school_id' => 'nullable|integer',
            'session_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'approved_by' => 'nullable|integer',
            'is_active' => 'boolean',
            'is_finalized' => 'boolean',
            'status' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        if($this->myclassSubjectId){
            // Update existing myclass subject
            $myclassSubject = MyclassSubject::find($this->myclassSubjectId);
            if($myclassSubject){
                $myclassSubject->update([
                    'name' => $this->name,
                    'description' => $this->description ? $this->description : null,
                    'order_index' => $this->order_index ? $this->order_index : null,
                    'is_optional' => $this->is_optional,
                    'myclass_id' => $this->myclass_id ? $this->myclass_id : null,
                    'subject_id' => $this->subject_id ? $this->subject_id : null,
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
            // Create new myclass subject
            MyclassSubject::create([
                'name' => $this->name,
                'description' => $this->description ? $this->description : null,
                'order_index' => $this->order_index ? $this->order_index : null,
                'is_optional' => $this->is_optional,
                'myclass_id' => $this->myclass_id ? $this->myclass_id : null,
                'subject_id' => $this->subject_id ? $this->subject_id : null,
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

        session()->flash('message', $this->myclassSubjectId ? 'Class Subject Updated Successfully.' : 'Class Subject Created Successfully.');

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
        $myclassSubject = MyclassSubject::findOrFail($id);
        $this->myclassSubjectId = $id;
        $this->name = $myclassSubject->name;
        $this->description = $myclassSubject->description;
        $this->order_index = $myclassSubject->order_index;
        $this->is_optional = $myclassSubject->is_optional;
        $this->myclass_id = $myclassSubject->myclass_id;
        $this->subject_id = $myclassSubject->subject_id;
        $this->school_id = $myclassSubject->school_id;
        $this->session_id = $myclassSubject->session_id;
        $this->user_id = $myclassSubject->user_id;
        $this->approved_by = $myclassSubject->approved_by;
        $this->is_active = $myclassSubject->is_active;
        $this->is_finalized = $myclassSubject->is_finalized;
        $this->status = $myclassSubject->status;
        $this->remarks = $myclassSubject->remarks;

        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        MyclassSubject::find($id)->delete();
        session()->flash('message', 'Class Subject Deleted Successfully.');
    }
}
