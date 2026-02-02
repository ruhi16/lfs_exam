<div class="flex-1 p-6 overflow-y-auto max-w-full mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Student Class Records</h1>
                <p class="mt-1 text-sm text-gray-600">View and manage class-wise student information from student
                    database</p>
            </div>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if(session()->has('message')): ?>
        <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
            <?php echo e(session('message')); ?>

        </div>
    <?php endif; ?>

    <?php if(session()->has('error')): ?>
        <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
            <?php echo e(session('error')); ?>

        </div>
    <?php endif; ?>

    <!-- Debug Panel -->
    <?php if($debugMode): ?>
        <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
            <h4 class="text-sm font-medium text-yellow-800 mb-2">Debug Panel</h4>
            <div class="flex space-x-2 mb-2">
                <button wire:click="checkDatabaseConnection" class="bg-blue-500 text-white px-3 py-1 rounded text-xs">
                    Test DB Connection
                </button>
                <button wire:click="testDataLoad" class="bg-green-500 text-white px-3 py-1 rounded text-xs">
                    Test Data Load
                </button>
                <button wire:click="refreshData" class="bg-purple-500 text-white px-3 py-1 rounded text-xs">
                    Refresh Data
                </button>
                <button wire:click="testStudentRecords" class="bg-orange-500 text-white px-3 py-1 rounded text-xs">
                    Test Records
                </button>
                <button wire:click="loadAllStudents" class="bg-pink-500 text-white px-3 py-1 rounded text-xs">
                    Load All Students
                </button>
            </div>
            <div class="text-xs text-yellow-700">
                Selected Class: <?php echo e($selectedClassId ?? 'None'); ?> |
                Selected Section: <?php echo e($selectedSectionId ?? 'None'); ?> |
                Student Records: <?php echo e(count($studentRecords)); ?> |
                Students DB: <?php echo e(count($students)); ?>

            </div>
        </div>
    <?php endif; ?>

    <!-- Debug Toggle Button -->
    <div class="mb-4">
        <button wire:click="toggleDebugMode" class="bg-gray-500 text-white px-3 py-1 rounded text-xs">
            <?php echo e($debugMode ? 'Hide Debug' : 'Show Debug'); ?>

        </button>
    </div>

    <!-- Class Selection -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex space-x-8">
            <?php if($classes && count($classes) > 0): ?>
                <?php $__currentLoopData = $classes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button wire:click="selectClass(<?php echo e($class->id); ?>)"
                        class="<?php if($selectedClassId == $class->id): ?> border-indigo-500 text-indigo-600 <?php else: ?> border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 <?php endif; ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                        <?php echo e($class->name); ?>

                    </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <div class="text-gray-500 py-4">No classes available</div>
            <?php endif; ?>
        </nav>
    </div>

    <!-- Section Selection -->
    <?php if($selectedClassId): ?>
        <?php if($classSections && count($classSections) > 0): ?>
            <div class="mb-6">
                <h3 class="text-lg font-medium text-gray-900 mb-3">Select Section</h3>
                <div class="flex flex-wrap gap-2">
                    <?php $__currentLoopData = $classSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <button wire:click="selectSection(<?php echo e($section->id); ?>)"
                            class="<?php if($selectedSectionId == $section->id): ?> bg-indigo-600 text-white <?php else: ?> bg-gray-200 text-gray-700 hover:bg-gray-300 <?php endif; ?> px-4 py-2 rounded-md text-sm font-medium">
                            <?php echo e($section->section->name); ?>

                        </button>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        <?php else: ?>
            <div class="mb-6 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                <p class="text-sm text-yellow-700">No sections found for this class. Showing all students in the class.</p>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <!-- Student Records Display -->
    <?php if($selectedClassId && ($selectedSectionId || count($classSections) == 0)): ?>
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="p-4 border-b border-gray-200">
                <h3 class="text-lg font-medium text-gray-900">
                    Student Records for
                    <span class="text-indigo-600 font-semibold">
                        <?php if($classes && $selectedClassId): ?>
                            <?php echo e($classes->firstWhere('id', $selectedClassId)->name ?? 'Unknown Class'); ?>

                        <?php endif; ?>
                        <?php if($classSections && $selectedSectionId): ?>
                            - <?php echo e($classSections->firstWhere('id', $selectedSectionId)->name ?? 'Unknown Section'); ?>

                        <?php endif; ?>
                    </span>
                </h3>
            </div>

            <?php if(count($studentRecords) > 0): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Roll No.
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Student Name
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Student ID
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Class
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Section
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__currentLoopData = $studentRecords; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $record): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        <?php echo e($record['roll_no'] ?? 'N/A'); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 font-semibold">
                                        <?php echo e($record['studentdb']['name'] ?? 'N/A'); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo e($record['studentdb_id'] ?? 'N/A'); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo e($record['myclass']['name'] ?? 'N/A'); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        xx<?php echo e($record['section']['id'] ?? 'N/A'); ?>

                                        
                                        
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button wire:click="viewStudent(<?php echo e($record['id']); ?>)"
                                            class="text-indigo-600 hover:text-indigo-900 mr-3 font-medium">
                                            View
                                        </button>
                                        <button wire:click="editStudent(<?php echo e($record['id']); ?>)"
                                            class="text-green-600 hover:text-green-900 mr-3 font-medium">
                                            Edit
                                        </button>
                                        <button wire:click="deleteStudent(<?php echo e($record['id']); ?>)"
                                            onclick="return confirm('Are you sure you want to deactivate this student record?')"
                                            class="text-red-600 hover:text-red-900 font-medium">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <!-- Summary -->
                <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
                    <div class="flex justify-between items-center">
                        <div class="text-sm text-gray-600">
                            Total Students: <strong><?php echo e(count($studentRecords)); ?></strong>
                        </div>
                        <div class="text-sm text-gray-600">
                            Active: <strong><?php echo e(collect($studentRecords)->where('is_active', true)->count()); ?></strong> |
                            Inactive: <strong><?php echo e(collect($studentRecords)->where('is_active', false)->count()); ?></strong>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="p-6 text-center text-gray-500">
                    <div class="text-lg font-medium mb-2">No student records found</div>
                    <div class="text-sm">No students are assigned to this class and section yet.</div>
                </div>
            <?php endif; ?>
        </div>
    <?php elseif($selectedClassId): ?>
        <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
            <div class="text-lg font-medium mb-2">Select a section to view student records</div>
            <div class="text-sm">Choose a section from the options above to see student information.</div>
        </div>
    <?php else: ?>
        <div class="bg-white rounded-lg shadow-md p-6 text-center text-gray-500">
            <div class="text-lg font-medium mb-2">Select a class to view student records</div>
            <div class="text-sm">Choose a class from the tabs above to see available sections and students.</div>
        </div>
    <?php endif; ?>

    <!-- Student Details Modal -->
    <?php if($showModal && $selectedStudent): ?>
        <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50" wire:click="closeModal">
            <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white" wire:click.stop>
                <!-- Modal Header -->
                <div class="flex items-center justify-between pb-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Student Details</h3>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-gray-600">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="py-4">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Student Basic Information -->
                        <div class="space-y-4">
                            <h4 class="text-md font-medium text-gray-900 border-b pb-2">Basic Information</h4>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Student Name</label>
                                <p class="mt-1 text-sm text-gray-900"><?php echo e($selectedStudent->studentdb->name ?? 'N/A'); ?></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Roll Number</label>
                                <p class="mt-1 text-sm text-gray-900"><?php echo e($selectedStudent->roll_number ?? 'N/A'); ?></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Student ID</label>
                                <p class="mt-1 text-sm text-gray-900"><?php echo e($selectedStudent->studentdb_id ?? 'N/A'); ?></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Class</label>
                                <p class="mt-1 text-sm text-gray-900"><?php echo e($selectedStudent->myclass->name ?? 'N/A'); ?></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Section</label>
                                <p class="mt-1 text-sm text-gray-900">
                                    <?php echo e($selectedStudent->myclassSection->name ?? $selectedStudent->section->name ?? 'N/A'); ?>

                                </p>
                            </div>
                        </div>

                        <!-- Additional Information -->
                        <div class="space-y-4">
                            <h4 class="text-md font-medium text-gray-900 border-b pb-2">Additional Information</h4>
                            
                            <?php if($selectedStudent->studentdb): ?>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Email</label>
                                    <p class="mt-1 text-sm text-gray-900"><?php echo e($selectedStudent->studentdb->email ?? 'N/A'); ?></p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Phone</label>
                                    <p class="mt-1 text-sm text-gray-900"><?php echo e($selectedStudent->studentdb->phone ?? 'N/A'); ?></p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Address</label>
                                    <p class="mt-1 text-sm text-gray-900"><?php echo e($selectedStudent->studentdb->address ?? 'N/A'); ?></p>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Date of Birth</label>
                                    <p class="mt-1 text-sm text-gray-900"><?php echo e($selectedStudent->studentdb->date_of_birth ?? 'N/A'); ?></p>
                                </div>
                            <?php endif; ?>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status</label>
                                <p class="mt-1">
                                    <?php if($selectedStudent->is_active): ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Active
                                        </span>
                                    <?php else: ?>
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Inactive
                                        </span>
                                    <?php endif; ?>
                                </p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Record Created</label>
                                <p class="mt-1 text-sm text-gray-900"><?php echo e($selectedStudent->created_at ? $selectedStudent->created_at->format('M d, Y H:i') : 'N/A'); ?></p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Last Updated</label>
                                <p class="mt-1 text-sm text-gray-900"><?php echo e($selectedStudent->updated_at ? $selectedStudent->updated_at->format('M d, Y H:i') : 'N/A'); ?></p>
                            </div>
                        </div>
                    </div>

                    <!-- Debug Information (if debug mode is on) -->
                    <?php if($debugMode): ?>
                        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                            <h5 class="text-sm font-medium text-yellow-800 mb-2">Debug Information</h5>
                            <div class="text-xs text-yellow-700">
                                <p><strong>Record ID:</strong> <?php echo e($selectedStudent->id); ?></p>
                                <p><strong>Student DB ID:</strong> <?php echo e($selectedStudent->studentdb_id); ?></p>
                                <p><strong>Class ID:</strong> <?php echo e($selectedStudent->myclass_id); ?></p>
                                <p><strong>Section ID:</strong> <?php echo e($selectedStudent->myclass_section_id ?? $selectedStudent->section_id ?? 'N/A'); ?></p>
                                <p><strong>Raw Data:</strong></p>
                                <pre class="mt-2 text-xs bg-yellow-100 p-2 rounded overflow-x-auto"><?php echo e(json_encode($selectedStudent->toArray(), JSON_PRETTY_PRINT)); ?></pre>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Modal Footer -->
                <div class="flex items-center justify-end pt-4 border-t border-gray-200 space-x-2">
                    <button wire:click="editStudent(<?php echo e($selectedStudent->id); ?>)" 
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                        Edit Student
                    </button>
                    <button wire:click="closeModal" 
                            class="bg-gray-300 hover:bg-gray-400 text-gray-700 px-4 py-2 rounded-md text-sm font-medium">
                        Close
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div><?php /**PATH /home/bkoq0ic0h8xi/public_html/littleflowerschool.co.in/resources/views/livewire/student-cr-comp.blade.php ENDPATH**/ ?>