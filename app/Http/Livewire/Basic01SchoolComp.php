<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\School;
use App\Models\Session;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;

class Basic01SchoolComp extends Component
{
    use WithPagination;

    public $name, $code, $details, $vill, $po, $ps, $pin, $dist, $index, $hscode, $disecode, $estd, $status, $remark, $is_active, $is_finalized, $session_id, $schoolId;
    public $isOpen = 0;
    public $search = '';

    public function render()
    {
        $sessions = Session::all();
        
        $query = School::query();
        
        if ($this->search) {
            $query->where(function($subQuery) {
                $subQuery->where('name', 'like', '%' . $this->search . '%')
                         ->orWhere('code', 'like', '%' . $this->search . '%')
                         ->orWhere('vill', 'like', '%' . $this->search . '%')
                         ->orWhere('po', 'like', '%' . $this->search . '%')
                         ->orWhere('dist', 'like', '%' . $this->search . '%');
            });
        }

        $schools = $query->paginate(10);

        return view('livewire.basic01-school-comp', [
            'schools' => $schools ?? collect([]),
            'sessions' => $sessions
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
        $this->code = '';
        $this->details = '';
        $this->vill = '';
        $this->po = '';
        $this->ps = '';
        $this->pin = '';
        $this->dist = '';
        $this->index = '';
        $this->hscode = '';
        $this->disecode = '';
        $this->estd = '';
        $this->status = '';
        $this->remark = '';
        $this->is_active = false;
        $this->is_finalized = false;
        $this->session_id = '';
        $this->schoolId = null;
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
            'session_id' => 'required',
            'code' => 'nullable|string|max:255',
            'details' => 'nullable|string',
            'vill' => 'nullable|string|max:255',
            'po' => 'nullable|string|max:255',
            'ps' => 'nullable|string|max:255',
            'pin' => 'nullable|string|max:255',
            'dist' => 'nullable|string|max:255',
            'index' => 'nullable|string|max:255',
            'hscode' => 'nullable|string|max:255',
            'disecode' => 'nullable|string|max:255',
            'estd' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'remark' => 'nullable|string',
            'is_active' => 'boolean',
            'is_finalized' => 'boolean',
        ]);

        School::updateOrCreate(['id' => $this->schoolId], [
            'name' => $this->name,
            'code' => $this->code,
            'details' => $this->details,
            'vill' => $this->vill,
            'po' => $this->po,
            'ps' => $this->ps,
            'pin' => $this->pin,
            'dist' => $this->dist,
            'index' => $this->index,
            'hscode' => $this->hscode,
            'disecode' => $this->disecode,
            'estd' => $this->estd,
            'status' => $this->status,
            'remark' => $this->remark,
            'is_active' => $this->is_active,
            'is_finalized' => $this->is_finalized,
            'session_id' => $this->session_id,
        ]);

        session()->flash('message', $this->schoolId ? 'School Updated Successfully.' : 'School Created Successfully.');

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
        $school = School::findOrFail($id);
        $this->schoolId = $id;
        $this->name = $school->name;
        $this->code = $school->code;
        $this->details = $school->details;
        $this->vill = $school->vill;
        $this->po = $school->po;
        $this->ps = $school->ps;
        $this->pin = $school->pin;
        $this->dist = $school->dist;
        $this->index = $school->index;
        $this->hscode = $school->hscode;
        $this->disecode = $school->disecode;
        $this->estd = $school->estd;
        $this->status = $school->status;
        $this->remark = $school->remark;
        $this->is_active = $school->is_active;
        $this->is_finalized = $school->is_finalized;
        $this->session_id = $school->session_id;

        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        School::find($id)->delete();
        session()->flash('message', 'School Deleted Successfully.');
    }
}