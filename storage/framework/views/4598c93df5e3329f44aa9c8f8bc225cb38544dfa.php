<div class="flex-1 p-6 overflow-y-auto max-w-full mx-auto">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-semibold text-gray-900">Class Sections Management</h1>
                <p class="mt-1 text-sm text-gray-600">Quick management of sections assigned to each class</p>
            </div>
            <div class="flex space-x-2">
                <button wire:click="refreshData" 
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                    Refresh Data
                </button>
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

    <!-- Classes with Sections Table -->
    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="p-4 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Classes and Their Sections</h3>
            <p class="text-sm text-gray-600 mt-1">
                Total Classes: <?php echo e(count($classesWithSections)); ?> | 
                Use Add/Remove buttons to quickly manage sections for each class
            </p>
        </div>

        <?php if(count($classesWithSections) > 0): ?>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Class Name
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Assigned Sections
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total Students
                            </th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Status
                            </th>
                            <th class="px-4 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quick Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        <?php $__currentLoopData = $classesWithSections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $class): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr class="hover:bg-gray-50">
                                <!-- Class Name -->
                                <td class="px-4 py-3 text-sm text-gray-900">
                                    <div class="font-medium"><?php echo e($class['name']); ?></div>
                                    <?php if($class['description']): ?>
                                        <div class="text-xs text-gray-500"><?php echo e($class['description']); ?></div>
                                    <?php endif; ?>
                                </td>

                                <!-- Assigned Sections -->
                                <td class="px-4 py-3 text-sm text-gray-500">
                                    <?php if(count($class['sections']) > 0): ?>
                                        <div class="flex flex-wrap gap-1">
                                            <?php $__currentLoopData = $class['sections']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                                    <?php echo e($section['is_active'] ? 'bg-blue-100 text-blue-800' : 'bg-gray-100 text-gray-800'); ?>">
                                                    <?php echo e($section['section_name']); ?>

                                                    <?php if($section['section_code']): ?>
                                                        (<?php echo e($section['section_code']); ?>)
                                                    <?php endif; ?>
                                                    <?php if($section['students_count'] > 0): ?>
                                                        <span class="ml-1 text-xs"><?php echo e($section['students_count']); ?></span>
                                                    <?php endif; ?>
                                                </span>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <div class="text-xs text-gray-400 mt-1">
                                            <?php echo e(count($class['sections'])); ?> section<?php echo e(count($class['sections']) > 1 ? 's' : ''); ?> assigned
                                        </div>
                                    <?php else: ?>
                                        <span class="text-gray-400 italic">No sections assigned</span>
                                    <?php endif; ?>
                                </td>

                                <!-- Total Students -->
                                <td class="px-4 py-3 text-sm text-gray-500">
                                    <?php
                                        $totalStudents = array_sum(array_column($class['sections'], 'students_count'));
                                    ?>
                                    <div class="font-medium"><?php echo e($totalStudents); ?></div>
                                    <?php if($totalStudents > 0): ?>
                                        <div class="text-xs text-gray-400">across all sections</div>
                                    <?php endif; ?>
                                </td>

                                <!-- Status -->
                                <td class="px-4 py-3 text-sm">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium 
                                        <?php echo e($class['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                                        <?php echo e($class['is_active'] ? 'Active' : 'Inactive'); ?>

                                    </span>
                                </td>

                                <!-- Quick Actions -->
                                <td class="px-4 py-3 text-sm text-center">
                                    <div class="flex justify-center space-x-2">
                                        <!-- Add Section Button -->
                                        <?php if($class['has_available_sections']): ?>
                                            <button wire:click="addSectionToClass(<?php echo e($class['id']); ?>)" 
                                                class="bg-green-600 hover:bg-green-700 text-white px-3 py-1 rounded text-xs font-medium"
                                                title="Add next available section">
                                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Add Section
                                            </button>
                                        <?php else: ?>
                                            <button disabled 
                                                class="bg-gray-300 text-gray-500 px-3 py-1 rounded text-xs font-medium cursor-not-allowed"
                                                title="No available sections to add">
                                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Add Section
                                            </button>
                                        <?php endif; ?>

                                        <!-- Remove Section Button -->
                                        <?php if(count($class['sections']) > 0): ?>
                                            <button wire:click="removeSectionFromClass(<?php echo e($class['id']); ?>)" 
                                                onclick="return confirm('Remove the last added section from this class?')"
                                                class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded text-xs font-medium"
                                                title="Remove last added section">
                                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                </svg>
                                                Remove Section
                                            </button>
                                        <?php else: ?>
                                            <button disabled 
                                                class="bg-gray-300 text-gray-500 px-3 py-1 rounded text-xs font-medium cursor-not-allowed"
                                                title="No sections to remove">
                                                <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                                </svg>
                                                Remove Section
                                            </button>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Available Sections Info -->
                                    <?php if($class['has_available_sections']): ?>
                                        <div class="text-xs text-green-600 mt-1">
                                            <?php echo e(count($class['available_sections'])); ?> available
                                        </div>
                                    <?php else: ?>
                                        <div class="text-xs text-gray-400 mt-1">
                                            All sections assigned
                                        </div>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>

            <!-- Summary Section -->
            <div class="bg-gray-50 px-4 py-3 border-t border-gray-200">
                <div class="flex justify-between items-center text-sm text-gray-600">
                    <div>
                        <?php
                            $totalSections = array_sum(array_column($classesWithSections, 'sections_count'));
                            $totalStudents = 0;
                            foreach($classesWithSections as $class) {
                                $totalStudents += array_sum(array_column($class['sections'], 'students_count'));
                            }
                        ?>
                        <span class="font-medium">Summary:</span>
                        <?php echo e(count($classesWithSections)); ?> Classes | 
                        <?php echo e($totalSections); ?> Total Sections | 
                        <?php echo e($totalStudents); ?> Total Students
                    </div>
                    <div class="text-xs">
                        <span class="text-green-600">●</span> Active Class |
                        <span class="text-blue-600">●</span> Active Section |
                        <span class="text-gray-600">●</span> Inactive
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="p-6 text-center text-gray-500">
                <div class="text-lg font-medium mb-2">No classes found</div>
                <div class="text-sm">No active classes are available to manage sections.</div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Help Section -->
    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-md p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                </svg>
            </div>
            <div class="ml-3">
                <h3 class="text-sm font-medium text-blue-800">Quick Actions Help</h3>
                <div class="mt-2 text-sm text-blue-700">
                    <ul class="list-disc list-inside space-y-1">
                        <li><strong>Add Section:</strong> Automatically assigns the next available section to the class</li>
                        <li><strong>Remove Section:</strong> Removes the last added section from the class (if no students enrolled)</li>
                        <li><strong>Section Tags:</strong> Show section name, code, and student count</li>
                        <li><strong>Status Colors:</strong> Blue = Active Section, Gray = Inactive Section</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div><?php /**PATH /home/bkoq0ic0h8xi/public_html/littleflowerschool.co.in/resources/views/livewire/myclass-section-comp.blade.php ENDPATH**/ ?>