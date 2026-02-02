

<div class="relative h-screen overflow-hidden">
    <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="absolute inset-0 transition-opacity duration-1000 <?php echo e($currentSlide === $index ? 'opacity-100' : 'opacity-0'); ?>">
        <div class="absolute inset-0 bg-gradient-to-r from-blue-900/80 to-purple-900/80"></div>
        <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo e($slide['image']); ?>')"></div>
        <div class="relative z-10 flex items-center justify-center h-full">
            <div class="text-center text-white max-w-4xl px-6">
                <h1 class="text-5xl md:text-7xl font-bold mb-4 animate-fade-in-up"><?php echo e($slide['title']); ?></h1>
                <h2 class="text-2xl md:text-3xl font-light mb-6 text-yellow-300"><?php echo e($slide['subtitle']); ?></h2>
                <p class="text-lg md:text-xl mb-8 leading-relaxed"><?php echo e($slide['description']); ?></p>
                <div class="space-x-4">
                    <button class="bg-yellow-500 hover:bg-yellow-600 text-white px-8 py-3 rounded-full font-semibold transition-colors duration-300">
                        Enroll Now
                    </button>
                    <button class="border-2 border-white text-white hover:bg-white hover:text-blue-900 px-8 py-3 rounded-full font-semibold transition-all duration-300">
                        Learn More
                    </button>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

    
    <button wire:click="prevSlide" class="absolute left-6 top-1/2 transform -translate-y-1/2 text-white hover:text-yellow-300 transition-colors">
        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
        </svg>
    </button>
    
    <button wire:click="nextSlide" class="absolute right-6 top-1/2 transform -translate-y-1/2 text-white hover:text-yellow-300 transition-colors">
        <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
        </svg>
    </button>

    
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 flex space-x-3">
        <?php $__currentLoopData = $slides; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $slide): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <button wire:click="goToSlide(<?php echo e($index); ?>)" 
                class="w-3 h-3 rounded-full transition-all duration-300 <?php echo e($currentSlide === $index ? 'bg-yellow-400' : 'bg-white/50 hover:bg-white/80'); ?>">
        </button>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div><?php /**PATH D:\LaravelProject\LFS_Exam\resources\views/livewire/wcui/hero-section.blade.php ENDPATH**/ ?>