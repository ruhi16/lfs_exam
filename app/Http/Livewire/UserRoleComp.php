<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Role;
use App\Models\Teacher;
use App\Models\Studentdb;
use App\Models\Myclass;
use App\Models\Section;
use App\Models\Studentcr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class UserRoleComp extends Component
{
    use WithPagination;

    // Filter properties
    public $selectedRole = '';
    public $searchTerm = '';
    public $statusFilter = '';

    // Modal properties
    public $showUserModal = false;
    public $showStudentModal = false;
    public $userId = null;
    public $editMode = false;

    // Form properties for role assignment
    public $selectedUserRole = '';
    public $selectedTeacher = '';
    
    // Student assignment properties
    public $selectedClass = '';
    public $selectedSection = '';
    public $studentRoll = '';
    public $studentDob = '';
    public $selectedStudent = '';

    // Display properties
    protected $users;
    protected $roles;
    protected $teachers;
    protected $students;
    protected $classes;
    protected $sections;

    protected $rules = [
        'selectedUserRole' => 'required|exists:roles,id',
        'selectedTeacher' => 'required_if:selectedUserRole,2|nullable|exists:teachers,id',
        'selectedClass' => 'required_if:selectedUserRole,1|exists:myclasses,id',
        'selectedSection' => 'required_if:selectedUserRole,1|exists:sections,id', 
        'studentRoll' => 'required_if:selectedUserRole,1|string|max:20',
        'studentDob' => 'required_if:selectedUserRole,1|date',
    ];

    protected $messages = [
        'selectedUserRole.required' => 'Please select a role for the user.',
        'selectedTeacher.required_if' => 'Teacher assignment is required for Sub Admin role.',
        'selectedTeacher.exists' => 'Please select a valid teacher.',
        'selectedClass.required_if' => 'Class is required for student role.',
        'selectedSection.required_if' => 'Section is required for student role.',
        'studentRoll.required_if' => 'Roll number is required for student role.',
        'studentDob.required_if' => 'Date of birth is required for student verification.',
    ];

    public function mount()
    {
        try {
            // Initialize collections first
            $this->users = collect();
            $this->roles = collect();
            $this->teachers = collect();
            $this->classes = collect();
            $this->sections = collect();
            
            // Load data
            $this->loadRoles();
            $this->loadUsers();
            $this->loadTeachers();
            $this->loadClasses();
            $this->loadSections();
            
        } catch (\Exception $e) {
            Log::error('Error in UserRoleComp mount: ' . $e->getMessage());
            session()->flash('error', 'Error loading component: ' . $e->getMessage());

            // Initialize empty collections as fallback
            $this->users = User::paginate(15);
            $this->roles = collect();
            $this->teachers = collect();
            $this->classes = collect();
            $this->sections = collect();
        }
    }

    public function loadUsers()
    {
        try {
            $query = User::with(['role', 'teacher', 'studentdb.myclass', 'studentdb.sections']);

            // Filter by role (include unassigned users when filter is set to 0)
            if ($this->selectedRole !== '' && $this->selectedRole !== null) {
                if ($this->selectedRole == '0') {
                    // Filter for unassigned users
                    $query->where(function($q) {
                        $q->whereNull('role_id')
                          ->orWhere('role_id', 0);
                    });
                } else {
                    $query->where('role_id', $this->selectedRole);
                }
            }

            // Search filter
            if ($this->searchTerm) {
                $query->where(function ($q) {
                    $q->where('name', 'like', "%{$this->searchTerm}%")
                      ->orWhere('email', 'like', "%{$this->searchTerm}%");
                });
            }

            // Status filter
            if ($this->statusFilter) {
                $query->where('status', $this->statusFilter);
            }

            $this->users = $query->orderByRaw('CASE WHEN role_id IS NULL OR role_id = 0 THEN 1 ELSE 0 END')
                                ->orderBy('role_id', 'desc')
                                ->orderBy('name')
                                ->paginate(15);
                                
            // Ensure we have a collection
            if (!$this->users) {
                $this->users = User::paginate(15);
            }
        } catch (\Exception $e) {
            Log::error('Error loading users: ' . $e->getMessage());
            $this->users = User::paginate(15);
        }
    }

    public function loadRoles()
    {
        try {
            $this->roles = Role::orderBy('id', 'desc')->get();
            
            // Ensure we have a collection, even if empty
            if (!$this->roles) {
                $this->roles = collect();
            }
        } catch (\Exception $e) {
            Log::error('Error loading roles: ' . $e->getMessage());
            $this->roles = collect();
        }
    }

    public function loadTeachers()
    {
        try {
            $this->teachers = Teacher::where(function($query) {
                                       $query->whereNull('user_id')
                                             ->orWhere('user_id', 0);
                                   })
                                   ->orWhereHas('user', function($q) {
                                       $q->where('id', $this->userId);
                                   })
                                   ->orderBy('name')
                                   ->get();
                                   
            // Ensure we have a collection
            if (!$this->teachers) {
                $this->teachers = collect();
            }
        } catch (\Exception $e) {
            Log::error('Error loading teachers: ' . $e->getMessage());
            $this->teachers = collect();
        }
    }

    public function getUnassignedTeachers()
    {
        try {
            // Only show teachers without user_id assignment (as per memory specification)
            return Teacher::where(function($query) {
                            $query->whereNull('user_id')
                                  ->orWhere('user_id', 0);
                        })
                         ->orderBy('name')
                         ->get();
        } catch (\Exception $e) {
            Log::error('Error loading unassigned teachers: ' . $e->getMessage());
            return collect();
        }
    }

    public function loadClasses()
    {
        try {
            $this->classes = Myclass::where('is_active', true)->orderBy('name')->get();
            
            // Ensure we have a collection
            if (!$this->classes) {
                $this->classes = collect();
            }
        } catch (\Exception $e) {
            Log::error('Error loading classes: ' . $e->getMessage());
            $this->classes = collect();
        }
    }

    public function loadSections()
    {
        try {
            $this->sections = Section::orderBy('name')->get();
            
            // Ensure we have a collection
            if (!$this->sections) {
                $this->sections = collect();
            }
        } catch (\Exception $e) {
            Log::error('Error loading sections: ' . $e->getMessage());
            $this->sections = collect();
        }
    }

    public function updatedSelectedRole()
    {
        $this->resetPage();
        try {
            $this->loadUsers();
        } catch (\Exception $e) {
            Log::error('Error updating selected role filter: ' . $e->getMessage());
            session()->flash('error', 'Error applying role filter.');
        }
    }

    public function updatedSearchTerm()
    {
        $this->resetPage();
        try {
            $this->loadUsers();
        } catch (\Exception $e) {
            Log::error('Error updating search term: ' . $e->getMessage());
            session()->flash('error', 'Error applying search filter.');
        }
    }

    public function updatedStatusFilter()
    {
        $this->resetPage();
        try {
            $this->loadUsers();
        } catch (\Exception $e) {
            Log::error('Error updating status filter: ' . $e->getMessage());
            session()->flash('error', 'Error applying status filter.');
        }
    }

    public function openUserModal($userId)
    {
        $this->resetForm();
        $this->userId = $userId;
        $this->editMode = true;
        
        $user = User::find($userId);
        if ($user) {
            $this->selectedUserRole = $user->role_id;
            $this->selectedTeacher = $user->teacher_id;
        }
        
        $this->loadTeachers();
        $this->showUserModal = true;
    }

    public function closeUserModal()
    {
        $this->showUserModal = false;
        $this->resetForm();
    }

    public function verifyStudent()
    {
        $this->validate([
            'selectedClass' => 'required',
            'selectedSection' => 'required',
            'studentRoll' => 'required',
            'studentDob' => 'required|date'
        ]);

        

        try{
            $student = Studentcr::where('myclass_id', $this->selectedClass)
                              ->where('section_id', $this->selectedSection)
                              ->where('roll_no', $this->studentRoll)
                            //   ->where('dob', $this->studentDob)
                              ->first();
            // dd($student->studentdb->dob);

        
            if ($student->studentdb->dob == $this->studentDob) {
                $this->selectedStudent = $student->id;
                session()->flash('student_verified', 'Student verified successfully!');
            } else {
                session()->flash('student_error', 'No student found with the provided details.');
                $this->selectedStudent = '';
            }
        } catch (\Exception $e) {
            Log::error('Error verifying student: ' . $e->getMessage());
            session()->flash('student_error', 'Error verifying student.');
        }
    }

    public function assignRole()
    {
        // Check if current user can assign this role
        if (!$this->canAssignRole($this->selectedUserRole)) {
            session()->flash('error', 'You do not have permission to assign this role.');
            return;
        }

        // dd($this->selectedStudent);
        // $this->validate();

        try {
            $user = User::find($this->userId);
            if (!$user) {
                session()->flash('error', 'User not found.');
                return;
            }

            // Update role
            $user->role_id = $this->selectedUserRole;

            // Handle teacher assignment for non-student roles
            if ($this->selectedTeacher && $this->selectedUserRole != 1) {
                $teacher = Teacher::find($this->selectedTeacher);
                if ($teacher && ($teacher->user_id == 0 || $teacher->user_id == null)) {
                    $teacher->user_id = $user->id;
                    $teacher->save();
                    $user->teacher_id = $this->selectedTeacher;
                }
            }

            // Handle student assignment for User role
            if ($this->selectedStudent && $this->selectedUserRole == 1) {
                $user->studentdb_id = $this->selectedStudent;
                // Clear teacher assignment if switching to student
                if ($user->teacher_id) {
                    $oldTeacher = Teacher::find($user->teacher_id);
                    if ($oldTeacher) {
                        $oldTeacher->user_id = 0;
                        $oldTeacher->save();
                    }
                    $user->teacher_id = 0;
                }
            }

            // Clear student assignment if switching from student to other role
            if ($this->selectedUserRole != 1 && $user->studentdb_id) {
                $user->studentdb_id = 0;
            }

            $user->save();

            session()->flash('message', 'Role assigned successfully!');
            $this->closeUserModal();
            $this->loadUsers();

        } catch (\Exception $e) {
            Log::error('Error assigning role: ' . $e->getMessage());
            session()->flash('error', 'Error assigning role: ' . $e->getMessage());
        }
    }

    private function canAssignRole($roleId)
    {
        $currentUser = Auth::user();
        $currentUserRole = $currentUser->role_id;

        // Super Admin (5) can assign any role
        if ($currentUserRole == 5) {
            return true;
        }

        // Admin (4) can assign roles 1, 2, 3
        if ($currentUserRole == 4 && in_array($roleId, [1, 2, 3])) {
            return true;
        }

        // Office (3) can assign roles 1, 2
        if ($currentUserRole == 3 && in_array($roleId, [1, 2])) {
            return true;
        }

        // Sub Admin (2) can assign role 1 only
        if ($currentUserRole == 2 && $roleId == 1) {
            return true;
        }

        return false;
    }

    public function getAvailableRoles()
    {
        // Ensure roles are loaded
        if (!$this->roles || $this->roles->isEmpty()) {
            $this->loadRoles();
        }
        
        $currentUser = Auth::user();
        $currentUserRole = $currentUser->role_id;

        $availableRoles = collect();

        // Super Admin can assign any role
        if ($currentUserRole == 5) {
            $availableRoles = $this->roles;
        }
        // Admin can assign roles 1, 2, 3
        elseif ($currentUserRole == 4) {
            $availableRoles = $this->roles->whereIn('id', [1, 2, 3]);
        }
        // Office can assign roles 1, 2
        elseif ($currentUserRole == 3) {
            $availableRoles = $this->roles->whereIn('id', [1, 2]);
        }
        // Sub Admin can assign role 1 only
        elseif ($currentUserRole == 2) {
            $availableRoles = $this->roles->where('id', 1);
        }

        return $availableRoles;
    }

    public function refreshData()
    {
        $this->loadUsers();
        $this->loadRoles();
        $this->loadTeachers();
        $this->loadClasses();
        $this->loadSections();
        session()->flash('message', 'Data refreshed successfully!');
    }

    public function clearFilters()
    {
        $this->selectedRole = '';
        $this->searchTerm = '';
        $this->statusFilter = '';
        $this->resetPage();
        $this->loadUsers();
    }

    private function resetForm()
    {
        $this->userId = null;
        $this->editMode = false;
        $this->selectedUserRole = '';
        $this->selectedTeacher = '';
        $this->selectedClass = '';
        $this->selectedSection = '';
        $this->studentRoll = '';
        $this->studentDob = '';
        $this->selectedStudent = '';
    }

    public function canUserManageRole($roleId)
    {
        $currentUser = Auth::user();
        $currentUserRole = $currentUser->role_id;

        // Allow de-assignment of unassigned users (role_id = 0 or null)
        if (!$roleId || $roleId == 0) {
            return true;
        }

        // Super Admin (5) can manage all roles except their own level
        if ($currentUserRole == 5) {
            return $roleId < 5; // Can manage roles 1, 2, 3, 4
        }

        // Admin (4) can manage roles 1, 2, 3
        if ($currentUserRole == 4) {
            return in_array($roleId, [1, 2, 3]);
        }

        // Office (3) can manage roles 1, 2
        if ($currentUserRole == 3) {
            return in_array($roleId, [1, 2]);
        }

        // Sub Admin (2) can manage role 1 only
        if ($currentUserRole == 2) {
            return $roleId == 1;
        }

        return false;
    }

    public function getRoleSectionColor($roleId)
    {
        switch($roleId) {
            case 5:
                return ['border' => 'border-purple-500', 'bg' => 'bg-purple-50'];
            case 4:
                return ['border' => 'border-red-500', 'bg' => 'bg-red-50'];
            case 3:
                return ['border' => 'border-blue-500', 'bg' => 'bg-blue-50'];
            case 2:
                return ['border' => 'border-green-500', 'bg' => 'bg-green-50'];
            case 1:
                return ['border' => 'border-gray-500', 'bg' => 'bg-gray-50'];
            default:
                return ['border' => 'border-gray-500', 'bg' => 'bg-gray-50'];
        }
    }

    public function getRoleColorClass($roleId)
    {
        switch($roleId) {
            case 5:
                return 'bg-purple-100 text-purple-800';
            case 4:
                return 'bg-red-100 text-red-800';
            case 3:
                return 'bg-blue-100 text-blue-800';
            case 2:
                return 'bg-green-100 text-green-800';
            case 1:
                return 'bg-gray-100 text-gray-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    }

    public function render()
    {
        // Ensure all properties are initialized
        if (!$this->users) {
            $this->loadUsers();
        }
        if (!$this->roles) {
            $this->loadRoles();
        }
        if (!$this->teachers) {
            $this->loadTeachers();
        }
        if (!$this->classes) {
            $this->loadClasses();
        }
        if (!$this->sections) {
            $this->loadSections();
        }

        return view('livewire.user-role-comp', [
            'users' => $this->users ?? User::paginate(15),
            'roles' => $this->roles ?? collect(),
            'availableRoles' => $this->getAvailableRoles(),
            'teachers' => $this->teachers ?? collect(),
            'unassignedTeachers' => $this->getUnassignedTeachers(),
            'classes' => $this->classes ?? collect(),
            'sections' => $this->sections ?? collect()
        ]);
    }

    public function suspendUser($userId)
    {
        try {
            $user = User::find($userId);
            if (!$user) {
                session()->flash('error', 'User not found.');
                return;
            }

            // Check if current user can manage this user's role
            if (!$this->canUserManageRole($user->role_id)) {
                session()->flash('error', 'You do not have permission to suspend this user.');
                return;
            }

            $user->status = 'suspended';
            $user->save();

            session()->flash('message', 'User suspended successfully!');
            $this->loadUsers();

        } catch (\Exception $e) {
            Log::error('Error suspending user: ' . $e->getMessage());
            session()->flash('error', 'Error suspending user.');
        }
    }

    public function reactivateUser($userId)
    {
        try {
            $user = User::find($userId);
            if (!$user) {
                session()->flash('error', 'User not found.');
                return;
            }

            // Check if current user can manage this user's role
            if (!$this->canUserManageRole($user->role_id)) {
                session()->flash('error', 'You do not have permission to reactivate this user.');
                return;
            }

            $user->status = 'active';
            $user->save();

            session()->flash('message', 'User reactivated successfully!');
            $this->loadUsers();

        } catch (\Exception $e) {
            Log::error('Error reactivating user: ' . $e->getMessage());
            session()->flash('error', 'Error reactivating user.');
        }
    }

    public function deAssignUser($userId)
    {
        try {
            $user = User::find($userId);
            if (!$user) {
                session()->flash('error', 'User not found.');
                return;
            }

            // Check if current user can manage this user's role
            // Skip permission check if user is already unassigned (role_id = 0 or null)
            if ($user->role_id && $user->role_id > 0 && !$this->canUserManageRole($user->role_id)) {
                session()->flash('error', 'You do not have permission to de-assign this user.');
                return;
            }

            // Clear teacher assignment if exists and update teacher record
            if ($user->teacher_id) {
                $teacher = Teacher::find($user->teacher_id);
                if ($teacher) {
                    $teacher->user_id = 0;
                    $teacher->save();
                    Log::info('Cleared teacher assignment for teacher ID: ' . $teacher->id);
                }
            }

            // Store original values for logging
            $originalRole = $user->role_id;
            $originalTeacher = $user->teacher_id;
            $originalStudent = $user->studentdb_id;

            // Reset all user assignments
            $user->role_id = 0;
            $user->teacher_id = 0;
            $user->studentdb_id = 0;
            $user->status = 'inactive';
            
            // Use fill and save for better handling
            $user->fill([
                'role_id' => 0,
                'teacher_id' => 0,
                'studentdb_id' => 0,
                'status' => 'inactive'
            ]);
            
            $saveResult = $user->save();
            
            if (!$saveResult) {
                throw new \Exception('Failed to save user changes');
            }

            Log::info('User de-assigned successfully', [
                'user_id' => $userId,
                'original_role' => $originalRole,
                'original_teacher' => $originalTeacher,
                'original_student' => $originalStudent
            ]);

            session()->flash('message', 'User de-assigned successfully! All role and assignment data cleared.');
            $this->loadUsers();

        } catch (\Exception $e) {
            Log::error('Error de-assigning user: ' . $e->getMessage(), [
                'user_id' => $userId,
                'trace' => $e->getTraceAsString()
            ]);
            session()->flash('error', 'Error de-assigning user: ' . $e->getMessage());
        }
    }

    public function testDeAssign($userId)
    {
        // Debug method to test de-assignment
        try {
            $user = User::find($userId);
            $currentUser = Auth::user();
            
            if (!$user) {
                session()->flash('error', 'User not found for testing.');
                return;
            }
            
            $debugInfo = [
                'user_id' => $userId,
                'user_name' => $user->name,
                'user_role_id' => $user->role_id,
                'user_teacher_id' => $user->teacher_id,
                'user_studentdb_id' => $user->studentdb_id,
                'user_status' => $user->status,
                'current_user_role' => $currentUser->role_id,
                'can_manage' => $this->canUserManageRole($user->role_id)
            ];
            
            Log::info('De-assignment debug info', $debugInfo);
            
            // Try a simple update to test database connection
            $user->updated_at = now();
            $updateResult = $user->save();
            
            session()->flash('message', 'Debug completed. Can manage: ' . ($debugInfo['can_manage'] ? 'YES' : 'NO') . '. Update test: ' . ($updateResult ? 'SUCCESS' : 'FAILED'));
            
        } catch (\Exception $e) {
            Log::error('Debug test failed: ' . $e->getMessage());
            session()->flash('error', 'Debug test failed: ' . $e->getMessage());
        }
    }
}
