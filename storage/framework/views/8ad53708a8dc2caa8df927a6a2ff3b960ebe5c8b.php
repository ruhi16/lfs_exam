<div class="p-6 bg-white border-b border-gray-200">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">MyClass-Section Matrix</h2>
        <div class="flex items-center">
            <span class="mr-3 text-sm font-medium text-gray-900"><?php echo e($isEditMode ? 'Edit Mode ON' : 'Edit Mode OFF'); ?></span>
            <label for="toggle-edit-section" class="relative inline-flex items-center cursor-pointer">
                <input type="checkbox" id="toggle-edit-section" class="sr-only peer" wire:click="toggleEditMode" <?php echo e($isEditMode ? 'checked' : ''); ?>>
                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
            </label>
        </div>
    </div>

    <?php if(session()->has('message')): ?>
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
            <p><?php echo e(session('message')); ?></p>
        </div>
    <?php endif; ?>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 border">
            <thead class="bg-gray-50">
                <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10 border-r">
                        MyClass
                    </th>
                    <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-l">
                            <?php echo e($section->name); ?>

                        </th>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php $__currentLoopData = $myclasses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $myclass): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white z-10 border-r">
                            <?php echo e($myclass->name); ?>

                        </td>
                        <?php $__currentLoopData = $sections; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $section): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                                $isChecked = isset($matrix[$myclass->id][$section->id]);
                            ?>
                            <td class="px-6 py-4 whitespace-nowrap text-center border-l">
                                <input type="checkbox" 
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 disabled:opacity-50 disabled:cursor-not-allowed h-5 w-5"
                                    <?php echo e($isChecked ? 'checked' : ''); ?>

                                    <?php echo e($isEditMode ? '' : 'disabled'); ?>

                                    wire:click="updateMapping(<?php echo e($myclass->id); ?>, <?php echo e($section->id); ?>, $event.target.checked)"
                                >
                            </td>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php /**PATH D:\LaravelProject\LFS_Exam\resources\views/livewire/basic10-class-section-comp.blade.php ENDPATH**/ ?>