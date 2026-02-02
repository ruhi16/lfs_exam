<div>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside class="bg-gray-800 text-white transition-all duration-300 <?php echo e($sidebarOpen ? 'w-64' : 'w-20'); ?>">
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-700">
                <?php if($sidebarOpen): ?>
                    <h1 class="text-xl font-bold">SubAdmin Panel</h1>
                <?php endif; ?>
                <button wire:click="toggleSidebar" class="p-2 rounded hover:bg-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="<?php echo e($sidebarOpen ? 'M11 19l-7-7 7-7m8 14l-7-7 7-7' : 'M13 5l7 7-7 7M5 5l7 7-7 7'); ?>">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Menu Items -->
            <nav class="mt-4">
                <?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <button wire:click="switchComponent('<?php echo e($item['component']); ?>')"
                        class="w-full flex items-center px-4 py-3 transition-colors duration-200 
                               <?php echo e($currentComponent === $item['component'] ? 'bg-gray-700 border-l-4 border-blue-500' : 'hover:bg-gray-700'); ?>">
                        <svg class="w-6 h-6 <?php echo e($sidebarOpen ? 'mr-3' : 'mx-auto'); ?>" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="<?php echo e($item['icon']); ?>">
                            </path>
                        </svg>
                        <?php if($sidebarOpen): ?>
                            <span class="font-medium"><?php echo e($item['name']); ?></span>
                        <?php endif; ?>
                    </button>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </nav>

            <!-- Sidebar Footer -->
            <div class="absolute bottom-0 w-full p-4 border-t border-gray-700">
                <div class="flex items-center <?php echo e($sidebarOpen ? '' : 'justify-center'); ?>">
                    <div class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center">
                        <span class="text-sm font-semibold">AD</span>
                    </div>
                    <?php if($sidebarOpen): ?>
                        <div class="ml-3">
                            <p class="text-sm font-medium">SubAdmin User</p>
                            <p class="text-xs text-gray-400">admin@example.com</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto">
            <!-- Top Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <h2 class="text-2xl font-semibold text-gray-800">
                        <?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($currentComponent === $item['component']): ?>
                                <?php echo e($item['name']); ?>

                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </h2>
                    <div class="flex items-center space-x-4">
                        <button class="p-2 rounded-full hover:bg-gray-100 focus:outline-none">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Dynamic Content Area -->
            <div class="p-6">
                <?php if($currentComponent === 'dashboard'): ?>
                    
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('subadmin-dc-profile-comp')->html();
} elseif ($_instance->childHasBeenRendered('l213797109-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l213797109-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l213797109-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l213797109-0');
} else {
    $response = \Livewire\Livewire::mount('subadmin-dc-profile-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l213797109-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                <?php elseif($currentComponent === 'users'): ?>
                    
                <?php elseif($currentComponent === 'products'): ?>
                    
                <?php elseif($currentComponent === 'orders'): ?>
                    
                <?php elseif($currentComponent === 'settings'): ?>
                    
                <?php else: ?>
                    <div class="bg-white rounded-lg shadow p-6">
                        <h3 class="text-lg font-semibold mb-2">Component Not Found</h3>
                        <p class="text-gray-600">The requested component "<?php echo e($currentComponent); ?>" is not available.</p>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>

    <style>
        /* Ensure the component takes full height */
        [wire\:id] {
            height: 100vh;
        }
    </style>
</div><?php /**PATH D:\LaravelProject\LFS_Exam\resources\views/livewire/subadmin-dashboard-container-comp.blade.php ENDPATH**/ ?>