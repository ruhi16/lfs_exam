<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    

    <div class="font-semibold text-xl text-gray-800 leading-tight">
        <?php echo e(__('Admin Dashboard')); ?>

    </div>
    
    <div class="p-6">
        
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('admin-dashboard-container-comp')->html();
} elseif ($_instance->childHasBeenRendered('P5Tky8J')) {
    $componentId = $_instance->getRenderedChildComponentId('P5Tky8J');
    $componentTag = $_instance->getRenderedChildComponentTagName('P5Tky8J');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('P5Tky8J');
} else {
    $response = \Livewire\Livewire::mount('admin-dashboard-container-comp');
    $html = $response->html();
    $_instance->logRenderedChild('P5Tky8J', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>        
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH D:\LaravelProject\LFS_Exam\resources\views/components/admin-dashboard.blade.php ENDPATH**/ ?>