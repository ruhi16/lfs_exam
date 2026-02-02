<?php if($showWidget): ?>
<!-- Dashboard Widget Mode -->
<div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4">
    <div class="flex items-center justify-between mb-3">
        <h3 class="text-sm font-medium text-gray-900">Active Session</h3>
        <button wire:click="refreshData" class="text-gray-400 hover:text-gray-600">
            <i class="fas fa-sync-alt text-sm"></i>
        </button>
    </div>

    <?php if($activeSession): ?>
    <div class="space-y-2">
        <div class="flex items-center justify-between">
            <span class="text-lg font-semibold text-gray-900"><?php echo e($activeSession->name); ?></span>
            <span
                class="px-2 py-1 text-xs font-medium rounded-full <?php echo e($this->getSessionStatusColor($activeSession->status)); ?>">
                <?php echo e(ucfirst($activeSession->status)); ?>

            </span>
        </div>

        <div class="text-sm text-gray-600">
            <div class="flex items-center">
                <i class="fas fa-calendar-alt w-4 mr-2"></i>
                <?php echo e($this->getSessionDuration($activeSession)); ?>

            </div>
            <?php if($this->isSessionCurrent($activeSession)): ?>
            <div class="flex items-center mt-1 text-green-600">
                <i class="fas fa-check-circle w-4 mr-2"></i>
                Current Session
            </div>
            <?php endif; ?>
        </div>

        <?php if($activeSession->details): ?>
        <p class="text-xs text-gray-500 truncate" title="<?php echo e($activeSession->details); ?>">
            <?php echo e($activeSession->details); ?>

        </p>
        <?php endif; ?>
    </div>

    <!-- Quick Session Switcher -->
    <?php
    // $sessions->where('status', '!=', 'active')->count()
    $activeSessionCount = count(array_filter($sessions, function ($session) {
    return $session['status'] !== 'active';
    }));
    $sessions = collect($sessions)->map(function ($item) {
    return new Session($item);
    });
    ?>
    <?php if($activeSessionCount > 0): ?>
    <div class="mt-3 pt-3 border-t border-gray-100">
        <div class="relative">
            <select wire:change="setActiveSession($event.target.value)"
                class="w-full text-xs border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500">
                <option value="">Switch Session...</option>
                
            </select>
        </div>
    </div>
    <?php endif; ?>
    <?php else: ?>
    <div class="text-center py-4">
        <div class="text-gray-400 mb-2">
            <i class="fas fa-calendar-times text-2xl"></i>
        </div>
        <p class="text-sm text-gray-500">No active session</p>
        <button wire:click="openModal" class="mt-2 text-xs bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700">
            Create Session
        </button>
    </div>
    <?php endif; ?>
</div>
<?php else: ?>

