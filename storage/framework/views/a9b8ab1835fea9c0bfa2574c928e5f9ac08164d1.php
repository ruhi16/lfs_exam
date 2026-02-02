<div class="container mx-auto px-4 py-6">
    <div class="mb-4">
        <h1 class="text-xl font-semibold text-gray-800">Student Mark Sheet</h1>
        <p class="text-gray-600 mt-1 text-xs">Compact view of marks with grades</p>
    </div>

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
            <button 
                wire:click="$refresh"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                Refresh
            </button>
        </div>
    </div>

    <?php if(isset($classes[$activeTab])): ?>
        <?php
            $activeClass = $classes[$activeTab];
            $classSections = $this->getClassSections($activeClass->id);
            $examDetailsGrouped = $this->getExamDetailsForClass($activeClass->id);
            $groupedClassSubjects = $this->getClassSubjectsGroupedByType($activeClass->id);
        ?>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
            <div class="bg-white rounded border p-3">
                <h3 class="text-sm font-semibold text-gray-800 mb-2">School</h3>
                <div class="text-xs text-gray-700 space-y-1">
                    <div><span class="font-medium">Name:</span> <?php echo e($school->name ?? 'N/A'); ?></div>
                    <div><span class="font-medium">Address:</span> <?php echo e($school->address ?? 'N/A'); ?></div>
                    <div><span class="font-medium">Phone:</span> <?php echo e($school->phone ?? 'N/A'); ?></div>
                </div>
            </div>
            <div class="bg-white rounded border p-3">
                <h3 class="text-sm font-semibold text-gray-800 mb-2">Session</h3>
                <div class="text-xs text-gray-700 space-y-1">
                    <div><span class="font-medium">Name:</span> <?php echo e($session->name ?? 'N/A'); ?></div>
                    <div><span class="font-medium">Year:</span> <?php echo e($session->year ?? 'N/A'); ?></div>
                    <div><span class="font-medium">Status:</span> <?php echo e($session->status ?? 'N/A'); ?></div>
                </div>
            </div>
            <div class="bg-white rounded border p-3">
                <h3 class="text-sm font-semibold text-gray-800 mb-2">Student Selection</h3>
                <div class="space-y-2">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Section</label>
                        <select 
                            wire:model="selectedSectionId"
                            wire:change="setSelectedSection($event.target.value)"
                            class="w-full px-2 py-1 text-xs border border-gray-300 rounded-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">-- Select Section --</option>
                            <?php $__currentLoopData = $classSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sec): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($sec->id); ?>"><?php echo e($sec->section->name ?? 'N/A'); ?></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Student</label>
                        <select 
                            wire:model="selectedStudentId"
                            wire:change="setSelectedStudent($event.target.value)"
                            class="w-full px-2 py-1 text-xs border border-gray-300 rounded-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">-- Select Student --</option>
                            <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $stu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($stu->id); ?>"><?php echo e($stu->studentdb->name ?? 'N/A'); ?> (Roll: <?php echo e($stu->roll_no ?? 'N/A'); ?>)</option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>
                    <?php if($selectedStudentId): ?>
                        <?php
                            $curStudent = $students->firstWhere('id', $selectedStudentId);
                        ?>
                        <div class="text-xs text-gray-700 space-y-1">
                            <div><span class="font-medium">Name:</span> <?php echo e($curStudent->studentdb->name ?? 'N/A'); ?></div>
                            <div><span class="font-medium">Roll:</span> <?php echo e($curStudent->roll_no ?? 'N/A'); ?></div>
                            <div><span class="font-medium">Class:</span> <?php echo e($curStudent->myclass->name ?? $activeClass->name); ?></div>
                            <div><span class="font-medium">Section:</span> <?php echo e($curStudent->section->name ?? ($classSections->firstWhere('id', $selectedSectionId)->section->name ?? 'N/A')); ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Tables: Summative and Formative -->
        <?php
            $summativeType = $subjectTypes->firstWhere('name', 'Summative');
            $formativeType = $subjectTypes->firstWhere('name', 'Formative');
        ?>

        <?php $__currentLoopData = [['label' => 'Summative', 'type' => $summativeType], ['label' => 'Formative', 'type' => $formativeType]]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $block): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $typeId = $block['type']->id ?? null;
                $classSubjectsOfType = $typeId ? ($groupedClassSubjects[$typeId] ?? collect()) : collect();
                $examDetailsGroupedByType = $typeId ? $this->getExamDetailsBySubjectType($activeClass->id, $typeId) : collect();
                $isSummative = strtolower($block['label']) === 'summative';
            ?>
            <?php if($typeId && $classSubjectsOfType->count() > 0): ?>
                <div class="bg-white rounded border overflow-hidden mb-6">
                    <div class="bg-gray-50 px-4 py-2 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-sm font-medium text-gray-900"><?php echo e($block['label']); ?> Subjects</h3>
                        <div class="text-xs text-gray-500">Class: <?php echo e($activeClass->name); ?></div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-xs">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left font-medium text-gray-600 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                        Subject
                                    </th>
                                    <?php $__currentLoopData = $examDetailsGroupedByType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examNameId => $examDetailsByType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $examName = $examNames->firstWhere('id', $examNameId);
                                            $colspan = $examDetailsByType->groupBy('exam_type_id')
                                                ->map(function($typeGroup, $etypeId) use ($examTypes, $block) {
                                                    $et = $examTypes->firstWhere('id', $etypeId);
                                                    return (strtolower($et->name) === strtolower($block['label'])) 
                                                        ? $typeGroup->groupBy('exam_part_id')->count() 
                                                        : 0;
                                                })->sum();
                                            $examNameLabel = strtolower($examName->name ?? '');
                                            $needsTotal = $isSummative && in_array($examNameLabel, ['end of first term','halfyearly term','end of second term','annually term']);
                                            if($needsTotal){ $colspan += 1; }
                                        ?>
                                        <?php if($examName && $colspan > 0): ?>
                                            <th colspan="<?php echo e($colspan); ?>" class="px-3 py-2 text-center font-medium text-gray-600 uppercase tracking-wider bg-blue-50">
                                                <?php echo e($examName->name); ?>

                                            </th>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($isSummative): ?>
                                        <th class="px-3 py-2 text-center font-medium text-gray-600 uppercase tracking-wider bg-blue-50">
                                            Grand Total
                                        </th>
                                        <th class="px-3 py-2 text-center font-medium text-gray-600 uppercase tracking-wider bg-blue-50">
                                            Grade
                                        </th>
                                    <?php endif; ?>
                                </tr>
                                <tr>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                        -
                                    </th>
                                    <?php $__currentLoopData = $examDetailsGroupedByType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examNameId => $examDetailsByType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $examName = $examNames->firstWhere('id', $examNameId);
                                            $examNameLabel = strtolower($examName->name ?? '');
                                            $needsTotal = $isSummative && in_array($examNameLabel, ['end of first term','halfyearly term','end of second term','annually term']);
                                        ?>
                                        <?php $__currentLoopData = $examDetailsByType->groupBy('exam_type_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examTypeId => $typeDetails): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $examType = $examTypes->firstWhere('id', $examTypeId);
                                                $isMatchingType = $examType && (strtolower($examType->name) === strtolower($block['label']));
                                                $partsCount = $isMatchingType ? ($typeDetails->groupBy('exam_part_id')->count() + ($needsTotal ? 1 : 0)) : 0;
                                            ?>
                                            <?php if($isMatchingType && $partsCount > 0): ?>
                                                <th colspan="<?php echo e($partsCount); ?>" class="px-2 py-1 text-center font-medium text-blue-700 uppercase tracking-wider bg-blue-100 border-l border-r border-gray-200">
                                                    <?php echo e($examType->name); ?>

                                                </th>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($isSummative): ?>
                                        <th class="px-2 py-1 text-center font-medium text-blue-700 uppercase tracking-wider bg-blue-100 border-l border-r border-gray-200">
                                            -
                                        </th>
                                        <th class="px-2 py-1 text-center font-medium text-blue-700 uppercase tracking-wider bg-blue-100 border-l border-r border-gray-200">
                                            -
                                        </th>
                                    <?php endif; ?>
                                </tr>
                                <tr>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                        -
                                    </th>
                                    <?php $__currentLoopData = $examDetailsGroupedByType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examNameId => $examDetailsByType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $examName = $examNames->firstWhere('id', $examNameId);
                                            $examNameLabel = strtolower($examName->name ?? '');
                                            $needsTotal = $isSummative && in_array($examNameLabel, ['end of first term','halfyearly term','end of second term','annually term']);
                                        ?>
                                        <?php $__currentLoopData = $examDetailsByType->groupBy('exam_type_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examTypeId => $typeDetails): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $examType = $examTypes->firstWhere('id', $examTypeId);
                                                $isMatchingType = $examType && (strtolower($examType->name) === strtolower($block['label']));
                                            ?>
                                            <?php if($isMatchingType): ?>
                                                <?php $__currentLoopData = $typeDetails->groupBy('exam_part_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examPartId => $partDetails): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <?php
                                                        $examPartObj = $examParts->firstWhere('id', $examPartId);
                                                        $firstDetail = $partDetails->first();
                                                    ?>
                                                    <th class="px-2 py-1 text-center font-medium text-purple-700 uppercase tracking-wider bg-purple-50 border border-gray-200">
                                                        <div class="text-[10px] text-gray-500 mb-1">
                                                            <?php echo e($examPartObj ? $examPartObj->name : 'N/A'); ?>

                                                        </div>
                                                        <div class="text-[10px] text-gray-500">
                                                            <?php echo e($firstDetail->examMode->name ?? 'Mode N/A'); ?>

                                                        </div>
                                                    </th>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($needsTotal): ?>
                                                    <th class="px-2 py-1 text-center font-semibold text-gray-700 bg-gray-100 border border-gray-200">
                                                        Total
                                                    </th>
                                                <?php endif; ?>
                                            <?php endif; ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    <?php if($isSummative): ?>
                                        <th class="px-2 py-1 text-center font-semibold text-gray-700 bg-gray-100 border border-gray-200">
                                            -
                                        </th>
                                        <th class="px-2 py-1 text-center font-semibold text-gray-700 bg-gray-100 border border-gray-200">
                                            -
                                        </th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <?php
                                    $sumMarks = 0;
                                    $sumFull = 0;
                                    $summativeExamType = $examTypes->firstWhere('name', 'Summative');
                                ?>
                                <?php $__currentLoopData = $classSubjectsOfType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $classSubject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-2 whitespace-nowrap font-medium text-gray-900 sticky left-0 bg-white z-10 border-r border-gray-200">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <span class="text-blue-800 font-medium text-xs"><?php echo e(substr($classSubject->subject->name ?? 'N/A', 0, 1)); ?></span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="font-medium text-gray-900 text-sm"><?php echo e($classSubject->subject->name ?? 'N/A'); ?></div>
                                                    <div class="text-gray-500 text-[10px]"><?php echo e($classSubject->subject->code ?? ''); ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <?php
                                            $subjectGrandMarks = 0;
                                            $subjectGrandFull = 0;
                                        ?>
                                        <?php $__currentLoopData = $examDetailsGroupedByType; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examNameId => $examDetailsByType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $examName = $examNames->firstWhere('id', $examNameId);
                                                $examNameLabel = strtolower($examName->name ?? '');
                                                $needsTotal = $isSummative && in_array($examNameLabel, ['end of first term','halfyearly term','end of second term','annually term']);
                                            ?>
                                            <?php $__currentLoopData = $examDetailsByType->groupBy('exam_type_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examTypeId => $typeDetails): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php
                                                    $examType = $examTypes->firstWhere('id', $examTypeId);
                                                    $isMatchingType = $examType && (strtolower($examType->name) === strtolower($block['label']));
                                                ?>
                                                <?php if($isMatchingType): ?>
                                                    <?php $__currentLoopData = $typeDetails->groupBy('exam_part_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examPartId => $partDetails): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                            $examDetail = $partDetails->first();
                                                            $entry = ($selectedStudentId) ? $this->getMarkEntry($classSubject->subject_id, $examDetail->id) : null;
                                                            $val = $entry['marks'] ?? null;
                                                            $isAbsent = $entry['is_absent'] ?? false;
                                                            $gradeId = $entry['grade_id'] ?? null;
                                                            $gradeObj = $gradeId ? ($this->gradesMap[$gradeId] ?? null) : null;
                                                            $fm = $this->getFullMarks($classSubject->subject_id, $examDetail->id);
                                                            if($isSummative && !$isAbsent && !is_null($val) && !is_null($fm)){
                                                                $sumMarks += (int)$val;
                                                                $sumFull += (int)$fm;
                                                                $subjectGrandMarks += (int)$val;
                                                                $subjectGrandFull += (int)$fm;
                                                            }
                                                        ?>
                                                        <td class="px-2 py-2 whitespace-nowrap text-center border border-gray-200 bg-white">
                                                            <?php if($selectedStudentId): ?>
                                                                <?php if(!is_null($val)): ?>
                                                                    <?php if($val == -99 || $isAbsent): ?>
                                                                        <span class="inline-block px-2 py-1 bg-gray-100 text-gray-600 rounded font-semibold">AB</span>
                                                                    <?php else: ?>
                                                                        <div class="flex flex-col items-center space-y-1">
                                                                            <span class="inline-block px-2 py-1 bg-green-50 text-green-700 rounded font-semibold"><?php echo e(intval($val)); ?></span>
                                                                            <span class="text-[10px] text-gray-500"><?php echo e($gradeObj->grade ?? ''); ?></span>
                                                                            <span class="text-[10px] text-gray-400">FM: <?php echo e($fm ?? '-'); ?></span>
                                                                        </div>
                                                                    <?php endif; ?>
                                                                <?php else: ?>
                                                                    <span class="text-[10px] text-gray-300">-</span>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <span class="text-[10px] text-gray-400">Select student</span>
                                                            <?php endif; ?>
                                                        </td>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php if($needsTotal): ?>
                                                        <?php
                                                            $termMarks = 0;
                                                            $termFull = 0;
                                                        ?>
                                                        <?php $__currentLoopData = $typeDetails->groupBy('exam_part_id'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examPartId => $partDetails): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php
                                                                $examDetail = $partDetails->first();
                                                                $entry = ($selectedStudentId) ? $this->getMarkEntry($classSubject->subject_id, $examDetail->id) : null;
                                                                $val = $entry['marks'] ?? null;
                                                                $isAbsent = $entry['is_absent'] ?? false;
                                                                $fm = $this->getFullMarks($classSubject->subject_id, $examDetail->id);
                                                                if(!$isAbsent && !is_null($val) && !is_null($fm)){
                                                                    $termMarks += (int)$val;
                                                                    $termFull += (int)$fm;
                                                                }
                                                            ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        <?php
                                                            $termPercent = $termFull > 0 ? round(($termMarks / $termFull) * 100, 2) : null;
                                                            $termGrade = ($summativeExamType && !is_null($termPercent)) ? $this->computeGradeByPercent($termPercent, $summativeExamType->id) : '';
                                                        ?>
                                                        <td class="px-2 py-2 whitespace-nowrap text-center border border-gray-300 bg-gray-50 font-semibold text-gray-700">
                                                            <?php if($selectedStudentId): ?>
                                                                <?php if($termFull > 0): ?>
                                                                    <?php echo e($termMarks); ?> / <?php echo e($termFull); ?> <span class="text-[10px] text-gray-500">(<?php echo e($termPercent ?? 0); ?>%)</span> <span class="text-[10px] text-gray-700">Grade: <?php echo e($termGrade); ?></span>
                                                                <?php else: ?>
                                                                    <span class="text-[10px] text-gray-300">-</span>
                                                                <?php endif; ?>
                                                            <?php else: ?>
                                                                <span class="text-[10px] text-gray-400">Select student</span>
                                                            <?php endif; ?>
                                                        </td>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($isSummative): ?>
                                            <?php
                                                $grandPercent = $subjectGrandFull > 0 ? round(($subjectGrandMarks / $subjectGrandFull) * 100, 2) : null;
                                                $grandGrade = ($summativeExamType && !is_null($grandPercent)) ? $this->computeGradeByPercent($grandPercent, $summativeExamType->id) : '';
                                            ?>
                                            <td class="px-2 py-2 whitespace-nowrap text-center border border-gray-300 bg-gray-100 font-semibold text-gray-700">
                                                <?php if($selectedStudentId): ?>
                                                    <?php if($subjectGrandFull > 0): ?>
                                                        <?php echo e($subjectGrandMarks); ?> / <?php echo e($subjectGrandFull); ?>

                                                    <?php else: ?>
                                                        <span class="text-[10px] text-gray-300">-</span>
                                                    <?php endif; ?>
                                                <?php else: ?>
                                                    <span class="text-[10px] text-gray-400">Select student</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="px-2 py-2 whitespace-nowrap text-center border border-gray-300 bg-gray-100 font-semibold text-gray-700">
                                                <?php if($selectedStudentId): ?>
                                                    <?php echo e($grandGrade); ?>

                                                <?php else: ?>
                                                    <span class="text-[10px] text-gray-400">Select student</span>
                                                <?php endif; ?>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php if($isSummative): ?>
                                    <?php
                                        $totalPercent = $sumFull > 0 ? round(($sumMarks / $sumFull) * 100, 2) : null;
                                        $totalGrade = ($summativeExamType && !is_null($totalPercent)) ? $this->computeGradeByPercent($totalPercent, $summativeExamType->id) : '';
                                        $displayColCount = $examDetailsGroupedByType->map(function($examDetailsByType, $examNameId) use ($examTypes, $examNames) {
                                            $examName = $examNames->firstWhere('id', $examNameId);
                                            $examNameLabel = strtolower($examName->name ?? '');
                                            $needsTotalLocal = in_array($examNameLabel, ['end of first term','halfyearly term','end of second term','annually term']);
                                            $count = 0;
                                            foreach($examDetailsByType->groupBy('exam_type_id') as $examTypeId => $typeDetails){
                                                $examType = $examTypes->firstWhere('id', $examTypeId);
                                                if($examType && strtolower($examType->name) === 'summative'){
                                                    $count += $typeDetails->groupBy('exam_part_id')->count();
                                                }
                                            }
                                            return $count + ($needsTotalLocal ? 1 : 0);
                                        })->sum();
                                    ?>
                                    <tr class="bg-gray-50">
                                        <td class="px-3 py-2 text-right font-semibold text-gray-700 sticky left-0 bg-gray-50 z-10 border-r border-gray-200">Total</td>
                                        <td colspan="<?php echo e($displayColCount + 2); ?>" class="px-3 py-2 text-center font-semibold text-gray-700">
                                            <?php echo e($sumMarks); ?> / <?php echo e($sumFull); ?> &nbsp; (<?php echo e($totalPercent ?? 0); ?>%) &nbsp; Grade: <?php echo e($totalGrade); ?>

                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php
            $overallMarks = 0; $overallFull = 0;
            if(isset($summativeType)){
                $classSubjectsSummative = $groupedClassSubjects[$summativeType->id] ?? collect();
                $examDetailsSummative = $this->getExamDetailsBySubjectType($activeClass->id, $summativeType->id);
                foreach($classSubjectsSummative as $classSubject){
                    foreach($examDetailsSummative as $examNameId => $examDetailsByType){
                        foreach($examDetailsByType->groupBy('exam_type_id') as $examTypeId => $typeDetails){
                            foreach($typeDetails->groupBy('exam_part_id') as $examPartId => $partDetails){
                                $examDetail = $partDetails->first();
                                $entry = ($selectedStudentId) ? $this->getMarkEntry($classSubject->subject_id, $examDetail->id) : null;
                                $val = $entry['marks'] ?? null;
                                $isAbsent = $entry['is_absent'] ?? false;
                                $fm = $this->getFullMarks($classSubject->subject_id, $examDetail->id);
                                if(!$isAbsent && !is_null($val) && !is_null($fm)){
                                    $overallMarks += (int)$val;
                                    $overallFull += (int)$fm;
                                }
                            }
                        }
                    }
                }
            }
            $overallPercent = $overallFull > 0 ? round(($overallMarks / $overallFull) * 100, 2) : null;
            $overallGrade = ($summativeExamType && !is_null($overallPercent)) ? $this->computeGradeByPercent($overallPercent, $summativeExamType->id) : '';
        ?>
        <div class="mt-6 bg-white rounded border">
            <div class="px-4 py-2 border-b text-sm font-medium text-gray-800">Overall Result & Promotion</div>
            <div class="p-4 grid grid-cols-1 md:grid-cols-2 gap-4 text-xs text-gray-700">
                <div class="border rounded p-3">
                    <div class="font-semibold mb-2">Overall Result</div>
                    <div>Marks: <?php echo e($overallMarks); ?> / <?php echo e($overallFull); ?></div>
                    <div>Percent: <?php echo e($overallPercent ?? 0); ?>%</div>
                    <div>Grade: <?php echo e($overallGrade); ?></div>
                </div>
                <div class="border rounded p-3">
                    <div class="font-semibold mb-2">Promotional Declaration</div>
                    <div>Declaration: ________________________________</div>
                </div>
                <div class="border rounded p-3">
                    <div class="font-semibold mb-2">Next Class Details</div>
                    <div>Class: __________________ Section: ____________</div>
                </div>
                <div class="border rounded p-3">
                    <div class="font-semibold mb-2">Other Remarks</div>
                    <div>______________________________________________</div>
                </div>
            </div>
            <div class="px-4 py-3 border-t grid grid-cols-1 md:grid-cols-3 gap-4 text-xs text-gray-700">
                <div class="flex flex-col items-center">
                    <div class="w-full text-center">Student Signature</div>
                    <div class="mt-6 w-40 border-b border-gray-300"></div>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-full text-center">Class Teacher Signature</div>
                    <div class="mt-6 w-40 border-b border-gray-300"></div>
                </div>
                <div class="flex flex-col items-center">
                    <div class="w-full text-center">Guardian Signature</div>
                    <div class="mt-6 w-40 border-b border-gray-300"></div>
                </div>
            </div>
        </div>
        <div class="mt-6 bg-white rounded border">
            <div class="px-4 py-2 border-b text-sm font-medium text-gray-800">Declaration & Rules</div>
            <table class="w-full text-xs">
                <tbody>
                    <tr>
                        <td class="px-4 py-2 border text-gray-700">1. AB indicates absence in the corresponding exam part.</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border text-gray-700">2. Grades are calculated as per the exam type’s grade scheme.</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border text-gray-700">3. This marksheet is system generated and valid without signature.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH D:\LaravelProject\LFS_Exam\resources\views/livewire/exam20-student-mark-sheet-indv-comp.blade.php ENDPATH**/ ?>