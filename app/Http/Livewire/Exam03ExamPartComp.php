<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Exam03Part;
use App\Models\Session;
use App\Models\School;
use App\Models\User;
use Livewire\WithPagination;

class Exam03ExamPartComp extends Component
{
    use WithPagination;

    public $name, $description, $order_index, $is_optional, $session_id, $school_id, $user_id, $approved_by, $is_active, $is_finalized, $status, $remarks, $exam03PartId;
    public $isOpen = 0;
    public $search = '';
    public $perPage = 10;

    public function render()
    {
        $sessions = Session::all();
        $schools = School::all();
        $users = User::all();
        
        $exam03Parts = Exam03Part::query();
        
        if ($this->search) {
            $exam03Parts->where(function($subQuery) {
                $subQuery->where('name', 'like', '%' . $this->search . '%')
                         ->orWhere('description', 'like', '%' . $this->search . '%')
                         ->orWhere('status', 'like', '%' . $this->search . '%')
                         ->orWhere('remarks', 'like', '%' . $this->search . '%');
            });
        }

        $exam03Parts = $exam03Parts->paginate($this->perPage);

        return view('livewire.exam03-exam-part-comp', [
            'exam03Parts' => $exam03Parts ?? collect([]),
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
        $this->exam03PartId = null;
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

        if($this->exam03PartId){
            // Update existing exam part
            $exam03Part = Exam03Part::find($this->exam03PartId);
            if($exam03Part){
                $exam03Part->update([
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
            // Create new exam part
            Exam03Part::create([
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

        session()->flash('message', $this->exam03PartId ? 'Exam Part Updated Successfully.' : 'Exam Part Created Successfully.');

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
        $exam03Part = Exam03Part::findOrFail($id);
        $this->exam03PartId = $id;
        $this->name = $exam03Part->name;
        $this->description = $exam03Part->description;
        $this->order_index = $exam03Part->order_index;
        $this->is_optional = $exam03Part->is_optional;
        $this->session_id = $exam03Part->session_id;
        $this->school_id = $exam03Part->school_id;
        $this->user_id = $exam03Part->user_id;
        $this->approved_by = $exam03Part->approved_by;
        $this->is_active = $exam03Part->is_active;
        $this->is_finalized = $exam03Part->is_finalized;
        $this->status = $exam03Part->status;
        $this->remarks = $exam03Part->remarks;

        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Exam03Part::find($id)->delete();
        session()->flash('message', 'Exam Part Deleted Successfully.');
    }
}
