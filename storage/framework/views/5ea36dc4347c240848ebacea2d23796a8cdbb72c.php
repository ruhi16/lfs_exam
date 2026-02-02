<div>
    <div class="flex-1 p-6 overflow-y-auto max-w-full mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-2xl font-semibold text-gray-900">Exam Configuration</h1>
                    <p class="mt-1 text-sm text-gray-600">Define which exams, types, parts, and modes are active for each class.</p>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if(session()->has('message')): ?>
            <div class="mb-4 bg-green-100 border border-green-300 text-green-800 px-4 py-3 rounded-md">
                <?php echo e(session('message')); ?>

            </div>
        <?php endif; ?>

        <?php if(session()->has('error')): ?>
            <div class="mb-4 bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-md">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>

        <!-- Class Tabs -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="-mb-px flex space-x-8" aria-label="Tabs">
                <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button wire:key="class-tab-<?php echo e($class->id); ?>"
                        wire:click="selectClass(<?php echo e($class->id); ?>)"
                        class="<?php echo e($selectedClassId == $class->id ? 'border-indigo-500 text-indigo-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        <?php echo e($class->name); ?>

                    </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </nav>
        </div>

        <!-- Exam Configuration Panel -->
        <?php if($selectedClassId): ?>
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="p-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Configuration for <span class="text-indigo-600 font-semibold"><?php echo e($classes->firstWhere('id', $selectedClassId)->name); ?></span></h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full border-collapse border border-gray-300">
                        <thead class="bg-gray-50">
                            <tr>
                                <?php $__currentLoopData = $examNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th colspan="<?php echo e(count($examTypes)); ?>" class="border border-gray-300 px-4 py-3 text-center text-sm font-medium text-gray-900">
                                        <label class="flex items-center justify-center space-x-2">
                                            <input type="checkbox" wire:model="selectedExamNames.<?php echo e($selectedClassId); ?>.<?php echo e($examName->id); ?>" <?php if($this->isFinalized($selectedClassId, $examName->id)): ?> disabled <?php endif; ?> class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                            <span class="font-semibold"><?php echo e($examName->name); ?></span>
                                        </label>
                                    </th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                            <tr class="bg-gray-100">
                                <?php $__currentLoopData = $examNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $examTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th class="border border-gray-300 px-2 py-2 text-center text-xs font-medium text-gray-700 min-w-32">
                                            <?php if(isset($selectedExamNames[$selectedClassId][$examName->id]) && $selectedExamNames[$selectedClassId][$examName->id]): ?>
                                                <label class="flex items-center justify-center space-x-1">
                                                    <input type="checkbox" wire:model="selectedExamTypes.<?php echo e($selectedClassId); ?>.<?php echo e($examName->id); ?>.<?php echo e($examType->id); ?>" <?php if($this->isFinalized($selectedClassId, $examName->id)): ?> disabled <?php endif; ?> class="h-3 w-3 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                    <span class="text-xs font-medium"><?php echo e($examType->name); ?></span>
                                                </label>
                                            <?php else: ?>
                                                <span class="text-xs text-gray-400"><?php echo e($examType->name); ?></span>
                                            <?php endif; ?>
                                        </th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            <?php $__currentLoopData = $examParts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examPart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <?php $__currentLoopData = $examNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $__currentLoopData = $examTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td class="border border-gray-300 px-2 py-2 text-center align-top min-w-40">
                                                <?php if(isset($selectedExamNames[$selectedClassId][$examName->id]) && $selectedExamNames[$selectedClassId][$examName->id] && isset($selectedExamTypes[$selectedClassId][$examName->id][$examType->id]) && $selectedExamTypes[$selectedClassId][$examName->id][$examType->id]): ?>
                                                    <?php if($this->isFinalized($selectedClassId, $examName->id)): ?>
                                                        
                                                        <?php if(isset($selectedExamParts[$selectedClassId][$examName->id][$examType->id][$examPart->id]) && $selectedExamParts[$selectedClassId][$examName->id][$examType->id][$examPart->id]): ?>
                                                            <div class="p-3 bg-slate-50 rounded-lg border border-slate-200 shadow-sm text-center h-full flex flex-col justify-center">
                                                                <div class="flex items-center justify-center">
                                                                    <svg class="h-5 w-5 text-slate-500 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path d="M7 3.5A1.5 1.5 0 018.5 2h3.879a1.5 1.5 0 011.06.44l3.122 3.121A1.5 1.5 0 0117 6.621V16.5a1.5 1.5 0 01-1.5 1.5h-11A1.5 1.5 0 013 16.5v-13A1.5 1.5 0 014.5 2H6a1.5 1.5 0 011 1.5v1zM8.5 5a.5.5 0 000 1h3a.5.5 0 000-1h-3zM6 9.5A.5.5 0 016.5 9h7a.5.5 0 010 1h-7a.5.5 0 01-.5-.5zm0 2A.5.5 0 016.5 11h7a.5.5 0 010 1h-7a.5.5 0 01-.5-.5zm0 2A.5.5 0 016.5 13h7a.5.5 0 010 1h-7a.5.5 0 01-.5-.5z" /></svg>
                                                                    <p class="font-bold text-md text-slate-700"><?php echo e($examPart->name); ?></p>
                                                                </div>
                                                                <?php
                                                                    $selectedModeId = null;
                                                                    if(isset($selectedExamModes[$selectedClassId][$examName->id][$examType->id][$examPart->id])) {
                                                                        $selectedModeId = array_search(true, $selectedExamModes[$selectedClassId][$examName->id][$examType->id][$examPart->id], true);
                                                                    }
                                                                    $modeName = $selectedModeId ? ($examModes->firstWhere('id', $selectedModeId)->name ?? 'N/A') : 'N/A';
                                                                ?>
                                                                <?php if($selectedModeId): ?>
                                                                    <div class="mt-3 inline-flex items-center bg-teal-100 text-teal-800 text-xs font-semibold px-3 py-1 rounded-full">
                                                                        <svg class="h-4 w-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                                        <?php echo e($modeName); ?>

                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        
                                                        <div class="w-full p-2 flex flex-col items-center">
                                                            <label class="flex items-center space-x-2 bg-blue-50 px-3 py-1 rounded-md border border-blue-200 mb-3">
                                                                <input type="checkbox" wire:model="selectedExamParts.<?php echo e($selectedClassId); ?>.<?php echo e($examName->id); ?>.<?php echo e($examType->id); ?>.<?php echo e($examPart->id); ?>" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                                                <span class="text-sm font-semibold text-blue-800"><?php echo e($examPart->name); ?></span>
                                                            </label>
                                                            <?php if(isset($selectedExamParts[$selectedClassId][$examName->id][$examType->id][$examPart->id]) && $selectedExamParts[$selectedClassId][$examName->id][$examType->id][$examPart->id]): ?>
                                                                <div class="bg-green-50 border border-green-200 rounded-md p-2 space-y-1">
                                                                    <div class="text-xs text-green-700 font-medium text-center mb-1">Select Mode:</div>
                                                                    <?php $__currentLoopData = $examModes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examMode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <label class="flex items-center justify-center space-x-2 text-xs hover:bg-green-100 p-1 rounded">
                                                                            <input type="radio" name="examMode_<?php echo e($selectedClassId); ?>_<?php echo e($examName->id); ?>_<?php echo e($examType->id); ?>_<?php echo e($examPart->id); ?>" wire:click="selectExamMode(<?php echo e($selectedClassId); ?>, <?php echo e($examName->id); ?>, <?php echo e($examType->id); ?>, <?php echo e($examPart->id); ?>, <?php echo e($examMode->id); ?>)" <?php if(isset($selectedExamModes[$selectedClassId][$examName->id][$examType->id][$examPart->id][$examMode->id]) && $selectedExamModes[$selectedClassId][$examName->id][$examType->id][$examPart->id][$examMode->id]): ?> checked <?php endif; ?> class="h-3 w-3 text-green-600 focus:ring-green-500 border-gray-300">
                                                                            <span class="text-green-800 font-medium"><?php echo e($examMode->name); ?></span>
                                                                        </label>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <div class="w-full p-2 flex justify-center">
                                                        <span class="text-sm text-gray-400 bg-gray-100 px-3 py-1 rounded-md border border-gray-200"><?php echo e($examPart->name); ?></span>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                        <tfoot class="bg-gray-50 border-t-2 border-gray-300">
                            <tr>
                                <?php $__currentLoopData = $examNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <td colspan="<?php echo e(count($examTypes)); ?>" class="px-4 py-3 text-center">
                                        <?php if($this->isFinalized($selectedClassId, $examName->id)): ?>
                                            <span class="text-green-600 font-semibold p-2 bg-green-100 border border-green-200 rounded-md">Structure Finalized</span>
                                        <?php else: ?>
                                            <div class="flex justify-center space-x-2">
                                                <button wire:key="save-btn-<?php echo e($examName->id); ?>" wire:click="saveExamConfiguration(<?php echo e($selectedClassId); ?>, <?php echo e($examName->id); ?>)" <?php if($this->isSaveDisabled($selectedClassId, $examName->id)): ?> disabled <?php endif; ?> class="bg-indigo-600 hover:bg-indigo-700 text-white px-3 py-1 rounded text-sm transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed">
                                                    Save
                                                </button>
                                                <button wire:click="finalizeConfiguration(<?php echo e($selectedClassId); ?>, <?php echo e($examName->id); ?>)" wire:confirm="Are you sure? This will lock the exam structure." <?php if($this->isSaveDisabled($selectedClassId, $examName->id)): ?> disabled <?php endif; ?> class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-sm transition-colors disabled:bg-gray-400 disabled:cursor-not-allowed">
                                                    Finalize
                                                </button>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        <?php else: ?>
            <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
                <p class="text-lg font-medium">Select a class to begin configuring exams.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH /home/bkoq0ic0h8xi/public_html/littleflowerschool.co.in/resources/views/livewire/exam-settings.blade.php ENDPATH**/ ?>