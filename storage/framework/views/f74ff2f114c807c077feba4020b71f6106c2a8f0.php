<div class="flex-1 p-6 overflow-y-auto max-w-full mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Answer Script Distribution</h1>
        <p class="mt-1 text-sm text-gray-600">Assign teachers to subjects for each exam.</p>
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

    <!-- Class Selection -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8" aria-label="Tabs">
            <?php $__empty_1 = true; $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <button wire:click="selectClass(<?php echo e($class->id); ?>)"
                    class="<?php echo e($selectedClassId == $class->id ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                    <?php echo e($class->name); ?>

                </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-500 py-4">No classes available.</p>
            <?php endif; ?>
        </nav>
    </div>

    <?php if($selectedClassId): ?>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">
                    Teacher Assignments for <?php echo e($classes->find($selectedClassId)->name); ?>

                </h3>
            </div>

            <?php if($subjects->isNotEmpty() && $examNames->isNotEmpty()): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                    Subject
                                </th>
                                <?php $__currentLoopData = $examNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th scope="col"
                                        class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-l border-gray-300">
                                        <?php echo e($examName->name); ?>

                                    </th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        </thead>
                        <?php $__currentLoopData = $subjects->groupBy('display_type'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeName => $subjectsInGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tbody class="bg-white divide-y divide-gray-200" wire:key="group-<?php echo e($typeName); ?>">
                                <tr class="bg-gray-100">
                                    <td colspan="<?php echo e($examNames->count() + 1); ?>" class="px-6 py-2 text-sm font-bold text-gray-600">
                                        <?php echo e($typeName); ?>

                                    </td>
                                </tr>
                                <?php $__currentLoopData = $subjectsInGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classSubject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-gray-50" wire:key="subject-<?php echo e($classSubject->id); ?>">
                                        <td
                                            class="px-6 py-4 text-sm font-medium text-gray-900 sticky left-0 bg-white hover:bg-gray-50 z-10 border-r border-gray-200">
                                            <?php echo e($classSubject->subject->name ?? 'Unknown Subject'); ?>

                                        </td>
                                        <?php $__currentLoopData = $examNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td class="px-4 py-4 text-center border-l border-gray-300"
                                                wire:key="cell-<?php echo e($classSubject->id); ?>-<?php echo e($examName->id); ?>">
                                                <?php
                                                    $key = $classSubject->subject_id . '_' . $examName->id;
                                                    $assignedTeacherId = $distributions[$key] ?? null;
                                                    $assignedTeacher = $assignedTeacherId ? $teachers->find($assignedTeacherId) : null;
                                                ?>

                                                <?php if($assignedTeacher): ?>
                                                    <div class="text-sm font-bold text-green-600 mb-1" title="Assigned: <?php echo e($assignedTeacher->name); ?>">
                                                        <?php echo e($assignedTeacher->name); ?>

                                                    </div>
                                                <?php else: ?>
                                                    <div class="text-sm text-red-600 mb-1">No Teacher</div>
                                                <?php endif; ?>

                                                <select wire:model="distributions.<?php echo e($key); ?>"
                                                    class="w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                                                    <option value="">-- Select Teacher --</option>
                                                    <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($teacher->id); ?>"><?php echo e($teacher->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <div wire:loading wire:target="distributions.<?php echo e($key); ?>" class="text-xs text-blue-500 mt-1">
                                                    Saving...
                                                </div>
                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </table>
                </div>
            <?php else: ?>
                <div class="p-6 text-center text-gray-500">
                    <p>No subjects or exams configured for this class.</p>
                </div>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
            <p class="text-lg font-medium">Please select a class to view and assign teachers.</p>
        </div>
    <?php endif; ?>
</div><?php /**PATH /home/bkoq0ic0h8xi/public_html/littleflowerschool.co.in/resources/views/livewire/answer-script-distribution-comp2.blade.php ENDPATH**/ ?>