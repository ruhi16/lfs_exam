

<div class="py-20 bg-white">
    <div class="container mx-auto px-6">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Our Programs</h2>
            <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                Age-appropriate programs designed to nurture your child's development at every stage
            </p>
        </div>

        
        <div class="flex flex-wrap justify-center mb-12">
            <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <button wire:click="setActiveTab('<?php echo e($key); ?>')" 
                    class="mx-2 mb-4 px-6 py-3 rounded-full font-semibold transition-all duration-300
                           <?php echo e($activeTab === $key ? 'bg-blue-600 text-white shadow-lg' : 'bg-gray-200 text-gray-700 hover:bg-gray-300'); ?>">
                <?php echo e($program['name']); ?>

            </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        
        <div class="max-w-4xl mx-auto">
            <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="<?php echo e($activeTab === $key ? 'block' : 'hidden'); ?>">
                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 md:p-12">
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <h3 class="text-3xl font-bold text-gray-800 mb-4"><?php echo e($program['name']); ?></h3>
                            <div class="space-y-3 mb-6">
                                <div class="flex items-center">
                                    <span class="text-blue-600 font-semibold mr-3">Age Group:</span>
                                    <span class="text-gray-700"><?php echo e($program['age']); ?></span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-blue-600 font-semibold mr-3">Duration:</span>
                                    <span class="text-gray-700"><?php echo e($program['duration']); ?></span>
                                </div>
                            </div>
                            <p class="text-gray-600 leading-relaxed mb-6"><?php echo e($program['description']); ?></p>
                            <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-8 py-3 rounded-full font-semibold transition-colors duration-300">
                                Learn More
                            </button>
                        </div>
                        <div>
                            <h4 class="text-xl font-bold text-gray-800 mb-4">Program Features</h4>
                            <ul class="space-y-3">
                                <?php $__currentLoopData = $program['features']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="flex items-center">
                                    <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-gray-700"><?php echo e($feature); ?></span>
                                </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</div><?php /**PATH /home/bkoq0ic0h8xi/public_html/littleflowerschool.co.in/resources/views/livewire/wcui/programs.blade.php ENDPATH**/ ?>