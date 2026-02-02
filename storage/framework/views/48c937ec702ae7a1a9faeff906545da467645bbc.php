<div>
    <div class="p-6">
        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">School Management</h1>
                <p class="text-gray-600 mt-1">Manage schools information with CRUD using modal</p>
            </div>
            <div class="flex space-x-3">
                <button wire:click="refreshData"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                    Refresh
                </button>
                <button wire:click="openModal"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>New School
                </button>
            </div>
        </div>

        <!-- Flash Messages -->
        <?php if(session()->has('message')): ?>
            <div class="mb-4 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-md">
                <div class="flex">
                    <i class="fas fa-check-circle mr-2 mt-0.5"></i>
                    <?php echo e(session('message')); ?>

                </div>
            </div>
        <?php endif; ?>

        <?php if(session()->has('error')): ?>
            <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
                <div class="flex">
                    <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                    <?php echo e(session('error')); ?>

                </div>
            </div>
        <?php endif; ?>

        <!-- Filters -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search</label>
                    <input type="text" wire:model.debounce.300ms="searchTerm" placeholder="Search by name, code, location..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="flex items-end">
                    <button wire:click="clearFilters"
                        class="w-full px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                        Clear Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Schools Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Schools</h3>
            </div>

            <?php if($schools && $schools->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Address</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Index</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">HS Code</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__currentLoopData = $schools; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $school): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($school->id); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900"><?php echo e($school->name); ?></div>
                                        <div class="text-xs text-gray-500">Session: <?php echo e($school->session_id); ?></div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($school->code); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        <?php echo e($school->vill); ?>, <?php echo e($school->po); ?>, <?php echo e($school->ps); ?>, <?php echo e($school->dist); ?>, <?php echo e($school->pin); ?>

                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($school->index); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500"><?php echo e($school->hscode); ?></td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-0.5 text-xs font-semibold rounded-full <?php echo e($school->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800'); ?>">
                                            <?php echo e(ucfirst($school->status ?? 'inactive')); ?>

                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <div class="flex space-x-2 justify-end">
                                            <button wire:click="openModal(<?php echo e($school->id); ?>)" class="px-2 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200">Edit</button>
                                            <?php if(($school->status ?? 'inactive') === 'active'): ?>
                                                <button wire:click="toggleStatus(<?php echo e($school->id); ?>)" onclick="return confirm('Deactivate this school?')" class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200">Deactivate</button>
                                            <?php else: ?>
                                                <button wire:click="toggleStatus(<?php echo e($school->id); ?>)" onclick="return confirm('Activate this school?')" class="px-2 py-1 bg-green-100 text-green-700 rounded hover:bg-green-200">Activate</button>
                                            <?php endif; ?>
                                            <button wire:click="delete(<?php echo e($school->id); ?>)" onclick="return confirm('Delete this school?')" class="px-2 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>

                <div class="px-6 py-4 border-t border-gray-200">
                    <?php echo e($schools->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-school text-6xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Schools Found</h3>
                    <p class="text-gray-600 mb-4">Start by creating your first school.</p>
                    <button wire:click="openModal" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Create School
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal -->
    <?php if($showModal): ?>
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4" style="z-index: 9999;">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
                <!-- Modal Header -->
                <div class="flex justify-between items-center p-6 border-b border-gray-200 bg-blue-50">
                    <h3 class="text-xl font-semibold text-gray-900">
                        <?php echo e($editMode ? 'Edit School' : 'Create School'); ?>

                    </h3>
                    <button wire:click="closeModal" class="text-gray-500 hover:text-gray-700">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        
                        <!-- Name -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Name *</label>
                            <input type="text" wire:model="name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Code -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Code</label>
                            <input type="text" wire:model="code" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <!-- Session ID -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Session ID *</label>
                            <input type="number" wire:model="session_id" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <?php $__errorArgs = ['session_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Details -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Details</label>
                            <textarea wire:model="details" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="School details..."></textarea>
                            <?php $__errorArgs = ['details'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Address Fields -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Village</label>
                            <input type="text" wire:model="vill" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">P.O.</label>
                            <input type="text" wire:model="po" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">P.S.</label>
                            <input type="text" wire:model="ps" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">PIN</label>
                            <input type="text" wire:model="pin" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">District</label>
                            <input type="text" wire:model="dist" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        
                        <!-- Codes/Indexes -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Index</label>
                            <input type="text" wire:model="index" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">HS Code</label>
                            <input type="text" wire:model="hscode" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">DISE Code</label>
                            <input type="text" wire:model="disecode" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Established</label>
                            <input type="text" wire:model="estd" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500" placeholder="e.g., 1985">
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select wire:model="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                            </select>
                        </div>

                        <!-- Remark -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Remark</label>
                            <textarea wire:model="remark" rows="2" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end items-center p-6 border-t border-gray-200 space-x-3">
                    <button wire:click="closeModal" class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">Cancel</button>
                    <button wire:click="save" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i><?php echo e($editMode ? 'Update' : 'Save'); ?>

                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH /home/bkoq0ic0h8xi/public_html/littleflowerschool.co.in/resources/views/livewire/school-comp.blade.php ENDPATH**/ ?>