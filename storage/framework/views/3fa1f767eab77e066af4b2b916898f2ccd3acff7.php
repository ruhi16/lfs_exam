<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Exam Marks Register</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 4px; text-align: center; }
        th { background-color: #f0f0f0; }
        .text-left { text-align: left; }
        .bg-gray-100 { background-color: #f3f4f6; }
        .bg-blue-100 { background-color: #dbeafe; }
        .bg-yellow-100 { background-color: #fef9c3; }
        .font-bold { font-weight: bold; }
        .text-red { color: red; }
        .text-gray-400 { color: #9ca3af; }
        .text-xs { font-size: 10px; }
    </style>
</head>
<body>
    <h1>Exam Marks Register</h1>
    <?php if($activeClass): ?>
        <h2>Class: <?php echo e($activeClass->name); ?></h2>
        
        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $sectionStudents = $students->where('section_id', $section->section_id);
                if ($sectionStudents->isEmpty()) continue;
                
                $totalExamRows = 0;
                foreach($examDetailsGrouped as $examNameId => $examParts) {
                    $totalExamRows += count($examParts);
                }
            ?>
            
            <div style="margin-bottom: 20px;">
                <div style="background-color: #eee; padding: 5px; font-weight: bold; border: 1px solid #ccc; border-bottom: none;">
                    Section: <?php echo e($section->section->name ?? 'N/A'); ?>

                </div>
                
                <table>
                    <thead>
                        <?php
                            $summativeSubjects = $classSubjects->filter(function($ms){ return strtolower($ms->subject->subjectType->name ?? '') === 'summative'; });
                            $formativeSubjects = $classSubjects->filter(function($ms){ return strtolower($ms->subject->subjectType->name ?? '') === 'formative'; });
                        ?>
                        <tr>
                            <th class="text-left" style="width: 120px;">Student</th>
                            <th class="text-left" style="width: 80px;">Exam</th>
                            <th class="text-left" style="width: 60px;">Part</th>
                            <th colspan="<?php echo e($summativeSubjects->count() + 1); ?>">Summative</th>
                            <th colspan="<?php echo e($formativeSubjects->count() + 1); ?>">Formative</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="bg-blue-100">
                                <div>Summ Detail</div>
                                <div style="font-weight: normal; font-size: 8px;">ID</div>
                            </th>
                            <?php $__currentLoopData = $summativeSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th>
                                    <div><?php echo e($ms->subject->name ?? 'Sub'); ?></div>
                                    
                                </th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <th class="bg-yellow-100">
                                <div>Form Detail</div>
                                <div style="font-weight: normal; font-size: 8px;">ID</div>
                            </th>
                            <?php $__currentLoopData = $formativeSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <th>
                                    <div><?php echo e($ms->subject->name ?? 'Sub'); ?></div>
                                    
                                </th>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $sectionStudents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php $isFirstStudentRow = true; ?>
                            
                            <?php $__currentLoopData = $examDetailsGrouped; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examNameId => $examParts): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php 
                                    $examName = $examParts[array_key_first($examParts)][0]->examName->name ?? 'Exam';
                                    $isFirstExamRow = true;
                                    $examRowCount = count($examParts);
                                ?>
                                
                                <?php $__currentLoopData = $examParts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examPartId => $details): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php 
                                        $detail = $details[0]; 
                                    ?>
                                    <tr>
                                        <!-- Student Column -->
                                        <?php if($isFirstStudentRow): ?>
                                            <td rowspan="<?php echo e($totalExamRows); ?>" class="text-left" style="vertical-align: top;">
                                                <div class="font-bold"><?php echo e($student->studentdb->name ?? 'N/A'); ?></div>
                                                <div>Roll: <?php echo e($student->roll_no); ?></div>
                                            </td>
                                            <?php $isFirstStudentRow = false; ?>
                                        <?php endif; ?>
                                        
                                        <!-- Exam Name Column -->
                                        <?php if($isFirstExamRow): ?>
                                            <td rowspan="<?php echo e($examRowCount); ?>" class="text-left" style="vertical-align: top; background-color: #f9f9f9;">
                                                <?php echo e($examName); ?>

                                            </td>
                                            <?php $isFirstExamRow = false; ?>
                                        <?php endif; ?>
                                        
                                        <!-- Exam Part Column -->
                                        <td class="bg-gray-100">
                                            <?php echo e($detail->examPart->name ?? 'Part'); ?>

                                        </td>
                                        
                                        <?php
                                            $summDetail = collect($details)->first(function($d){ return ($d->exam_type_id ?? null) === 1; });
                                            $summMarksSum = null;
                                            if ($summDetail) {
                                                $ecsMap = $examClassSubjectMap[$summDetail->id] ?? [];
                                                $total = 0;
                                                $hasAny = false;
                                                foreach ($ecsMap as $subId => $map) {
                                                    $key = $student->id . '_' . $map['id'];
                                                    $entry = $marksData[$key] ?? null;
                                                    if ($entry && !($entry['is_absent'] ?? false) && isset($entry['exam_marks'])) {
                                                        $total += $entry['exam_marks'];
                                                        $hasAny = true;
                                                    }
                                                }
                                                $summMarksSum = $hasAny ? $total : null;
                                            }
                                        ?>
                                        <td class="bg-blue-100">
                                            <div><?php echo e($summDetail->id ?? '-'); ?></div>
                                            <div class="text-xs"><?php echo e($summMarksSum !== null ? $summMarksSum : '-'); ?></div>
                                        </td>
                                        
                                        <!-- Summative Marks -->
                                        <?php $__currentLoopData = $summativeSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $subjectId = $ms->subject_id;
                                                $expectedTypeId = 1;
                                                $selectedDetail = collect($details)->first(function($d) use ($expectedTypeId, $subjectId, $examClassSubjectMap){
                                                    return ($d->exam_type_id ?? null) === $expectedTypeId
                                                        && isset($examClassSubjectMap[$d->id][$subjectId]);
                                                });
                                                $mapping = $selectedDetail ? ($examClassSubjectMap[$selectedDetail->id][$subjectId] ?? null) : null;
                                                $key = $mapping ? ($student->id . '_' . $mapping['id']) : null;
                                                $markEntry = $key ? ($marksData[$key] ?? null) : null;
                                                $bgColor = $mapping ? '' : 'background-color: #f3f4f6;';
                                            ?>
                                            
                                            <td style="<?php echo e($bgColor); ?>">
                                                <?php if($mapping): ?>
                                                    <?php if(isset($markEntry['is_absent']) && $markEntry['is_absent']): ?>
                                                        <span class="text-red font-bold">AB</span>
                                                    <?php elseif(isset($markEntry['exam_marks']) && $markEntry['exam_marks'] !== null): ?>
                                                        <span class="font-bold"><?php echo e($markEntry['exam_marks']); ?></span>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                    <div class="text-gray-400" style="font-size: 8px;">ECS: <?php echo e($mapping['id']); ?></div>
                                                <?php else: ?>
                                                    <span class="text-gray-400" style="font-size: 8px;">N/A</span>
                                                <?php endif; ?>
                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                        
                                        <?php
                                            $formDetail = collect($details)->first(function($d){ return ($d->exam_type_id ?? null) === 2; });
                                        ?>
                                        <td class="bg-yellow-100">
                                            <?php echo e($formDetail->id ?? '-'); ?>

                                        </td>
                                        
                                        <!-- Formative Marks -->
                                        <?php $__currentLoopData = $formativeSubjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ms): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                $subjectId = $ms->subject_id;
                                                $expectedTypeId = 2;
                                                $selectedDetail = collect($details)->first(function($d) use ($expectedTypeId, $subjectId, $examClassSubjectMap){
                                                    return ($d->exam_type_id ?? null) === $expectedTypeId
                                                        && isset($examClassSubjectMap[$d->id][$subjectId]);
                                                });
                                                $mapping = $selectedDetail ? ($examClassSubjectMap[$selectedDetail->id][$subjectId] ?? null) : null;
                                                $key = $mapping ? ($student->id . '_' . $mapping['id']) : null;
                                                $markEntry = $key ? ($marksData[$key] ?? null) : null;
                                                $bgColor = $mapping ? '' : 'background-color: #f3f4f6;';
                                            ?>
                                            
                                            <td style="<?php echo e($bgColor); ?>">
                                                <?php if($mapping): ?>
                                                    <?php if(isset($markEntry['is_absent']) && $markEntry['is_absent']): ?>
                                                        <span class="text-red font-bold">AB</span>
                                                    <?php elseif(isset($markEntry['exam_marks']) && $markEntry['exam_marks'] !== null): ?>
                                                        <span class="font-bold"><?php echo e($markEntry['exam_marks']); ?></span>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif; ?>
                                                    <div class="text-gray-400" style="font-size: 8px;">ECS: <?php echo e($mapping['id']); ?></div>
                                                <?php else: ?>
                                                    <span class="text-gray-400" style="font-size: 8px;">N/A</span>
                                                <?php endif; ?>
                                            </td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <p>No active class selected.</p>
    <?php endif; ?>
</body>
</html>
<?php /**PATH D:\LaravelProject\LFS_Exam\resources\views/exports/exam12-exam-marks-register-pdf.blade.php ENDPATH**/ ?>