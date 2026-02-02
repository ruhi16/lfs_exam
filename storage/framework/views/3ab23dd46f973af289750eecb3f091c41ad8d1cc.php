<div class="flex-1 p-6 overflow-y-auto max-w-full mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Classes Management</h1>
                <p class="mt-1 text-sm text-gray-600">Manage school classes with ordering and configuration</p>
            </div>
            <div class="flex space-x-2">
                <button wire:click="refreshData" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Refresh Data
                </button>
                <button wire:click="showAddForm" 
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Add Class
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

    <!-- Add/Edit Form -->
    <?php if($showAddForm): ?>
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">
                    <?php echo e($editingId ? 'Edit Class' : 'Add New Class'); ?>

                </h3>
                <button wire:click="hideAddForm" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="saveClass">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Class Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Class Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model="name" id="name" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="e.g., Grade 10, Class XII">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Order Index -->
                    <div>
                        <label for="orderIndex" class="block text-sm font-medium text-gray-700 mb-2">
                            Order Index <span class="text-red-500">*</span>
                        </label>
                        <input type="number" wire:model="orderIndex" id="orderIndex" min="1"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        <?php $__errorArgs = ['orderIndex'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea wire:model="description" id="description" rows="3"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Brief description of the class"></textarea>
                        <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                            Status <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="status" id="status" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                            <option value="pending">Pending</option>
                        </select>
                        <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Remarks -->
                    <div>
                        <label for="remarks" class="block text-sm font-medium text-gray-700 mb-2">
                            Remarks
                        </label>
                        <input type="text" wire:model="remarks" id="remarks" 
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="Additional notes">
                        <?php $__errorArgs = ['remarks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" wire:click="hideAddForm" 
                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md text-sm font-medium">
                        Cancel
                    </button>
                    <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        <?php echo e($editingId ? 'Update' : 'Save'); ?>

                    </button>
                </div>
            </form>
        </div>
    <?php endif; ?>

    <!-- Classes Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">All Classes</h3>
            <p class="text-sm text-gray-600 mt-1">
                Total Classes: <?php echo e(count($classes)); ?>

            </p>
        </div>

        <?php if(count($classes) > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Order
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Class Name
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Description
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Statistics
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Created
                            </th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    <div class="flex items-center space-x-1">
                                        <span class="font-medium"><?php echo e($class['order_index']); ?></span>
                                        <div class="flex flex-col space-y-1">
                                            <?php if($class['order_index'] > 1): ?>
                                                <button wire:click="moveUp(<?php echo e($class['id']); ?>)" 
                                                    class="text-blue-600 hover:text-blue-800">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            <?php endif; ?>
                                            <?php if($class['order_index'] < count($classes)): ?>
                                                <button wire:click="moveDown(<?php echo e($class['id']); ?>)" 
                                                    class="text-blue-600 hover:text-blue-800">
                                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    <div class="font-medium"><?php echo e($class['name']); ?></div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">
                                    <?php echo e($class['description'] ?: 'No description'); ?>

                                </td>
                                <td class="px-4 py-3 text-sm">
                                    <div class="flex flex-col space-y-1">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                            <?php echo e($class['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                            <?php echo e($class['is_active'] ? 'Active' : 'Inactive'); ?>

                                        </span>
                                        <?php if($class['is_finalized']): ?>
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                Finalized
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">
                                    <div class="space-y-1">
                                        <div>Sections: <?php echo e($class['sections_count']); ?></div>
                                        <div>Subjects: <?php echo e($class['subjects_count']); ?></div>
                                        <div>Students: <?php echo e($class['students_count']); ?></div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-500">
                                    <div><?php echo e($class['created_at']); ?></div>
                                </td>
                                <td class="px-4 py-3 text-sm text-center">
                                    <div class="flex justify-center space-x-2">
                                        <button wire:click="editClass(<?php echo e($class['id']); ?>)" 
                                            class="text-indigo-600 hover:text-indigo-900">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                            </svg>
                                        </button>
                                        
                                        <button wire:click="toggleStatus(<?php echo e($class['id']); ?>)" 
                                            class="<?php echo e($class['is_active'] ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900'); ?>">
                                            <?php if($class['is_active']): ?>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            <?php else: ?>
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            <?php endif; ?>
                                        </button>

                                        <?php if(!$class['is_finalized']): ?>
                                            <button wire:click="finalizeClass(<?php echo e($class['id']); ?>)" 
                                                class="text-blue-600 hover:text-blue-900"
                                                title="Finalize">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </button>
                                        <?php endif; ?>
                                        
                                        <button wire:click="deleteClass(<?php echo e($class['id']); ?>)" 
                                            onclick="return confirm('Are you sure you want to delete this class?')"
                                            class="text-red-600 hover:text-red-900">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="p-6 text-center text-gray-500">
                <div class="text-lg font-medium mb-2">No classes found</div>
                <div class="text-sm">No classes have been created yet.</div>
                <button wire:click="showAddForm" 
                    class="mt-4 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Add First Class
                </button>
            </div>
        <?php endif; ?>
    </div>
</div><?php /**PATH /home/bkoq0ic0h8xi/public_html/littleflowerschool.co.in/resources/views/livewire/myclass-comp.blade.php ENDPATH**/ ?>