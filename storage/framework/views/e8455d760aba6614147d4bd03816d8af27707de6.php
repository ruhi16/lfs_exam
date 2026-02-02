<div class="bg-white rounded-lg shadow p-6">
    <h2 class="text-xl font-bold mb-4">Debug Test Component</h2>

    <div class="mb-4 p-3 bg-blue-100 rounded">
        <p class="text-blue-800">Counter: <?php echo e($counter); ?></p>
        <button wire:click="increment" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded">
            Increment
        </button>
    </div>

    <div class="mb-6">
        <h3 class="text-lg font-semibold mb-3">Test Data Array:</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <?php $__currentLoopData = $testData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="border rounded p-4" wire:key="item-<?php echo e($key); ?>">
                    <h4 class="font-medium"><?php echo e($item['name']); ?></h4>
                    <div class="mt-2">
                        <label class="block text-sm font-medium text-gray-700">Value:</label>
                        <input type="number" wire:model="testData.<?php echo e($key); ?>.value" wire:key="input-<?php echo e($key); ?>"
                            class="mt-1 block w-full rounded border-gray-300 shadow-sm">
                    </div>
                    <div class="mt-2 text-sm text-gray-600">
                        Current value: <?php echo e($item['value']); ?>

                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <div class="bg-gray-50 p-4 rounded">
        <h3 class="font-medium mb-2">Debug Info:</h3>
        <pre class="text-xs"><?php echo e(json_encode($testData, JSON_PRETTY_PRINT)); ?></pre>
    </div>
</div><?php /**PATH D:\LaravelProject\LFS_Exam\resources\views/livewire/debug-test-component.blade.php ENDPATH**/ ?>