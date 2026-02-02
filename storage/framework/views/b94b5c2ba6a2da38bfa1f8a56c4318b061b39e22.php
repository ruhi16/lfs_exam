<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Exam Full Marks, Pass Marks & Time Configuration</h1>
        <p class="text-gray-600 mt-2">Configure full marks, pass marks, and time allocation for each subject and exam combination.</p>
    </div>
    
    <!-- Status Messages -->
    <?php if(session()->has('message')): ?>
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
            <?php echo e(session('message')); ?>

        </div>
    <?php endif; ?>
    
    <?php if(session()->has('error')): ?>
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>
    
    <!-- Class Tabs and Action Buttons -->
    <div class="mb-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <nav class="flex space-x-8" aria-label="Tabs">
                <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button
                        wire:click="setActiveTab(<?php echo e($index); ?>)"
                        class="py-4 px-1 border-b-2 font-medium text-sm <?php if($activeTab === $index): ?> border-blue-500 text-blue-600 <?php else: ?> border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 <?php endif; ?>"
                    >
                        <?php echo e($class->name); ?>

                    </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </nav>
            <div class="space-x-2">
                <button 
                    wire:click="$refresh"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Refresh
                </button>
                <button 
                    wire:click="toggleEditEnable"
                    class="px-4 py-2 text-sm font-medium text-white bg-<?php if($isEditingEnabled): ?> red <?php else: ?> blue <?php endif; ?>-600 border border-<?php if($isEditingEnabled): ?> red <?php else: ?> blue <?php endif; ?>-600 rounded-md hover:bg-<?php if($isEditingEnabled): ?> red <?php else: ?> blue <?php endif; ?>-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php if($isEditingEnabled): ?> red <?php else: ?> blue <?php endif; ?>-500"
                >
                    <?php if($isEditingEnabled): ?> Disable <?php else: ?> Enable <?php endif; ?> Edit
                </button>
            </div>
        </div>
    </div>
    
    <!-- Content Area -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <?php if(isset($classes[$activeTab])): ?>
            <?php
                $activeClass = $classes[$activeTab];
                $classSubjects = $this->getClassSubjects($activeClass->id);
                $examDetailsGrouped = $this->getExamDetailsForClass($activeClass->id);
            ?>
            
            <?php if($classSubjects->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                    Subject
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                    <div class="flex flex-col items-center">
                                        <span class="block">FM</span>
                                        <span class="block">PM</span>
                                        <span class="block">TIME</span>
                                    </div>
                                </th>
                                
                                <!-- Exam Name Headers -->
                                <?php $__currentLoopData = $examDetailsGrouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examNameId => $examDetailsByType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $examName = $examNames->firstWhere('id', $examNameId);
                                        $colspan = 0;
                                        foreach($examDetailsByType->groupBy('exam_type_id') as $typeGroup) {
                                            $colspan += $typeGroup->groupBy('exam_part_id')->count();
                                        }
                                    ?>
                                    <?php if($examName && $colspan > 0): ?>
                                        <th colspan="<?php echo e($colspan); ?>" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-blue-50">
                                            <?php echo e($examName->name); ?>

                                        </th>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                            
                            <!-- Exam Type and Part Headers -->
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                    -
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                    Allocation
                                </th>
                                
                                <?php $__currentLoopData = $examDetailsGrouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examNameId => $examDetailsByType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $examDetailsByType->groupBy('exam_type_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examTypeId => $typeDetails): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $examType = $examTypes->firstWhere('id', $examTypeId);
                                            $partsCount = $typeDetails->groupBy('exam_part_id')->count();
                                        ?>
                                        <?php if($examType && $partsCount > 0): ?>
                                            <th colspan="<?php echo e($partsCount); ?>" class="px-4 py-2 text-center text-xs font-medium text-blue-700 uppercase tracking-wider bg-blue-100 border-l border-r border-gray-200">
                                                <?php echo e($examType->name); ?>

                                            </th>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                            
                            <!-- Exam Part Headers -->
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                    -
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                    &nbsp;
                                </th>
                                
                                <?php $__currentLoopData = $examDetailsGrouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examNameId => $examDetailsByType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $examDetailsByType->groupBy('exam_type_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examTypeId => $typeDetails): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $__currentLoopData = $typeDetails->groupBy('exam_part_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examPartId => $partDetails): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $examPart = $examParts->firstWhere('id', $examPartId);
                                                $firstDetail = $partDetails->first();
                                            ?>
                                            <th class="px-3 py-2 text-center text-xs font-medium text-purple-700 uppercase tracking-wider bg-purple-50 border border-gray-200">
                                                <div class="text-xs text-gray-500 mb-1">
                                                    <?php echo e($examPart ? $examPart->name : 'N/A'); ?>

                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    <?php echo e($firstDetail->examMode->name ?? 'Mode N/A'); ?>

                                                </div>
                                            </th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        </thead>
                        
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php
                                $groupedClassSubjects = $this->getClassSubjectsGroupedByType($activeClass->id);
                            ?>
                            <?php $__currentLoopData = $groupedClassSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subjectTypeId => $classSubjectsOfType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($subjectTypeId): ?>
                                    <?php
                                        $subjectType = $subjectTypes->firstWhere('id', $subjectTypeId);
                                    ?>
                                    <?php if($subjectType): ?>
                                        <tr class="bg-gray-100">
                                            <td colspan="<?php echo e(2 + $examDetailsGrouped->sum(function($examDetailsByType) {
                                                return $examDetailsByType->groupBy('exam_type_id')->sum(function($typeDetails) {
                                                    return $typeDetails->groupBy('exam_part_id')->count();
                                                });
                                            })); ?>" class="px-6 py-2 text-sm font-semibold text-gray-700">
                                                <?php echo e($subjectType->name); ?>

                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endif; ?>
                                <?php $__currentLoopData = $classSubjectsOfType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classSubject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white z-10 border-r border-gray-200">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <span class="text-blue-800 font-medium"><?php echo e(substr($classSubject->subject->name ?? 'N/A', 0, 1)); ?></span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="font-medium text-gray-900"><?php echo e($classSubject->subject->name ?? 'N/A'); ?></div>
                                                    <div class="text-gray-500 text-xs"><?php echo e($classSubject->subject->code ?? ''); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 bg-gray-50">
                                            <!-- FM, PM, Time column for all exam combinations -->
                                            <div class="space-y-2">
                                                <div class="flex flex-col space-y-1">
                                                    <span class="inline-block px-2 py-1 bg-white border border-gray-300 rounded text-xs font-semibold text-gray-700">FM</span>
                                                    <span class="inline-block px-2 py-1 bg-white border border-gray-300 rounded text-xs font-semibold text-gray-700">PM</span>
                                                    <span class="inline-block px-2 py-1 bg-white border border-gray-300 rounded text-xs font-semibold text-gray-700">TIME</span>
                                                    <span class="inline-block px-2 py-1 bg-white border border-gray-300 rounded text-xs font-semibold text-gray-700" aria-disabled="true">|</span>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Data Cells -->
                                        <?php $__currentLoopData = $examDetailsGrouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examNameId => $examDetailsByType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $__currentLoopData = $examDetailsByType->groupBy('exam_type_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examTypeId => $typeDetails): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php $__currentLoopData = $typeDetails->groupBy('exam_part_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examPartId => $partDetails): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $examDetail = $partDetails->first();
                                                        $existingRecord = $this->getExistingRecord($activeClass->id, $classSubject->subject_id, $examDetail->id);
                                                        $cellKey = $activeClass->id . '_' . $classSubject->subject_id . '_' . $examDetail->id;
                                                    ?>
                                                    <td class="px-3 py-3 whitespace-nowrap text-center border border-gray-200 bg-white">
                                                        <?php if($existingRecord): ?>
                                                            <!-- Existing Record - Show Edit Form -->
                                                            <div class="space-y-2">
                                                                <div class="flex flex-col space-y-1">
                                                                    <input 
                                                                        type="number" 
                                                                        wire:model="formData.<?php echo e($cellKey); ?>.full_marks" 
                                                                        value="<?php echo e($this->getFormDataValue($activeClass->id, $classSubject->subject_id, $examDetail->id, 'full_marks')); ?>"
                                                                        class="w-16 px-1 py-1 text-xs border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-center" 
                                                                        placeholder="FM"
                                                                        min="0"
                                                                        <?php if(!$isEditingEnabled): ?> disabled <?php endif; ?>
                                                                    >
                                                                    <input 
                                                                        type="number" 
                                                                        wire:model="formData.<?php echo e($cellKey); ?>.pass_marks" 
                                                                        value="<?php echo e($this->getFormDataValue($activeClass->id, $classSubject->subject_id, $examDetail->id, 'pass_marks')); ?>"
                                                                        class="w-16 px-1 py-1 text-xs border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-center" 
                                                                        placeholder="PM"
                                                                        min="0"
                                                                        <?php if(!$isEditingEnabled): ?> disabled <?php endif; ?>
                                                                    >
                                                                    <input 
                                                                        type="number" 
                                                                        wire:model="formData.<?php echo e($cellKey); ?>.time_in_minutes" 
                                                                        value="<?php echo e($this->getFormDataValue($activeClass->id, $classSubject->subject_id, $examDetail->id, 'time_in_minutes')); ?>"
                                                                        class="w-16 px-1 py-1 text-xs border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-center" 
                                                                        placeholder="Min"
                                                                        min="0"
                                                                        <?php if(!$isEditingEnabled): ?> disabled <?php endif; ?>
                                                                    >
                                                                </div>
                                                                <div class="flex space-x-1 justify-center">
                                                                    <button 
                                                                        wire:click="saveRecord(<?php echo e($activeClass->id); ?>, <?php echo e($classSubject->subject_id); ?>, <?php echo e($examDetail->id); ?>)"
                                                                        class="px-2 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700"
                                                                    >
                                                                        ✓
                                                                    </button>
                                                                    <button 
                                                                        wire:click="deleteRecord(<?php echo e($existingRecord->id); ?>)"
                                                                        class="px-2 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700"
                                                                        onclick="return confirm('Are you sure you want to delete this record?')"
                                                                    >
                                                                        ✗
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        <?php else: ?>
                                                            <!-- No Record - Show Placeholder -->
                                                            <div class="h-full flex items-center justify-center">
                                                                <span class="text-xs text-gray-300">-</span>
                                                            </div>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No Subjects Found</h3>
                    <p class="text-gray-500">No subjects are assigned to this class. Please configure class subjects first.</p>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center py-12">
                <div class="text-gray-400 mb-4">
                    <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">No Classes Found</h3>
                <p class="text-gray-500">Please configure classes in the system first.</p>
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Footer Info -->
    <div class="mt-6 text-sm text-gray-500">
        Showing configuration for <?php echo e($classes->count() ?? 0); ?> classes
    </div>
</div><?php /**PATH D:\LaravelProject\LFS_Exam\resources\views/livewire/exam06-exam-fmpm-comp.blade.php ENDPATH**/ ?>