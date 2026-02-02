<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    
    <div class="font-semibold text-xl text-gray-800 leading-tight">
        <?php echo e(__('Subadmin Dashboard')); ?>

    </div>

    <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('subadmin-dashboard-container-comp')->html();
} elseif ($_instance->childHasBeenRendered('vO7utTD')) {
    $componentId = $_instance->getRenderedChildComponentId('vO7utTD');
    $componentTag = $_instance->getRenderedChildComponentTagName('vO7utTD');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('vO7utTD');
} else {
    $response = \Livewire\Livewire::mount('subadmin-dashboard-container-comp');
    $html = $response->html();
    $_instance->logRenderedChild('vO7utTD', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>

    
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?>
<?php /**PATH D:\LaravelProject\LFS_Exam\resources\views/components/subadmin-dashboard.blade.php ENDPATH**/ ?>