<?php
namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Myclass;
use App\Models\School;
use App\Models\Session;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class Basic03ClassComp extends Component
{
    use WithPagination;

    public $name, $description, $order_index, $code, $school_id, $session_id, $user_id, $approved_by, $is_active, $is_finalized, $status, $remarks, $myclassId;
    public $isOpen = 0;
    public $search = '';

    public function render()
    {
        $schools = School::all();
        $sessions = Session::all();
        $users = User::all();
        
        $myclasses = Myclass::query();
        
        if ($this->search) {
            $myclasses->where(function($subQuery) {
                $subQuery->where('name', 'like', '%' . $this->search . '%')
                         ->orWhere('code', 'like', '%' . $this->search . '%')
                         ->orWhere('status', 'like', '%' . $this->search . '%')
                         ->orWhere('remarks', 'like', '%' . $this->search . '%')
                         ->orWhere('description', 'like', '%' . $this->search . '%');
            });
        }

        $myclasses = $myclasses->paginate(10);

        return view('livewire.basic03-class-comp', [
            'myclasses' => $myclasses ?? collect([]),
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
        $this->myclassId = null;
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

        if($this->myclassId){
            // Update existing class
            $myclass = Myclass::find($this->myclassId);
            if($myclass){
                $myclass->update([
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
            // Create new class
            Myclass::create([
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

        session()->flash('message', $this->myclassId ? 'Class Updated Successfully.' : 'Class Created Successfully.');

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
        $myclass = Myclass::findOrFail($id);
        $this->myclassId = $id;
        $this->name = $myclass->name;
        $this->description = $myclass->description;
        $this->order_index = $myclass->order_index;
        $this->code = $myclass->code;
        $this->school_id = $myclass->school_id;
        $this->session_id = $myclass->session_id;
        $this->user_id = $myclass->user_id;
        $this->approved_by = $myclass->approved_by;
        $this->is_active = $myclass->is_active;
        $this->is_finalized = $myclass->is_finalized;
        $this->status = $myclass->status;
        $this->remarks = $myclass->remarks;

        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Myclass::find($id)->delete();
        session()->flash('message', 'Class Deleted Successfully.');
    }
}
