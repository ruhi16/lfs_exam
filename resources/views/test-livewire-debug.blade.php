<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livewire Debug Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @livewireStyles
</head>

<body class="bg-gray-100">
    <div class="min-h-screen py-8">
        <div class="max-w-4xl mx-auto px-4">
            <h1 class="text-3xl font-bold text-gray-900 mb-8">Livewire Debug Test</h1>

            @livewire('debug-test-component')
        </div>
    </div>

    @livewireScripts
</body>

</html>