<div class="container mx-auto py-6">
    <div class="bg-white shadow rounded-lg p-6">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Teacher Marks Entry</h1>

        <!-- Teacher Selection -->
        <div class="mb-8">
            <label class="block text-sm font-medium text-gray-700 mb-2">Select Teacher</label>
            <select wire:model="selectedTeacherId"
                class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                <option value="">-- Select Teacher --</option>
                <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($teacher->id); ?>">
                        <?php echo e($teacher->user ? $teacher->user->name : ($teacher->name ?? 'N/A')); ?>

                    </option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </select>
        </div>

        <!-- Answer Scripts Table -->
        <?php if($selectedTeacherId && count($answerScripts) > 0): ?>
            <div class="mt-8">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">Assigned Answer Scripts</h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Class-Section</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Exam Type</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Exam Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Subject</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Exam Part</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Exam Mode</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-yellow-50">
                                    Exam Detail ID</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-yellow-50">
                                    Class Section ID</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-yellow-50">
                                    Class Subject ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions</th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-green-50">
                                    Individual View</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__currentLoopData = $answerScripts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $script): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        <?php echo e(($script['myclass_section']['myclass']['name'] ?? 'N/A') . ' - ' . ($script['myclass_section']['section']['name'] ?? 'N/A')); ?>

                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        <?php echo e($script['exam_detail']['exam_type']['name'] ?? 'N/A'); ?>

                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        <?php echo e($script['exam_detail']['exam_name']['name'] ?? 'N/A'); ?>

                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        <?php echo e($script['exam_class_subject']['subject']['name'] ?? 'N/A'); ?>

                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        <?php echo e($script['exam_detail']['exam_part']['name'] ?? 'N/A'); ?>

                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        <?php echo e($script['exam_detail']['exam_mode']['name'] ?? 'N/A'); ?>

                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-yellow-50 font-mono">
                                                        <?php echo e($script['exam_detail_id'] ?? 'N/A'); ?>

                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-yellow-50 font-mono">
                                                        <?php echo e($script['myclass_section_id'] ?? 'N/A'); ?>

                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-yellow-50 font-mono">
                                                        <?php echo e($script['exam_class_subject_id'] ?? 'N/A'); ?>

                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                        <a href="<?php echo e(route('marksEntryOld', [
                                    'exam_detail_id' => $script['exam_detail']['id'] ?? '',
                                    'myclass_section_id' => $script['myclass_section_id'] ?? '',
                                    'myclass_subject_id' => $script['exam_class_subject_id'] ?? ''
                                ])); ?>" target="_blank"
                                                            class="px-3 py-1 bg-blue-600 text-white rounded hover:bg-blue-700 text-xs inline-block">
                                                            Enter Marks
                                                        </a>
                                                    </td>
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 bg-green-50">
                                                        <a href="<?php echo e(route('marksEntryOld', [
                                    'exam_detail_id' => $script['exam_detail']['id'] ?? '',
                                    'myclass_section_id' => $script['myclass_section_id'] ?? '',
                                    'myclass_subject_id' => $script['exam_class_subject_id'] ?? '',
                                    'teacher_id' => $script['teacher']['id'] ?? ''
                                ])); ?>" target="_blank"
                                                            class="px-3 py-1 bg-green-600 text-white rounded hover:bg-green-700 text-xs inline-block">
                                                            Individual View
                                                        </a>
                                                    </td>
                                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php elseif($selectedTeacherId): ?>
            <div class="mt-8 text-center py-8 text-gray-500">
                No answer scripts assigned to this teacher.
            </div>
        <?php endif; ?>

        <!-- Individual View Component -->
        <?php if($showIndividualView): ?>
            <div class="mt-8 p-6 bg-gray-50 rounded-lg border border-gray-200">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-800">Individual Subject View</h3>
                    <button wire:click="closeIndividualView"
                        class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                        Close
                    </button>
                </div>
                <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('exam10-exam-marks-entry-indv2-comp', ['examClassSubjectId' => $individualExamClassSubjectId,'examDetailId' => $individualExamDetailId,'myclassSectionId' => $individualMyclassSectionId,'myclassSubjectId' => $individualMyclassSubjectId,'exam_class_subject_id' => $individualExamClassSubjectId,'exam_detail_id' => $individualExamDetailId,'myclass_section_id' => $individualMyclassSectionId,'myclass_subject_id' => $individualMyclassSubjectId])->html();
} elseif ($_instance->childHasBeenRendered('individual-' . $individualExamClassSubjectId)) {
    $componentId = $_instance->getRenderedChildComponentId('individual-' . $individualExamClassSubjectId);
    $componentTag = $_instance->getRenderedChildComponentTagName('individual-' . $individualExamClassSubjectId);
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('individual-' . $individualExamClassSubjectId);
} else {
    $response = \Livewire\Livewire::mount('exam10-exam-marks-entry-indv2-comp', ['examClassSubjectId' => $individualExamClassSubjectId,'examDetailId' => $individualExamDetailId,'myclassSectionId' => $individualMyclassSectionId,'myclassSubjectId' => $individualMyclassSubjectId,'exam_class_subject_id' => $individualExamClassSubjectId,'exam_detail_id' => $individualExamDetailId,'myclass_section_id' => $individualMyclassSectionId,'myclass_subject_id' => $individualMyclassSubjectId]);
    $html = $response->html();
    $_instance->logRenderedChild('individual-' . $individualExamClassSubjectId, $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
            </div>
        <?php endif; ?>
    </div>
</div><?php /**PATH D:\LaravelProject\LFS_Exam\resources\views/livewire/exam15-teacher-marks-entry-comp.blade.php ENDPATH**/ ?>