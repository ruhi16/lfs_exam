<div class="flex-1 p-6 overflow-y-auto max-w-full mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Marks Entry</h1>
                <?php if($examDetail && $subject && $section): ?>
                <div class="mt-2 space-y-1">
                    <p class="text-sm text-gray-600">
                        <span class="font-medium">Class:</span>
                        <span class="inline-block px-2 py-0.5 rounded bg-indigo-100 text-indigo-800 text-semibold">
                            <?php echo e($examDetail->myclass->name ?? 'Unknown'); ?>

                        </span>|
                        <span class="font-medium">Section:</span>
                        <span class="inline-block px-2 py-0.5 rounded bg-red-100 text-red-800 text-semibold">
                            <?php echo e($section->section->name ?? 'Unknown'); ?>

                        </span>|
                    </p>
                    <p class="text-sm text-gray-600">
                        <span class="font-medium">Exam:</span>
                        <span class="inline block px-2 py-0.5 rounded bg-yellow-100 text-yellow-800 text-semibold">
                            <?php echo e($examDetail->examName->name ?? 'Unknown'); ?>

                        </span>|
                        <span class="font-medium">Type:</span>
                        <span class="inline-block px-2 py-0.5 rounded bg-green-100 text-green-800 text-semibold">
                            <?php echo e($examDetail->examType->name ?? 'Unknown'); ?>

                        </span>|
                        <span class="font-medium">Part:</span>
                        <span class="inline-block px-2 py-0.5 rounded bg-blue-100 text-blue-800 text-semibold">
                            <?php echo e($examDetail->examPart->name ?? 'Unknown'); ?>

                        </span>
                    </p>
                    <p class="text-sm text-gray-600">
                        <span class="font-medium">Subject:</span>
                        <span class="inline-block px-2 py-0.5 rounded bg-yellow-100 text-yellow-800 text-semibold">
                            <?php echo e($subject->name ?? 'Unknown'); ?>

                        </span>|
                        <span class="font-medium">Teacher:</span>
                        <span class="inline-block px-2 py-0.5 rounded bg-green-100 text-green-800 text-semibold">
                            <?php if(isset($ansscrDist)): ?>
                            <?php echo e($ansscrDist->teacher ? $ansscrDist->teacher->name ?? 'No Name': 'No Teacher Assigned'); ?>

                            <?php else: ?>
                            <?php echo e('Answer Script is not alloted to any instructor, al all.'); ?>

                            <?php endif; ?>

                        </span>
                    </p>
                </div>
                <?php endif; ?>
            </div>
            <button wire:click="goBack"
                class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium">
                ← Back to Selection
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

    <!-- Finalization Status Alert -->
    <?php if($examClassSubject && $examClassSubject->is_finalized): ?>
    <div class="mb-4 bg-yellow-50 border border-yellow-200 text-yellow-800 px-4 py-3 rounded-md">
        <div class="flex items-center">
            <i class="fas fa-lock text-yellow-600 mr-2"></i>
            <strong>Notice:</strong> These marks have been finalized and cannot be edited. Contact an administrator to
            unfinalize if changes are needed.
        </div>
    </div>
    <?php endif; ?>

    <!-- Marks Entry Form -->
    <?php if($students && count($students) > 0): ?>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="p-4 border-b border-gray-200 bg-gray-50">
            <div class="flex justify-between items-center">
                <h3 class="text-lg font-semibold text-blue-600">Student Marks Entry</h3>
                <div class="text-sm text-gray-900">
                    Total Students: <?php echo e(count($students)); ?>

                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Sl-SCR-SDB
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Roll No.
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Student Name
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Current Marks
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Previous Marks History
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <?php echo e($loop->iteration); ?>-<?php echo e($student->id); ?>-<?php echo e($student->studentdb->id ?? 'N/A'); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            <?php echo e($student->roll_no ?? 'N/A'); ?>

                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <div class="font-medium">
                                <?php echo e($student->studentdb->name ?? $student->name ?? 'Unknown Student'); ?>

                            </div>
                            <div class="text-xs text-gray-500">ID: <?php echo e($student->id); ?></div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                            <div class="flex flex-col items-center space-y-2">
                                <div class="relative">
                                    <?php if(isset($absentStudents[$student->id]) && $absentStudents[$student->id]): ?>
                                    <!-- Absent State -->
                                    <div
                                        class="w-20 px-3 py-2 border-2 border-red-500 rounded-md bg-red-50 text-center text-red-700 font-bold text-sm">
                                        AB
                                    </div>
                                    <input type="number"
                                        class="w-20 px-3 py-2 border border-gray-300 rounded-md shadow-sm text-center hidden"
                                        disabled>
                                    <?php else: ?>
                                    <!-- Normal State -->
                                    <input type="number" wire:model.lazy="marks.<?php echo e($student->id); ?>"
                                        class="w-20 px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-center
                                                        <?php if($examClassSubject && $examClassSubject->is_finalized): ?> bg-gray-100 cursor-not-allowed <?php endif; ?>" placeholder="0" min="0"
                                        max="100" step="0.01" <?php if($examClassSubject && $examClassSubject->is_finalized): ?>
                                    readonly <?php endif; ?>>
                                    <?php endif; ?>

                                    <!-- Embedded Absent Checkbox -->
                                    <div class="absolute -top-1 -right-1">
                                        <input type="checkbox" wire:model="absentStudents.<?php echo e($student->id); ?>"
                                            class="w-4 h-4 text-red-600 bg-white border-2 border-red-300 rounded focus:ring-red-500 focus:ring-2
                                                        <?php if($examClassSubject && $examClassSubject->is_finalized): ?> cursor-not-allowed <?php endif; ?>" title="Mark as Absent" <?php if($examClassSubject
                                            && $examClassSubject->is_finalized): ?> disabled <?php endif; ?>>
                                    </div>
                                </div>

                                <div class="text-xs text-green-600" wire:loading wire:target="marks.<?php echo e($student->id); ?>">
                                    Saving...
                                </div>
                                <div class="text-xs text-orange-600" wire:loading
                                    wire:target="absentStudents.<?php echo e($student->id); ?>">
                                    Updating...
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <?php if(isset($previousMarks[$student->id]) && count($previousMarks[$student->id]) > 0): ?>
                            <div class="space-y-1 max-h-32 overflow-y-auto">
                                <?php $__currentLoopData = $previousMarks[$student->id]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prevMark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="text-xs bg-gray-100 rounded px-2 py-1">
                                    <div class="font-medium text-gray-800">
                                        <?php echo e($prevMark['exam_name']); ?> - <?php echo e($prevMark['exam_type']); ?>

                                    </div>
                                    <div class="text-gray-600">
                                        <?php echo e($prevMark['exam_part']); ?>:
                                        <?php if($prevMark['marks'] == -99): ?>
                                        <span class="font-semibold text-red-600 bg-red-100 px-1 rounded">AB</span>
                                        <?php else: ?>
                                        <span
                                            class="font-semibold <?php echo e($prevMark['marks'] ? 'text-blue-600' : 'text-gray-400'); ?>">
                                            <?php echo e($prevMark['marks'] ?? 'N/A'); ?>

                                        </span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <?php else: ?>
                            <div class="text-xs text-gray-400">No previous marks</div>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <!-- Save Button -->
        <div class="p-4 border-t border-gray-200 bg-gray-50">
            <div class="flex justify-between items-center">
                <div class="flex space-x-2">
                    <button wire:click="goBack"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md text-sm font-medium">
                        Cancel
                    </button>
                    <button wire:click="saveMarks"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md text-sm font-medium"
                        <?php if($examClassSubject && $examClassSubject->is_finalized): ?> disabled <?php endif; ?>>
                        Save Marks
                    </button>
                </div>

                <!-- Finalization Controls -->
                <div class="flex space-x-2">
                    <?php if($examClassSubject): ?>
                    <?php if($examClassSubject->is_finalized): ?>
                    <div class="inline-flex items-center px-3 py-2 bg-green-100 border border-green-300 rounded-md">
                        <i class="fas fa-lock text-green-600 mr-2"></i>
                        <span class="text-green-700 text-sm font-medium">Marks Finalized</span>
                    </div>
                    <?php else: ?>
                    <button wire:click="finalizeMarks"
                        class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium"
                        onclick="return confirm('Are you sure you want to finalize these marks? This will prevent further edits.')">
                        <i class="fas fa-lock mr-2"></i>Finalize Marks
                    </button>
                    <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php else: ?>
    <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
        <div class="text-lg font-medium mb-2">No students found</div>
        <div class="text-sm">No students are enrolled in this class and section.</div>
        <button wire:click="goBack"
            class="mt-4 bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-md text-sm font-medium">
            ← Back to Selection
        </button>
    </div>
    <?php endif; ?>
</div><?php /**PATH /home/bkoq0ic0h8xi/public_html/littleflowerschool.co.in/resources/views/livewire/marks-entry-detail-comp.blade.php ENDPATH**/ ?>