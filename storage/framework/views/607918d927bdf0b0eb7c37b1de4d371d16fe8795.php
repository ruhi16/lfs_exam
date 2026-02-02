<div class="flex-1 p-6 overflow-y-auto max-w-full mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Class Exam Subject Configuration</h1>
                <p class="mt-1 text-sm text-gray-600">Configure which subjects are available for each class, exam, and
                    exam type combination</p>
            </div>
            <div class="flex space-x-2">
                <?php if($selectedClassId): ?>
                <?php if($isFinalized): ?>
                <button wire:click="unfinalizeData"
                    onclick="return confirm('Are you sure you want to unfinalize? This will allow changes to be made again.')"
                    class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    🔓 Unfinalize
                </button>
                <?php else: ?>
                <button wire:click="saveAllSelections"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    💾 Save All
                </button>
                <button wire:click="clearAllSelections"
                    onclick="return confirm('Are you sure you want to clear all selections for this class?')"
                    class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    🗑️ Clear All
                </button>
                <button wire:click="finalizeData"
                    onclick="return confirm('Are you sure you want to finalize? This will prevent any further changes.')"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    🔒 Finalize
                </button>
                <?php endif; ?>
                <?php endif; ?>
                <button wire:click="refreshData"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    🔄 Refresh
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

    <!-- Debug Panel -->
    <?php if($debugMode): ?>
    <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
        <h4 class="text-sm font-medium text-yellow-800 mb-2">Debug Panel</h4>
        <div class="text-xs text-yellow-700">
            Selected Class: <?php echo e($selectedClassId ?? 'None'); ?> |
            Subjects: <?php echo e(count($classSubjects)); ?> |
            Subject Types: <?php echo e(count($subjectsByType)); ?> |
            Exam Names: <?php echo e(count($examNames)); ?> |
            Exam Types: <?php echo e(count($examTypes)); ?> |
            Exam Details: <?php echo e(count($examDetails)); ?> |
            Selections: <?php echo e(collect($subjectSelections)->flatten()->filter()->count()); ?>

        </div>
    </div>
    <?php endif; ?>

    <!-- Debug Toggle Button -->
    <div class="mb-4">
        <button wire:click="toggleDebugMode" class="bg-gray-500 text-white px-3 py-1 rounded text-xs">
            <?php echo e($debugMode ? 'Hide Debug' : 'Show Debug'); ?>

        </button>
    </div>

    <!-- Class Selection -->
    <div class="border-b border-gray-200 mb-6">
        <?php if($selectedClassId): ?>
        <div class="mb-3 p-2 bg-blue-50 border-l-4 border-blue-400">
            <span class="text-blue-800 font-medium">
                Selected: <?php echo e($this->classes->where('id', $selectedClassId)->first()->name ?? 'Unknown Class'); ?>

            </span>
            <?php if($isFinalized): ?>
            <span class="ml-4 px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">
                🔒 FINALIZED - Read Only
            </span>
            <?php else: ?>
            <span class="ml-4 px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                ✏️ EDITABLE
            </span>
            <?php endif; ?>
        </div>
        <?php endif; ?>
        <nav class="-mb-px flex space-x-8">
            <?php if($this->classes && count($this->classes) > 0): ?>
            <?php $__currentLoopData = $this->classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
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

    <!-- Subject-Exam Matrix Table -->
    <?php if($selectedClassId && count($subjectsByType) > 0 && count($examNames) > 0): ?>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-200 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-900">Subject-Exam Configuration Matrix</h3>
            <p class="text-sm text-gray-600 mt-1">
                Select which subjects are available for each exam and exam type combination (grouped by subject type)
            </p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <!-- Subject Column Header -->
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                            Subject (by Type)
                        </th>

                        <!-- Exam Name Headers with Sub-columns for Exam Types -->
                        <?php $__currentLoopData = $examNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th scope="col"
                            class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-l border-gray-300">
                            <div class="font-semibold text-gray-900 mb-2"><?php echo e($examName->name); ?></div>
                            <div class="grid gap-1"
                                style="grid-template-columns: repeat(<?php echo e(count($examTypes)); ?>, minmax(0, 1fr));">
                                <?php $__currentLoopData = $examTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="text-xs font-medium text-gray-600 p-1 bg-gray-100 rounded">
                                    <?php echo e($examType->name); ?>

                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $subjectsByType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subjectTypeName => $typeData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <!-- Subject Type Header Row -->
                    <tr class="bg-blue-50">
                        <td colspan="<?php echo e(count($examNames) + 1); ?>"
                            class="px-6 py-3 text-sm font-bold text-blue-900 bg-blue-100 border-b border-blue-200">
                            <div class="flex items-center">
                                <span class="mr-2">📚</span>
                                <?php echo e($subjectTypeName); ?>

                                <span class="ml-2 text-xs text-blue-600">(<?php echo e($typeData['subjects']->count()); ?>

                                    subjects)</span>
                            </div>
                        </td>
                    </tr>

                    <!-- Subjects within this type -->
                    <?php $__currentLoopData = $typeData['subjects']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <!-- Subject Name Column -->
                        <td
                            class="px-6 py-4 text-sm font-medium text-gray-900 sticky left-0 bg-white z-10 border-r border-gray-200">
                            <div class="flex items-center">
                                <span class="w-4 h-4 bg-gray-300 rounded-full mr-3 flex-shrink-0"></span>
                                <div>
                                    <div class="font-semibold"><?php echo e($subject->subject->name ?? 'Unknown Subject'); ?></div>
                                    <div class="text-xs text-gray-500">ID: <?php echo e($subject->subject->id ?? 'N/A'); ?></div>
                                </div>
                            </div>
                        </td>

                        <!-- Exam Name Columns with Checkboxes for Each Exam Type -->
                        <?php $__currentLoopData = $examNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td class="px-4 py-4 text-center border-l border-gray-300">
                            <div class="grid gap-2"
                                style="grid-template-columns: repeat(<?php echo e(count($examTypes)); ?>, minmax(0, 1fr));">
                                <?php $__currentLoopData = $examTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $examDetailKey = $examName->id . '_' . $examType->id;
                                $hasExamDetail = isset($examDetails[$examDetailKey]);
                                $isSelected = $subjectSelections[$subject->subject_id][$examName->id][$examType->id] ??
                                false;
                                ?>

                                <div class="flex flex-col items-center">
                                    <?php if($hasExamDetail): ?>
                                    <input type="checkbox"
                                        wire:click="toggleSubjectSelection(<?php echo e($subject->subject_id); ?>, <?php echo e($examName->id); ?>, <?php echo e($examType->id); ?>)"
                                        <?php echo e($isSelected ? 'checked' : ''); ?> <?php echo e($isFinalized ? 'disabled' : ''); ?>

                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded <?php echo e($isFinalized ? 'opacity-50 cursor-not-allowed' : 'cursor-pointer'); ?>">
                                    <?php if($isSelected): ?>
                                    <div class="text-xs text-green-600 mt-1">✓</div>
                                    <?php endif; ?>
                                    <?php else: ?>
                                    <div class="h-4 w-4 bg-gray-200 rounded border-2 border-gray-300"
                                        title="No exam detail configured"></div>
                                    <div class="text-xs text-gray-400 mt-1">N/A</div>
                                    <?php endif; ?>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                        </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <!-- Summary Footer -->
        <div class="p-4 border-t border-gray-200 bg-gray-50">
            <div class="flex justify-between items-center text-sm text-gray-600">
                <div>
                    Total Subjects: <?php echo e(count($classSubjects)); ?> |
                    Subject Types: <?php echo e(count($subjectsByType)); ?> |
                    Total Exam Combinations: <?php echo e(count($examNames) * count($examTypes)); ?> |
                    Available Combinations: <?php echo e(count($examDetails)); ?>

                    <?php if($isFinalized): ?>
                    <span class="ml-2 text-red-600 font-medium">🔒 FINALIZED</span>
                    <?php endif; ?>
                </div>
                <div>
                    Selected: <?php echo e(collect($subjectSelections)->flatten()->filter()->count()); ?> combinations
                </div>
            </div>
        </div>
    </div>

    <!-- Legend -->
    <div class="mt-4 bg-white rounded-lg shadow p-4">
        <h4 class="text-sm font-medium text-gray-900 mb-2">Legend</h4>
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-xs text-gray-600">
            <div class="flex items-center">
                <input type="checkbox" checked disabled class="h-3 w-3 text-indigo-600 mr-2">
                <span>Subject is available for this exam type</span>
            </div>
            <div class="flex items-center">
                <input type="checkbox" disabled class="h-3 w-3 text-gray-400 mr-2">
                <span>Subject is not available for this exam type</span>
            </div>
            <div class="flex items-center">
                <div class="h-3 w-3 bg-gray-200 rounded border-2 border-gray-300 mr-2"></div>
                <span>Exam detail not configured (N/A)</span>
            </div>
            <div class="flex items-center">
                <span class="text-red-600 mr-2">🔒</span>
                <span>Data is finalized (read-only)</span>
            </div>
        </div>
    </div>
    <?php elseif($selectedClassId && count($subjectsByType) === 0): ?>
    <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
        <div class="text-lg font-medium mb-2">No subjects found</div>
        <div class="text-sm">This class has no subjects configured. Please add subjects to this class first.</div>
    </div>
    <?php elseif($selectedClassId && count($examNames) === 0): ?>
    <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
        <div class="text-lg font-medium mb-2">No exams found</div>
        <div class="text-sm">No exam names are configured. Please add exam names first.</div>
    </div>
    <?php else: ?>
    <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
        <div class="text-lg font-medium mb-2">Select a class to configure exam subjects</div>
        <div class="text-sm">Choose a class from the tabs above to get started.</div>
    </div>
    <?php endif; ?>
</div><?php /**PATH /home/bkoq0ic0h8xi/public_html/littleflowerschool.co.in/resources/views/livewire/class-exam-subject-comp.blade.php ENDPATH**/ ?>