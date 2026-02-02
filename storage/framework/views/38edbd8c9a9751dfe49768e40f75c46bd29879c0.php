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
        <?php if(session()->has('message')): ?>
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
            <div class="flex">
                <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                <?php echo e(session('message')); ?>

            </div>
        </div>
        <?php endif; ?>

        <?php if(session()->has('error')): ?>
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
            <div class="flex">
                <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                <?php echo e(session('error')); ?>

            </div>
        </div>
        <?php endif; ?>

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
                        <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

            <?php if($users && $users->count() > 0): ?>
            <?php
            $usersByRole = $users->groupBy('role_id');
            $currentUserRole = auth()->user()->role_id;
            ?>

            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if(isset($usersByRole[$role->id]) && $usersByRole[$role->id]->count() > 0): ?>
            <?php
            $roleUsers = $usersByRole[$role->id];
            $canManageRole = $this->canUserManageRole($role->id);
            $sectionColorClass = $this->getRoleSectionColor($role->id);
            ?>

            <!-- Role Section -->
            <div class="border-l-4 <?php echo e($sectionColorClass['border']); ?> <?php echo e($sectionColorClass['bg']); ?> mb-4">
                <div class="px-6 py-3 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <span
                                class="inline-flex px-3 py-1 text-sm font-semibold rounded-full <?php echo e($this->getRoleColorClass($role->id)); ?>">
                                <?php echo e($role->name); ?>

                            </span>
                            <span class="ml-3 text-sm text-gray-600">
                                (<?php echo e($roleUsers->count()); ?> <?php echo e($roleUsers->count() == 1 ? 'user' : 'users'); ?>)
                            </span>
                            <?php if(!$canManageRole): ?>
                            <span
                                class="ml-3 inline-flex px-2 py-1 text-xs font-medium rounded bg-red-100 text-red-700">
                                <i class="fas fa-lock mr-1"></i>Restricted
                            </span>
                            <?php endif; ?>
                        </div>
                        <?php if($role->description): ?>
                        <span class="text-sm text-gray-500"><?php echo e($role->description); ?></span>
                        <?php endif; ?>
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
                            <?php $__currentLoopData = $roleUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                            <div class="text-sm font-medium text-gray-900"><?php echo e($user->name); ?></div>
                                            <div class="text-sm text-gray-500"><?php echo e($user->email); ?></div>
                                            <div class="text-xs text-gray-400">ID: <?php echo e($user->id); ?></div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Assignments -->
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-900">
                                        <?php if($user->teacher): ?>
                                        <div class="flex items-center mb-1">
                                            <i class="fas fa-chalkboard-teacher text-blue-500 w-4 mr-2"></i>
                                            <span class="font-medium">Teacher: <?php echo e($user->teacher->name); ?></span>
                                        </div>
                                        <?php if($user->teacher->desig): ?>
                                        <div class="text-xs text-gray-500"><?php echo e($user->teacher->desig); ?></div>
                                        <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if($user->studentdb): ?>
                                        <div class="flex items-center mb-1">
                                            <i class="fas fa-user-graduate text-green-500 w-4 mr-2"></i>
                                            <span class="font-medium">Student</span>
                                        </div>
                                        <?php if($user->studentdb->myclass): ?>
                                        <div class="text-xs text-gray-500">
                                            Class: <?php echo e($user->studentdb->myclass->name); ?>

                                            <?php if($user->studentdb->sections): ?>
                                            - <?php echo e($user->studentdb->sections->name); ?>

                                            <?php endif; ?>
                                        </div>
                                        <?php endif; ?>
                                        <?php endif; ?>

                                        <?php if(!$user->teacher && !$user->studentdb): ?>
                                        <span class="text-gray-400 text-sm">No assignments</span>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php if($user->status == 'active'): ?>
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                    <?php elseif($user->status == 'suspended'): ?>
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-orange-100 text-orange-800">
                                        <i class="fas fa-user-slash mr-1"></i>Suspended
                                    </span>
                                    <?php elseif($user->status == 'inactive'): ?>
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Inactive
                                    </span>
                                    <?php else: ?>
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <?php echo e(ucfirst($user->status ?? 'Pending')); ?>

                                    </span>
                                    <?php endif; ?>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <?php if($canManageRole): ?>
                                    <div class="flex justify-end space-x-2">
                                        <button wire:click="openUserModal(<?php echo e($user->id); ?>)"
                                            class="text-blue-600 hover:text-blue-900 transition-colors">
                                            <i class="fas fa-edit mr-1"></i>Manage Role
                                        </button>

                                        <?php if($user->status == 'active'): ?>
                                        <button wire:click="suspendUser(<?php echo e($user->id); ?>)"
                                            onclick="return confirm('Are you sure you want to suspend this user?')"
                                            class="text-orange-600 hover:text-orange-900 transition-colors">
                                            <i class="fas fa-user-slash mr-1"></i>Suspend
                                        </button>
                                        <?php else: ?>
                                        <button wire:click="reactivateUser(<?php echo e($user->id); ?>)"
                                            class="text-green-600 hover:text-green-900 transition-colors">
                                            <i class="fas fa-user-check mr-1"></i>Reactivate
                                        </button>
                                        <?php endif; ?>

                                        <button wire:click="deAssignUser(<?php echo e($user->id); ?>)"
                                            onclick="return confirm('Are you sure you want to remove all assignments for this user? This will reset their role, teacher, and student assignments.')"
                                            class="text-red-600 hover:text-red-900 transition-colors">
                                            <i class="fas fa-user-times mr-1"></i>De-assign
                                        </button>

                                        <!-- Debug button - remove after testing -->
                                        <button wire:click="testDeAssign(<?php echo e($user->id); ?>)"
                                            class="text-purple-600 hover:text-purple-900 transition-colors text-xs">
                                            <i class="fas fa-bug mr-1"></i>Debug
                                        </button>
                                    </div>
                                    <?php else: ?>
                                    <span class="text-gray-400 text-sm">
                                        <i class="fas fa-lock mr-1"></i>Restricted
                                    </span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <!-- Unassigned Users Section -->
            <?php
            $unassignedUsers = $users->filter(function($user) {
            return $user->role_id == 0 || is_null($user->role_id);
            });
            ?>

            callback: <?php if($unassignedUsers->count() > 0): ?>
            <div class="border-l-4 border-orange-500 bg-orange-50 mb-4">
                <div class="px-6 py-3 border-b border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center">
                            <span
                                class="inline-flex px-3 py-1 text-sm font-semibold rounded-full bg-orange-100 text-orange-800">
                                Unassigned Users
                            </span>
                            <span class="ml-3 text-sm text-gray-600">
                                (<?php echo e($unassignedUsers->count()); ?> <?php echo e($unassignedUsers->count() == 1 ? 'user' : 'users'); ?>)
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
                            <?php $__currentLoopData = $unassignedUsers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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
                                            <div class="text-sm font-medium text-gray-900"><?php echo e($user->name); ?></div>
                                            <div class="text-sm text-gray-500"><?php echo e($user->email); ?></div>
                                            <div class="text-xs text-gray-400">ID: <?php echo e($user->id); ?></div>
                                        </div>
                                    </div>
                                </td>

                                <!-- Registration Date -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <?php echo e($user->created_at->format('d M, Y')); ?>

                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span
                                        class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        <?php echo e(ucfirst($user->status ?? 'Pending')); ?>

                                    </span>
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <button wire:click="openUserModal(<?php echo e($user->id); ?>)"
                                        class="text-blue-600 hover:text-blue-900 transition-colors">
                                        <i class="fas fa-user-tag mr-1"></i>Assign Role
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                </div>
            </div>
            <?php endif; ?>
            <?php else: ?>
            <div class="px-6 py-12 text-center">
                <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No Users Found</h3>
                <p class="text-gray-500">No users match your current filter criteria.</p>
            </div>
            <?php endif; ?>
        </div>

        <!-- User Role Assignment Modal -->
        <?php if($showUserModal): ?>
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
                                <?php $__currentLoopData = $availableRoles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($role->id); ?>"><?php echo e($role->name); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['selectedUserRole'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Teacher Assignment (for roles other than Student) -->
                        <?php if($selectedUserRole && $selectedUserRole != 1): ?>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Assign Teacher
                                <?php if($selectedUserRole == 2): ?>
                                <span class="text-red-500">*</span>
                                <?php endif; ?>
                            </label>
                            <select wire:model="selectedTeacher"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Choose an unassigned teacher...</option>
                                <?php $__currentLoopData = $unassignedTeachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($teacher->id); ?>"><?php echo e($teacher->name); ?> - <?php echo e($teacher->desig); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php if($unassignedTeachers->count() == 0): ?>
                            <p class="mt-1 text-sm text-amber-600">
                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                No unassigned teachers available
                            </p>
                            <?php else: ?>
                            <p class="mt-1 text-xs text-gray-500">
                                <i class="fas fa-info-circle mr-1"></i>
                                Only teachers without user accounts are shown
                            </p>
                            <?php endif; ?>
                            <?php $__errorArgs = ['selectedTeacher'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        <?php endif; ?>

                        <!-- Student Assignment (for User role only) -->
                        <?php if($selectedUserRole == 1): ?>
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
                                        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($class->id); ?>"><?php echo e($class->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['selectedClass'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Section Selection -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Section *</label>
                                    <select wire:model="selectedSection"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Select Section</option>
                                        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($section->id); ?>"><?php echo e($section->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['selectedSection'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Roll Number -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Roll Number *</label>
                                    <input type="text" wire:model="studentRoll" placeholder="Enter roll number"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['studentRoll'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>

                                <!-- Date of Birth -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Date of Birth *</label>
                                    <input type="date" wire:model="studentDob"
                                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <?php $__errorArgs = ['studentDob'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                    <p class="mt-1 text-sm text-red-600"><?php echo e($message); ?></p>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="mt-4">
                                <button wire:click="verifyStudent" type="button"
                                    class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                    <i class="fas fa-search mr-2"></i>Verify Student Details
                                </button>
                            </div>

                            <?php if(session()->has('student_verified')): ?>
                            <div class="mt-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
                                <div class="flex">
                                    <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                                    <?php echo e(session('student_verified')); ?>

                                </div>
                            </div>
                            <?php endif; ?>

                            <?php if(session()->has('student_error')): ?>
                            <div class="mt-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
                                <div class="flex">
                                    <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                                    <?php echo e(session('student_error')); ?>

                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                        <?php endif; ?>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end space-x-3 pt-4 border-t">
                        <button wire:click="closeUserModal" type="button"
                            class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                            Cancel
                        </button>
                        <button wire:click="assignRole" type="button" 
                        <?php $isDisabled=false; if ($selectedUserRole==1
                            && !$selectedStudent) { $isDisabled=true; // Student role but no student verified 
                                }
                            elseif($selectedUserRole==2 && !$selectedTeacher) { $isDisabled=true; // Sub Admin role but no teacher selected 
                                } elseif (!$selectedUserRole) { $isDisabled=true; // No role selected 
                                    }
                            ?> <?php if($isDisabled): ?> disabled <?php endif; ?>
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed">
                            <i class="fas fa-save mr-2"></i>Assign Role
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div><?php /**PATH /home/bkoq0ic0h8xi/public_html/littleflowerschool.co.in/resources/views/livewire/user-role-comp.blade.php ENDPATH**/ ?>