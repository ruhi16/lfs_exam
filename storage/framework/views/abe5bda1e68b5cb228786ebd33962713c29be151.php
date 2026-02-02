<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Exam Marks Entry</h1>
        <p class="text-gray-600 mt-2">Manage exam marks entries for students by class and section.</p>
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
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-100 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200"
                >
                    Refresh
                </button>
                <button 
                    wire:click="toggleEditEnable"
                    class="px-4 py-2 text-sm font-medium text-white <?php echo e($isEditingEnabled ? 'bg-red-600 border-red-600 hover:bg-red-700 focus:ring-red-500' : 'bg-indigo-600 border-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500'); ?> border rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 transition-colors duration-200"
                >
                    <?php if($isEditingEnabled): ?> Disable <?php else: ?> Enable <?php endif; ?> Edit
                </button>
            </div>
        </div>
    </div>
    
    <!-- Exam Name, Exam Type and Subject Filters -->
    <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-<?php if($isValidationPassed): ?> green-200 <?php else: ?> red-200 <?php endif; ?>">
        <div class="flex space-x-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Exam Name <?php if(!$selectedExamNameId): ?><span class="text-red-500">*</span><?php endif; ?></label>
                <select 
                    wire:model="selectedExamNameId"
                    wire:change="setSelectedExamName($event.target.value)"
                    class="w-full px-3 py-2 border <?php if(!$selectedExamNameId): ?> border-red-300 <?php else: ?> border-green-300 <?php endif; ?> rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">-- Select Exam Name --</option>
                    <?php $__currentLoopData = $examNames; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examName): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($examName->id); ?>"><?php echo e($examName->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Exam Type <?php if($selectedExamNameId && !$selectedExamTypeId): ?><span class="text-red-500">*</span><?php endif; ?></label>
                <select 
                    wire:model="selectedExamTypeId"
                    wire:change="setSelectedExamType($event.target.value)"
                    class="w-full px-3 py-2 border <?php if($selectedExamNameId && !$selectedExamTypeId): ?> border-red-300 <?php else: ?> border-<?php if($selectedExamTypeId): ?> green-300 <?php else: ?> gray-300 <?php endif; ?> <?php endif; ?> rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 <?php if(!$selectedExamNameId): ?> opacity-50 cursor-not-allowed <?php endif; ?>"
                    <?php if(!$selectedExamNameId): ?> disabled <?php endif; ?>
                >
                    <option value="">-- Select Exam Type --</option>
                    <?php $__currentLoopData = $examTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($examType->id); ?>"><?php echo e($examType->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Subject <?php if($selectedExamTypeId && !$selectedSubjectId): ?><span class="text-red-500">*</span><?php endif; ?></label>
                <select 
                    wire:model="selectedSubjectId"
                    wire:change="setSelectedSubject($event.target.value)"
                    class="w-full px-3 py-2 border <?php if($selectedExamTypeId && !$selectedSubjectId): ?> border-red-300 <?php else: ?> border-<?php if($selectedSubjectId): ?> green-300 <?php else: ?> gray-300 <?php endif; ?> <?php endif; ?> rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 <?php if(!$selectedExamTypeId): ?> opacity-50 cursor-not-allowed <?php endif; ?>"
                    <?php if(!$selectedExamTypeId): ?> disabled <?php endif; ?>
                >
                    <option value="">-- Select Subject --</option>
                    <option value="all">-- All Subjects --</option>
                    <?php $__currentLoopData = $filteredSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($subject->id); ?>"><?php echo e($subject->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
        
        <?php if(!$isValidationPassed): ?>
            <div class="mt-2 text-sm <?php if(!$selectedExamNameId): ?> text-red-600 <?php else: ?> <?php if(!$selectedExamTypeId): ?> text-yellow-600 <?php else: ?> text-yellow-600 <?php endif; ?> <?php endif; ?>">
                <?php if(!$selectedExamNameId): ?>
                    <svg class="inline-block w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    Please select an exam name to enable exam type selection.
                <?php elseif(!$selectedExamTypeId): ?>
                    <svg class="inline-block w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    Please select an exam type to enable subject selection.
                <?php elseif(!$selectedSubjectId): ?>
                    <svg class="inline-block w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    Please select a subject to enable student selection and marks entry.
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="mt-2 text-sm text-green-600">
                <svg class="inline-block w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                Selection valid. You can now select students and enter marks.
            </div>
        <?php endif; ?>
    </div>
    
    <!-- Content Area -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <?php if(isset($classes[$activeTab])): ?>
            <?php
                $activeClass = $classes[$activeTab];
                $classSections = $this->getClassSections($activeClass->id);
                $examClassSubjects = $this->getUniqueExamClassSubjectsForClass($activeClass->id);
                $examParts = $this->getExamPartsForClass($activeClass->id);
            ?>
            
            <?php if($classSections->count() > 0 && $examClassSubjects->count() > 0): ?>
                <div class="space-y-8 p-6">
                    <!-- Sections Loop -->
                    <?php $__currentLoopData = $classSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="border border-gray-200 rounded-lg <?php if(!$isValidationPassed): ?> opacity-50 cursor-not-allowed <?php endif; ?>">
                            <div class="bg-gray-50 px-6 py-3 border-b border-gray-200 flex justify-between items-center">
                                <h3 class="text-lg font-medium text-gray-900">Section: <?php echo e($section->section->name ?? 'N/A'); ?></h3>
                                <button 
                                    wire:click="saveAllEntries"
                                    class="px-4 py-2 text-sm font-medium text-white bg-<?php if($isValidationPassed): ?> emerald <?php else: ?> gray <?php endif; ?>-600 border border-<?php if($isValidationPassed): ?> emerald <?php else: ?> gray <?php endif; ?>-600 rounded-md hover:bg-<?php if($isValidationPassed): ?> emerald <?php else: ?> gray <?php endif; ?>-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-<?php if($isValidationPassed): ?> emerald <?php else: ?> gray <?php endif; ?>-500 <?php if(!$isEditingEnabled || !$isValidationPassed): ?> opacity-50 cursor-not-allowed <?php endif; ?> transition-colors duration-200"
                                    <?php if(!$isEditingEnabled || !$isValidationPassed): ?> disabled <?php endif; ?>
                                >
                                    <?php if($isValidationPassed): ?> Save All Entries <?php else: ?> Validation Required <?php endif; ?>
                                </button>
                            </div>
                            
                            <div class="overflow-x-auto">
                                <?php
                                    $students = $this->getStudentsInSection($section->id);
                                ?>
                                
                                <?php if($students->count() > 0): ?>
                                    <?php if($examParts->count() >= 1): ?>
                                        <!-- Display with sub-rows for exam parts (even if only one) to maintain consistency -->
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                                        Student
                                                    </th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">
                                                        Exam Part
                                                    </th>
                                                    
                                                    <!-- Exam Class Subjects Headers -->
                                                    <?php $__currentLoopData = $examClassSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examClassSubject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-blue-50">
                                                            <?php echo e($examClassSubject->subject->name ?? 'N/A'); ?><br>
                                                            <span class="text-[10px] text-gray-600"><?php echo e($examClassSubject->examDetail->examName->name ?? 'N/A'); ?> - <?php echo e($examClassSubject->examDetail->examType->name ?? 'N/A'); ?></span>
                                                            <div class="mt-2">
                                                                <button
                                                                    wire:click="saveAllEntriesForSubject(<?php echo e($section->id); ?>, <?php echo e($examClassSubject->id); ?>)"
                                                                    class="px-2 py-1 text-xs font-medium text-white bg-purple-600 border border-purple-600 rounded hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 <?php if(!$isEditingEnabled || !$isValidationPassed): ?> opacity-50 cursor-not-allowed <?php endif; ?>"
                                                                    <?php if(!$isEditingEnabled || !$isValidationPassed): ?> disabled <?php endif; ?>
                                                                >
                                                                    Save Subject
                                                                </button>
                                                            </div>
                                                        </th>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tr>
                                            </thead>
                                            
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__currentLoopData = $examParts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examPart): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <tr class="hover:bg-gray-50 <?php if(!$isValidationPassed): ?> bg-gray-100 <?php endif; ?>">
                                                            <?php if($loop->first): ?>
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white z-10 border-r border-gray-200 <?php if($examParts->count() > 1): ?> <?php else: ?> border-b <?php endif; ?>" rowspan="<?php echo e($examParts->count()); ?>">
                                                                    <div class="flex items-center">
                                                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                                            <span class="text-blue-800 font-medium"><?php echo e($student->roll_no ?? 'N/A'); ?></span>
                                                                        </div>
                                                                        <div class="ml-4">
                                                                            <div class="font-medium text-gray-900"><?php echo e($student->studentdb->name ?? 'N/A'); ?></div>
                                                                            <div class="text-gray-500 text-xs">Roll: <?php echo e($student->roll_no ?? 'N/A'); ?></div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            <?php endif; ?>
                                                            
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 <?php if(!$isValidationPassed): ?> text-gray-400 <?php endif; ?>">
                                                                <?php echo e($examPart->examPart->name ?? 'N/A'); ?>

                                                                <span class="text-xs text-gray-500">(<?php echo e($examPart->examMode->name ?? 'N/A'); ?>)</span>
                                                            </td>
                                                            
                                                            <!-- Exam Class Subjects Cells -->
                                                            <?php $__currentLoopData = $examClassSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examClassSubject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <?php
                                                                    // For single exam part, include part_id in key for consistency
                                                                    $cellKey = $section->id . '_' . $student->id . '_' . $examClassSubject->id . '_' . $examPart->id;
                                                                ?>
                                                                <td class="px-6 py-4 border border-gray-200 bg-white <?php if(!$isValidationPassed): ?> opacity-50 cursor-not-allowed <?php endif; ?>">
                                                                    <?php if($isValidationPassed): ?>
                                                                        <div class="flex items-center space-x-2">
                                                                            <input
                                                                                type="number"
                                                                                wire:model="formData.<?php echo e($cellKey); ?>.marks"
                                                                                class="flex-1 px-2 py-1 text-xs border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 <?php if(!$isEditingEnabled): ?> bg-gray-100 cursor-not-allowed <?php endif; ?> <?php if(data_get($this->formData, "{$cellKey}.is_absent")): ?> bg-gray-100 cursor-not-allowed opacity-50 <?php endif; ?>"
                                                                                placeholder="Enter marks"
                                                                                min="0"
                                                                                max="<?php echo e($examClassSubject->full_marks ?? 100); ?>"
                                                                                <?php if(!$isEditingEnabled || data_get($this->formData, "{$cellKey}.is_absent")): ?> disabled <?php endif; ?>
                                                                            />
                                                                            <div class="flex items-center">
                                                                                <input
                                                                                    type="checkbox"
                                                                                    wire:click="clearMarks('<?php echo e($cellKey); ?>')"
                                                                                    wire:model="formData.<?php echo e($cellKey); ?>.is_absent"
                                                                                    class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded <?php if(!$isEditingEnabled): ?> cursor-not-allowed <?php endif; ?>"
                                                                                    <?php if(!$isEditingEnabled): ?> disabled <?php endif; ?>
                                                                                />
                                                                                <span class="ml-1 text-xs text-gray-500">Absent</span>
                                                                            </div>
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <div class="flex items-center justify-center h-8">
                                                                            <span class="text-gray-400 text-xs">Validation required</span>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                </td>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    <?php else: ?>
                                        <div class="text-center py-12">
                                            <div class="text-gray-400 mb-4">
                                                <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900 mb-1">No Exam Parts Found</h3>
                                            <p class="text-gray-500">No exam parts are configured for the selected exam name and type.</p>
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <div class="text-center py-12">
                                        <div class="text-gray-400 mb-4">
                                            <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-1">No Students Found</h3>
                                        <p class="text-gray-500">No students are enrolled in this section.</p>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php elseif($classSections->count() == 0): ?>
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No Sections Found</h3>
                    <p class="text-gray-500">No sections are configured for this class.</p>
                </div>
            <?php elseif($examClassSubjects->count() == 0): ?>
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No Exam Class Subjects Found</h3>
                    <p class="text-gray-500">No exam class subjects are configured for this class.</p>
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
        Showing exam marks entries for <?php echo e($classes->count() ?? 0); ?> classes
    </div>
</div>
<?php /**PATH D:\LaravelProject\LFS_Exam\resources\views/livewire/exam10-exam-marks-entry-comp.blade.php ENDPATH**/ ?>