<div class="flex-1 p-6 overflow-y-auto max-w-full mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Sessions Management</h1>
                <p class="mt-1 text-sm text-gray-600">Manage academic sessions and their configurations</p>
            </div>
            <div class="flex space-x-2">
                <button wire:click="refreshData"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Refresh Data
                </button>
                <button wire:click="showAddModal"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Add Session
                </button>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if(session()->has('message')): ?>
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
        <?php echo e(session('message')); ?>

    </div>
    <?php endif; ?>

    <?php if(session()->has('error')): ?>
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
        <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>

    <!-- Sessions Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">All Sessions</h3>
            <p class="text-sm text-gray-600 mt-1">
                Total Sessions: <?php echo e(count($sessions)); ?> |
                Active: <?php echo e(count(array_filter($sessions, fn($s) => $s['status'] === 'Active'))); ?> |
                Inactive: <?php echo e(count(array_filter($sessions, fn($s) => $s['status'] === 'Inactive'))); ?>

            </p>
        </div>

        <?php if(count($sessions) > 0): ?>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Session
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Duration
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            School
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Related Data
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Finalization
                        </th>
                        <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 text-sm text-gray-900">
                            <div class="font-medium"><?php echo e($session['name']); ?></div>
                            <?php if($session['details']): ?>
                            <div class="text-xs text-gray-500 mt-1"><?php echo e($session['details']); ?></div>
                            <?php endif; ?>
                            <?php if($session['remark']): ?>
                            <div class="text-xs text-gray-400 mt-1"><?php echo e($session['remark']); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">
                            <div class="text-xs text-gray-400">to</div>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">
                            <?php echo e($session['school_name']); ?>

                        </td>
                        <td class="px-4 py-3 text-sm">
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium <?php echo e($session['status'] === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                <?php echo e($session['status']); ?>

                            </span>
                        </td>
                        <td class="px-4 py-3 text-sm text-gray-500">
                            <div class="grid grid-cols-2 gap-1 text-xs">
                                <div>Classes: <?php echo e($session['myclasses_count']); ?></div>
                                <div>Sections: <?php echo e($session['sections_count']); ?></div>
                                <div>Subjects: <?php echo e($session['subjects_count']); ?></div>
                                <div>Students: <?php echo e($session['studentdbs_count']); ?></div>
                                <div>Records: <?php echo e($session['studentcrs_count']); ?></div>
                                <div>Exams: <?php echo e($session['exams_count']); ?></div>
                            </div>
                        </td>
                        <td class="px-4 py-3 text-sm">
                            <?php if($session['is_finalized']): ?>
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                🔒 FINALIZED
                            </span>
                            <?php else: ?>
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                ✏️ EDITABLE
                            </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-sm text-center">
                            <div class="flex justify-center space-x-2">
                                <?php if($session['is_finalized']): ?>
                                <button wire:click="unfinalizeData(<?php echo e($session['id']); ?>)"
                                    onclick="return confirm('Are you sure you want to unfinalize this session? This will allow changes again.')"
                                    class="bg-orange-500 hover:bg-orange-700 text-white px-2 py-1 rounded text-xs">
                                    🔓 Unfinalize
                                </button>
                                <?php else: ?>
                                <button wire:click="confirmFinalize(<?php echo e($session['id']); ?>)"
                                    class="bg-green-500 hover:bg-green-700 text-white px-2 py-1 rounded text-xs mr-1">
                                    🔒 Finalize
                                </button>
                                <button wire:click="editSession(<?php echo e($session['id']); ?>)"
                                    class="text-blue-600 hover:text-blue-900">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    </svg>
                                </button>
                                <button wire:click="toggleStatus(<?php echo e($session['id']); ?>)"
                                    class="text-yellow-600 hover:text-yellow-900">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                        </path>
                                    </svg>
                                </button>
                                <button wire:click="deleteSession(<?php echo e($session['id']); ?>)"
                                    class="text-red-600 hover:text-red-900"
                                    onclick="return confirm('Are you sure you want to delete this session?')">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        <?php else: ?>
        <div class="p-8 text-center">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900">No sessions</h3>
            <p class="mt-1 text-sm text-gray-500">Get started by creating a new session.</p>
            <div class="mt-6">
                <button wire:click="showAddModal"
                    class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700">
                    <svg class="-ml-1 mr-2 h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add Session
                </button>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Modal -->
    <?php if($showModal): ?>
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" id="modal">
        <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-medium text-gray-900">
                        <?php echo e($editingId ? 'Edit Session' : 'Add New Session'); ?>

                    </h3>
                    <button wire:click="hideModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <form wire:submit.prevent="saveSession">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <!-- Session Name -->
                        <div class="col-span-2">
                            <label for="name" class="block text-sm font-medium text-gray-700">Session Name *</label>
                            <input type="text" wire:model="name" id="name"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Details -->
                        <div class="col-span-2">
                            <label for="details" class="block text-sm font-medium text-gray-700">Details</label>
                            <textarea wire:model="details" id="details" rows="2"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500"></textarea>
                            <?php $__errorArgs = ['details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Start Date -->
                        <div>
                            <label for="stdate" class="block text-sm font-medium text-gray-700">Start Date *</label>
                            <input type="date" wire:model="stdate" id="stdate"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <?php $__errorArgs = ['stdate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- End Date -->
                        <div>
                            <label for="entdate" class="block text-sm font-medium text-gray-700">End Date *</label>
                            <input type="date" wire:model="entdate" id="entdate"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <?php $__errorArgs = ['entdate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Status -->
                        <div>
                            <label for="status" class="block text-sm font-medium text-gray-700">Status *</label>
                            <select wire:model="status" id="status"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- School -->
                        <div>
                            <label for="schoolId" class="block text-sm font-medium text-gray-700">School</label>
                            <select wire:model="schoolId" id="schoolId"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select School</option>
                                <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($school['id']); ?>"><?php echo e($school['name']); ?></option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['schoolId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Previous Session -->
                        <div>
                            <label for="prevSessionId" class="block text-sm font-medium text-gray-700">Previous
                                Session</label>
                            <select wire:model="prevSessionId" id="prevSessionId"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Previous Session</option>
                                <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($session['id'] != $editingId): ?>
                                <option value="<?php echo e($session['id']); ?>"><?php echo e($session['name']); ?></option>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['prevSessionId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Next Session -->
                        <div>
                            <label for="nextSessionId" class="block text-sm font-medium text-gray-700">Next
                                Session</label>
                            <select wire:model="nextSessionId" id="nextSessionId"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Next Session</option>
                                <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($session['id'] != $editingId): ?>
                                <option value="<?php echo e($session['id']); ?>"><?php echo e($session['name']); ?></option>
                                <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['nextSessionId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Remark -->
                        <div class="col-span-2">
                            <label for="remark" class="block text-sm font-medium text-gray-700">Remark</label>
                            <input type="text" wire:model="remark" id="remark"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <?php $__errorArgs = ['remark'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3 mt-6">
                        <button type="button" wire:click="hideModal"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded-md text-sm font-medium">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            <?php echo e($editingId ? 'Update' : 'Create'); ?> Session
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Finalization Confirmation Modal -->
    <?php if($showFinalizeModal): ?>
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="cancelFinalize"></div>

            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-1a2 2 0 00-2-2H6a2 2 0 00-2 2v1a2 2 0 002 2zM12 7a2 2 0 100-4 2 2 0 000 4z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Finalize Session</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to finalize this session? Once finalized, it cannot be edited
                                    or deleted.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="finalizeData"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm">
                        🔒 Finalize
                    </button>
                    <button wire:click="cancelFinalize"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<?php endif; ?><?php /**PATH /home/bkoq0ic0h8xi/public_html/littleflowerschool.co.in/resources/views/livewire/session-comp.blade.php ENDPATH**/ ?>