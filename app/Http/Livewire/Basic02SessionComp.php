<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Session;
use App\Models\School;
use Illuminate\Support\Facades\Hash;
use Livewire\WithPagination;
use DateTimeInterface;

class Basic02SessionComp extends Component
{
    use WithPagination;

    public $name, $details, $code, $stdate, $entdate, $status, $remark, $prev_session_id, $next_session_id, $school_id, $is_active, $is_finalized, $sessionId;
    public $isOpen = 0;
    public $search = '';

    public function render()
    {
        $schools = School::all();
        $sessions = Session::query();
        
        if ($this->search) {
            $sessions->where(function($subQuery) {
                $subQuery->where('name', 'like', '%' . $this->search . '%')
                         ->orWhere('code', 'like', '%' . $this->search . '%')
                         ->orWhere('status', 'like', '%' . $this->search . '%')
                         ->orWhere('remark', 'like', '%' . $this->search . '%');
            });
        }

        $sessions = $sessions->paginate(10);
        $allSessions = Session::all();

        return view('livewire.basic02-session-comp', [
            'sessions' => $sessions ?? collect([]),
            'allSessions' => $allSessions,
            'schools' => $schools
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
        $this->details = '';
        $this->code = '';
        $this->stdate = '';
        $this->entdate = '';
        $this->status = '';
        $this->remark = '';
        $this->prev_session_id = '';
        $this->next_session_id = '';
        $this->school_id = '';
        $this->is_active = false;
        $this->is_finalized = false;
        $this->sessionId = null;
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
            'stdate' => 'required|date',
            'entdate' => 'required|date',
            'details' => 'nullable|string',
            'code' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'remark' => 'nullable|string',
            'prev_session_id' => 'nullable|integer',
            'next_session_id' => 'nullable|integer',
            'school_id' => 'nullable|integer',
            'is_active' => 'boolean',
            'is_finalized' => 'boolean',
        ]);

        if($this->is_active){
            // If setting a session as active, deactivate all other sessions
            Session::where('id', '!=', $this->sessionId)->update(['is_active' => false]);
        }
        
        if($this->sessionId){
            // Update existing session
            $session = Session::find($this->sessionId);
            if($session){
                $session->update([
                    'name' => $this->name,
                    'details' => $this->details ? $this->details : null,
                    'code' => $this->code ? $this->code : null,
                    'stdate' => $this->stdate,
                    'entdate' => $this->entdate,
                    'status' => $this->status ? $this->status : null,
                    'remark' => $this->remark ? $this->remark : null,
                    'prev_session_id' => $this->prev_session_id ? $this->prev_session_id : null,
                    'next_session_id' => $this->next_session_id ? $this->next_session_id : null,
                    'school_id' => $this->school_id ? $this->school_id : null,
                    'is_active' => $this->is_active,
                    'is_finalized' => $this->is_finalized,
                ]);
            }
        } else {
            // Create new session
            Session::create([
                'name' => $this->name,
                'details' => $this->details ? $this->details : null,
                'code' => $this->code ? $this->code : null,
                'stdate' => $this->stdate,
                'entdate' => $this->entdate,
                'status' => $this->status ? $this->status : null,
                'remark' => $this->remark ? $this->remark : null,
                'prev_session_id' => $this->prev_session_id ? $this->prev_session_id : null,
                'next_session_id' => $this->next_session_id ? $this->next_session_id : null,
                'school_id' => $this->school_id ? $this->school_id : null,
                'is_active' => $this->is_active,
                'is_finalized' => $this->is_finalized,
            ]);
        }

        session()->flash('message', $this->sessionId ? 'Session Updated Successfully.' : 'Session Created Successfully.');

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
        $session = Session::findOrFail($id);
        $this->sessionId = $id;
        $this->name = $session->name;
        $this->details = $session->details;
        $this->code = $session->code;
        $this->stdate = $session->stdate ? ($session->stdate instanceof DateTimeInterface ? $session->stdate->format('Y-m-d') : $session->stdate) : null;
        $this->entdate = $session->entdate ? ($session->entdate instanceof DateTimeInterface ? $session->entdate->format('Y-m-d') : $session->entdate) : null;
        $this->status = $session->status;
        $this->remark = $session->remark;
        $this->prev_session_id = $session->prev_session_id;
        $this->next_session_id = $session->next_session_id;
        $this->school_id = $session->school_id;
        $this->is_active = $session->is_active;
        $this->is_finalized = $session->is_finalized;

        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Session::find($id)->delete();
        session()->flash('message', 'Session Deleted Successfully.');
    }
}
