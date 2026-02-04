<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Role;
use App\Models\Teacher;
use App\Models\Studentdb;
use Illuminate\Support\Facades\Hash;

class SupadminDcUsersComp extends Component
{
    protected $users;
    public $roles, $teachers, $students;
    public $name, $email, $password, $role_id, $teacher_id, $studentdb_id, $status, $user_id;
    public $isOpen = 0;
    public $isEdit = false;
    public $search = '';

    public function mount()
    {
        $this->roles = Role::where('id', '<', auth()->user()->role_id)->get();
        $this->teachers = Teacher::where('id', '>', 5)->get();
        $this->students = Studentdb::all();
    }

    public function getUsers()
    {
        $query = User::with(['role', 'teacher', 'studentdb'])->orderBy('id', 'desc');
        
        if (!empty($this->search)) {
            $query->where(function($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }
        
        return $query->latest()->paginate(10);
    }

    public function render()
    {
        return view('livewire.supadmin-dc-users-comp', [
            'users' => $this->getUsers()
        ]);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
        $this->isEdit = false;
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function resetInputFields()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->role_id = '';
        $this->teacher_id = '';
        $this->studentdb_id = '';
        $this->status = '';
        $this->user_id = null;
    }

    public function store()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . ($this->user_id ? $this->user_id : '') . '',
            'password' => $this->user_id ? 'nullable' : 'required|min:6',
            'role_id' => 'required|exists:roles,id',
        ]);

        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role_id,
        ];

        if (!$this->user_id && $this->password) {
            $userData['password'] = Hash::make($this->password);
        } elseif ($this->user_id && $this->password) {
            $userData['password'] = Hash::make($this->password);
        }

        if ($this->teacher_id) {
            $userData['teacher_id'] = $this->teacher_id;
        }

        if ($this->studentdb_id) {
            $userData['studentdb_id'] = $this->studentdb_id;
        }

        if ($this->status !== '') {
            $userData['status'] = $this->status;
        }

        if ($this->user_id) {
            $user = User::find($this->user_id);
            $user->update($userData);
            session()->flash('message', 'User Updated Successfully.');
        } else {
            User::create($userData);
            session()->flash('message', 'User Created Successfully.');
        }

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        $this->user_id = $id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role_id = $user->role_id;
        $this->teacher_id = $user->teacher_id;
        $this->studentdb_id = $user->studentdb_id;
        $this->status = $user->status ?? '';

        $this->isEdit = true;
        $this->openModal();
    }

    public function delete($id)
    {
        User::find($id)->delete();
        session()->flash('message', 'User Deleted Successfully.');
    }
}
