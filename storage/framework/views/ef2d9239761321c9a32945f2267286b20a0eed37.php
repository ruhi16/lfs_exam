<?php $__env->startComponent($view, $params); ?>
    <?php $__env->slot($slotOrSection); ?>
        <?php echo $manager->initialDehydrate()->toInitialResponse()->effects['html']; ?>

    <?php $__env->endSlot(); ?>
<?php echo $__env->renderComponent(); ?>
<?php /**PATH /home/bkoq0ic0h8xi/public_html/littleflowerschool.co.in/vendor/livewire/livewire/src/Macros/livewire-view-component.blade.php ENDPATH**/ ?>