<div class="p-6">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Class Section Teacher Assignment</h1>
                <p class="text-gray-600 mt-1">
                    Assign class teachers to class-sections.
                </p>
            </div>
            <div class="flex space-x-2">
                <button wire:click="loadData"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
            </div>
        </div>
    </div>
    <!-- Flash Messages -->
    <?php if(session()->has('message')): ?>
    <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
        <div class="flex">
            <i class="fas fa-check-circle mr-2 mt-0.5"></i>
            <?php echo e(session('message')); ?>

        </div>
    </div>
    <?php endif; ?>

    <?php if(session()->has('error')): ?>
    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
        <div class="flex">
            <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
            <?php echo e(session('error')); ?>

        </div>
    </div>
    <?php endif; ?>

    <!-- Class Section Tasks Table -->
    <?php if($myclassSections): ?>
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Section Tasks</h3>
            <p class="text-sm text-gray-600 mt-1">Manage teachers and view students for each section</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Class-Section
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Teacher
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Students
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Formative Exams
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Actions
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php $__currentLoopData = $myclassSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                <?php echo e($section->myclass->name ?? 'N/A'); ?> - <?php echo e($section->section->name ?? 'N/A'); ?>

                            </div>
                            <div class="text-sm text-gray-500">
                                <?php echo e($section->studentcrs_count ?? 0); ?> students
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <?php if($section->teacher): ?>
                            <div class="flex items-center">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">
                                        <?php echo e($section->teacher->name); ?>

                                    </div>
                                </div>
                            </div>
                            <?php else: ?>
                            <span
                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                Unassigned
                            </span>
                            <?php endif; ?>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <button wire:click="viewStudents(<?php echo e($section->id); ?>)"
                                class="text-blue-600 hover:text-blue-900 text-sm font-medium">
                                View Students (<?php echo e($section->studentcrs_count ?? 0); ?>)
                            </button>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-500">
                                <div>Class Section: <?php echo e($section->id ?? 'N/A'); ?></div>
                                <?php if(isset($examDetails[$section->id]) && count($examDetails[$section->id]) > 0): ?>
                                <?php
                                // Collect unique formative exam detail IDs
                                $formativeExamDetailIds = [];
                                foreach($examDetails[$section->id] as $examDetail) {
                                if(($examDetail->exam_type_id ?? null) == 2) {
                                $formativeExamDetailIds[$examDetail->id] = $examDetail;
                                }
                                }
                                ?>

                                <?php if(count($formativeExamDetailIds) > 0): ?>
                                <?php $__currentLoopData = $formativeExamDetailIds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $examDetailId => $examDetail): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="flex items-center justify-between">
                                    <span>Formative Exam: <?php echo e($examDetailId); ?></span>
                                    <a href="<?php echo e(route('test.formative.marks.entry', ['exam_detail_id' => $examDetailId, 'myclass_section_id' => $section->id])); ?>"
                                        class="ml-2 inline-flex items-center px-2 py-1 border border-transparent text-xs font-medium rounded text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Open
                                    </a>
                                </div>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                <div>No Formative Exams</div>
                                <?php endif; ?>

                                <!-- Show details from the first exam detail -->
                                <?php
                                $firstExamDetail = $examDetails[$section->id][0];
                                ?>
                                <div class="mt-2 pt-2 border-t border-gray-200">
                                    <div>Exam Name ID: <?php echo e($firstExamDetail->exam_name_id ?? 'N/A'); ?></div>
                                    <div>Exam Type ID: <?php echo e($firstExamDetail->exam_type_id ?? 'N/A'); ?></div>
                                    <div>Exam Part ID: <?php echo e($firstExamDetail->exam_part_id ?? 'N/A'); ?></div>
                                    <div>Exam Mode ID: <?php echo e($firstExamDetail->exam_mode_id ?? 'N/A'); ?></div>
                                </div>
                                <?php else: ?>
                                <div>Exam Detail: N/A</div>
                                <div>Exam Name ID: N/A</div>
                                <div>Exam Type ID: N/A</div>
                                <div>Exam Part ID: N/A</div>
                                <div>Exam Mode ID: N/A</div>
                                <?php endif; ?>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button wire:click="showTeacherModal(<?php echo e($section->id); ?>)"
                                class="text-indigo-600 hover:text-indigo-900">
                                <?php echo e($section->teacher ? 'Change Teacher' : 'Assign Teacher'); ?>

                            </button>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php else: ?>
    <div class="text-center py-12">
        <div class="text-gray-400 mb-4">
            <i class="fas fa-table text-6xl"></i>
        </div>
        <h3 class="text-lg font-medium text-gray-900 mb-2">No Data Available</h3>
        <p class="text-gray-600">Unable to load class sections for this exam.</p>
    </div>
    <?php endif; ?>

    <!-- Teacher Assignment Modal -->
    <?php if($showTeacherModal): ?>
    <div class="fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900">
                                Assign Teacher
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 mb-4">
                                    Select a teacher to assign to this section.
                                </p>
                                <div class="mt-1 rounded-md shadow-sm">
                                    <select wire:model="selectedTeacherId"
                                        class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-3 pr-10 py-2 text-base border-gray-300 sm:text-sm rounded-md">
                                        <option value="">Select a teacher</option>
                                        <?php $__currentLoopData = $availableTeachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($teacher->id); ?>"><?php echo e($teacher->name); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="assignTeacher" type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Assign
                    </button>
                    <button wire:click="$set('showTeacherModal', false)" type="button"
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Students Modal -->
    <div x-data="{ open: false }" <?php echo $__env->yieldSection(); ?>-students-modal.window="open = true">
        <div x-show="open" class="fixed inset-0 z-50 overflow-y-auto">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                </div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

                <div
                    class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Students
                                </h3>
                                <div class="mt-4">
                                    <?php if($students && count($students) > 0): ?>
                                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-300">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col"
                                                        class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                        Roll No</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                        Name</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                        Class</th>
                                                    <th scope="col"
                                                        class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                        Section</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 bg-white">
                                                <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <tr>
                                                    <td
                                                        class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                        <?php echo e($student->roll_no ?? 'N/A'); ?></td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?php echo e($student->studentdb->name ?? 'N/A'); ?></td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?php echo e($student->myclass->name ?? 'N/A'); ?></td>
                                                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500"><?php echo e($student->section->name ?? 'N/A'); ?></td>
                                                </tr>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <?php else: ?>
                                    <p class="text-gray-500">No students found for this section.</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button @click="open = false" type="button"
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /home/bkoq0ic0h8xi/public_html/littleflowerschool.co.in/resources/views/livewire/class-section-tasks-comp.blade.php ENDPATH**/ ?>