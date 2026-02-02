<div class="flex-1 p-6 overflow-y-auto max-w-full mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Marks Entry </h1>
                <p class="mt-1 text-sm text-gray-600">Select exam details to enter marks for students</p>
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
        <div class="flex space-x-2 mb-2">
            <button wire:click="checkDatabaseConnection" class="bg-blue-500 text-white px-3 py-1 rounded text-xs">
                Test DB Connection
            </button>
            <button wire:click="refreshData" class="bg-purple-500 text-white px-3 py-1 rounded text-xs">
                Refresh Data
            </button>
            <button wire:click="debugExamDetails" class="bg-orange-500 text-white px-3 py-1 rounded text-xs">
                Debug Exam Details
            </button>
        </div>
        <div class="text-xs text-yellow-700">
            Selected Class: <span class="font-semibold"> <?php echo e($selectedClassId ?? 'None'); ?> </span>|
            Selected Exam: <?php echo e($selectedExamNameId ?? 'None'); ?> |
            Sections: <?php echo e(count($classSections)); ?> |
            Subjects: <?php echo e(is_countable($classSubjects) ? count($classSubjects) : 0); ?> |
            Exam Details: <?php echo e(is_array($examDetails) ? array_sum(array_map('count', $examDetails)) : 0); ?>

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
                Selected: <?php echo e($classes->where('id', $selectedClassId)->first()->name ?? 'Unknown Class'); ?>

            </span>
        </div>
        <?php endif; ?>
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

    <!-- Exam Name Selection -->
    <?php if($selectedClassId && count($examNames) > 0): ?>
    <div class="mb-6">
        <h3 class="text-lg font-medium text-gray-900 mb-3">Select Exam</h3>
        <div class="flex flex-wrap gap-2">
            <?php $__currentLoopData = $examNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button wire:click="selectExamName(<?php echo e($examName->id); ?>)"
                class="<?php if($selectedExamNameId == $examName->id): ?> bg-indigo-600 text-white <?php else: ?> bg-gray-200 text-gray-700 hover:bg-gray-300 <?php endif; ?> px-4 py-2 rounded-md text-sm font-medium">
                <?php echo e($examName->name); ?> X
            </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- DEBUG INFO -->
    
    
    <!-- Marks Entry Tables by Exam Type (Summative first, then Formative) -->
    <?php if($selectedClassId && $selectedExamNameId && count($classSubjects) > 0 && count($classSections) > 0 &&
    is_array($examDetails) && count($examDetails) > 0): ?>
    <div class="space-y-8">
        <?php $__currentLoopData = $examTypes->sortByDesc('id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <!-- DEBUG: Checking exam type <?php echo e($examType->id); ?> -->
        
        

        <?php if(isset($examDetails[$examType->id])): ?>
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div
                class="p-4 border-b border-gray-200 bg-gray-200 sticky top-0 z-10 flex items-center justify-between py-2 px-4">
                <h3 class="text-lg font-semibold text-gray-900">
                    <?php echo e($examType->name); ?> - Marks Entry
                    
                    
                    
                    
                    
                </h3>
                <p class="text-sm text-gray-600 mt-1">
                    Click on any cell to enter marks for that exam part
                </p>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-800 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                Subject
                            </th>
                            <?php $__currentLoopData = $classSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classSection): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <th scope="col"
                                class="px-4 py-3 text-center text-xs font-medium text-gray-800 uppercase tracking-wider border-l border-gray-300">
                                <div class="font-semibold text-gray-900"><?php echo e($classSection->section->name); ?> Section
                                </div>
                                
                            </th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $examDetailsForType = $examDetails[$examType->id] ?? []; ?>
                        <?php $__currentLoopData = $classSubjects->filter(function($classSubject) use ($examType) {
                        if ($classSubject->subject && $classSubject->subject->subjectType) {
                        return str_contains(strtolower($classSubject->subject->subjectType->name),
                        strtolower($examType->name));
                        }
                        // If subject has no type, don't show it in typed tables.
                        return false;
                        }); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50">
                            <td
                                class="px-6 py-4 text-sm font-medium text-gray-900 sticky left-0 bg-white z-10 border-r border-gray-200">
                                <div class="font-semibold"><?php echo e($subject->subject->name ?? 'Unknown Subject'); ?></div>
                                <div class="text-xs text-gray-500"><?php echo e($subject->name); ?></div>
                            </td>
                            <?php $__currentLoopData = $classSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <td class="px-4 py-4 text-center border-l border-gray-300">
                                <div class="space-y-2">
                                    <?php $__currentLoopData = $examDetailsForType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                    // Check if the current exam detail is valid for the current subject
                                    $validExamDetailsForSubject = $subjectExamDetailMap->get($subject->subject_id, []);
                                    $isCombinationValid = in_array($examDetail->id, $validExamDetailsForSubject);
                                    ?>

                                    <?php if($isCombinationValid): ?>
                                    <?php
                                    $lookupKey = $examDetail->id . '_' . $subject->subject_id . '_' . $section->id;
                                    $answerScriptDistribution = $distributions->get($lookupKey);
                                    ?>

                                    <div class="relative">
                                        <?php
                                        $lookupKey = $examDetail->id . '_' . $subject->subject_id . '_' . $section->id;
                                        $answerScriptDistribution = $distributions->get($lookupKey);
                                        $isFinalized = $answerScriptDistribution &&
                                        $answerScriptDistribution->examClassSubject &&
                                        $answerScriptDistribution->examClassSubject->is_finalized;
                                        ?>

                                        <button
                                            wire:click="openMarksEntry(<?php echo e($examDetail->id ?? 0); ?>, <?php echo e($subject->subject_id ?? 0); ?>, <?php echo e($section->section_id ?? 0); ?>)"
                                            class="w-full rounded p-2 transition-colors relative
                                                                            <?php if($isFinalized): ?>
                                                                                bg-gray-300 border border-gray-400 cursor-not-allowed
                                                                            <?php elseif($answerScriptDistribution): ?>
                                                                                <?php if($answerScriptDistribution->status === 'Done'): ?>
                                                                                    bg-green-100 border border-green-300 hover:bg-green-200
                                                                                <?php else: ?>
                                                                                    bg-blue-100 border border-blue-300 hover:bg-blue-200
                                                                                <?php endif; ?>
                                                                            <?php else: ?>
                                                                                bg-red-100 border border-red-300 hover:bg-red-200
                                                                            <?php endif; ?>
                                                                        " <?php if($isFinalized): ?> disabled <?php endif; ?>>

                                            <div
                                                class="text-xs font-medium 
                                                                            <?php if($isFinalized): ?> text-gray-600 <?php else: ?> text-blue-800 <?php endif; ?>">
                                                <?php echo e($examDetail->examPart->name ?? 'Unknown Part'); ?>

                                            </div>

                                            <?php if($isFinalized): ?>
                                            <div class="text-xs text-gray-500">Finalized</div>
                                            <?php else: ?>
                                            <div class="text-xs text-blue-600">Enter Marks</div>
                                            <?php endif; ?>

                                            <div class="text-xs text-gray-500 mt-1">
                                                <?php if($answerScriptDistribution): ?>
                                                <div class="text-xs font-semibold
                                                                                    <?php if($isFinalized): ?> text-gray-700
                                                                                    <?php else: ?> text-blue-900 <?php endif; ?>">
                                                    <?php echo e($answerScriptDistribution->teacher ?
                                                    $answerScriptDistribution->teacher->name : 'N/A'); ?>

                                                </div>
                                                <div class="flex items-center justify-between mt-1">
                                                    <div class="text-xs 
                                                                                        <?php if($isFinalized): ?> text-gray-600
                                                                                        <?php elseif($answerScriptDistribution->status === 'Done'): ?> text-green-700 
                                                                                        <?php else: ?> text-yellow-700 <?php endif; ?>">
                                                        <?php echo e($answerScriptDistribution->status ?? 'Pending'); ?>

                                                    </div>
                                                    <?php if($isFinalized): ?>
                                                    <button
                                                        wire:click.stop="unfinalizeMarks(<?php echo e($answerScriptDistribution->examClassSubject->id ?? 0); ?>)"
                                                        class="text-xs bg-orange-500 hover:bg-orange-600 text-white px-2 py-1 rounded"
                                                        title="Unfinalize marks">
                                                        Unfinalize
                                                    </button>
                                                    <?php endif; ?>
                                                </div>
                                                <?php else: ?>
                                                <div class="text-xs text-red-600">Not Assigned</div>
                                                <?php endif; ?>
                                            </div>
                                        </button>
                                    </div>
                                    <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </td>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                        </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <?php elseif($selectedClassId && $selectedExamNameId): ?>
    <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
        <div class="text-lg font-medium mb-2">No exam details found</div>
        <div class="text-sm">Please ensure this class and exam have been configured with exam details.</div>
    </div>
    <?php elseif($selectedClassId): ?>
    <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
        <div class="text-lg font-medium mb-2">Select an exam to view marks entry options</div>
        <div class="text-sm">Choose an exam from the options above to proceed with marks entry.</div>
    </div>
    <?php else: ?>
    <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
        <div class="text-lg font-medium mb-2">Select a class to begin marks entry</div>
        <div class="text-sm">Choose a class from the tabs above to get started.</div>
    </div>
    <?php endif; ?>
</div><?php /**PATH /home/bkoq0ic0h8xi/public_html/littleflowerschool.co.in/resources/views/livewire/marks-entry-comp.blade.php ENDPATH**/ ?>