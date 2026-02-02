<div class="p-6">
    <!-- Debug Information -->
    <?php if(app()->environment('local')): ?>
    <div class="mb-4 p-4 bg-yellow-100 border border-yellow-300 rounded">
        <h3 class="font-bold text-yellow-800">Debug Information</h3>
        <p>Exam Detail ID: <?php echo e($exam_detail_id ?? 'N/A'); ?></p>
        <p>Myclass Section ID: <?php echo e($myclass_section_id ?? 'N/A'); ?></p>
        <p>Exam Type ID: <?php echo e($examDetail->exam_type_id ?? 'N/A'); ?></p>
        <p>Grades Count: <?php echo e($grades ? (is_array($grades) ? count($grades) : $grades->count()) : 0); ?></p>
        <p>Students Count: <?php echo e(count($students ?? [])); ?></p>
        <p>Formative Subjects Count: <?php echo e($formativeSubjects ? $formativeSubjects->count() : 0); ?></p>

        <?php
        // Count saved marks entries
        $savedMarksCount = 0;
        if (isset($marksData) && is_array($marksData)) {
        foreach ($marksData as $studentData) {
        foreach ($studentData as $subjectData) {
        if (!empty($subjectData['grade_id'])) {
        $savedMarksCount++;
        }
        }
        }
        }
        ?>
        <p>Saved Marks Entries: <?php echo e($savedMarksCount); ?></p>

        <?php if($formativeSubjects): ?>
        <p>Formative Subjects IDs: <?php echo e($formativeSubjects->pluck('id')->implode(', ')); ?></p>
        <?php $__currentLoopData = $formativeSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <p>Subject ID <?php echo e($subject->id); ?>: <?php echo e($subject->subject->name ?? 'N/A'); ?> (Type: <?php echo e($subject->subject->subjectType->name ?? 'N/A'); ?>)</p>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
        <?php if($grades && (is_array($grades) ? count($grades) > 0 : $grades->count() > 0)): ?>
        <?php
        $firstGrade = is_array($grades) ? $grades[0] : $grades->first();
        ?>
        <p>First Grade: <?php echo e($firstGrade->name ?? 'N/A'); ?> (ID: <?php echo e($firstGrade->id ?? 'N/A'); ?>)</p>
        <?php endif; ?>
        <div class="flex space-x-2 mt-2">
            <button wire:click="loadData" class="px-3 py-1 bg-blue-500 text-white rounded text-sm">Refresh All
                Data</button>
            <button wire:click="refreshMarksData" class="px-3 py-1 bg-green-500 text-white rounded text-sm">Refresh
                Marks Data Only</button>
        </div>
    </div>
    <?php endif; ?>

    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Formative Exam Marks Entry</h1>
                <p class="text-gray-600 mt-1">
                    <?php if($examDetail && $myclassSection): ?>
                    <?php echo e($examDetail->examName->name ?? 'N/A'); ?> -
                    <?php echo e($examDetail->examType->name ?? 'N/A'); ?> -
                    <?php echo e($myclassSection->myclass->name ?? 'N/A'); ?> -
                    <?php echo e($myclassSection->section->name ?? 'N/A'); ?>

                    <?php endif; ?>
                </p>
            </div>
            <div class="flex space-x-2">
                <!-- Finalize/Unfinalize Button at the top -->
                <?php if($isFinalized): ?>
                <button wire:click="unfinalizeMarks"
                    onclick="return confirm('Are you sure you want to unfinalize these marks?')"
                    class="px-4 py-2 bg-orange-500 hover:bg-orange-600 text-white rounded-lg transition-colors">
                    <i class="fas fa-unlock mr-2"></i>Unfinalize Marks
                </button>
                <?php else: ?>
                <button wire:click="finalizeMarks"
                    onclick="return confirm('Are you sure you want to finalize these marks? This action cannot be undone without admin privileges.')"
                    class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-lock mr-2"></i>Finalize Marks
                </button>
                <?php endif; ?>

                <button wire:click="loadData"
                    class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
            </div>
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

    <!-- Finalization Status -->
    <div class="mb-6">
        <?php if($isFinalized): ?>
        <div class="bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center">
                <i class="fas fa-lock text-red-500 mr-2"></i>
                <div>
                    <h3 class="text-lg font-medium text-red-800">Marks Finalized</h3>
                    <p class="text-sm text-red-700">This marks entry has been finalized and cannot be modified.</p>
                </div>
            </div>
        </div>
        <?php else: ?>
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center">
                <i class="fas fa-edit text-blue-500 mr-2"></i>
                <div>
                    <h3 class="text-lg font-medium text-blue-800">Marks Entry in Progress</h3>
                    <p class="text-sm text-blue-700">Enter grades for each student and formative subject, then save and
                        finalize when complete.</p>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Marks Entry Table -->
    <?php if($students && $formativeSubjects && $formativeSubjects->count() > 0): ?>
    <?php if($grades && (is_array($grades) ? count($grades) > 0 : $grades->count() > 0)): ?>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Student Marks Entry</h3>
            <p class="text-sm text-gray-600 mt-1">Select grades for each student and formative subject</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50">
                            Student
                        </th>
                        <?php $__currentLoopData = $formativeSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            <?php echo e($subject->subject->name ?? 'N/A'); ?>

                        </th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap sticky left-0 bg-white">
                            <div class="flex items-center">
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        <?php echo e($student->studentdb->name ?? 'N/A'); ?>

                                    </div>
                                    <div class="text-sm text-gray-500">
                                        Roll: <?php echo e($student->roll_no ?? 'N/A'); ?>

                                    </div>
                                </div>
                            </div>
                        </td>
                        <?php $__currentLoopData = $formativeSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($isFinalized): ?>
                            <!-- Display finalized marks as numeric values -->
                            <?php
                            $marksEntry = $marksData[$student->id][$subject->id] ?? null;
                            $displayValue = 'N/A';
                            if ($marksEntry) {
                            if ($marksEntry['grade_id'] === 'absent') {
                            $displayValue = 'ABSENT';
                            } elseif ($marksEntry['grade_id'] && $marksEntry['marks'] !== null) {
                            // Show the actual marks value
                            $displayValue = $marksEntry['marks'];
                            }
                            }
                            ?>
                            <span
                                class="text-sm font-medium <?php echo e($displayValue === 'N/A' ? 'text-gray-400' : ($displayValue === 'ABSENT' ? 'text-red-600' : 'text-gray-900')); ?> <?php echo e($displayValue !== 'N/A' ? 'bg-green-100 px-2 py-1 rounded' : ''); ?>">
                                <?php echo e($displayValue); ?>

                            </span>
                            <?php else: ?>
                            <!-- Editable grade selection with Absent as last option -->
                            <?php
                            // Get current value for this student and subject
                            $studentSubjectData = $marksData[$student->id][$subject->id] ?? [];
                            $currentGradeId = $studentSubjectData['grade_id'] ?? '';
                            $currentMarks = $studentSubjectData['marks'] ?? 'N/A';
                            $hasSavedData = !empty($currentGradeId);
                            ?>
                            <div class="<?php echo e($hasSavedData ? 'border-2 border-green-500 rounded p-1 relative' : ''); ?>">
                                <?php if($hasSavedData): ?>
                                <div
                                    class="absolute -top-2 -right-2 bg-green-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs">
                                    ✓
                                </div>
                                <?php endif; ?>
                                <select wire:model="marksData.<?php echo e($student->id); ?>.<?php echo e($subject->id); ?>.grade_id"
                                    class="w-full px-3 py-1 border border-gray-300 rounded-md text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                    <option value="">Select Grade</option>
                                    <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($grade->id); ?>" <?php echo e((string)$currentGradeId===(string)$grade->id ?
                                        'selected' : ''); ?>><?php echo e($grade->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <option value="absent" <?php echo e($currentGradeId==='absent' ? 'selected' : ''); ?>>Absent
                                    </option>
                                </select>
                                <!-- Debug: Show current value and marks -->
                                <?php if(app()->environment('local')): ?>
                                <div class="text-xs text-gray-500 mt-1 flex justify-between items-center">
                                    <div>
                                        Grade ID: <span class="font-mono">'<?php echo e($currentGradeId); ?>'</span>,
                                        Marks: <span class="font-mono">'<?php echo e($currentMarks); ?>'</span>
                                    </div>
                                    <?php if($hasSavedData): ?>
                                    <span
                                        class="bg-green-500 text-white px-2 py-0.5 rounded text-xs font-bold flex items-center">
                                        <i class="fas fa-check mr-1"></i> SAVED
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if(!$isFinalized): ?>
                            <?php
                            $isComplete = true;
                            foreach($formativeSubjects as $subject) {
                            if (!isset($marksData[$student->id][$subject->id]) ||
                            empty($marksData[$student->id][$subject->id]['grade_id'])) {
                            $isComplete = false;
                            break;
                            }
                            }
                            ?>
                            <div class="flex space-x-2">
                                <button wire:click="saveStudentMarks(<?php echo e($student->id); ?>)" <?php if(!$isComplete): ?> disabled
                                    <?php endif; ?>
                                    class="px-3 py-1 text-sm rounded <?php if($isComplete): ?> bg-blue-600 hover:bg-blue-700 text-white <?php else: ?> bg-gray-300 text-gray-500 cursor-not-allowed <?php endif; ?>">
                                    Save
                                </button>
                                <?php if(app()->environment('local')): ?>
                                <button wire:click="refreshMarksData"
                                    class="px-3 py-1 text-sm rounded bg-gray-500 hover:bg-gray-600 text-white">
                                    <i class="fas fa-sync"></i>
                                </button>
                                <?php endif; ?>
                            </div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <!-- Action Buttons -->
        <?php if(!$isFinalized): ?>
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            <div class="flex justify-end space-x-3">
                <button wire:click="saveMarks"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors">
                    <i class="fas fa-save mr-2"></i>Save All Marks
                </button>
                <!-- Refresh button for easier testing -->
                <?php if(app()->environment('local')): ?>
                <button wire:click="refreshMarksData"
                    class="px-4 py-2 bg-gray-500 hover:bg-gray-600 text-white rounded-lg transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh Data
                </button>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
    <?php else: ?>
    <div class="bg-red-50 border border-red-200 rounded-lg p-6">
        <div class="flex">
            <div class="flex-shrink-0">
                <i class="fas fa-exclamation-circle text-red-400 text-xl"></i>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-red-800">No Grades Available</h3>
                <div class="mt-2 text-sm text-red-700">
                    <p>No grades found for exam type <?php echo e($examDetail->exam_type_id ?? 'N/A'); ?>.</p>
                    <p class="mt-2">Please ensure that grades are configured for this exam type in the system.</p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
    <?php else: ?>
    <div class="text-center py-12">
        <div class="text-gray-400 mb-4">
            <i class="fas fa-table text-6xl"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No Formative Subjects Found</h3>
        <p class="text-gray-600 mb-4">No formative subjects are configured for this exam.</p>
        <p class="text-gray-500 text-sm">Please ensure that formative subjects are properly set up with the correct
            subject types.</p>

        <!-- Debug Information when no data -->
        <?php if(app()->environment('local')): ?>
        <div class="mt-4 p-4 bg-red-100 border border-red-300 rounded">
            <h4 class="font-bold text-red-800">Debug Details:</h4>
            <ul class="text-left list-disc list-inside">
                <li>Students: <?php echo e($students ? count($students) : 'null'); ?></li>
                <li>Formative Subjects: <?php echo e($formativeSubjects ? $formativeSubjects->count() : 'null'); ?></li>
                <li>Grades: <?php echo e($grades ? (is_array($grades) ? count($grades) : $grades->count()) : 'null'); ?></li>
            </ul>
            <button wire:click="loadData" class="mt-2 px-3 py-1 bg-blue-500 text-white rounded text-sm">Refresh
                Data</button>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- Grades Legend -->
    <?php if($grades && (is_array($grades) ? count($grades) > 0 : $grades->count() > 0)): ?>
    <div class="mt-6 bg-white rounded-lg shadow-sm border border-gray-200 p-4">
        <h4 class="text-md font-semibold text-gray-900 mb-3">Grades Legend</h4>
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2">
            <?php $__currentLoopData = $grades; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grade): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="flex items-center px-3 py-2 bg-gray-50 rounded-md">
                <span
                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800 mr-2">
                    <?php echo e($grade->name); ?>

                </span>
                <span class="text-xs text-gray-600">
                    <?php echo e($grade->min_mark_percentage); ?>% - <?php echo e($grade->max_mark_percentage); ?>%
                </span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>
</div><?php /**PATH /home/bkoq0ic0h8xi/public_html/littleflowerschool.co.in/resources/views/livewire/marks-entry-formative-comp.blade.php ENDPATH**/ ?>