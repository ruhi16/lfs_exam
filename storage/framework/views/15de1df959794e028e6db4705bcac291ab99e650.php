<div class="container mx-auto py-6">
    <div class="flex flex-col space-y-6">
        <!-- Tabs for Classes -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-2 overflow-x-auto" aria-label="Classes">
                <?php if(isset($classes) && $classes instanceof \Illuminate\Database\Eloquent\Collection): ?>
                    <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($class instanceof \App\Models\Myclass): ?>
                            <button wire:click="setActiveTab(<?php echo e($index); ?>)"
                                class="whitespace-nowrap py-2 px-4 text-sm font-medium rounded-t-lg transition-colors duration-200 <?php echo e($activeTab == $index ? 'text-blue-600 border-b-2 border-blue-600 bg-blue-50' : 'text-gray-500 hover:text-gray-700'); ?>">
                                <?php echo e($class->name); ?>

                            </button>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php endif; ?>
            </nav>
        </div>

        <!-- Success/Error Messages -->
        <?php if(session()->has('message')): ?>
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
                <p><?php echo e(session('message')); ?></p>
            </div>
        <?php endif; ?>

        <?php if(session()->has('error')): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                <p><?php echo e(session('error')); ?></p>
            </div>
        <?php endif; ?>

        <!-- Class Content -->
        <?php if(isset($classes[$activeTab]) && $classes[$activeTab] instanceof \App\Models\Myclass): ?>
            <?php
                $activeClass = $classes[$activeTab];
                $classSections = $this->getClassSections($activeClass->id);

                // Organize exam details: ExamName -> ExamType -> ExamPart
                // Using the $examDetails collection passed from render
                $organizedExamDetails = collect([]);
                foreach ($examDetails as $detail) {
                    $examNameId = $detail->exam_name_id;
                    $examTypeId = $detail->exam_type_id;
                    $examPartId = $detail->exam_part_id;

                    if (!$organizedExamDetails->has($examNameId)) {
                        $organizedExamDetails->put($examNameId, collect([]));
                    }
                    if (!$organizedExamDetails[$examNameId]->has($examTypeId)) {
                        $organizedExamDetails[$examNameId]->put($examTypeId, collect([]));
                    }
                    
                    // We just need to know this part exists for this type/name
                    if (!$organizedExamDetails[$examNameId][$examTypeId]->contains($detail)) {
                        $organizedExamDetails[$examNameId][$examTypeId]->push($detail);
                    }
                }
            ?>

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Answer Script Distribution - <?php echo e($activeClass->name); ?>

                    </h3>
                </div>

                <!-- Toggle Edit Button -->
                <div class="px-4 py-3 sm:px-6 bg-gray-50 border-b border-gray-200">
                    <button wire:click="toggleEditEnable"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        <?php echo e($isEditingEnabled ? 'Disable Editing' : 'Enable Editing'); ?>

                        <?php if($isEditingEnabled): ?>
                            <span class="ml-2 bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Editing Enabled</span>
                        <?php endif; ?>
                    </button>
                </div>

                <?php $__empty_1 = true; $__currentLoopData = $classSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="mb-8 border border-gray-200 rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 border-b border-gray-200">
                            <h4 class="text-md font-medium text-gray-800">
                                Section: <?php echo e($section->section->name ?? 'N/A'); ?>

                                <span class="text-xs text-gray-500 ml-2">(ID: <?php echo e($section->id); ?>)</span>
                            </h4>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 border-collapse">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th rowspan="3"
                                            class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10 border border-gray-200 w-64">
                                            Subject
                                        </th>

                                        <!-- Exam Name Headers -->
                                        <?php $__currentLoopData = $organizedExamDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examNameId => $examTypes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $examName = $examNames->firstWhere('id', $examNameId);
                                                $totalCols = 0;
                                                foreach ($examTypes as $examType) {
                                                    $totalCols += $examType->count(); // Each detail is a column
                                                }
                                            ?>
                                            <?php if($examName && $totalCols > 0): ?>
                                                <th colspan="<?php echo e($totalCols); ?>"
                                                    class="px-4 py-2 text-center text-xs font-bold text-gray-700 uppercase tracking-wider bg-blue-100 border border-gray-300">
                                                    <?php echo e($examName->name); ?>

                                                </th>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>

                                    <!-- Exam Type Headers -->
                                    <tr>
                                        <?php $__currentLoopData = $organizedExamDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examNameId => $examTypes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $__currentLoopData = $examTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examTypeId => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $examType = $examTypes[$examTypeId]->first()->examType;
                                                    $colSpan = $details->count();
                                                ?>
                                                <th colspan="<?php echo e($colSpan); ?>"
                                                    class="px-3 py-1 text-center text-xs font-medium text-blue-800 uppercase tracking-wider bg-blue-50 border border-gray-200">
                                                    <?php echo e($examType->name ?? 'N/A'); ?>

                                                </th>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>

                                    <!-- Exam Part Headers -->
                                    <tr>
                                        <?php $__currentLoopData = $organizedExamDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examNameId => $examTypes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $__currentLoopData = $examTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examTypeId => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                     <th class="px-2 py-1 text-center text-xs font-medium text-purple-700 uppercase tracking-wider bg-purple-50 border border-gray-200 min-w-[200px]">
                                                        <div class="flex flex-col">
                                                            <span><?php echo e($detail->examPart->name ?? 'Part N/A'); ?></span>
                                                            <span class="text-[10px] text-gray-500"><?php echo e($detail->examMode->name ?? 'Mode N/A'); ?></span>
                                                        </div>
                                                    </th>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                </thead>

                                <tbody class="bg-white divide-y divide-gray-200">
                                    <?php if($classSubjects && $classSubjects->count() > 0): ?>
                                        <?php $__currentLoopData = $classSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classSubject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <tr class="hover:bg-gray-50">
                                                <!-- Subject Column -->
                                                <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white z-10 border-r border-gray-200 border-b">
                                                    <div class="flex items-center">
                                                        <div class="flex-shrink-0 h-8 w-8 bg-gray-100 rounded-full flex items-center justify-center">
                                                            <span class="text-gray-600 text-xs font-medium">
                                                                <?php echo e(substr($classSubject->subject->name ?? '?', 0, 1)); ?>

                                                            </span>
                                                        </div>
                                                        <div class="ml-2">
                                                            <div class="font-medium text-gray-900 text-sm">
                                                                <?php echo e($classSubject->subject->name ?? 'N/A'); ?>

                                                            </div>
                                                            <div class="text-gray-500 text-xs flex flex-col">
                                                                <span>Code: <?php echo e($classSubject->subject->code ?? 'N/A'); ?></span>
                                                                <span class="text-[10px] text-gray-400">
                                                                    <?php echo e($classSubject->subject->subjectType->name ?? 'Type N/A'); ?>

                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <!-- Data Cells -->
                                                <?php $__currentLoopData = $organizedExamDetails; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examNameId => $examTypes): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php $__currentLoopData = $examTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examTypeId => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php $__currentLoopData = $details; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $detail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                // Find the ECS for this subject + detail combination
                                                                // We need to check if this subject is applicable for this exam detail
                                                                // We can look into examClassSubjects collection
                                                                
                                                                $ecs = $examClassSubjects->first(function($item) use ($classSubject, $detail) {
                                                                    return $item->subject_id == $classSubject->subject_id 
                                                                        && $item->exam_detail_id == $detail->id;
                                                                });

                                                                $isValidCell = !is_null($ecs);
                                                                
                                                                $cellKey = '';
                                                                $teacherId = '';
                                                                
                                                                if ($isValidCell) {
                                                                    $cellKey = $section->id . '_' . $ecs->id . '_' . $detail->id;
                                                                    
                                                                    // Check if we have form data, otherwise try to load from existing
                                                                    if (isset($formData[$cellKey])) {
                                                                        $teacherId = $formData[$cellKey]['teacher_id'];
                                                                    } else {
                                                                         // Fallback check in existing distributions if not in formData yet
                                                                         $existing = $existingDistributions->first(function ($dist) use ($section, $ecs) {
                                                                             return $dist->myclass_section_id == $section->id &&
                                                                                 $dist->exam_class_subject_id == $ecs->id;
                                                                         });
                                                                         $teacherId = $existing ? $existing->teacher_id : '';
                                                                    }
                                                                }
                                                            ?>
                                                            
                                                            <td class="px-2 py-2 text-center border border-gray-200 align-middle <?php echo e($isValidCell ? '' : 'bg-gray-100'); ?>">
                                                                <?php if($isValidCell): ?>
                                                                    <div class="text-[10px] text-gray-400 mb-1 flex flex-col space-y-0.5">
                                                                        <span>ED: <?php echo e($detail->id); ?></span>
                                                                        <span>ECS: <?php echo e($ecs->id); ?></span>
                                                                        <span>T: <?php echo e($teacherId ?: 'None'); ?></span>
                                                                    </div>
                                                                    <?php if($isEditingEnabled): ?>
                                                                        <div class="flex flex-col space-y-2">
                                                                            <select wire:model.defer="formData.<?php echo e($cellKey); ?>.teacher_id"
                                                                                class="block w-full pl-3 pr-10 py-1 text-xs border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-xs rounded-md shadow-sm">
                                                                                <option value="">Select Teacher</option>
                                                                                <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                    <option value="<?php echo e($teacher->id); ?>">
                                                                                        <?php echo e($teacher->user->name ?? $teacher->name ?? 'Unknown'); ?>

                                                                                    </option>
                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            </select>
                                                                            
                                                                            <button wire:click="saveDistribution(<?php echo e($section->id); ?>, <?php echo e($detail->id); ?>, <?php echo e($ecs->id); ?>)"
                                                                                class="inline-flex justify-center items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 shadow-sm">
                                                                                Save
                                                                            </button>
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <div class="text-xs text-gray-700">
                                                                            <?php
                                                                                $tName = 'Not Assigned';
                                                                                if($teacherId) {
                                                                                    $t = $teachers->firstWhere('id', $teacherId);
                                                                                    $tName = $t ? ($t->user->name ?? $t->name ?? 'Unknown') : 'Unknown ID: '.$teacherId;
                                                                                }
                                                                            ?>
                                                                            <?php echo e($tName); ?>

                                                                        </div>
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                    <span class="text-gray-400 text-xs">-</span>
                                                                <?php endif; ?>
                                                            </td>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tr>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="100" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                                No subjects found for this class.
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6 text-center text-gray-500">
                        No sections found for this class.
                    </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg p-6 text-center text-gray-500">
                Please select a class to view distribution.
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH D:\LaravelProject\LFS_Exam\resources\views/livewire/exam07-anscr-distribution-comp.blade.php ENDPATH**/ ?>