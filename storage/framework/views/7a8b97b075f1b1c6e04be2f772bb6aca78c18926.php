<div>
    <div class="flex h-screen bg-gray-100">
        <!-- Sidebar -->
        <aside
            class="bg-gray-800 text-white transition-all duration-300 <?php echo e($sidebarOpen ? 'w-64' : 'w-20'); ?> flex flex-col">
            <!-- Sidebar Header -->
            <div class="flex items-center justify-between p-4 border-b border-gray-700">
                <?php if($sidebarOpen): ?>
                    <h1 class="text-xl font-bold">Admin Panel</h1>
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
            <nav class="mt-4 flex-1 overflow-y-auto">
                <?php $__currentLoopData = $menuItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="mb-1">
                        <!-- Main Menu Item -->
                        <?php if(count($item['submenu']) > 0): ?>
                            <!-- Menu with Submenu -->
                            <button wire:click="toggleMenu(<?php echo e($index); ?>)" class="w-full flex items-center justify-between px-4 py-3 transition-colors duration-200 hover:bg-gray-700
                                           <?php echo e(in_array($index, $expandedMenus) ? 'bg-gray-700' : ''); ?>">
                                <div class="flex items-center <?php echo e($sidebarOpen ? '' : 'justify-center w-full'); ?>">
                                    <svg class="w-6 h-6 <?php echo e($sidebarOpen ? 'mr-3' : ''); ?>" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="<?php echo e($item['icon']); ?>"></path>
                                    </svg>
                                    <?php if($sidebarOpen): ?>
                                        <span class="font-medium"><?php echo e($item['name']); ?></span>
                                    <?php endif; ?>
                                </div>
                                <?php if($sidebarOpen): ?>
                                    <svg class="w-4 h-4 transition-transform duration-200 <?php echo e(in_array($index, $expandedMenus) ? 'rotate-180' : ''); ?>"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7">
                                        </path>
                                    </svg>
                                <?php endif; ?>
                            </button>

                            <!-- Submenu Items -->
                            <?php if($sidebarOpen && in_array($index, $expandedMenus)): ?>
                                <div class="bg-gray-900">
                                    <?php $__currentLoopData = $item['submenu']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subitem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <button wire:click="switchComponent('<?php echo e($subitem['component']); ?>')"
                                            class="w-full flex items-center px-4 py-2 pl-14 text-sm transition-colors duration-200 
                                                               <?php echo e($currentComponent === $subitem['component'] ? 'bg-blue-600 text-white' : 'text-gray-300 hover:bg-gray-800 hover:text-white'); ?>">
                                            <span class="mr-2">•</span>
                                            <span><?php echo e($subitem['name']); ?></span>
                                        </button>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            <?php endif; ?>
                        <?php else: ?>
                            <!-- Menu without Submenu -->
                            <button wire:click="switchComponent('<?php echo e($item['component']); ?>')"
                                class="w-full flex items-center px-4 py-3 transition-colors duration-200 
                                           <?php echo e($currentComponent === $item['component'] ? 'bg-gray-700 border-l-4 border-blue-500' : 'hover:bg-gray-700'); ?>">
                                <svg class="w-6 h-6 <?php echo e($sidebarOpen ? 'mr-3' : 'mx-auto'); ?>" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="<?php echo e($item['icon']); ?>"></path>
                                </svg>
                                <?php if($sidebarOpen): ?>
                                    <span class="font-medium"><?php echo e($item['name']); ?></span>
                                <?php endif; ?>
                            </button>
                        <?php endif; ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </nav>

            <!-- Sidebar Footer -->
            <div class="border-t border-gray-700 p-4">
                <div class="flex items-center <?php echo e($sidebarOpen ? '' : 'justify-center'); ?>">
                    <div class="w-10 h-10 rounded-full bg-gray-600 flex items-center justify-center flex-shrink-0">
                        <span class="text-sm font-semibold">AD</span>
                    </div>
                    <?php if($sidebarOpen): ?>
                        <div class="ml-3 overflow-hidden">
                            <p class="text-sm font-medium truncate">Admin User</p>
                            <p class="text-xs text-gray-400 truncate">admin@example.com</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </aside>

        <!-- Main Content Area -->
        <main class="flex-1 overflow-y-auto flex flex-col">
            <!-- Top Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between px-6 py-4">
                    <h2 class="text-2xl font-semibold text-gray-800">
                        <?php
                            $pageTitle = 'Dashboard';
                            foreach ($menuItems as $item) {
                                if ($currentComponent === $item['component']) {
                                    $pageTitle = $item['name'];
                                    break;
                                }
                                if (count($item['submenu']) > 0) {
                                    foreach ($item['submenu'] as $subitem) {
                                        if ($currentComponent === $subitem['component']) {
                                            $pageTitle = $item['name'] . ' / ' . $subitem['name'];
                                            break 2;
                                        }
                                    }
                                }
                            }
                            echo $pageTitle;
                        ?>
                    </h2>
                    <div class="flex items-center space-x-4">
                        <button class="p-2 rounded-full hover:bg-gray-100 focus:outline-none relative">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                                </path>
                            </svg>
                            <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                        </button>
                    </div>
                </div>
            </header>

            <!-- Dynamic Content Area -->
            <div class="p-6 flex-1">
                <?php if($currentComponent === 'dashboard'): ?>
                    

                
                <?php elseif($currentComponent === 'users.all'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('supadmin-d-c-users-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-0');
} else {
    $response = \Livewire\Livewire::mount('supadmin-d-c-users-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                



                
                <?php elseif($currentComponent === 'basic.wall'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin-dc-basic-wall-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-1');
} else {
    $response = \Livewire\Livewire::mount('admin-dc-basic-wall-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

                    
                <?php elseif($currentComponent === 'basic.school'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('basic01-school-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-2')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-2');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-2');
} else {
    $response = \Livewire\Livewire::mount('basic01-school-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>


                <?php elseif($currentComponent === 'basic.session'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('basic02-session-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-3')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-3');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-3');
} else {
    $response = \Livewire\Livewire::mount('basic02-session-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>



                <?php elseif($currentComponent === 'basic.class'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('basic03-class-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-4')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-4');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-4');
} else {
    $response = \Livewire\Livewire::mount('basic03-class-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>


                <?php elseif($currentComponent === 'basic.section'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('basic04-section-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-5')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-5');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-5');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-5');
} else {
    $response = \Livewire\Livewire::mount('basic04-section-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-5', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>


                <?php elseif($currentComponent === 'basic.subject'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('basic06-subject-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-6')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-6');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-6');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-6');
} else {
    $response = \Livewire\Livewire::mount('basic06-subject-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-6', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

                <?php elseif($currentComponent === 'basic.teacher'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('basic07-teacher-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-7')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-7');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-7');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-7');
} else {
    $response = \Livewire\Livewire::mount('basic07-teacher-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-7', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>


                <?php elseif($currentComponent === 'basic.class_section'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('basic10-class-section-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-8')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-8');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-8');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-8');
} else {
    $response = \Livewire\Livewire::mount('basic10-class-section-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-8', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

                <?php elseif($currentComponent === 'basic.class_subject'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('basic11-class-subject-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-9')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-9');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-9');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-9');
} else {
    $response = \Livewire\Livewire::mount('basic11-class-subject-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-9', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>




                <?php elseif($currentComponent === 'student.students_db'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('student-db-component')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-10')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-10');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-10');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-10');
} else {
    $response = \Livewire\Livewire::mount('student-db-component');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-10', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

                
                
                
                <?php elseif($currentComponent === 'exam.detail'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('exam05-exam-detail-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-11')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-11');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-11');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-11');
} else {
    $response = \Livewire\Livewire::mount('exam05-exam-detail-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-11', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

                <?php elseif($currentComponent === 'exam.fmpm'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('exam06-exam-fmpm-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-12')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-12');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-12');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-12');
} else {
    $response = \Livewire\Livewire::mount('exam06-exam-fmpm-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-12', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>


                <?php elseif($currentComponent === 'exam.exam_name'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('exam01-exam-name-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-13')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-13');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-13');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-13');
} else {
    $response = \Livewire\Livewire::mount('exam01-exam-name-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-13', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>



                <?php elseif($currentComponent === 'exam.exam_type'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('exam02-exam-type-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-14')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-14');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-14');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-14');
} else {
    $response = \Livewire\Livewire::mount('exam02-exam-type-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-14', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>


                <?php elseif($currentComponent === 'exam.exam_part'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('exam03-exam-part-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-15')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-15');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-15');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-15');
} else {
    $response = \Livewire\Livewire::mount('exam03-exam-part-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-15', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

                
                <?php elseif($currentComponent === 'exam.exam_mode'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('exam04-exam-mode-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-16')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-16');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-16');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-16');
} else {
    $response = \Livewire\Livewire::mount('exam04-exam-mode-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-16', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

                    


                <?php elseif($currentComponent === 'exam.exam_class_subject'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('exam06-exam-myclass-subject-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-17')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-17');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-17');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-17');
} else {
    $response = \Livewire\Livewire::mount('exam06-exam-myclass-subject-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-17', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
                    



                <?php elseif($currentComponent === 'exam.exam_schedule'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('exam09-exam-schedule-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-18')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-18');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-18');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-18');
} else {
    $response = \Livewire\Livewire::mount('exam09-exam-schedule-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-18', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>



                <?php elseif($currentComponent === 'marks_entry.wall'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('marks-entry-wall-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-19')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-19');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-19');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-19');
} else {
    $response = \Livewire\Livewire::mount('marks-entry-wall-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-19', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>                


                <?php elseif($currentComponent === 'marks_entry.anscr_distribution'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('exam07-anscr-distribution-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-20')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-20');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-20');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-20');
} else {
    $response = \Livewire\Livewire::mount('exam07-anscr-distribution-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-20', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>


                <?php elseif($currentComponent === 'marks_entry.marks_entry'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('exam10-exam-marks-entry-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-21')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-21');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-21');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-21');
} else {
    $response = \Livewire\Livewire::mount('exam10-exam-marks-entry-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-21', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>


                <?php elseif($currentComponent === 'marks_entry.mark_register'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('exam12-exam-mark-register-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-22')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-22');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-22');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-22');
} else {
    $response = \Livewire\Livewire::mount('exam12-exam-mark-register-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-22', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>


                    
                <?php elseif($currentComponent === 'exam.teacher_marks_entry'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('exam15-teacher-marks-entry-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-23')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-23');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-23');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-23');
} else {
    $response = \Livewire\Livewire::mount('exam15-teacher-marks-entry-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-23', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

                <?php elseif($currentComponent === 'exam.student_mark_sheet'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('exam20-student-mark-sheet-indv-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-24')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-24');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-24');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-24');
} else {
    $response = \Livewire\Livewire::mount('exam20-student-mark-sheet-indv-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-24', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

                <?php elseif($currentComponent === 'exam.student_mark_sheet2'): ?>
                    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('exam20-student-mark-sheet-indv2-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2091979430-25')) {
    $componentId = $_instance->getRenderedChildComponentId('l2091979430-25');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2091979430-25');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2091979430-25');
} else {
    $response = \Livewire\Livewire::mount('exam20-student-mark-sheet-indv2-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2091979430-25', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>



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

        /* Custom scrollbar for sidebar */
        aside nav::-webkit-scrollbar {
            width: 6px;
        }

        aside nav::-webkit-scrollbar-track {
            background: #1f2937;
        }

        aside nav::-webkit-scrollbar-thumb {
            background: #4b5563;
            border-radius: 3px;
        }

        aside nav::-webkit-scrollbar-thumb:hover {
            background: #6b7280;
        }
    </style>
</div><?php /**PATH D:\LaravelProject\LFS_Exam\resources\views/livewire/admin-dashboard-container-comp.blade.php ENDPATH**/ ?>