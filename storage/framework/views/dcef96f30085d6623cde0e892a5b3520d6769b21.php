<div>
    <!-- Search and Filter Controls -->
    <div class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <input type="text" wire:model.debounce.300ms="search" id="search" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Search...">
            </div>
            <div>
                <label for="selectedSession" class="block text-sm font-medium text-gray-700">Session</label>
                <select wire:model="selectedSession" id="selectedSession" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">All Sessions</option>
                    <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($session->id); ?>"><?php echo e($session->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div>
                <label for="selectedExamName" class="block text-sm font-medium text-gray-700">Exam Name</label>
                <select wire:model="selectedExamName" id="selectedExamName" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">All Exam Names</option>
                    <?php $__currentLoopData = $examNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($examName->id); ?>"><?php echo e($examName->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="flex items-end">
                <button wire:click="create()" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Add New Exam Detail
                </button>
            </div>
        </div>
    </div>

    <!-- Status Message -->
    <?php if(session()->has('message')): ?>
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
            <?php echo e(session('message')); ?>

        </div>
    <?php endif; ?>

    <!-- Grouped Table -->
    <div class="overflow-x-auto">
        <?php if($groupedData->count() > 0): ?>
            <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                        <?php $__currentLoopData = $examNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $colspan = $types->count() * $parts->count();
                            ?>
                            <th colspan="<?php echo e($colspan); ?>" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-blue-50">
                                <?php echo e($examName->name); ?>

                            </th>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-blue-50">Actions</th>
                    </tr>
                    
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">-</th>
                        
                        <?php $__currentLoopData = $examNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th colspan="<?php echo e($parts->count()); ?>" class="px-4 py-2 text-center text-xs font-medium text-blue-700 uppercase tracking-wider bg-blue-100 border-l border-r border-gray-200">
                                    <?php echo e($examType->name); ?>

                                </th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <th class="px-4 py-2 text-center text-xs font-medium text-blue-700 uppercase tracking-wider bg-blue-100 border-l border-r border-gray-200">-</th>
                    </tr>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">-</th>
                        <?php $__currentLoopData = $examNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examPart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <th class="px-2 py-2 text-center text-xs font-medium text-purple-700 uppercase tracking-wider bg-purple-50 border border-gray-200">
                                        <?php echo e($examPart->name); ?>

                                    </th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <th class="px-2 py-2 text-center text-xs font-medium text-purple-700 uppercase tracking-wider bg-purple-50 border border-gray-200">-</th>
                    </tr>
                </thead>
                
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 bg-gray-50">
                                <?php echo e($class->name); ?>

                            </td>
                            <?php $__currentLoopData = $examNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examPart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $cellKey = $class->id . '_' . $examName->id . '_' . $examType->id . '_' . $examPart->id;
                                            $enabled = data_get($matrix, "{$cellKey}.enabled", false);
                                            $modeId = data_get($matrix, "{$cellKey}.mode_id", null);
                                        ?>
                                        <td class="px-2 py-2 whitespace-nowrap text-sm text-gray-700 text-center border border-gray-200 bg-white">
                                            <div class="flex flex-col items-center space-y-2">
                                                <label class="inline-flex items-center space-x-2">
                                                    <input type="checkbox" wire:model="matrix.<?php echo e($cellKey); ?>.enabled" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                    <span class="text-xs text-gray-600">Enable</span>
                                                </label>
                                                <div class="flex flex-wrap items-center justify-center gap-2">
                                                    <?php $__currentLoopData = $modes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <label class="inline-flex items-center space-x-1">
                                                            <input type="radio" name="mode_<?php echo e($cellKey); ?>" value="<?php echo e($mode->id); ?>" wire:model="matrix.<?php echo e($cellKey); ?>.mode_id" class="h-3 w-3 text-purple-600 border-gray-300 focus:ring-purple-500" <?php if(!$enabled): ?> disabled <?php endif; ?>>
                                                            <span class="text-[11px] text-gray-600"><?php echo e($mode->name); ?></span>
                                                        </label>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                            </div>
                                        </td>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <td class="px-2 py-2 text-center border border-gray-200 bg-white">
                                <button wire:click="saveClassConfig(<?php echo e($class->id); ?>)" class="px-3 py-1 text-xs font-medium text-white bg-emerald-600 border border-emerald-600 rounded hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500">
                                    Save
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        <?php else: ?>
            <div class="text-center py-12">
                <div class="text-gray-400 mb-4">
                    <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">No Exam Details Found</h3>
                <p class="text-gray-500">Get started by adding your first exam detail.</p>
                <div class="mt-6">
                    <button wire:click="create()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Add Exam Detail
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal Form -->
    <div x-data="{ isOpen: <?php if ((object) ('isOpen') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('isOpen'->value()); ?>')<?php echo e('isOpen'->hasModifier('defer') ? '.defer' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('isOpen'); ?>')<?php endif; ?> }" x-show="isOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="isOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
            
            <div x-show="isOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                <?php echo e($isEdit ? 'Edit Exam Detail' : 'Add New Exam Detail'); ?>

                            </h3>
                            <div class="mt-4 w-full">
                                <form wire:submit.prevent="submitForm">
                                    <div class="space-y-4">
                                        <!-- Basic Information -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="session_id" class="block text-sm font-medium text-gray-700">Session *</label>
                                                <select 
                                                    wire:model.defer="session_id" 
                                                    id="session_id" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['session_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    required
                                                >
                                                    <option value="">-- Select Session --</option>
                                                    <?php $__currentLoopData = $sessions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $session): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($session->id); ?>"><?php echo e($session->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php $__errorArgs = ['session_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div>
                                                <label for="exam_name_id" class="block text-sm font-medium text-gray-700">Exam Name *</label>
                                                <select 
                                                    wire:model.defer="exam_name_id" 
                                                    id="exam_name_id" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['exam_name_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    required
                                                >
                                                    <option value="">-- Select Exam Name --</option>
                                                    <?php $__currentLoopData = $examNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $exam): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($exam->id); ?>"><?php echo e($exam->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php $__errorArgs = ['exam_name_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <!-- Classes Selection (Horizontal checkboxes) -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Classes *</label>
                                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2">
                                                <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="flex items-center">
                                                        <input 
                                                            type="checkbox" 
                                                            value="<?php echo e($class->id); ?>" 
                                                            id="class_<?php echo e($class->id); ?>"
                                                            wire:model="selectedClasses"
                                                            class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                        >
                                                        <label for="class_<?php echo e($class->id); ?>" class="ml-2 text-sm text-gray-700"><?php echo e($class->name); ?></label>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                            <?php $__errorArgs = ['selectedClasses'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <!-- Exam Types Selection (Checkboxes) -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Exam Types *</label>
                                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                                                <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <div class="flex items-center">
                                                        <input 
                                                            type="checkbox" 
                                                            value="<?php echo e($type->id); ?>" 
                                                            id="type_<?php echo e($type->id); ?>"
                                                            wire:model="selectedExamTypes"
                                                            class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                        >
                                                        <label for="type_<?php echo e($type->id); ?>" class="ml-2 text-sm text-gray-700"><?php echo e($type->name); ?></label>
                                                    </div>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                            <?php $__errorArgs = ['selectedExamTypes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <!-- Exam Parts Selection for Selected Exam Types -->
                                        <?php if($selectedExamTypes && count($selectedExamTypes) > 0): ?>
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Select Exam Parts for Selected Types</label>
                                                <div class="space-y-4">
                                                    <?php $__currentLoopData = $selectedExamTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examTypeId): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                            $examType = $types->firstWhere('id', $examTypeId);
                                                        ?>
                                                        <?php if($examType): ?>
                                                            <div class="border border-gray-200 rounded p-3 bg-gray-50">
                                                                <h4 class="font-medium text-gray-800 mb-2"><?php echo e($examType->name); ?></h4>
                                                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                                                                    <?php $__currentLoopData = $parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <div class="flex items-center">
                                                                            <input 
                                                                                type="checkbox" 
                                                                                value="<?php echo e($part->id); ?>" 
                                                                                id="part_<?php echo e($examTypeId); ?>_<?php echo e($part->id); ?>"
                                                                                wire:model="selectedExamParts.<?php echo e($examTypeId); ?>"
                                                                                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                            >
                                                                            <label for="part_<?php echo e($examTypeId); ?>_<?php echo e($part->id); ?>" class="ml-2 text-sm text-gray-700"><?php echo e($part->name); ?></label>
                                                                        </div>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </div>
                                                <?php $__errorArgs = ['selectedExamParts'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Exam Mode Selection (Option buttons) -->
                                        <div class="mb-4">
                                            <label for="exam_mode_id" class="block text-sm font-medium text-gray-700">Exam Mode *</label>
                                            <select wire:model.defer="exam_mode_id" id="exam_mode_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['exam_mode_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                                <option value="">-- Select Exam Mode --</option>
                                                <?php $__currentLoopData = $modes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mode): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($mode->id); ?>"><?php echo e($mode->name); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                            <?php $__errorArgs = ['exam_mode_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <!-- Other form fields -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="name" class="block text-sm font-medium text-gray-700">Exam Detail Name *</label>
                                                <input 
                                                    type="text" 
                                                    wire:model.defer="name" 
                                                    id="name" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    placeholder="Enter exam detail name"
                                                    required
                                                >
                                                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div>
                                                <label for="order_index" class="block text-sm font-medium text-gray-700">Order Index</label>
                                                <input 
                                                    type="number" 
                                                    wire:model.defer="order_index" 
                                                    id="order_index" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['order_index'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    placeholder="Enter order index"
                                                >
                                                <?php $__errorArgs = ['order_index'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                            <textarea 
                                                wire:model.defer="description" 
                                                id="description" 
                                                rows="3"
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="Enter description"
                                            ></textarea>
                                            <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="school_id" class="block text-sm font-medium text-gray-700">School</label>
                                                <select 
                                                    wire:model.defer="school_id" 
                                                    id="school_id" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['school_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                >
                                                    <option value="">-- Select School --</option>
                                                    <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($school->id); ?>"><?php echo e($school->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php $__errorArgs = ['school_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div>
                                                <label for="user_id" class="block text-sm font-medium text-gray-700">Created By</label>
                                                <select 
                                                    wire:model.defer="user_id" 
                                                    id="user_id" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                >
                                                    <option value="">-- Select User --</option>
                                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php $__errorArgs = ['user_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <label for="is_optional" class="block text-sm font-medium text-gray-700">Is Optional</label>
                                                <select 
                                                    wire:model.defer="is_optional" 
                                                    id="is_optional" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['is_optional'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                >
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                                <?php $__errorArgs = ['is_optional'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div>
                                                <label for="is_active" class="block text-sm font-medium text-gray-700">Is Active</label>
                                                <select 
                                                    wire:model.defer="is_active" 
                                                    id="is_active" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                >
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                                <?php $__errorArgs = ['is_active'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div>
                                                <label for="is_finalized" class="block text-sm font-medium text-gray-700">Is Finalized</label>
                                                <select 
                                                    wire:model.defer="is_finalized" 
                                                    id="is_finalized" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['is_finalized'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                >
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                                <?php $__errorArgs = ['is_finalized'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="approved_by" class="block text-sm font-medium text-gray-700">Approved By</label>
                                                <select 
                                                    wire:model.defer="approved_by" 
                                                    id="approved_by" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['approved_by'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                >
                                                    <option value="">-- Select Approver --</option>
                                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?></option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                                <?php $__errorArgs = ['approved_by'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>

                                            <div>
                                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                                <input 
                                                    type="text" 
                                                    wire:model.defer="status" 
                                                    id="status" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    placeholder="Enter status"
                                                >
                                                <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                            <input 
                                                type="text" 
                                                wire:model.defer="remarks" 
                                                id="remarks" 
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm <?php $__errorArgs = ['remarks'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="Enter remarks"
                                            >
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
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button 
                        wire:click.prevent="submitForm" 
                        type="button" 
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                        <?php echo e($isEdit ? 'Update' : 'Create'); ?>

                    </button>
                    <button 
                        @click="isOpen = false" 
                        type="button" 
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH D:\LaravelProject\LFS_Exam\resources\views/livewire/exam05-exam-detail-comp.blade.php ENDPATH**/ ?>