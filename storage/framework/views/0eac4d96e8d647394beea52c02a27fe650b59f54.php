<div>
    <!-- Tabs -->
    <div class="border-b border-gray-200">
        <nav class="-mb-px flex space-x-8 overflow-x-auto">
            <button wire:click="switchTab('school')"
                class="<?php echo e($activeTab === 'school' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Schools
            </button>
            <button wire:click="switchTab('session')"
                class="<?php echo e($activeTab === 'session' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Sessions
            </button>
            <button wire:click="switchTab('class')"
                class="<?php echo e($activeTab === 'class' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Classes
            </button>
            <button wire:click="switchTab('section')"
                class="<?php echo e($activeTab === 'section' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Sections
            </button>
            <button wire:click="switchTab('subject')"
                class="<?php echo e($activeTab === 'subject' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Subjects
            </button>
            <button wire:click="switchTab('room')"
                class="<?php echo e($activeTab === 'room' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300'); ?> whitespace-nowrap py-4 px-1 border-b-2 font-medium text-sm">
                Rooms
            </button>
        </nav>
    </div>

    <!-- Tab Content -->
    <div class="mt-6">
        <?php if($activeTab === 'school'): ?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('basic01-school-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2311235922-0')) {
    $componentId = $_instance->getRenderedChildComponentId('l2311235922-0');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2311235922-0');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2311235922-0');
} else {
    $response = \Livewire\Livewire::mount('basic01-school-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2311235922-0', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        <?php elseif($activeTab === 'session'): ?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('basic02-session-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2311235922-1')) {
    $componentId = $_instance->getRenderedChildComponentId('l2311235922-1');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2311235922-1');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2311235922-1');
} else {
    $response = \Livewire\Livewire::mount('basic02-session-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2311235922-1', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        <?php elseif($activeTab === 'class'): ?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('basic03-class-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2311235922-2')) {
    $componentId = $_instance->getRenderedChildComponentId('l2311235922-2');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2311235922-2');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2311235922-2');
} else {
    $response = \Livewire\Livewire::mount('basic03-class-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2311235922-2', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        <?php elseif($activeTab === 'section'): ?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('basic04-section-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2311235922-3')) {
    $componentId = $_instance->getRenderedChildComponentId('l2311235922-3');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2311235922-3');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2311235922-3');
} else {
    $response = \Livewire\Livewire::mount('basic04-section-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2311235922-3', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        <?php elseif($activeTab === 'subject'): ?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('basic06-subject-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2311235922-4')) {
    $componentId = $_instance->getRenderedChildComponentId('l2311235922-4');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2311235922-4');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2311235922-4');
} else {
    $response = \Livewire\Livewire::mount('basic06-subject-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2311235922-4', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        <?php elseif($activeTab === 'room'): ?>
            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('basic05-room-comp')->html();
} elseif ($_instance->childHasBeenRendered('l2311235922-5')) {
    $componentId = $_instance->getRenderedChildComponentId('l2311235922-5');
    $componentTag = $_instance->getRenderedChildComponentTagName('l2311235922-5');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('l2311235922-5');
} else {
    $response = \Livewire\Livewire::mount('basic05-room-comp');
    $html = $response->html();
    $_instance->logRenderedChild('l2311235922-5', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        <?php endif; ?>
    </div>
</div><?php /**PATH D:\LaravelProject\LFS_Exam\resources\views/livewire/admin-dc-basic-wall-comp.blade.php ENDPATH**/ ?>