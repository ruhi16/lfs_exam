<div class="w-full bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="flex items-center gap-5 p-4">
        <!-- Avatar + basic info -->
        <div class="relative flex-shrink-0">
            <?php if(isset($teacher) && $teacher->img_ref): ?>
                <img class="h-16 w-16 rounded-full object-cover border-2 border-white shadow"
                     src="<?php echo e(asset('storage/' . $teacher->img_ref)); ?>" alt="<?php echo e($user->name); ?>">
            <?php else: ?>
                <div class="h-16 w-16 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-2xl shadow">
                    <?php echo e(mb_substr($user->name ?? '', 0, 1)); ?>

                </div>
            <?php endif; ?>
            <span class="absolute -bottom-0.5 -right-0.5 h-4 w-4 bg-green-500 rounded-full border-2 border-white"></span>
        </div>

        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-3 flex-wrap">
                <h2 class="text-lg font-semibold text-gray-900 truncate"><?php echo e($user->name ?? '—'); ?></h2>
                <?php if(isset($role) && $role->name): ?>
                    <span class="inline-flex px-2.5 py-0.5 text-xs font-medium bg-indigo-100 text-indigo-800 rounded-full">
                        <?php echo e($role->name); ?>

                    </span>
                <?php endif; ?>
                <span class="inline-flex items-center gap-1.5 px-2.5 py-0.5 text-xs font-medium rounded-full
                    <?php echo e(($user->status ?? 'active') === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'); ?>">
                    <span class="h-2 w-2 rounded-full <?php echo e(($user->status ?? 'active') === 'active' ? 'bg-green-500' : 'bg-red-500'); ?>"></span>
                    <?php echo e(ucfirst($user->status ?? 'Active')); ?>

                </span>
            </div>

            <div class="mt-1 text-sm text-gray-600 flex flex-wrap gap-x-4 gap-y-1">
                <span><?php echo e($user->email ?? '—'); ?></span>
                <?php if(isset($teacher)): ?>
                    <span>• <?php echo e($teacher->desig ?: '—'); ?></span>
                    <?php if($teacher->mobno): ?>
                        <span>• <?php echo e($teacher->mobno); ?></span>
                    <?php endif; ?>
                    <?php if(isset($teacher->school)): ?>
                        <span>• <?php echo e($teacher->school->name ?? '—'); ?></span>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div><?php /**PATH D:\LaravelProject\LFS_Exam\resources\views/livewire/subadmin-dc-profile-comp.blade.php ENDPATH**/ ?>