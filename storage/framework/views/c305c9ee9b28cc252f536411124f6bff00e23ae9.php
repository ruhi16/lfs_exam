<div>

    <div class="p-6">
        <!-- Debug Panel -->
        <div class="mb-4 p-3 bg-yellow-100 border border-yellow-400 rounded text-sm">
            <strong>🐛 DEBUG:</strong>
            showModal = <span
                class="font-bold <?php echo e($showModal ? 'text-green-600' : 'text-red-600'); ?>"><?php echo e($showModal ? 'TRUE' : 'FALSE'); ?></span>,
            editMode = <?php echo e($editMode ? 'true' : 'false'); ?>,
            subjects = <?php echo e($subjects ? $subjects->count() : 'NULL'); ?>,
            teachers = <?php echo e($teachers ? $teachers->count() : 'NULL'); ?>

        </div>

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Teacher Management</h1>
                <p class="text-gray-600 mt-1">Manage teaching staff with categories and qualifications</p>
            </div>
            <div class="flex space-x-3">
                <button wire:click="refreshData"
                    class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                    <i class="fas fa-sync-alt mr-2"></i>Refresh
                </button>
                <button wire:click="$set('showModal', true)"
                    class="px-3 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors">
                    Force
                </button>
                <button wire:click="testModal"
                    class="px-3 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">
                    Test
                </button>
                <button wire:click="openModal"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-plus mr-2"></i>Add Teacher
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

        
        <!-- Filters Section -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Search Teachers</label>
                    <input type="text" wire:model.debounce.300ms="searchTerm"
                        placeholder="Search by name, mobile, or designation..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Category</label>
                    <select wire:model="selectedCategory"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="">All Categories</option>
                        <?php $__currentLoopData = $teacherCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $designations): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category); ?>"><?php echo e($category); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="flex items-end">
                    <button wire:click="clearFilters"
                        class="w-full px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors">
                        <i class="fas fa-refresh mr-2"></i>Clear Filters
                    </button>
                </div>
            </div>
        </div>

        <!-- Teachers Table -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Teaching Staff Directory</h3>
            </div>

            <?php if($teachers && $teachers->count() > 0): ?>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Teacher Details
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Designation & Category
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Qualifications
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Subject & Contact
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Actions
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php $__currentLoopData = $teachers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $teacher): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr class="hover:bg-gray-50">
                                    <!-- Teacher Details -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-12 w-12">
                                                <?php if($teacher->img_ref): ?>
                                                    
                                                    <img src="<?php echo e(asset('storage/student-profiles/' . $teacher->img_ref)); ?>" alt="<?php echo e($teacher->name); ?>"
                                                        class="h-12 w-12 rounded-full object-cover border-2 border-gray-200"
                                                        onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                                    <div
                                                        class="h-12 w-12 rounded-full bg-gray-300 items-center justify-center border-2 border-gray-200 hidden">
                                                        <i class="fas fa-user text-gray-600"></i>
                                                    </div>
                                                <?php else: ?>
                                                    <div
                                                        class="h-12 w-12 rounded-full bg-gray-300 flex items-center justify-center border-2 border-gray-200">
                                                        <i class="fas fa-chalkboard-teacher text-gray-600"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900"><?php echo e($teacher->name); ?></div>
                                                <?php if($teacher->nickName): ?>
                                                    <div class="text-sm text-gray-500">"<?php echo e($teacher->nickName); ?>"</div>
                                                <?php endif; ?>
                                                <div class="text-xs text-gray-400">ID: <?php echo e($teacher->id); ?></div>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Designation & Category -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <div class="font-medium"><?php echo e($teacher->desig); ?></div>
                                            <span
                                                class="inline-flex px-2 py-1 text-xs font-semibold rounded-full mt-1 <?php echo e($this->getCategoryColor($this->getTeacherCategory($teacher->desig))); ?>">
                                                <?php echo e($this->getTeacherCategory($teacher->desig)); ?>

                                            </span>
                                        </div>
                                    </td>

                                    <!-- Qualifications -->
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-900">
                                            <?php if($teacher->hqual): ?>
                                                <div class="flex items-center mb-1">
                                                    <i class="fas fa-graduation-cap text-blue-500 w-4 mr-2"></i>
                                                    <span class="font-medium"><?php echo e($teacher->hqual); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if($teacher->train_qual): ?>
                                                <div class="flex items-center mb-1">
                                                    <i class="fas fa-certificate text-green-500 w-4 mr-2"></i>
                                                    <span class="text-sm"><?php echo e($teacher->train_qual); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if($teacher->extra_qual): ?>
                                                <div class="flex items-center">
                                                    <i class="fas fa-plus-circle text-purple-500 w-4 mr-2"></i>
                                                    <span class="text-sm"><?php echo e($teacher->extra_qual); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if(!$teacher->hqual && !$teacher->train_qual && !$teacher->extra_qual): ?>
                                                <span class="text-gray-400 text-sm">No qualifications listed</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <!-- Subject & Contact -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            <?php if($teacher->subject): ?>
                                                <div class="flex items-center mb-1">
                                                    <i class="fas fa-book text-indigo-500 w-4 mr-2"></i>
                                                    <span class="font-medium"><?php echo e($teacher->subject->name); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if($teacher->mobno): ?>
                                                <div class="flex items-center">
                                                    <i class="fas fa-phone text-green-500 w-4 mr-2"></i>
                                                    <span><?php echo e($teacher->mobno); ?></span>
                                                </div>
                                            <?php endif; ?>
                                            <?php if(!$teacher->subject && !$teacher->mobno): ?>
                                                <span class="text-gray-400 text-sm">No contact info</span>
                                            <?php endif; ?>
                                        </div>
                                    </td>

                                    <!-- Status -->
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full <?php echo e($this->getStatusColor($teacher->status)); ?>">
                                            <?php echo e(ucfirst($teacher->status)); ?>

                                        </span>
                                        <?php if($teacher->remark): ?>
                                            <div class="text-xs text-gray-500 mt-1"><?php echo e(Str::limit($teacher->remark, 30)); ?></div>
                                        <?php endif; ?>
                                    </td>

                                    <!-- Actions -->
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <div class="flex space-x-2">
                                            <button wire:click="openModal(<?php echo e($teacher->id); ?>)"
                                                class="inline-flex items-center px-2 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 transition-colors"
                                                title="Edit Teacher">
                                                <i class="fas fa-edit text-xs"></i>
                                            </button>

                                            <?php if($teacher->status === 'active'): ?>
                                                <button wire:click="toggleStatus(<?php echo e($teacher->id); ?>)"
                                                    onclick="return confirm('Are you sure you want to suspend this teacher?')"
                                                    class="inline-flex items-center px-2 py-1 bg-yellow-100 text-yellow-700 rounded hover:bg-yellow-200 transition-colors"
                                                    title="Suspend Teacher">
                                                    <i class="fas fa-pause text-xs">Suspend</i>
                                                </button>
                                            <?php else: ?>
                                                <button wire:click="toggleStatus(<?php echo e($teacher->id); ?>)"
                                                    onclick="return confirm('Are you sure you want to activate this teacher?')"
                                                    class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded hover:bg-green-200 transition-colors"
                                                    title="Activate Teacher">
                                                    <i class="fas fa-play text-xs">Active</i>
                                                </button>
                                            <?php endif; ?>

                                            <button wire:click="delete(<?php echo e($teacher->id); ?>)"
                                                onclick="return confirm('Are you sure you want to delete this teacher? This action cannot be undone.')"
                                                class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 rounded hover:bg-red-200 transition-colors"
                                                title="Delete Teacher">
                                                <i class="fas fa-trash text-xs">Delete</i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                    
                </div>

                <!-- Pagination -->
                <div class="px-6 py-4 border-t border-gray-200">
                    <?php echo e($teachers->links()); ?>

                </div>
            <?php else: ?>
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <i class="fas fa-chalkboard-teacher text-6xl"></i>
                    </div>
                    <?php echo e(json_encode($teachers)); ?>

                    <h3 class="text-lg font-medium text-gray-900 mb-2">No Teachers Found</h3>
                    <p class="text-gray-600 mb-4">Get started by adding your first teacher.</p>
                    <button wire:click="openModal"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-plus mr-2"></i>Add Teacher
                    </button>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Modal -->
    <?php if($showModal): ?>
        
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 flex items-center justify-center p-4" style="z-index: 9999;">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-y-auto border-4 border-blue-500">
                <!-- Modal Header -->
                <div class="flex justify-between items-center p-6 border-b border-gray-200 bg-blue-100">
                    <h3 class="text-xl font-semibold text-gray-900">
                        🎯 MODAL IS WORKING! <?php echo e($editMode ? 'Edit Teacher' : 'Add New Teacher'); ?>

                    </h3>
                    <button wire:click="closeModal" class="text-red-600 hover:text-red-800 text-2xl font-bold">
                        ✕
                    </button>
                </div>
                <?php if(session()->has('error')): ?>
                    <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-md">
                        <div class="flex">
                            <i class="fas fa-exclamation-circle mr-2 mt-0.5"></i>
                            <?php echo e(session('error')); ?>

                        </div>
                    </div>
                <?php endif; ?>

                <!-- Modal Body -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div class="md:col-span-2 border-b border-gray-200 pb-4 mb-4">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Basic Information</h4>
                        </div>

                        <!-- Teacher Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Teacher Name *</label>
                            <input type="text" wire:model="name"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Full name of the teacher">
                            <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Nick Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nick Name</label>
                            <input type="text" wire:model="nickName"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Preferred name or nickname">
                            <?php $__errorArgs = ['nickName'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Mobile Number -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Mobile Number</label>
                            <input type="text" wire:model="mobno"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Contact number">
                            <?php $__errorArgs = ['mobno'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Designation -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Designation *</label>
                            <select wire:model="desig"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <?php $__currentLoopData = $teacherCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category => $designations): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <optgroup label="<?php echo e($category); ?>">
                                        <?php $__currentLoopData = $designations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $designation): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($designation); ?>"><?php echo e($designation); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </optgroup>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['desig'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Qualifications Section -->
                        <div class="md:col-span-2 border-b border-gray-200 pb-4 mb-4 mt-4">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Qualifications</h4>
                        </div>

                        <!-- Highest Qualification -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Highest Qualification</label>
                            <input type="text" wire:model="hqual"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="e.g., M.A., B.Ed., Ph.D.">
                            <?php $__errorArgs = ['hqual'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Training Qualification -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Training Qualification</label>
                            <input type="text" wire:model="train_qual"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="e.g., B.Ed., D.Ed., TET">
                            <?php $__errorArgs = ['train_qual'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Extra Qualification -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Additional Qualifications</label>
                            <input type="text" wire:model="extra_qual"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Any additional certifications or qualifications">
                            <?php $__errorArgs = ['extra_qual'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Subject & Status Section -->
                        <div class="md:col-span-2 border-b border-gray-200 pb-4 mb-4 mt-4">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Subject & Status</h4>
                        </div>

                        <!-- Main Subject -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Main Subject</label>
                            <select wire:model="main_subject_id"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Select Subject</option>
                                <?php if($subjects && $subjects->count() > 0): ?>
                                    <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($subject->id); ?>"><?php echo e($subject->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                <?php else: ?>
                                    <option value="" disabled>No subjects available</option>
                                <?php endif; ?>
                            </select>
                            <?php $__errorArgs = ['main_subject_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                            <select wire:model="status"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="retired">Retired</option>
                                <option value="transferred">Transferred</option>
                            </select>
                            <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Profile Image -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Profile Image</label>
                            <input type="file" wire:model="profile_image" accept="image/*"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <?php $__errorArgs = ['profile_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <?php if($profile_image): ?>
                                <div class="mt-2">
                                    <img src="<?php echo e($profile_image->temporaryUrl()); ?>" class="w-20 h-20 object-cover rounded-lg">
                                </div>
                            <?php elseif($img_ref): ?>
                                <div class="mt-2">
                                    <img src="<?php echo e(asset('storage/' . $img_ref)); ?>" class="w-20 h-20 object-cover rounded-lg">
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Notes -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                            <textarea wire:model="notes" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Additional notes about the teacher..."></textarea>
                            <?php $__errorArgs = ['notes'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <!-- Remarks -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Remarks</label>
                            <textarea wire:model="remark" rows="2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Any additional remarks..."></textarea>
                            <?php $__errorArgs = ['remark'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <span class="text-red-500 text-sm"><?php echo e($message); ?></span> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end items-center p-6 border-t border-gray-200 space-x-3">
                    <button wire:click="closeModal"
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg hover:bg-gray-400 transition-colors">
                        Cancel
                    </button>
                    <button wire:click="save"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="fas fa-save mr-2"></i><?php echo e($editMode ? 'Update' : 'Create'); ?> Teacher
                    </button>
                </div>
            </div>
        </div>
    <?php endif; ?>

</div><?php /**PATH /home/bkoq0ic0h8xi/public_html/littleflowerschool.co.in/resources/views/livewire/teacher-comp.blade.php ENDPATH**/ ?>