<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livewire Debug Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <?php echo \Livewire\Livewire::styles(); ?>

</head>

<body class="bg-gray-100">
    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Livewire Debug Test</h1>

            <?php
if (! isset($_instance)) {
    $html = \Livewire\Livewire::mount('debug-test-component')->html();
} elseif ($_instance->childHasBeenRendered('2sgSFsN')) {
    $componentId = $_instance->getRenderedChildComponentId('2sgSFsN');
    $componentTag = $_instance->getRenderedChildComponentTagName('2sgSFsN');
    $html = \Livewire\Livewire::dummyMount($componentId, $componentTag);
    $_instance->preserveRenderedChild('2sgSFsN');
} else {
    $response = \Livewire\Livewire::mount('debug-test-component');
    $html = $response->html();
    $_instance->logRenderedChild('2sgSFsN', $response->id(), \Livewire\Livewire::getRootElementTagName($html));
}
echo $html;
?>
        </div>
    </div>

    <?php echo \Livewire\Livewire::scripts(); ?>

</body>

</html><?php /**PATH D:\LaravelProject\LFS_Exam\resources\views/test-livewire-debug.blade.php ENDPATH**/ ?>