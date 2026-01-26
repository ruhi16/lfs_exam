<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Exam01Name;
use App\Models\Session;
use App\Models\School;
use App\Models\User;
use Livewire\WithPagination;

class Exam01ExamNameComp extends Component
{
    use WithPagination;

    public $name, $description, $exam_month, $exam_year, $order_index, $is_optional, $session_id, $school_id, $user_id, $approved_by, $is_active, $is_finalized, $status, $remarks, $exam01NameId;
    public $isOpen = 0;
    public $search = '';
    public $perPage = 10;

    public function render()
    {
        $sessions = Session::all();
        $schools = School::all();
        $users = User::all();
        
        $exam01Names = Exam01Name::query();
        
        if ($this->search) {
            $exam01Names->where(function($subQuery) {
                $subQuery->where('name', 'like', '%' . $this->search . '%')
                         ->orWhere('description', 'like', '%' . $this->search . '%')
                         ->orWhere('exam_month', 'like', '%' . $this->search . '%')
                         ->orWhere('exam_year', 'like', '%' . $this->search . '%')
                         ->orWhere('status', 'like', '%' . $this->search . '%')
                         ->orWhere('remarks', 'like', '%' . $this->search . '%');
            });
        }

        $exam01Names = $exam01Names->paginate($this->perPage);

        return view('livewire.exam01-exam-name-comp', [
            'exam01Names' => $exam01Names ?? collect([]),
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
        $this->exam_month = '';
        $this->exam_year = '';
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
        $this->exam01NameId = null;
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
            'exam_month' => 'nullable|string|max:255',
            'exam_year' => 'nullable|string|max:255',
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

        if($this->exam01NameId){
            // Update existing exam name
            $exam01Name = Exam01Name::find($this->exam01NameId);
            if($exam01Name){
                $exam01Name->update([
                    'name' => $this->name,
                    'description' => $this->description ? $this->description : null,
                    'exam_month' => $this->exam_month ? $this->exam_month : null,
                    'exam_year' => $this->exam_year ? $this->exam_year : null,
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
            // Create new exam name
            Exam01Name::create([
                'name' => $this->name,
                'description' => $this->description ? $this->description : null,
                'exam_month' => $this->exam_month ? $this->exam_month : null,
                'exam_year' => $this->exam_year ? $this->exam_year : null,
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

        session()->flash('message', $this->exam01NameId ? 'Exam Name Updated Successfully.' : 'Exam Name Created Successfully.');

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
        $exam01Name = Exam01Name::findOrFail($id);
        $this->exam01NameId = $id;
        $this->name = $exam01Name->name;
        $this->description = $exam01Name->description;
        $this->exam_month = $exam01Name->exam_month;
        $this->exam_year = $exam01Name->exam_year;
        $this->order_index = $exam01Name->order_index;
        $this->is_optional = $exam01Name->is_optional;
        $this->session_id = $exam01Name->session_id;
        $this->school_id = $exam01Name->school_id;
        $this->user_id = $exam01Name->user_id;
        $this->approved_by = $exam01Name->approved_by;
        $this->is_active = $exam01Name->is_active;
        $this->is_finalized = $exam01Name->is_finalized;
        $this->status = $exam01Name->status;
        $this->remarks = $exam01Name->remarks;

        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Exam01Name::find($id)->delete();
        session()->flash('message', 'Exam Name Deleted Successfully.');
    }
}



