<div class="p-6">
    <div class="mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">Teacher-wise Answer Script Allotments</h1>
        <p class="mt-1 text-sm text-gray-600">Arranged by Exam, then Class-Section with allotted subjects</p>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <?php
        // Group distributions by class and section for better organization
        $groupedDistributions = $distributions->groupBy(function($dist) {
        $class = optional(optional($dist->myclassSection)->myclass)->name ?? 'N/A';
        $section = optional(optional($dist->myclassSection)->section)->name ?? 'N/A';
        return $class . ' - ' . $section;
        })->sortKeys();
        ?>

        <?php $__currentLoopData = $groupedDistributions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classSection => $classSectionDistributions): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="border-b border-gray-200 last:border-b-0">
            <div class="bg-gray-100 px-6 py-3 font-semibold text-gray-800">
                <?php echo e($classSection); ?>

            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider w-64 sticky left-0 bg-gray-50 z-10">
                                Teacher
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Exam Name
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Exam Type
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Subject
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Exam Mode
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Marks Progress
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php
                        // Sort by exam name ID, exam type name, and subject name
                        $sortedDistributions = $classSectionDistributions->sortBy([
                        ['examDetail.examName.id', 'asc'],
                        ['examDetail.examType.name', 'asc'],
                        ['examClassSubject.subject.name', 'asc']
                        ]);

                        // Group by exam name ID for alternating background colors
                        $groupedByExam = $sortedDistributions->groupBy('examDetail.exam_name_id');
                        $examColors = [
                        'bg-white', 'bg-blue-50', 'bg-green-50', 'bg-yellow-50',
                        'bg-purple-50', 'bg-pink-50', 'bg-indigo-50'
                        ];
                        $colorIndex = 0;
                        ?>

                        <?php $__currentLoopData = $groupedByExam; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examId => $examGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $currentColor = $examColors[$colorIndex % count($examColors)];
                        $colorIndex++;
                        ?>

                        <?php $__currentLoopData = $examGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $distribution): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50 align-top <?php echo e($currentColor); ?>">
                            <td
                                class="px-6 py-4 text-sm font-medium text-gray-900 sticky left-0 <?php echo e($currentColor); ?> hover:bg-gray-50 z-10 border-r border-gray-200">
                                <div class="font-semibold"><?php echo e($distribution->teacher ? $distribution->teacher->name :
                                    'N/A'); ?></div>
                            </td>

                            <td class="px-6 py-4 text-sm font-medium text-gray-900 border-r border-gray-200">
                                <div class="font-semibold"><?php echo e($distribution->examDetail &&
                                    $distribution->examDetail->examName ? $distribution->examDetail->examName->name :
                                    'N/A'); ?></div>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 border-r border-gray-200">
                                <div class="font-semibold"><?php echo e($distribution->examDetail &&
                                    $distribution->examDetail->examType ? $distribution->examDetail->examType->name :
                                    'N/A'); ?></div>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 border-r border-gray-200">
                                <div class="font-semibold"><?php echo e($distribution->examClassSubject &&
                                    $distribution->examClassSubject->subject ?
                                    $distribution->examClassSubject->subject->name : 'N/A'); ?></div>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 border-r border-gray-200">
                                <div class="font-semibold"><?php echo e($distribution->examDetail &&
                                    $distribution->examDetail->examMode ? $distribution->examDetail->examMode->name :
                                    'N/A'); ?></div>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900 border-r border-gray-200">
                                <?php if($distribution->examClassSubject && $distribution->myclassSection): ?>
                                <?php
                                $examClassSubjectId = $distribution->examClassSubject->id;
                                $progress = isset($marksProgress[$examClassSubjectId]) ?
                                $marksProgress[$examClassSubjectId] : null;
                                ?>

                                <?php if($progress): ?>
                                <div class="flex flex-col items-start">
                                    <div class="w-full">
                                        <div class="flex justify-between mb-1">
                                            <span class="text-xs font-medium text-gray-700">
                                                <?php echo e($progress['entered']); ?>/<?php echo e($progress['total']); ?> (<?php echo e($progress['percentage']); ?>%)
                                            </span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-blue-600 h-2 rounded-full"
                                                style="width: <?php echo e($progress['percentage']); ?>%"></div>
                                        </div>
                                    </div>

                                    <?php if($distribution->examClassSubject->is_finalized): ?>
                                    <span
                                        class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        Finalized
                                    </span>
                                    <?php elseif($progress['percentage'] == 100): ?>
                                    <span
                                        class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        Completed
                                    </span>
                                    <?php else: ?>
                                    <span
                                        class="ml-0 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        In Progress
                                    </span>
                                    <?php endif; ?>
                                </div>
                                <?php else: ?>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    N/A
                                </span>
                                <?php endif; ?>
                                <?php else: ?>
                                <span
                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    N/A
                                </span>
                                <?php endif; ?>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-gray-900">
                                <?php if($distribution->examClassSubject && $distribution->myclassSection): ?>
                                <div class="flex items-center space-x-2">
                                    <a class="text-indigo-600 hover:text-indigo-900"
                                        href="<?php echo e(route('marks-entry.detail', [
                                                            'examDetailId' => $distribution->exam_detail_id,
                                                            'subjectId' => optional($distribution->examClassSubject)->subject_id,
                                                            'sectionId' => $distribution->myclassSection->section_id])); ?>">
                                        View
                                    </a>

                                    <?php if($distribution->examClassSubject): ?>
                                    <?php if($distribution->examClassSubject->is_finalized): ?>
                                    <!-- Unfinalize Button -->
                                    <button wire:click="unfinalizeMarks(<?php echo e($distribution->examClassSubject->id); ?>)"
                                        class="inline-flex items-center px-2 py-1 bg-orange-500 hover:bg-orange-600 text-white text-xs rounded"
                                        onclick="return confirm('Are you sure you want to unfinalize these marks? This will allow editing again.')">
                                        <i class="fas fa-unlock mr-1"></i>Unfinalize
                                    </button>
                                    <?php else: ?>
                                    <!-- Finalize Button -->
                                    <button wire:click="finalizeMarks(<?php echo e($distribution->examClassSubject->id); ?>)"
                                        class="inline-flex items-center px-2 py-1 bg-green-500 hover:bg-green-600 text-white text-xs rounded"
                                        onclick="return confirm('Are you sure you want to finalize these marks? This will prevent further editing.')">
                                        <i class="fas fa-lock mr-1"></i>Finalize
                                    </button>
                                    <?php endif; ?>
                                    <?php endif; ?>
                                </div>
                                <?php else: ?>
                                <span class="text-gray-400 cursor-not-allowed"
                                    title="Cannot generate link due to missing data.">View</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div><?php /**PATH /home/bkoq0ic0h8xi/public_html/littleflowerschool.co.in/resources/views/livewire/teacher-marks-entry-comp.blade.php ENDPATH**/ ?>