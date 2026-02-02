<div class="flex-1 p-6 overflow-y-auto max-w-6xl mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Exam Name Management</h1>
                <p class="mt-1 text-sm text-gray-600">Manage exam names and their configurations</p>
            </div>
            <button wire:click="openModal"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                Add New Exam Name
            </button>
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

    <!-- Search and Filters -->
    <div class="mb-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <div class="flex items-center space-x-4">
            <div class="flex-1">
                <label for="search" class="sr-only">Search</label>
                <input wire:model.debounce.300ms="search" type="text" id="search"
                    placeholder="Search exam names by name, description, or status..."
                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
            </div>
            <?php if($search): ?>
            <button wire:click="$set('search', '')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Exam Names Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Exam Name
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Description
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Order
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Status
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Finalization
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Created
                        </th>
                        <th scope="col"
                            class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__empty_1 = true; $__currentLoopData = $examNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center">
                                <div>
                                    <div class="text-sm font-medium text-gray-900"><?php echo e($examName->name); ?></div>
                                    <?php if($examName->is_finalized): ?>
                                    <div class="text-xs text-green-600">Finalized</div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-sm text-gray-900"><?php echo e($examName->description ?: '-'); ?></div>
                            <?php if($examName->remarks): ?>
                            <div class="text-xs text-gray-500"><?php echo e(Str::limit($examName->remarks, 50)); ?></div>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-900">
                            <?php echo e($examName->order_index ?: '-'); ?>

                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center space-x-2">
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium 
                                                                            <?php if($examName->is_active): ?> bg-green-100 text-green-800 <?php else: ?> bg-red-100 text-red-800 <?php endif; ?>">
                                    <?php echo e($examName->is_active ? 'Active' : 'Inactive'); ?>

                                </span>
                                <?php if($examName->status): ?>
                                <span class="text-xs text-gray-500"><?php echo e($examName->status); ?></span>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <?php if($examName->is_finalized): ?>
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                🔒 FINALIZED
                            </span>
                            <?php else: ?>
                            <span
                                class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                ✏️ EDITABLE
                            </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                            <?php echo e($examName->created_at); ?>

                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <?php if(!$isDataFinalized): ?>
                                <button wire:click="toggleStatus(<?php echo e($examName->id); ?>)"
                                    class="text-indigo-600 hover:text-indigo-900 text-xs">
                                    <?php echo e($examName->is_active ? 'Deactivate' : 'Activate'); ?>

                                </button>
                                <button wire:click="edit(<?php echo e($examName->id); ?>)"
                                    class="text-indigo-600 hover:text-indigo-900 text-xs">
                                    Edit
                                </button>
                                <button wire:click="confirmDelete(<?php echo e($examName->id); ?>)"
                                    class="text-red-600 hover:text-red-900 text-xs">
                                    Delete
                                </button>
                                <?php endif; ?>

                                <?php if($examName->is_finalized): ?>
                                <button wire:click="unfinalizeData(<?php echo e($examName->id); ?>)"
                                    onclick="return confirm('Are you sure you want to unfinalize this exam name? This will allow changes again.')"
                                    class="bg-orange-500 hover:bg-orange-700 text-white px-2 py-1 rounded text-xs">
                                    🔓 Unfinalize
                                </button>
                                <?php else: ?>
                                <button wire:click="confirmFinalize(<?php echo e($examName->id); ?>)"
                                    class="bg-green-500 hover:bg-green-700 text-white px-2 py-1 rounded text-xs">
                                    🔒 Finalize
                                </button>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">
                            <div class="text-lg font-medium mb-2">No exam names found</div>
                            <div class="text-sm">
                                <?php if($search): ?>
                                No exam names match your search criteria.
                                <?php else: ?>
                                Get started by creating your first exam name.
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if($examNames->hasPages()): ?>
        <div class="px-4 py-3 bg-gray-50 border-t border-gray-200">
            <?php echo e($examNames->links()); ?>

        </div>
        <?php endif; ?>
    </div>

    <!-- Create/Edit Modal -->
    <?php if($showModal): ?>
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" wire:click="closeModal"></div>

            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form wire:submit.prevent="save">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="mb-4">
                            <h3 class="text-lg font-medium text-gray-900" id="modal-title">
                                <?php echo e($editingId ? 'Edit Exam Name' : 'Add New Exam Name'); ?>

                            </h3>
                        </div>

                        <div class="space-y-4">
                            <!-- Name -->
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700">Exam Name *</label>
                                <input wire:model="name" type="text" id="name"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Description -->
                            <div>
                                <label for="description"
                                    class="block text-sm font-medium text-gray-700">Description</label>
                                <textarea wire:model="description" id="description" rows="3"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                                <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Order Index -->
                            <div>
                                <label for="order_index" class="block text-sm font-medium text-gray-700">Order
                                    Index</label>
                                <input wire:model="order_index" type="number" id="order_index" min="0"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <?php $__errorArgs = ['order_index'];
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
                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                <input wire:model="status" type="text" id="status"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Remarks -->
                            <div>
                                <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                <textarea wire:model="remarks" id="remarks" rows="2"
                                    class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                                <?php $__errorArgs = ['remarks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-xs"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>

                            <!-- Checkboxes -->
                            <div class="flex items-center space-x-6">
                                <div class="flex items-center">
                                    <input wire:model="is_active" type="checkbox" id="is_active"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_active" class="ml-2 block text-sm text-gray-900">Active</label>
                                </div>
                                <div class="flex items-center">
                                    <input wire:model="is_finalized" type="checkbox" id="is_finalized"
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                    <label for="is_finalized" class="ml-2 block text-sm text-gray-900">Finalized</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button type="submit"
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            <?php echo e($editingId ? 'Update' : 'Create'); ?>

                        </button>
                        <button type="button" wire:click="closeModal"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Delete Confirmation Modal -->
    <?php if($confirmingDeletion): ?>
    <div class="fixed inset-0 z-50 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div
                            class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                            <svg class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">Delete Exam Name</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Are you sure you want to delete this exam name? This action cannot be undone.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="delete"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-red-600 text-base font-medium text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Delete
                    </button>
                    <button wire:click="cancelDelete"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div><?php /**PATH /home/bkoq0ic0h8xi/public_html/littleflowerschool.co.in/resources/views/livewire/exam-name-comp.blade.php ENDPATH**/ ?>