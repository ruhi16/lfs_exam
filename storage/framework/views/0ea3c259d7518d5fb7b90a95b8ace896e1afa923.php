<?php if (isset($component)) { $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\AppLayout::class, []); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    

    
    
    
    
    <div class="p-6">
        <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('dashboard-comp')->html();
} elseif ($_instance->childHasBeenRendered('TKgB5o9')) {
    $componentId = $_instance->getRenderedChildComponentId('TKgB5o9');
    $componentTag = $_instance->getRenderedChildComponentTagName('TKgB5o9');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('TKgB5o9');
} else {
    $response = \Livewire\Livewire::mount('dashboard-comp');
    $html = $response->html();
    $_instance->logRenderedChild('TKgB5o9', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        
    </div>
    
    
    

 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da)): ?>
<?php $component = $__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da; ?>
<?php unset($__componentOriginal8e2ce59650f81721f93fef32250174d77c3531da); ?>
<?php endif; ?><?php /**PATH /home/bkoq0ic0h8xi/public_html/littleflowerschool.co.in/resources/views/components/admin-dashboard.blade.php ENDPATH**/ ?>