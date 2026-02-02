<div class="flex-1 p-6 overflow-y-auto max-w-full mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Class Subjects Management</h1>
                <p class="mt-1 text-sm text-gray-600">Manage subjects assigned to each class with ordering and
                    configuration</p>
            </div>
            <div class="flex space-x-2">
                <button wire:click="refreshData"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Refresh Data
                </button>
                <?php if($selectedClassId): ?>
                    <button wire:click="showAddForm"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Add Subject
                    </button>
                <?php endif; ?>
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

    <!-- Class Tabs -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8">
            <?php if($classes && count($classes) > 0): ?>
                <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button wire:click="selectClass(<?php echo e($class->id); ?>)"
                        class="<?php if($selectedClassId == $class->id): ?> border-indigo-500 text-indigo-600 <?php else: ?> border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 <?php endif; ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        <?php echo e($class->name); ?>

                    </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="text-gray-500 py-4">No classes available</div>
            <?php endif; ?>
        </nav>
    </div>

    <!-- Add/Edit Form -->
    <?php if($showAddForm): ?>
        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium text-gray-900">
                    <?php echo e($editingId ? 'Edit Class Subject' : 'Add New Class Subject'); ?>

                </h3>
                <button wire:click="hideAddForm" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <form wire:submit.prevent="saveClassSubject">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Subject Selection -->
                    <div>
                        <label for="selectedSubjectId" class="block text-sm font-medium text-gray-700 mb-2">
                            Subject <span class="text-red-500">*</span>
                        </label>
                        <select wire:model="selectedSubjectId" id="selectedSubjectId"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                            <option value="">Select a subject</option>
                            <?php if($editingId): ?>
                                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($subject->id); ?>"><?php echo e($subject->name); ?> (<?php echo e($subject->code); ?>)</option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php else: ?>
                                <?php $__currentLoopData = $availableSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($subject['id']); ?>"><?php echo e($subject['name']); ?> (<?php echo e($subject['code'] ?? 'N/A'); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </select>
                        <?php $__errorArgs = ['selectedSubjectId'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <!-- Class Subject Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Class Subject Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model="name" id="name"
                            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="e.g., Mathematics - Grade 10">
                        <?php $__errorArgs = ['name'];
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
                            placeholder="Brief description of the subject for this class"></textarea>
                        <?php $__errorArgs = ['description'];
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

                    <!-- Is Optional -->
                    <div class="flex items-center">
                        <input type="checkbox" wire:model="isOptional" id="isOptional"
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="isOptional" class="ml-2 block text-sm text-gray-700">
                            Optional Subject
                        </label>
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

    <!-- Class Subjects Table -->
    <?php if($selectedClassId): ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    Subjects for
                    <span class="text-indigo-600 font-semibold">
                        <?php echo e($classes->firstWhere('id', $selectedClassId)->name ?? 'Selected Class'); ?>

                    </span>
                </h3>
                <p class="text-sm text-gray-600 mt-1">
                    <?php
                        $totalSubjects = count($classSubjects['summative']) + count($classSubjects['formative']) + count($classSubjects['others']);
                    ?>
                    Total Subjects: <?php echo e($totalSubjects); ?> |
                    Summative: <?php echo e(count($classSubjects['summative'])); ?> |
                    Formative: <?php echo e(count($classSubjects['formative'])); ?> |
                    Others: <?php echo e(count($classSubjects['others'])); ?> |
                    Available to Add: <?php echo e(count($availableSubjects)); ?>

                </p>
            </div>

            <?php if($totalSubjects > 0): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Order
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Subject
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Type
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Class Subject Name
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Description
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Created By
                                </th>
                                <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <!-- Summative Subjects Section -->
                            <?php if(count($classSubjects['summative']) > 0): ?>
                                <tr class="bg-blue-50">
                                    <td colspan="8" class="px-4 py-2 text-sm font-semibold text-blue-800 border-b border-blue-200">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            SUMMATIVE SUBJECTS (<?php echo e(count($classSubjects['summative'])); ?>)
                                        </div>
                                    </td>
                                </tr>
                                <?php $__currentLoopData = $classSubjects['summative']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classSubject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $__env->make('livewire.partials.class-subject-row', ['classSubject' => $classSubject, 'typeColor' => 'blue'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                            <!-- Formative Subjects Section -->
                            <?php if(count($classSubjects['formative']) > 0): ?>
                                <tr class="bg-green-50">
                                    <td colspan="8"
                                        class="px-4 py-2 text-sm font-semibold text-green-800 border-b border-green-200">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            FORMATIVE SUBJECTS (<?php echo e(count($classSubjects['formative'])); ?>)
                                        </div>
                                    </td>
                                </tr>
                                <?php $__currentLoopData = $classSubjects['formative']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classSubject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $__env->make('livewire.partials.class-subject-row', ['classSubject' => $classSubject, 'typeColor' => 'green'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>

                            <!-- Other Subjects Section -->
                            <?php if(count($classSubjects['others']) > 0): ?>
                                <tr class="bg-gray-50">
                                    <td colspan="8" class="px-4 py-2 text-sm font-semibold text-gray-800 border-b border-gray-200">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd"
                                                    d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                            OTHER SUBJECTS (<?php echo e(count($classSubjects['others'])); ?>)
                                        </div>
                                    </td>
                                </tr>
                                <?php $__currentLoopData = $classSubjects['others']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classSubject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php echo $__env->make('livewire.partials.class-subject-row', ['classSubject' => $classSubject, 'typeColor' => 'gray'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="p-6 text-center text-gray-500">
                    <div class="text-lg font-medium mb-2">No subjects assigned</div>
                    <div class="text-sm">No subjects have been assigned to this class yet.</div>
                    <?php if(count($availableSubjects) > 0): ?>
                        <button wire:click="showAddForm"
                            class="mt-4 bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                            Add First Subject
                        </button>
                    <?php else: ?>
                        <div class="text-sm text-red-500 mt-2">No subjects available to add.</div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
            <div class="text-lg font-medium mb-2">Select a class to manage subjects</div>
            <div class="text-sm">Choose a class from the tabs above to view and manage its subjects.</div>
        </div>
    <?php endif; ?>
</div><?php /**PATH /home/bkoq0ic0h8xi/public_html/littleflowerschool.co.in/resources/views/livewire/myclass-subject-comp.blade.php ENDPATH**/ ?>