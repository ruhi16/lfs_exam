<div>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Role and Privilege Management</h1>
                <p class="text-gray-600 mt-1">Manage user roles and assign appropriate privileges</p>
            </div>
            <div class="flex space-x-3">
                <button wire:click="refreshData"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session()->has('message'))
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
            <div class="flex">
                <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                {{ session('message') }}
            </div>
        </div>
        @endif

        @if (session()->has('error'))
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
            <div class="flex">
                <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                {{ session('error') }}
            </div>
        </div>
        @endif

        <!-- Filters Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search Users</label>
                    <input type="text" wire:model.debounce.300ms="searchTerm" placeholder="Search by name or email..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Role</label>
                    <select wire:model="selectedRole"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Roles</option>
                        @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                        <option value="0">Unassigned Users</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Status Filter</label>
                    <select wire:model="statusFilter"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="suspended">Suspended</option>
                        <option value="pending">Pending</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button wire:click="clearFilters"
                        class="w-full px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                        <i class="fas fa-refresh mr-2"></i>Clear Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Users Table with Role-based Sections -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">User Directory by Role</h3>
            </div>

            @if($users && $users->count() > 0)
            @php
            $usersByRole = $users->groupBy('role_id');
            $currentUserRole = auth()->user()->role_id;
            @endphp

            @foreach($roles as $role)
            @if(isset($usersByRole[$role->id]) && $usersByRole[$role->id]->count() > 0)
            @php
            $roleUsers = $usersByRole[$role->id];
            $canManageRole = $this->canUserManageRole($role->id);
            $sectionColorClass = $this->getRoleSectionColor($role->id);
            @endphp

            <!-- Role Section -->
            <div class="border-l-4 {{ $sectionColorClass['border'] }} {{ $sectionColorClass['bg'] }} mb-4">
                <div class="px-6 py-3 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <span
                                class="inline-flex px-3 py-1 text-sm font-semibold rounded-full {{ $this->getRoleColorClass($role->id) }}">
                                {{ $role->name }}
                            </span>
                            <span class="ml-3 text-sm text-gray-600">
                                ({{ $roleUsers->count() }} {{ $roleUsers->count() == 1 ? 'user' : 'users' }})
                            </span>
                            @if(!$canManageRole)
                            <span
                                class="ml-3 inline-flex px-2 py-1 text-xs font-medium rounded bg-red-100 text-red-700">
                                <i class="fas fa-lock mr-1"></i>Restricted
                            </span>
                            @endif
                        </div>
                        @if($role->description)
                        <span class="text-sm text-gray-500">{{ $role->description }}</span>
                        @endif
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User Details
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Assignments
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($roleUsers as $user)
                            <tr class="hover:bg-gray-50">
                                <!-- User Details -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div
                                                class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center border-2 border-gray-200">
                                                <i class="fas fa-user text-gray-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                            <div class="text-xs text-gray-400">ID: {{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Assignments -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        @if($user->teacher)
                                        <div class="flex items-center mb-1">
                                            <i class="fas fa-chalkboard-teacher text-blue-500 w-4 mr-2"></i>
                                            <span class="font-medium">Teacher: {{ $user->teacher->name }}</span>
                                        </div>
                                        @if($user->teacher->desig)
                                        <div class="text-xs text-gray-500">{{ $user->teacher->desig }}</div>
                                        @endif
                                        @endif

                                        @if($user->studentdb)
                                        <div class="flex items-center mb-1">
                                            <i class="fas fa-user-graduate text-green-500 w-4 mr-2"></i>
                                            <span class="font-medium">Student</span>
                                        </div>
                                        @if($user->studentdb->myclass)
                                        <div class="text-xs text-gray-500">
                                            Class: {{ $user->studentdb->myclass->name }}
                                            @if($user->studentdb->sections)
                                            - {{ $user->studentdb->sections->name }}
                                            @endif
                                        </div>
                                        @endif
                                        @endif

                                        @if(!$user->teacher && !$user->studentdb)
                                        <span class="text-gray-400 text-sm">No assignments</span>
                                        @endif
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->status == 'active')
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                    @elseif($user->status == 'suspended')
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                                        <i class="fas fa-user-slash mr-1"></i>Suspended
                                    </span>
                                    @elseif($user->status == 'inactive')
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                    @else
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ ucfirst($user->status ?? 'Pending') }}
                                    </span>
                                    @endif
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    @if($canManageRole)
                                    <div class="flex justify-end space-x-2">
                                        <button wire:click="openUserModal({{ $user->id }})"
                                            class="text-blue-600 hover:text-blue-900 transition-colors">
                                            <i class="fas fa-edit mr-1"></i>Manage Role
                                        </button>

                                        @if($user->status == 'active')
                                        <button wire:click="suspendUser({{ $user->id }})"
                                            onclick="return confirm('Are you sure you want to suspend this user?')"
                                            class="text-orange-600 hover:text-orange-900 transition-colors">
                                            <i class="fas fa-user-slash mr-1"></i>Suspend
                                        </button>
                                        @else
                                        <button wire:click="reactivateUser({{ $user->id }})"
                                            class="text-green-600 hover:text-green-900 transition-colors">
                                            <i class="fas fa-user-check mr-1"></i>Reactivate
                                        </button>
                                        @endif

                                        <button wire:click="deAssignUser({{ $user->id }})"
                                            onclick="return confirm('Are you sure you want to remove all assignments for this user? This will reset their role, teacher, and student assignments.')"
                                            class="text-red-600 hover:text-red-900 transition-colors">
                                            <i class="fas fa-user-times mr-1"></i>De-assign
                                        </button>

                                        <!-- Debug button - remove after testing -->
                                        <button wire:click="testDeAssign({{ $user->id }})"
                                            class="text-purple-600 hover:text-purple-900 transition-colors text-xs">
                                            <i class="fas fa-bug mr-1"></i>Debug
                                        </button>
                                    </div>
                                    @else
                                    <span class="text-gray-400 text-sm">
                                        <i class="fas fa-lock mr-1"></i>Restricted
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif
            @endforeach

            <!-- Unassigned Users Section -->
            @php
            $unassignedUsers = $users->filter(function($user) {
            return $user->role_id == 0 || is_null($user->role_id);
            });
            @endphp

            callback: @if($unassignedUsers->count() > 0)
            <div class="border-l-4 border-orange-500 bg-orange-50 mb-4">
                <div class="px-6 py-3 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <span
                                class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-orange-100 text-orange-800">
                                Unassigned Users
                            </span>
                            <span class="ml-3 text-sm text-gray-600">
                                ({{ $unassignedUsers->count() }} {{ $unassignedUsers->count() == 1 ? 'user' : 'users'
                                }})
                            </span>
                            <span
                                class="ml-3 inline-flex px-2 py-1 text-xs font-medium rounded bg-yellow-100 text-yellow-700">
                                <i class="fas fa-user-clock mr-1"></i>Pending Assignment
                            </span>
                        </div>
                        <span class="text-sm text-gray-500">Users registered but not assigned to any role</span>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    User Details
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Registration Date
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($unassignedUsers as $user)
                            <tr class="hover:bg-gray-50">
                                <!-- User Details -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0 h-10 w-10">
                                            <div
                                                class="h-10 w-10 rounded-full bg-gray-300 flex items-center justify-center border-2 border-gray-200">
                                                <i class="fas fa-user text-gray-600"></i>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
                                            <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                            <div class="text-xs text-gray-400">ID: {{ $user->id }}</div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Registration Date -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ $user->created_at->format('d M, Y') }}
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        {{ ucfirst($user->status ?? 'Pending') }}
                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="openUserModal({{ $user->id }})"
                                        class="text-blue-600 hover:text-blue-900 transition-colors">
                                        <i class="fas fa-user-tag mr-1"></i>Assign Role
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                    </table>
                </div>
            </div>
            @endif
            @else
            <div class="px-6 py-12 text-center">
                <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Users Found</h3>
                <p class="text-gray-500">No users match your current filter criteria.</p>
            </div>
            @endif
        </div>

        <!-- User Role Assignment Modal -->
        @if($showUserModal)
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-2/3 lg:w-1/2 shadow-lg rounded-md bg-white">
                <div class="mt-3">
                    <!-- Modal Header -->
                    <div class="flex justify-between items-center pb-3 border-b">
                        <h3 class="text-lg font-semibold text-gray-900">Assign Role and Privileges</h3>
                        <button wire:click="closeUserModal" class="text-gray-400 hover:text-gray-600">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>

                    <!-- Modal Body -->
                    <div class="pt-4">
                        <!-- Role Selection -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Role *</label>
                            <select wire:model="selectedUserRole"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Choose a role...</option>
                                @foreach($availableRoles as $role)
                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('selectedUserRole')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Teacher Assignment (for roles other than Student) -->
                        @if($selectedUserRole && $selectedUserRole != 1)
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Assign Teacher
                                @if($selectedUserRole == 2)
                                <span class="text-red-500">*</span>
                                @endif
                            </label>
                            <select wire:model="selectedTeacher"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Choose an unassigned teacher...</option>
                                @foreach($unassignedTeachers as $teacher)
                                <option value="{{ $teacher->id }}">{{ $teacher->name }} - {{ $teacher->desig }}</option>
                                @endforeach
                            </select>
                            @if($unassignedTeachers->count() == 0)
                            <p class="mt-1 text-sm text-amber-600">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                No unassigned teachers available
                            </p>
                            @else
                            <p class="mt-1 text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Only teachers without user accounts are shown
                            </p>
                            @endif
                            @error('selectedTeacher')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        @endif

                        <!-- Student Assignment (for User role only) -->
                        @if($selectedUserRole == 1)
                        <div class="mb-4">
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                                <div class="flex items-center">
                                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                                    <div>
                                        <h4 class="text-sm font-medium text-blue-900">Student Role Assignment</h4>
                                        <p class="text-sm text-blue-700 mt-1">To assign a student role, please verify
                                            the student's details below.</p>
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <!-- Class Selection -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Class *</label>
                                    <select wire:model="selectedClass"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Class</option>
                                        @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('selectedClass')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Section Selection -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Section *</label>
                                    <select wire:model="selectedSection"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Section</option>
                                        @foreach($sections as $section)
                                        <option value="{{ $section->id }}">{{ $section->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('selectedSection')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Roll Number -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Roll Number *</label>
                                    <input type="text" wire:model="studentRoll" placeholder="Enter roll number"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('studentRoll')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Date of Birth -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth *</label>
                                    <input type="date" wire:model="studentDob"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    @error('studentDob')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <button wire:click="verifyStudent" type="button"
                                    class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    <i class="fas fa-search mr-2"></i>Verify Student Details
                                </button>
                            </div>

                            @if(session()->has('student_verified'))
                            <div class="mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
                                <div class="flex">
                                    <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                                    {{ session('student_verified') }}
                                </div>
                            </div>
                            @endif

                            @if(session()->has('student_error'))
                            <div class="mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
                                <div class="flex">
                                    <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                                    {{ session('student_error') }}
                                </div>
                            </div>
                            @endif
                        </div>
                        @endif
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-3 pt-4 border-t">
                        <button wire:click="closeUserModal" type="button"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                            Cancel
                        </button>
                        <button wire:click="assignRole" type="button" 
                        @php $isDisabled=false; if ($selectedUserRole==1
                            && !$selectedStudent) { $isDisabled=true; // Student role but no student verified 
                                }
                            elseif($selectedUserRole==2 && !$selectedTeacher) { $isDisabled=true; // Sub Admin role but no teacher selected 
                                } elseif (!$selectedUserRole) { $isDisabled=true; // No role selected 
                                    }
                            @endphp @if($isDisabled) disabled @endif
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed">
                            <i class="fas fa-save mr-2"></i>Assign Role
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>