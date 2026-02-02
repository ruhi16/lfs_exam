<div>
    <style>
        .submenu-container {
            overflow: hidden;
            transition: max-height 0.3s ease, opacity 0.3s ease;
            max-height: 0;
            opacity: 0;
        }

        .submenu-container.closed {
            max-height: 0;
            opacity: 0;
        }

        .submenu-container.open {
            max-height: 500px;
            opacity: 1;
        }
    </style>

    <div class="flex h-[calc(100vh_-_72px)] bg-gray-100 overflow-hidden">
        <!-- Sidebar (from home.blade.php) -->
        <div class="w-64 bg-white shadow-lg border-r border-gray-200 flex flex-col">
            <!-- Logo -->
            <div class="flex items-center justify-center h-16 bg-gradient-to-r from-blue-600 to-blue-700 text-white">
                <div class="flex items-center space-x-2">
                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2L3 7v11a1 1 0 001 1h3v-6a1 1 0 011-1h4a1 1 0 011 1v6h3a1 1 0 001-1V7l-7-5z" />
                    </svg>
                    <span class="text-xl font-semibold">AdminPanel</span>
                </div>
            </div>
            <!-- Left Side Navigation Bar -->
            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div>
                    <?php if(isset($item['subitems'])): ?>
                    <!-- Menu item with submenu -->
                    <button wire:click="toggleSubmenu('<?php echo e($key); ?>')"
                        class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-lg transition-colors menu-item-hover
                                    <?php echo e(in_array($key, $openSubmenus) ? 'bg-gray-100 text-gray-900' : 'text-gray-700 hover:text-blue-600'); ?>">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="<?php echo e($item['icon']); ?>" />
                            </svg>
                            <?php echo e($item['label']); ?>

                        </div>
                        <svg class="w-4 h-4 transition-transform <?php echo e(in_array($key, $openSubmenus) ? 'rotate-180' : ''); ?>"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Submenu -->
                    <div class="submenu-container <?php echo e(in_array($key, $openSubmenus) ? 'open' : 'closed'); ?>">
                        <div class="ml-6 mt-2 space-y-1">
                            <?php $__currentLoopData = $item['subitems']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subKey => $subItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <button wire:click="setActiveMenu('<?php echo e($key); ?>', '<?php echo e($subKey); ?>')"
                                class="w-full flex items-center px-3 py-2 text-sm rounded-lg transition-colors
                                                <?php echo e($activeMenu === $subKey ? 'bg-blue-100 text-blue-700 border-r-2 border-blue-600' : 'text-gray-600 hover:text-blue-600 hover:bg-gray-50'); ?>">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="<?php echo e($subItem['icon']); ?>" />
                                </svg>
                                <?php echo e($subItem['label']); ?>

                            </button>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php else: ?>
                    <!-- Single menu item -->
                    <button wire:click="setActiveMenu('<?php echo e($key); ?>')"
                        class="w-full flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors menu-item-hover
                                    <?php echo e($activeMenu === $key ? 'bg-blue-100 text-blue-700 border-r-2 border-blue-600' : 'text-gray-700 hover:text-blue-600'); ?>">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="<?php echo e($item['icon']); ?>" />
                        </svg>
                        <?php echo e($item['label']); ?>

                    </button>
                    <?php endif; ?>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </nav>

            <!-- User Profile -->
            <div class="border-t border-gray-200 p-4">
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-white">JD</span>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 truncate">Little Flower School</p>
                        <p class="text-xs text-gray-500 truncate">admin@example.com</p>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm border-b border-gray-200">
                <div class="flex items-center justify-between px-6 py-4">
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900 capitalize">
                            <?php echo e(str_replace('-', ' ', $activeMenu)); ?>

                            <small class="text-xs text-gray-400">(<?php echo e($activeMenu); ?>)</small>
                        </h1>
                        <p class="text-sm text-gray-500 mt-1">
                            <?php
                            $description = '';
                            foreach ($menuItems as $menu) {
                            if (isset($menu['subitems'])) {
                            foreach ($menu['subitems'] as $subKey => $subItem) {
                            if ($subKey === $activeMenu) {
                            $description = $subItem['description'];
                            break;
                            }
                            }
                            } elseif ($menu['label'] === $activeMenu) {
                            $description = $menu['description'];
                            break;
                            }
                            }
                            echo $description;
                            ?>
                        </p>
                    </div>
                    <div class="flex items-center space-x-4">
                        <button class="p-2 text-gray-400 hover:text-gray-600 relative">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-5 5v-5zM12 8v8m-6-4h12" />
                            </svg>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                        <button class="p-2 text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-6">
                <div class="max-w-8xl mx-auto">
                    <!-- Dashboard -->
                    <?php if($activeMenu === 'dashboard'): ?>
                    <div class="space-y-6">
                        <!-- Institution Overview -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                            <!-- Total Students -->
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-sm font-medium text-gray-500">Total Students</h3>
                                        <p class="text-2xl font-semibold text-gray-900"><?php echo e($student_stats['total_students'] ?? 0); ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Active Classes -->
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-sm font-medium text-gray-500">Classes</h3>
                                        <p class="text-2xl font-semibold text-gray-900"><?php echo e($academic_stats['total_classes'] ?? 0); ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Active Exams -->
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-sm font-medium text-gray-500">Active Exams</h3>
                                        <p class="text-2xl font-semibold text-gray-900"><?php echo e($exam_stats['active_exams']
                                            ?? 0); ?></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Teachers -->
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                                <div class="flex items-center">
                                    <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <h3 class="text-sm font-medium text-gray-500">Teachers</h3>
                                        <p class="text-2xl font-semibold text-gray-900"><?php echo e($system_stats['total_teachers'] ?? 0); ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Institution and Academic Stats -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Student Statistics -->
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Student Statistics</h3>
                                <div class="space-y-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Active Students</span>
                                        <span class="font-medium"><?php echo e($student_stats['active_students'] ?? 0); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Students with Photos</span>
                                        <span class="font-medium"><?php echo e($student_stats['students_with_photos'] ?? 0); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Recent Admissions (30 days)</span>
                                        <span class="font-medium"><?php echo e($student_stats['recent_admissions'] ?? 0); ?></span>
                                    </div>
                                </div>
                            </div>

                            <!-- Academic Statistics -->
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                                <h3 class="text-lg font-semibold text-gray-900 mb-4">Academic Statistics</h3>
                                <div class="space-y-4">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Total Sections</span>
                                        <span class="font-medium"><?php echo e($academic_stats['total_sections'] ?? 0); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Total Subjects</span>
                                        <span class="font-medium"><?php echo e($academic_stats['total_subjects'] ?? 0); ?></span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Class-Subject Assignments</span>
                                        <span class="font-medium"><?php echo e($academic_stats['class_subjects'] ?? 0); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Examination Overview -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Examination Overview</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                                <div class="text-center p-4 bg-gray-50 rounded-lg">
                                    <p class="text-2xl font-bold text-blue-600"><?php echo e($exam_stats['exam_names'] ?? 0); ?></p>
                                    <p class="text-sm text-gray-600">Exam Names</p>
                                </div>
                                <div class="text-center p-4 bg-gray-50 rounded-lg">
                                    <p class="text-2xl font-bold text-green-600"><?php echo e($exam_stats['exam_types'] ?? 0); ?>

                                    </p>
                                    <p class="text-sm text-gray-600">Exam Types</p>
                                </div>
                                <div class="text-center p-4 bg-gray-50 rounded-lg">
                                    <p class="text-2xl font-bold text-yellow-600"><?php echo e($exam_stats['exam_parts'] ?? 0); ?>

                                    </p>
                                    <p class="text-sm text-gray-600">Exam Parts</p>
                                </div>
                                <div class="text-center p-4 bg-gray-50 rounded-lg">
                                    <p class="text-2xl font-bold text-purple-600"><?php echo e($exam_stats['exam_modes'] ?? 0); ?>

                                    </p>
                                    <p class="text-sm text-gray-600">Exam Modes</p>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activity -->
                        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Recent Activity</h3>
                            <div class="space-y-4">
                                <?php if(isset($recent_activity['recent_students']) &&
                                count($recent_activity['recent_students']) > 0): ?>
                                <div>
                                    <h4 class="font-medium text-gray-700 mb-2">Recently Added Students</h4>
                                    <div class="space-y-2">
                                        <?php $__currentLoopData = $recent_activity['recent_students']->take(3); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <div class="flex items-center justify-between p-2 hover:bg-gray-50 rounded">
                                            <div class="flex items-center">
                                                <div
                                                    class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                    <span class="text-xs font-medium text-blue-800"><?php echo e(substr($student->name, 0, 1)); ?></span>
                                                </div>
                                                <div class="ml-3">
                                                    <p class="text-sm font-medium text-gray-900"><?php echo e($student->name); ?>

                                                    </p>
                                                    <p class="text-xs text-gray-500"><?php echo e($student->myclass->name ?? 'N/A'); ?> - <?php echo e($student->sections->first()->name ?? 'N/A'); ?></p>
                                                </div>
                                            </div>
                                            <span class="text-xs text-gray-500"><?php echo e($student->created_at->diffForHumans()); ?></span>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Student Database -->
                    <?php if($activeMenu === 'student-database'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('student-db-component')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-0');
} else {
    $response = \Livewire\Livewire::mount('student-db-component');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Sessions -->
                    <?php if($activeMenu === 'sessions'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('session-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-1');
} else {
    $response = \Livewire\Livewire::mount('session-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Schools -->
                    <?php if($activeMenu === 'schools'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('school-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-2')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-2');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-2');
} else {
    $response = \Livewire\Livewire::mount('school-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Teachers -->
                    <?php if($activeMenu === 'teachers'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('teacher-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-3')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-3');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-3');
} else {
    $response = \Livewire\Livewire::mount('teacher-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Classes -->
                    <?php if($activeMenu === 'classes'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('myclass-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-4')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-4');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-4');
} else {
    $response = \Livewire\Livewire::mount('myclass-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Sections -->
                    <?php if($activeMenu === 'sections'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('section-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-5')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-5');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-5');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-5');
} else {
    $response = \Livewire\Livewire::mount('section-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-5', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Class Sections -->
                    <?php if($activeMenu === 'class-sections'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('myclass-section-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-6')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-6');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-6');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-6');
} else {
    $response = \Livewire\Livewire::mount('myclass-section-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-6', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- My Class (Legacy) -->
                    <?php if($activeMenu === 'MyClass'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('myclass-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-7')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-7');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-7');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-7');
} else {
    $response = \Livewire\Livewire::mount('myclass-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-7', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Subject Types -->
                    <?php if($activeMenu === 'subject-types'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('subject-type-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-8')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-8');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-8');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-8');
} else {
    $response = \Livewire\Livewire::mount('subject-type-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-8', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Subjects -->
                    <?php if($activeMenu === 'subjects'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('subject-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-9')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-9');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-9');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-9');
} else {
    $response = \Livewire\Livewire::mount('subject-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-9', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Subject Teacher -->
                    <?php if($activeMenu === 'subject-teachers'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('subject-teacher-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-10')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-10');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-10');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-10');
} else {
    $response = \Livewire\Livewire::mount('subject-teacher-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-10', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Class Subjects -->
                    <?php if($activeMenu === 'myclass-subjects'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('myclass-subject-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-11')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-11');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-11');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-11');
} else {
    $response = \Livewire\Livewire::mount('myclass-subject-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-11', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Exam Settings -->
                    <?php if($activeMenu === 'exam-settings'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('exam-settings')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-12')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-12');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-12');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-12');
} else {
    $response = \Livewire\Livewire::mount('exam-settings');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-12', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Exam Settings View -->
                    

                    <!-- Exam Settings FMPM -->
                    

                    <!-- Exam Settings FMPM -->
                    <?php if($activeMenu === 'exam-settings-fmpm2'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('exam-setting-with-fmpm')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-13')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-13');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-13');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-13');
} else {
    $response = \Livewire\Livewire::mount('exam-setting-with-fmpm');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-13', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Exam Names -->
                    <?php if($activeMenu === 'exam-names'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('exam-name-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-14')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-14');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-14');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-14');
} else {
    $response = \Livewire\Livewire::mount('exam-name-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-14', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Exam Types -->
                    <?php if($activeMenu === 'exam-types'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('exam-type-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-15')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-15');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-15');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-15');
} else {
    $response = \Livewire\Livewire::mount('exam-type-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-15', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Exam Parts -->
                    <?php if($activeMenu === 'exam-parts'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('exam-part-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-16')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-16');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-16');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-16');
} else {
    $response = \Livewire\Livewire::mount('exam-part-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-16', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Exam Modes -->
                    <?php if($activeMenu === 'exam-modes'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('exam-mode-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-17')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-17');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-17');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-17');
} else {
    $response = \Livewire\Livewire::mount('exam-mode-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-17', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Exam Configuration -->
                    

                    <!-- Student Class Records -->
                    <?php if($activeMenu === 'student-cr'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('student-cr-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-18')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-18');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-18');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-18');
} else {
    $response = \Livewire\Livewire::mount('student-cr-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-18', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Answer Script Distribution -->
                    

                    <!-- Answer Script Distribution -->
                    <?php if($activeMenu === 'answer-script-distribution2'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('answer-script-distribution-comp2')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-19')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-19');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-19');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-19');
} else {
    $response = \Livewire\Livewire::mount('answer-script-distribution-comp2');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-19', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Marks Entry -->
                    <?php if($activeMenu === 'class-section-tasks'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('class-section-tasks-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-20')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-20');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-20');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-20');
} else {
    $response = \Livewire\Livewire::mount('class-section-tasks-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-20', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Marks Entry -->
                    <?php if($activeMenu === 'marks-entry'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('marks-entry-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-21')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-21');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-21');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-21');
} else {
    $response = \Livewire\Livewire::mount('marks-entry-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-21', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Marks Entry -->
                    <?php if($activeMenu === 'teacher-entry'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('teacher-marks-entry-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-22')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-22');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-22');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-22');
} else {
    $response = \Livewire\Livewire::mount('teacher-marks-entry-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-22', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- System Logs -->
                    <?php if($activeMenu === 'logs-viewer'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('logs-viewer-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-23')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-23');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-23');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-23');
} else {
    $response = \Livewire\Livewire::mount('logs-viewer-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-23', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Class Exam Subjects -->
                    <?php if($activeMenu === 'class-exam-subject'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('class-exam-subject-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-24')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-24');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-24');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-24');
} else {
    $response = \Livewire\Livewire::mount('class-exam-subject-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-24', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Mark Register -->
                    <?php if($activeMenu === 'mark-register'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('mark-register-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-25')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-25');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-25');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-25');
} else {
    $response = \Livewire\Livewire::mount('mark-register-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-25', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- User Role Components -->
                    <?php if($activeMenu === 'user-roles'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('user-role-comp')->html();
} elseif ($_instance->childHasBeenRendered('l562533446-26')) {
    $componentId = $_instance->getRenderedChildComponentId('l562533446-26');
    $componentTag = $_instance->getRenderedChildComponentTagName('l562533446-26');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l562533446-26');
} else {
    $response = \Livewire\Livewire::mount('user-role-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l562533446-26', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    <?php endif; ?>

                    <!-- Analytics -->
                    <?php if($activeMenu === 'analytics'): ?>
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                        <div class="text-center">
                            <div
                                class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">Analytics</h3>
                            <p class="text-gray-500 mb-6">View application analytics and reports.</p>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- Default/Other Pages -->
                    <?php if(!in_array($activeMenu, ['dashboard', 'schools', 'classes', 'sections', 'class-sections',
                    'subject-types', 'subjects', 'MyClass', 'myclass-subjects', 'student-database', 'sessions',
                    'teachers', 'subject-teachers', 'exam-settings', 'exam-settings-view', 'exam-settings-fmpm',
                    'exam-names', 'exam-types', 'exam-parts', 'exam-modes', 'student-cr', 'answer-script-distribution',
                    'answer-script-distribution2', 'marks-entry', 'logs-viewer', 'class-exam-subject', 'mark-register',
                    'user-roles', 'analytics',
                    'exam-config', 'exam-settings-fmpm2', 'class-section-tasks', 'teacher-entry'])): ?>
                    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
                        <div class="text-center">
                            <div
                                class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2 capitalize">
                                <?php echo e(str_replace('-', ' ', $activeMenu)); ?> Page
                            </h3>
                            <p class="text-gray-500 mb-6">
                                This is the '<?php echo e(str_replace('-', ' ', $activeMenu)); ?>' section. Content for this page
                                would
                                be implemented here.
                            </p>
                            <button
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                                Get Started
                            </button>
                        </div>
                    </div>
                    <?php endif; ?>
                </div>
            </main>
        </div>
    </div>

    <!-- Flash Messages -->
    <?php if(session()->has('message')): ?>
    <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50">
        <div class="flex items-center">
            <i class="fas fa-check-circle mr-2"></i>
            <?php echo e(session('message')); ?>

        </div>
    </div>
    <?php endif; ?>

    <script>
        // Auto-hide flash messages
        setTimeout(function () {
            const messages = document.querySelectorAll('[class*="fixed top-4 right-4"]');
            messages.forEach(function (message) {
                message.style.opacity = '0';
                setTimeout(function () {
                    message.remove();
                }, 300);
            });
        }, 3000);

        // Auto-refresh data every 30 seconds
        // setInterval(function () {
        //     window.livewire.find('<?php echo e($_instance->id); ?>').call('refreshData');
        // }, 30000);
    </script>
</div><?php /**PATH /home/bkoq0ic0h8xi/public_html/littleflowerschool.co.in/resources/views/livewire/dashboard-comp.blade.php ENDPATH**/ ?>