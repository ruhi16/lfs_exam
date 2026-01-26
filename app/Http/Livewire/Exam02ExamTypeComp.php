<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Exam02Type;
use App\Models\Session;
use App\Models\School;
use App\Models\User;
use Livewire\WithPagination;

class Exam02ExamTypeComp extends Component
{
    use WithPagination;

    public $name, $description, $order_index, $is_optional, $session_id, $school_id, $user_id, $approved_by, $is_active, $is_finalized, $status, $remarks, $exam02TypeId;
    public $isOpen = 0;
    public $search = '';
    public $perPage = 10;

    public function render()
    {
        $sessions = Session::all();
        $schools = School::all();
        $users = User::all();
        
        $exam02Types = Exam02Type::query();
        
        if ($this->search) {
            $exam02Types->where(function($subQuery) {
                $subQuery->where('name', 'like', '%' . $this->search . '%')
                         ->orWhere('description', 'like', '%' . $this->search . '%')
                         ->orWhere('status', 'like', '%' . $this->search . '%')
                         ->orWhere('remarks', 'like', '%' . $this->search . '%');
            });
        }

        $exam02Types = $exam02Types->paginate($this->perPage);

        return view('livewire.exam02-exam-type-comp', [
            'exam02Types' => $exam02Types ?? collect([]),
            'sessions' => $sessions,
            'schools' => $schools,
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
        $this->session_id = '';
        $this->school_id = '';
        $this->user_id = '';
        $this->approved_by = '';
        $this->is_active = true;
        $this->is_finalized = false;
        $this->status = '';
        $this->remarks = '';
        $this->exam02TypeId = null;
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
            'session_id' => 'nullable|integer',
            'school_id' => 'nullable|integer',
            'user_id' => 'nullable|integer',
            'approved_by' => 'nullable|integer',
            'is_active' => 'boolean',
            'is_finalized' => 'boolean',
            'status' => 'nullable|string|max:255',
            'remarks' => 'nullable|string',
        ]);

        if($this->exam02TypeId){
            // Update existing exam type
            $exam02Type = Exam02Type::find($this->exam02TypeId);
            if($exam02Type){
                $exam02Type->update([
                    'name' => $this->name,
                    'description' => $this->description ? $this->description : null,
                    'order_index' => $this->order_index ? $this->order_index : null,
                    'is_optional' => $this->is_optional,
                    'session_id' => $this->session_id ? $this->session_id : null,
                    'school_id' => $this->school_id ? $this->school_id : null,
                    'user_id' => $this->user_id ? $this->user_id : null,
                    'approved_by' => $this->approved_by ? $this->approved_by : null,
                    'is_active' => $this->is_active,
                    'is_finalized' => $this->is_finalized,
                    'status' => $this->status ? $this->status : null,
                    'remarks' => $this->remarks ? $this->remarks : null,
                ]);
            }
        } else {
            // Create new exam type
            Exam02Type::create([
                'name' => $this->name,
                'description' => $this->description ? $this->description : null,
                'order_index' => $this->order_index ? $this->order_index : null,
                'is_optional' => $this->is_optional,
                'session_id' => $this->session_id ? $this->session_id : null,
                'school_id' => $this->school_id ? $this->school_id : null,
                'user_id' => $this->user_id ? $this->user_id : null,
                'approved_by' => $this->approved_by ? $this->approved_by : null,
                'is_active' => $this->is_active,
                'is_finalized' => $this->is_finalized,
                'status' => $this->status ? $this->status : null,
                'remarks' => $this->remarks ? $this->remarks : null,
            ]);
        }

        session()->flash('message', $this->exam02TypeId ? 'Exam Type Updated Successfully.' : 'Exam Type Created Successfully.');

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
        $exam02Type = Exam02Type::findOrFail($id);
        $this->exam02TypeId = $id;
        $this->name = $exam02Type->name;
        $this->description = $exam02Type->description;
        $this->order_index = $exam02Type->order_index;
        $this->is_optional = $exam02Type->is_optional;
        $this->session_id = $exam02Type->session_id;
        $this->school_id = $exam02Type->school_id;
        $this->user_id = $exam02Type->user_id;
        $this->approved_by = $exam02Type->approved_by;
        $this->is_active = $exam02Type->is_active;
        $this->is_finalized = $exam02Type->is_finalized;
        $this->status = $exam02Type->status;
        $this->remarks = $exam02Type->remarks;

        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Exam02Type::find($id)->delete();
        session()->flash('message', 'Exam Type Deleted Successfully.');
    }
}
