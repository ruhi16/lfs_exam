<div class="bg-white rounded-lg shadow overflow-hidden" wire:key="main-container">
    <!-- Tab Navigation -->
    <div class="mb-6 border-b border-gray-200">
        <div class="flex space-x-8" aria-label="Tabs">
            <?php if(isset($classes) && count($classes) > 0): ?>
                <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button wire:click="setActiveTab(<?php echo e($index); ?>)"
                        class="py-4 px-1 border-b-2 font-medium text-sm <?php if($activeTab === $index): ?> border-blue-500 text-blue-600 <?php else: ?> border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 <?php endif; ?>">
                        <?php echo e($class->name ?? 'Class ' . ($index + 1)); ?>

                    </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- Content Area -->
    <div class="px-6 py-4">
        <?php if(isset($classes[$activeTab]) && $classes[$activeTab]): ?>
            <?php
                $activeClass = $classes[$activeTab];
            ?>
            
            <div class="mb-6 flex justify-between items-center">
                <h2 class="text-xl font-semibold text-gray-800">
                    Subject to Exam Mapping for: <?php echo e($activeClass->name ?? 'N/A'); ?>

                </h2>
                <div class="flex space-x-2">
                    <?php if(!$isEditing): ?>
                        <button wire:click="startEditing" 
                                class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            Configure Mapping
                        </button>
                    <?php else: ?>
                        <button wire:click="saveChanges" 
                                class="px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                            Save All
                        </button>
                        <button wire:click="cancelEditing" 
                                class="px-4 py-2 bg-gray-500 text-white rounded-md hover:bg-gray-600 transition-colors">
                            Cancel
                        </button>
                    <?php endif; ?>
                </div>
            </div>

            <?php if(!empty($examStructure)): ?>
                <!-- Subject Mapping Table -->
                <div class="overflow-auto max-h-[75vh] p-2">
                    <table class="min-w-[1200px] w-full divide-y divide-gray-200" wire:key="exam-subject-table">
                        <thead class="bg-gray-50 sticky top-0 z-10">
                            <tr>
                                <?php
                                    $examNameColors = [
                                        'bg-blue-100','bg-green-100','bg-yellow-100','bg-pink-100',
                                        'bg-purple-100','bg-indigo-100','bg-red-100','bg-teal-100'
                                    ];
                                ?>
                                <th rowspan="3" class="px-4 py-3 text-left text-xs font-semibold text-gray-700 uppercase bg-gray-100 border-r">
                                    Subject
                                </th>
                                <?php $__currentLoopData = $examStructure; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examNameId => $examNameData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $typeSpan = 0;
                                        foreach($examNameData['types'] as $typeData) { $typeSpan += count($typeData['parts']); }
                                        $examNameBg = $examNameColors[$loop->index % count($examNameColors)];
                                    ?>
                                    <th colspan="<?php echo e($typeSpan); ?>" class="px-4 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider <?php echo e($examNameBg); ?> border-b" wire:key="header-examname-<?php echo e($examNameId); ?>">
                                        <?php echo e($examNameData['name']); ?>

                                    </th>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <th rowspan="3" class="px-4 py-3 text-center text-xs font-semibold text-gray-700 uppercase bg-gray-100 border-l">
                                    Actions
                                </th>
                            </tr>
                            <tr>
                                <?php $__currentLoopData = $examStructure; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examNameId => $examNameData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $examNameData['types']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examTypeId => $typeData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <th colspan="<?php echo e(count($typeData['parts'])); ?>" class="px-3 py-2 text-center text-xs font-semibold text-gray-600 uppercase border-b" wire:key="header-examtype-<?php echo e($examTypeId); ?>">
                                            <?php echo e($typeData['name']); ?>

                                        </th>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                            <tr>
                                <?php $__currentLoopData = $examStructure; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examNameId => $examNameData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php $__currentLoopData = $examNameData['types']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examTypeId => $typeData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $__currentLoopData = $typeData['parts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examPartId => $partData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th class="px-2 py-1 text-center text-[11px] font-medium text-gray-600 uppercase" wire:key="header-exampart-<?php echo e($examPartId); ?>">
                                                <?php echo e($partData['name']); ?>

                                            </th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tr>
                        </thead>
                        
                        <!-- Table Body with Subjects Only -->
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php
                                $grouped = collect($classSubjects)->groupBy(function($cs){
                                    return strtolower($cs->subject->subjectType->name ?? 'unknown');
                                });
                                $subjectTypeColors = [
                                    'summative' => 'bg-blue-50',
                                    'formative' => 'bg-yellow-50',
                                    'unknown' => 'bg-gray-50'
                                ];
                            ?>
                            <?php $__empty_1 = true; $__currentLoopData = $grouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $typeName => $subjectsGroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <?php
                                    $rowSpan = count($subjectsGroup);
                                    $typeBg = $subjectTypeColors[$typeName] ?? 'bg-gray-50';
                                    $typeLabel = ucfirst($typeName);
                                ?>
                                <?php $__currentLoopData = $subjectsGroup; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $groupIndex => $classSubject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $subject = $classSubject->subject ?? null;
                                        $subjectType = $subject ? $subject->subjectType : null;
                                        $subjectTypeName = $subjectType ? $subjectType->name : 'Unknown';
                                    ?>
                                    <tr class="hover:bg-gray-50" wire:key="subject-row-<?php echo e($classSubject->id); ?>">
                                        <?php if($groupIndex === 0): ?>
                                            <td rowspan="<?php echo e($rowSpan); ?>" class="px-2 py-2 text-center border-r border-gray-200 <?php echo e($typeBg); ?>">
                                                <div style="writing-mode: vertical-rl; transform: rotate(180deg);" class="text-xs font-semibold text-gray-700">
                                                    <?php echo e($typeLabel); ?>

                                                </div>
                                            </td>
                                        <?php endif; ?>
                                        <td class="px-3 py-2 whitespace-nowrap border-r border-gray-200">
                                            <div class="text-sm font-medium text-gray-900"><?php echo e($subject ? $subject->name : 'Unnamed'); ?></div>
                                            <div class="text-[11px] text-gray-500"><?php echo e($subjectTypeName); ?></div>
                                        </td>
                                        <?php $__currentLoopData = $examStructure; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examNameId => $examNameData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php $__currentLoopData = $examNameData['types']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examTypeId => $typeData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php $__currentLoopData = $typeData['parts']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examPartId => $partData): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $examDetail = isset($partData['details'][0]) ? $partData['details'][0] : null;
                                                        $examDetailId = $examDetail->id ?? null;
                                                        $examTypeName = $typeData['name'] ?? '';
                                                        $isTypeMatch = (strtolower(trim($subjectTypeName)) === strtolower(trim($examTypeName)));
                                                    ?>
                                                    <td class="px-2 py-2 text-center border-r border-gray-100" wire:key="cell-<?php echo e($classSubject->id); ?>-<?php echo e($examPartId); ?>">
                                                        <?php if(!$isTypeMatch): ?>
                                                            <span class="text-[11px] text-gray-400">N/A</span>
                                                        <?php else: ?>
                                                            <?php if($examDetailId): ?>
                                                                <?php if($isEditing): ?>
                                                                    <div class="flex flex-col items-center space-y-1">
                                                                        <div class="flex items-center justify-center space-x-1">
                                                                            <input type="checkbox" 
                                                                                wire:model.defer="selectedMappings.<?php echo e($classSubject->subject_id); ?>.<?php echo e($examDetailId); ?>.checked"
                                                                                class="h-4 w-4 rounded border-gray-300 text-blue-600">
                                                                        </div>
                                                                        <div x-data="{ checked: <?php if ((object) ('selectedMappings.'.$classSubject->subject_id.'.'.$examDetailId.'.checked') instanceof \Livewire\WireDirective) : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('selectedMappings.'.$classSubject->subject_id.'.'.$examDetailId.'.checked'->value()); ?>')<?php echo e('selectedMappings.'.$classSubject->subject_id.'.'.$examDetailId.'.checked'->hasModifier('defer') ? '.defer' : ''); ?><?php else : ?>window.Livewire.find('<?php echo e($_instance->id); ?>').entangle('<?php echo e('selectedMappings.'.$classSubject->subject_id.'.'.$examDetailId.'.checked'); ?>')<?php endif; ?>.defer }" 
                                                                            x-show="checked" 
                                                                            class="flex flex-col space-y-1 w-full">
                                                                            <input type="number" placeholder="FM" 
                                                                                wire:model.defer="selectedMappings.<?php echo e($classSubject->subject_id); ?>.<?php echo e($examDetailId); ?>.full_marks"
                                                                                class="text-[11px] w-16 px-1 py-0.5 border rounded border-gray-300">
                                                                            <input type="number" placeholder="PM" 
                                                                                wire:model.defer="selectedMappings.<?php echo e($classSubject->subject_id); ?>.<?php echo e($examDetailId); ?>.pass_marks"
                                                                                class="text-[11px] w-16 px-1 py-0.5 border rounded border-gray-300">
                                                                            <input type="number" placeholder="Time" 
                                                                                wire:model.defer="selectedMappings.<?php echo e($classSubject->subject_id); ?>.<?php echo e($examDetailId); ?>.time_in_minutes"
                                                                                class="text-[11px] w-16 px-1 py-0.5 border rounded border-gray-300">
                                                                        </div>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <?php if(isset($selectedMappings[$classSubject->subject_id][$examDetailId]['checked']) && $selectedMappings[$classSubject->subject_id][$examDetailId]['checked']): ?>
                                                                        <div class="flex items-center justify-center space-x-1">
                                                                            <span class="text-green-600 text-sm">✓</span>
                                                                            <span class="text-[10px] text-gray-600">FM <?php echo e($selectedMappings[$classSubject->subject_id][$examDetailId]['full_marks'] ?? '-'); ?></span>
                                                                            <span class="text-[10px] text-gray-600">PM <?php echo e($selectedMappings[$classSubject->subject_id][$examDetailId]['pass_marks'] ?? '-'); ?></span>
                                                                            <span class="text-[10px] text-gray-600">T <?php echo e($selectedMappings[$classSubject->subject_id][$examDetailId]['time_in_minutes'] ?? '-'); ?></span>
                                                                        </div>
                                                                    <?php else: ?>
                                                                        <span class="text-gray-200">-</span>
                                                                    <?php endif; ?>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <span class="text-[11px] text-gray-400">N/A</span>
                                                            <?php endif; ?>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <td class="px-4 py-4 text-center border-l border-gray-200">
                                            <?php if($isEditing && isset($classes[$activeTab])): ?>
                                                <button wire:click="saveClassData(<?php echo e($classes[$activeTab]->id); ?>)"
                                                    class="px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700 transition-colors">
                                                    Save Class
                                                </button>
                                            <?php else: ?>
                                                <span class="text-xs text-gray-400">-</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="100" class="px-6 py-12 text-center">
                                        <div class="text-center">
                                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h.01M15 7h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <h3 class="mt-2 text-sm font-medium text-gray-900">No subjects found</h3>
                                            <p class="mt-1 text-sm text-gray-500">No subjects are configured for this class.</p>
                                        </div>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                
                <!-- Legend -->
                <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                    <h4 class="text-sm font-medium text-gray-700 mb-2">Visual Guide:</h4>
                    <ul class="text-sm text-gray-600 space-y-1">
                        <li>• Each <strong>Exam Name</strong> has a unique background color</li>
                        <li>• Each <strong>Exam Type</strong> within an exam name has a unique lighter shade</li>
                        <li>• Each <strong>Exam Part</strong> has a unique very light shade</li>
                        <li>• Subjects are ordered by subject_type (descending)</li>
                        <li>• Green checkmark indicates matching subject/exam types</li>
                        <li>• Yellow warning indicates type mismatch</li>
                    </ul>
                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No exam structure found</h3>
                    <p class="mt-1 text-sm text-gray-500">No exam details are configured for this class.</p>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="text-center py-12">
                <h3 class="text-lg font-medium text-gray-900 mb-1">No Classes Found</h3>
                <p class="text-gray-500">Please configure classes in the system first.</p>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH D:\LaravelProject\LFS_Exam\resources\views/livewire/exam06-exam-myclass-subject-comp.blade.php ENDPATH**/ ?>