<div x-data="{ isOpen: @entangle('isOpen') }">
    <!-- Modal backdrop -->
    <div x-show="isOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;" x-on:keydown.escape.window="$wire.call('closeModal')">
        <div x-show="isOpen" class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity" aria-hidden="true" x-on:click="$wire.call('closeModal')">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <!-- Modal panel -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block w-full max-w-3xl p-6 my-8 overflow-hidden text-left align-bottom transition-all transform bg-white shadow-xl rounded-lg sm:my-8 sm:align-middle sm:w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-2xl leading-6 font-bold text-gray-900 mb-4" id="modal-headline">
                                {{ $exam05DetailId ? 'Edit Exam Detail' : 'Add New Exam Detail' }}
                            </h3>
                            <div class="mt-2">
                                <form>
                                    @csrf
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div class="mb-4">
                                            <label for="name" class="block text-sm font-medium text-gray-700">Name *</label>
                                            <input type="text" 
                                                   wire:model="name" 
                                                   id="name" 
                                                   class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border @error('name') border-red-500 @enderror"
                                                   placeholder="Enter exam detail name">
                                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="order_index" class="block text-sm font-medium text-gray-700">Order Index</label>
                                            <input type="number" 
                                                   wire:model="order_index" 
                                                   id="order_index" 
                                                   class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border @error('order_index') border-red-500 @enderror"
                                                   placeholder="Enter order index">
                                            @error('order_index') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                            <textarea 
                                                   wire:model="description" 
                                                   id="description" 
                                                   rows="2"
                                                   class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border @error('description') border-red-500 @enderror"
                                                   placeholder="Enter description"></textarea>
                                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                            <input type="text" 
                                                   wire:model="status" 
                                                   id="status" 
                                                   class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border @error('status') border-red-500 @enderror"
                                                   placeholder="Enter status">
                                            @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                            <textarea 
                                                   wire:model="remarks" 
                                                   id="remarks" 
                                                   rows="2"
                                                   class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md p-2 border @error('remarks') border-red-500 @enderror"
                                                   placeholder="Enter remarks"></textarea>
                                            @error('remarks') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="myclass_id" class="block text-sm font-medium text-gray-700">Class</label>
                                            <select wire:model="myclass_id" 
                                                    id="myclass_id" 
                                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md p-2 border @error('myclass_id') border-red-500 @enderror">
                                                <option value="">-- Select Class --</option>
                                                @foreach($classes as $class)
                                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('myclass_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="exam_name_id" class="block text-sm font-medium text-gray-700">Exam Name</label>
                                            <select wire:model="exam_name_id" 
                                                    id="exam_name_id" 
                                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md p-2 border @error('exam_name_id') border-red-500 @enderror">
                                                <option value="">-- Select Exam Name --</option>
                                                @foreach($examNames as $examName)
                                                    <option value="{{ $examName->id }}">{{ $examName->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('exam_name_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="exam_type_id" class="block text-sm font-medium text-gray-700">Exam Type</label>
                                            <select wire:model="exam_type_id" 
                                                    id="exam_type_id" 
                                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md p-2 border @error('exam_type_id') border-red-500 @enderror">
                                                <option value="">-- Select Exam Type --</option>
                                                @foreach($examTypes as $examType)
                                                    <option value="{{ $examType->id }}">{{ $examType->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('exam_type_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="exam_part_id" class="block text-sm font-medium text-gray-700">Exam Part</label>
                                            <select wire:model="exam_part_id" 
                                                    id="exam_part_id" 
                                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md p-2 border @error('exam_part_id') border-red-500 @enderror">
                                                <option value="">-- Select Exam Part --</option>
                                                @foreach($examParts as $examPart)
                                                    <option value="{{ $examPart->id }}">{{ $examPart->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('exam_part_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="exam_mode_id" class="block text-sm font-medium text-gray-700">Exam Mode</label>
                                            <select wire:model="exam_mode_id" 
                                                    id="exam_mode_id" 
                                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md p-2 border @error('exam_mode_id') border-red-500 @enderror">
                                                <option value="">-- Select Exam Mode --</option>
                                                @foreach($examModes as $examMode)
                                                    <option value="{{ $examMode->id }}">{{ $examMode->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('exam_mode_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="session_id" class="block text-sm font-medium text-gray-700">Session</label>
                                            <select wire:model="session_id" 
                                                    id="session_id" 
                                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md p-2 border @error('session_id') border-red-500 @enderror">
                                                <option value="">-- Select Session --</option>
                                                @foreach($sessions as $session)
                                                    <option value="{{ $session->id }}">{{ $session->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('session_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="school_id" class="block text-sm font-medium text-gray-700">School</label>
                                            <select wire:model="school_id" 
                                                    id="school_id" 
                                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md p-2 border @error('school_id') border-red-500 @enderror">
                                                <option value="">-- Select School --</option>
                                                @foreach($schools as $school)
                                                    <option value="{{ $school->id }}">{{ $school->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('school_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="user_id" class="block text-sm font-medium text-gray-700">User</label>
                                            <select wire:model="user_id" 
                                                    id="user_id" 
                                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md p-2 border @error('user_id') border-red-500 @enderror">
                                                <option value="">-- Select User --</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('user_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div class="mb-4">
                                            <label for="approved_by" class="block text-sm font-medium text-gray-700">Approved By</label>
                                            <select wire:model="approved_by" 
                                                    id="approved_by" 
                                                    class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm rounded-md p-2 border @error('approved_by') border-red-500 @enderror">
                                                <option value="">-- Select Approver --</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('approved_by') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                        
                                        <div class="mb-4 flex items-center">
                                            <input type="checkbox" 
                                                   wire:model="is_optional" 
                                                   id="is_optional" 
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <label for="is_optional" class="ml-2 block text-sm text-gray-700">
                                                Is Optional
                                            </label>
                                        </div>
                                        
                                        <div class="mb-4 flex items-center">
                                            <input type="checkbox" 
                                                   wire:model="is_active" 
                                                   id="is_active" 
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <label for="is_active" class="ml-2 block text-sm text-gray-700">
                                                Is Active
                                            </label>
                                        </div>
                                        
                                        <div class="mb-4 flex items-center">
                                            <input type="checkbox" 
                                                   wire:model="is_finalized" 
                                                   id="is_finalized" 
                                                   class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                                            <label for="is_finalized" class="ml-2 block text-sm text-gray-700">
                                                Is Finalized
                                            </label>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click.prevent="store()" 
                            type="button" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm">
                        {{ $exam05DetailId ? 'Update' : 'Save' }}
                    </button>
                    <button wire:click="closeModal()" 
                            type="button" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                        Cancel
                    </button>
                </div>
            </div>
        </div>

    <!-- Filter Section -->
    <div class="bg-white shadow rounded-lg p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700 mb-1">Search</label>
                <input type="text" 
                       wire:model.debounce.300ms="search" 
                       id="search"
                       placeholder="Search exam details..." 
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
            </div>
            
            <div>
                <label for="selectedSession" class="block text-sm font-medium text-gray-700 mb-1">Session</label>
                <select wire:model="selectedSession" 
                        id="selectedSession"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Sessions</option>
                    @foreach($sessions as $session)
                        <option value="{{ $session->id }}">{{ $session->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div>
                <label for="selectedSchool" class="block text-sm font-medium text-gray-700 mb-1">School</label>
                <select wire:model="selectedSchool" 
                        id="selectedSchool"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                    <option value="">All Schools</option>
                    @foreach($schools as $school)
                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="flex items-end">
                <button class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                    Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Exam Details Overview</h2>
            <div class="flex space-x-2">
                <button wire:click="create()" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Add New Exam Detail
                </button>
                <button wire:click="exportData()" class="bg-gray-600 text-white px-4 py-2 rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                    Export Data
                </button>
            </div>
        </div>

        <!-- Grouped Table -->
        <div class="overflow-x-auto">
            @forelse($groupedData as $groupName => $group)
                <div class="mb-8 border border-gray-200 rounded-lg">
                    <!-- Group Header -->
                    <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $groupName }}</h3>
                    </div>
                    
                    <!-- Group Content -->
                    <div class="p-6">
                        @if(count($group['classes']) > 0)
                            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                                @foreach($group['classes'] as $className)
                                    <div class="border border-gray-200 rounded-lg">
                                        <div class="bg-blue-50 px-4 py-2 border-b border-gray-200">
                                            <h4 class="font-medium text-blue-800">{{ $className }}</h4>
                                        </div>
                                        <div class="p-4">
                                            <!-- Exam Parts for this class -->
                                            @php
                                                $classDetails = array_filter($group['details'], function($detail) use ($className) {
                                                    return $detail && $detail->myclass && $detail->myclass->name === $className;
                                                });
                                            @endphp
                                            
                                            @if(count($classDetails) > 0)
                                                <div class="space-y-3">
                                                    @foreach($classDetails as $detail)
                                                        @if($detail && $detail->myclass)
                                                        <div class="border border-gray-100 rounded p-3 hover:bg-gray-50">
                                                            <div class="flex justify-between items-start">
                                                                <div class="flex-1">
                                                                    <div class="flex items-center space-x-2 mb-2">
                                                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                                                            {{ $detail->examPart && $detail->examPart->name ? $detail->examPart->name : 'N/A' }}
                                                                        </span>
                                                                        <span class="text-sm text-gray-600">
                                                                            {{ $detail->examMode && $detail->examMode->name ? $detail->examMode->name : 'N/A' }}
                                                                        </span>
                                                                    </div>
                                                                    
                                                                    <div class="text-sm text-gray-500 space-y-1">
                                                                        @if($detail->description)
                                                                            <p>{{ Str::limit($detail->description, 50) }}</p>
                                                                        @endif
                                                                        <div class="flex flex-wrap gap-2 mt-2">
                                                                            @if($detail->order_index !== null && $detail->order_index !== '')
                                                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs bg-gray-100 text-gray-800">
                                                                                    Order: {{ $detail->order_index }}
                                                                                </span>
                                                                            @endif
                                                                            @if($detail->is_optional)
                                                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">
                                                                                    Optional
                                                                                </span>
                                                                            @endif
                                                                            @if($detail->status)
                                                                                <span class="inline-flex items-center px-2 py-1 rounded text-xs bg-green-100 text-green-800">
                                                                                    {{ $detail->status }}
                                                                                </span>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="flex space-x-1">
                                                                    <button wire:click="edit({{ $detail->id }})" class="text-blue-600 hover:text-blue-900 p-1">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                                        </svg>
                                                                    </button>
                                                                    <button wire:click="delete({{ $detail->id }})" class="text-red-600 hover:text-red-900 p-1">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            
                                                            @if($detail->remarks)
                                                                <div class="mt-2 pt-2 border-t border-gray-100">
                                                                    <p class="text-xs text-gray-500 italic">{{ $detail->remarks }}</p>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="text-center py-4 text-gray-500">
                                                    <p>No exam details found for this class</p>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-8 text-gray-500">
                                <p>No classes found for this exam group</p>
                            </div>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No Exam Details Found</h3>
                    <p class="text-gray-500">Get started by adding your first exam detail.</p>
                    <div class="mt-6">
                        <button wire:click="create()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Add Exam Detail
                        </button>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Summary Section -->
        <div class="mt-8 pt-6 border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-blue-50 rounded-lg p-4">
                    <div class="text-blue-800 text-sm font-medium">Total Exams</div>
                    <div class="text-2xl font-bold text-blue-900">{{ count($groupedData) }}</div>
                </div>
                <div class="bg-green-50 rounded-lg p-4">
                    <div class="text-green-800 text-sm font-medium">Total Classes</div>
                    <div class="text-2xl font-bold text-green-900">
                        @php
                            $totalClasses = 0;
                            foreach($groupedData as $group) {
                                $totalClasses += count($group['classes']);
                            }
                            echo $totalClasses;
                        @endphp
                    </div>
                </div>
                <div class="bg-yellow-50 rounded-lg p-4">
                    <div class="text-yellow-800 text-sm font-medium">Total Details</div>
                    <div class="text-2xl font-bold text-yellow-900">{{ $examDetails ? $examDetails->count() : 0 }}</div>
                </div>
                <div class="bg-purple-50 rounded-lg p-4">
                    <div class="text-purple-800 text-sm font-medium">Active Items</div>
                    <div class="text-2xl font-bold text-purple-900">
                        {{ $examDetails ? $examDetails->where('is_active', true)->count() : 0 }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
