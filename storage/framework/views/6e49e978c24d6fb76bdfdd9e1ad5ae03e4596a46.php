<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap">

    <!-- Tailwind CSS CDN (fallback) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Local CSS (if compiled) -->
    <link rel="stylesheet" href="<?php echo e(asset('css/app.css')); ?>">

    <!-- Scripts -->
    <script src="<?php echo e(asset('js/app.js')); ?>" defer></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <?php echo \Livewire\Livewire::styles(); ?>


    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .sidebar-transition {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .menu-item-hover:hover {
            background-color: rgba(59, 130, 246, 0.1);
        }

        .submenu-enter {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-out;
        }

        .submenu-enter.open {
            max-height: 300px;
        }
    </style>
</head>

<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100">
        <?php echo $__env->make('layouts.navigation', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        
        
                
                

        <!-- Page Content -->
        <?php if(isset($slot)): ?>
            <?php echo e($slot); ?>

        <?php else: ?>
        <main>
            <?php echo $__env->yieldContent('content'); ?>
        </main>
        <?php endif; ?>


        <!-- Page Footer -->
        



        
    </div>

    <?php echo \Livewire\Livewire::scripts(); ?>

    <script src="<?php echo e(asset('js/app.js')); ?>"></script>
    <script src="<?php echo e(asset('js/bootstrap.js')); ?>"></script>
</body>

</html><?php /**PATH D:\LaravelProject\LFS_Exam\resources\views/layouts/app.blade.php ENDPATH**/ ?>