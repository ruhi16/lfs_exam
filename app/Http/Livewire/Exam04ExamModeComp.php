<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Exam04Mode;
use App\Models\Session;
use App\Models\School;
use App\Models\User;
use Livewire\WithPagination;

class Exam04ExamModeComp extends Component
{
    use WithPagination;

    public $name, $description, $order_index, $is_optional, $session_id, $school_id, $user_id, $approved_by, $is_active, $is_finalized, $status, $remarks, $exam04ModeId;
    public $isOpen = 0;
    public $search = '';
    public $perPage = 10;

    public function render()
    {
        $sessions = Session::all();
        $schools = School::all();
        $users = User::all();
        
        $exam04Modes = Exam04Mode::query();
        
        if ($this->search) {
            $exam04Modes->where(function($subQuery) {
                $subQuery->where('name', 'like', '%' . $this->search . '%')
                         ->orWhere('description', 'like', '%' . $this->search . '%')
                         ->orWhere('status', 'like', '%' . $this->search . '%')
                         ->orWhere('remarks', 'like', '%' . $this->search . '%');
            });
        }

        $exam04Modes = $exam04Modes->paginate($this->perPage);

        return view('livewire.exam04-exam-mode-comp', [
            'exam04Modes' => $exam04Modes ?? collect([]),
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
        $this->exam04ModeId = null;
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

        if($this->exam04ModeId){
            // Update existing exam mode
            $exam04Mode = Exam04Mode::find($this->exam04ModeId);
            if($exam04Mode){
                $exam04Mode->update([
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
            // Create new exam mode
            Exam04Mode::create([
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

        session()->flash('message', $this->exam04ModeId ? 'Exam Mode Updated Successfully.' : 'Exam Mode Created Successfully.');

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
        $exam04Mode = Exam04Mode::findOrFail($id);
        $this->exam04ModeId = $id;
        $this->name = $exam04Mode->name;
        $this->description = $exam04Mode->description;
        $this->order_index = $exam04Mode->order_index;
        $this->is_optional = $exam04Mode->is_optional;
        $this->session_id = $exam04Mode->session_id;
        $this->school_id = $exam04Mode->school_id;
        $this->user_id = $exam04Mode->user_id;
        $this->approved_by = $exam04Mode->approved_by;
        $this->is_active = $exam04Mode->is_active;
        $this->is_finalized = $exam04Mode->is_finalized;
        $this->status = $exam04Mode->status;
        $this->remarks = $exam04Mode->remarks;

        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Exam04Mode::find($id)->delete();
        session()->flash('message', 'Exam Mode Deleted Successfully.');
    }
}