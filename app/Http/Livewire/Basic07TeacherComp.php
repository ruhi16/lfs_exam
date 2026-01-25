<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Teacher;
use App\Models\User;
use App\Models\Session;
use App\Models\School;
use App\Models\Subject;
use Livewire\WithPagination;

class Basic07TeacherComp extends Component
{
    use WithPagination;

    public $name, $nickName, $mobno, $desig, $hqual, $train_qual, $extra_qual, $main_subject_id, $notes, $prev_session_pk, $img_ref, $status, $remark, $user_id, $session_id, $school_id, $is_active, $teacherId;
    public $isOpen = 0;
    public $search = '';
    public $perPage = 10;

    public function render()
    {
        $users = User::all();
        $sessions = Session::all();
        $schools = School::all();
        $subjects = Subject::all();
        
        $teachers = Teacher::query();
        
        if ($this->search) {
            $teachers->where(function($subQuery) {
                $subQuery->where('name', 'like', '%' . $this->search . '%')
                         ->orWhere('nickName', 'like', '%' . $this->search . '%')
                         ->orWhere('mobno', 'like', '%' . $this->search . '%')
                         ->orWhere('desig', 'like', '%' . $this->search . '%')
                         ->orWhere('status', 'like', '%' . $this->search . '%')
                         ->orWhere('remark', 'like', '%' . $this->search . '%')
                         ->orWhere('notes', 'like', '%' . $this->search . '%');
            });
        }

        $teachers = $teachers->paginate($this->perPage);

        return view('livewire.basic07-teacher-comp', [
            'teachers' => $teachers ?? collect([]),
            'users' => $users,
            'sessions' => $sessions,
            'schools' => $schools,
            'subjects' => $subjects
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
        $this->nickName = '';
        $this->mobno = '';
        $this->desig = '';
        $this->hqual = '';
        $this->train_qual = '';
        $this->extra_qual = '';
        $this->main_subject_id = '';
        $this->notes = '';
        $this->prev_session_pk = null;
        $this->img_ref = '';
        $this->status = '';
        $this->remark = '';
        $this->user_id = '';
        $this->session_id = '';
        $this->school_id = '';
        $this->is_active = true;
        $this->teacherId = null;
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
            'nickName' => 'nullable|string|max:255',
            'mobno' => 'nullable|string|max:255',
            'desig' => 'nullable|string|max:255',
            'hqual' => 'nullable|string|max:255',
            'train_qual' => 'nullable|string|max:255',
            'extra_qual' => 'nullable|string|max:255',
            'main_subject_id' => 'nullable|integer',
            'notes' => 'nullable|string',
            'prev_session_pk' => 'nullable|integer',
            'img_ref' => 'nullable|string|max:255',
            'status' => 'nullable|string|max:255',
            'remark' => 'nullable|string',
            'user_id' => 'nullable|integer',
            'session_id' => 'nullable|integer',
            'school_id' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        if($this->teacherId){
            // Update existing teacher
            $teacher = Teacher::find($this->teacherId);
            if($teacher){
                $teacher->update([
                    'name' => $this->name,
                    'nickName' => $this->nickName ? $this->nickName : null,
                    'mobno' => $this->mobno ? $this->mobno : null,
                    'desig' => $this->desig ? $this->desig : null,
                    'hqual' => $this->hqual ? $this->hqual : null,
                    'train_qual' => $this->train_qual ? $this->train_qual : null,
                    'extra_qual' => $this->extra_qual ? $this->extra_qual : null,
                    'main_subject_id' => $this->main_subject_id ? $this->main_subject_id : null,
                    'notes' => $this->notes ? $this->notes : null,
                    'prev_session_pk' => $this->prev_session_pk ? $this->prev_session_pk : null,
                    'img_ref' => $this->img_ref ? $this->img_ref : null,
                    'status' => $this->status ? $this->status : null,
                    'remark' => $this->remark ? $this->remark : null,
                    'user_id' => $this->user_id ? $this->user_id : null,
                    'session_id' => $this->session_id ? $this->session_id : null,
                    'school_id' => $this->school_id ? $this->school_id : null,
                    'is_active' => $this->is_active,
                ]);
            }
        } else {
            // Create new teacher
            Teacher::create([
                'name' => $this->name,
                'nickName' => $this->nickName ? $this->nickName : null,
                'mobno' => $this->mobno ? $this->mobno : null,
                'desig' => $this->desig ? $this->desig : null,
                'hqual' => $this->hqual ? $this->hqual : null,
                'train_qual' => $this->train_qual ? $this->train_qual : null,
                'extra_qual' => $this->extra_qual ? $this->extra_qual : null,
                'main_subject_id' => $this->main_subject_id ? $this->main_subject_id : null,
                'notes' => $this->notes ? $this->notes : null,
                'prev_session_pk' => $this->prev_session_pk ? $this->prev_session_pk : null,
                'img_ref' => $this->img_ref ? $this->img_ref : null,
                'status' => $this->status ? $this->status : null,
                'remark' => $this->remark ? $this->remark : null,
                'user_id' => $this->user_id ? $this->user_id : null,
                'session_id' => $this->session_id ? $this->session_id : null,
                'school_id' => $this->school_id ? $this->school_id : null,
                'is_active' => $this->is_active,
            ]);
        }

        session()->flash('message', $this->teacherId ? 'Teacher Updated Successfully.' : 'Teacher Created Successfully.');

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
        $teacher = Teacher::findOrFail($id);
        $this->teacherId = $id;
        $this->name = $teacher->name;
        $this->nickName = $teacher->nickName;
        $this->mobno = $teacher->mobno;
        $this->desig = $teacher->desig;
        $this->hqual = $teacher->hqual;
        $this->train_qual = $teacher->train_qual;
        $this->extra_qual = $teacher->extra_qual;
        $this->main_subject_id = $teacher->main_subject_id;
        $this->notes = $teacher->notes;
        $this->prev_session_pk = $teacher->prev_session_pk;
        $this->img_ref = $teacher->img_ref;
        $this->status = $teacher->status;
        $this->remark = $teacher->remark;
        $this->user_id = $teacher->user_id;
        $this->session_id = $teacher->session_id;
        $this->school_id = $teacher->school_id;
        $this->is_active = $teacher->is_active;

        $this->openModal();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public function delete($id)
    {
        Teacher::find($id)->delete();
        session()->flash('message', 'Teacher Deleted Successfully.');
    }
}
