<div>
    <!-- Search and Filter Controls -->
    <div class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Search</label>
                <input type="text" wire:model.debounce.300ms="search" id="search" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm" placeholder="Search...">
            </div>
            <div>
                <label for="selectedSession" class="block text-sm font-medium text-gray-700">Session</label>
                <select wire:model="selectedSession" id="selectedSession" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">All Sessions</option>
                    @foreach($sessions as $session)
                        <option value="{{ $session->id }}">{{ $session->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="selectedExamName" class="block text-sm font-medium text-gray-700">Exam Name</label>
                <select wire:model="selectedExamName" id="selectedExamName" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    <option value="">All Exam Names</option>
                    @foreach($examNames as $examName)
                        <option value="{{ $examName->id }}">{{ $examName->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex items-end">
                <button wire:click="create()" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Add New Exam Detail
                </button>
            </div>
        </div>
    </div>

    <!-- Status Message -->
    @if(session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
            {{ session('message') }}
        </div>
    @endif

    <!-- Grouped Table -->
    <div class="overflow-x-auto">
        @if($groupedData->count() > 0)
            <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Class</th>
                        
                        @foreach($examNames as $examName)
                            @php
                                $examTypeIds = collect();
                                foreach($groupedData as $classId => $classData) {
                                    foreach($classData[$examName->id] ?? [] as $examTypeId => $details) {
                                        if($details->count() > 0) {
                                            $examTypeIds->push($examTypeId);
                                        }
                                    }
                                }
                                $examTypeIds = $examTypeIds->unique();
                            @endphp
                            
                            @if($examTypeIds->count() > 0)
                                <th colspan="{{ $examTypeIds->count() }}" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-blue-50">
                                    {{ $examName->name }}
                                </th>
                            @else
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                    {{ $examName->name }}
                                </th>
                            @endif
                        @endforeach
                    </tr>
                    
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">-</th>
                        
                        @foreach($examNames as $examName)
                            @php
                                $examTypeIds = collect();
                                foreach($groupedData as $classId => $classData) {
                                    foreach($classData[$examName->id] ?? [] as $examTypeId => $details) {
                                        if($details->count() > 0) {
                                            $examTypeIds->push($examTypeId);
                                        }
                                    }
                                }
                                $examTypeIds = $examTypeIds->unique();
                            @endphp
                            
                            @foreach($examTypeIds as $examTypeId)
                                @php
                                    $examType = $types->firstWhere('id', $examTypeId);
                                @endphp
                                <th class="px-4 py-2 text-center text-xs font-medium text-blue-700 uppercase tracking-wider bg-blue-100 border-l border-r border-gray-200">
                                    {{ $examType ? $examType->name : 'N/A' }}
                                </th>
                            @endforeach
                        @endforeach
                    </tr>
                </thead>
                
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($classes as $class)
                        @if($groupedData->has($class->id))
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 bg-gray-50">
                                    {{ $class->name }}
                                </td>
                                
                                @foreach($examNames as $examName)
                                    @php
                                        $examTypeIds = collect();
                                        $classData = $groupedData[$class->id] ?? collect();
                                        foreach($classData[$examName->id] ?? [] as $examTypeId => $details) {
                                            if($details->count() > 0) {
                                                $examTypeIds->push($examTypeId);
                                            }
                                        }
                                        $examTypeIds = $examTypeIds->unique();
                                    @endphp
                                    
                                    @foreach($examTypeIds as $examTypeId)
                                        @php
                                            $details = $classData[$examName->id][$examTypeId] ?? collect();
                                            $examParts = $details->pluck('examPart')->unique();
                                            $examModes = $details->pluck('examMode')->unique();
                                        @endphp
                                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500 text-center border-l border-r border-gray-200 bg-white">
                                            @if($details->count() > 0)
                                                <div class="space-y-1">
                                                    @if($examParts->count() > 0)
                                                        <div class="text-xs text-gray-600">
                                                            <strong>Parts:</strong> 
                                                            {{ $examParts->pluck('name')->filter()->take(3)->join(', ') }}
                                                            @if($examParts->count() > 3)
                                                                <span class="text-gray-400">+{{ $examParts->count() - 3 }} more</span>
                                                            @endif
                                                        </div>
                                                    @endif
                                                    
                                                    @if($examModes->count() > 0)
                                                        <div class="space-y-1">
                                                            @foreach($examModes->filter() as $examMode)
                                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">
                                                                    {{ $examMode->name }}
                                                                </span>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-gray-400 text-xs">-</span>
                                            @endif
                                        </td>
                                    @endforeach
                                @endforeach
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @else
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
        @endif
    </div>

    <!-- Modal Form -->
    <div x-data="{ isOpen: @entangle('isOpen') }" x-show="isOpen" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div x-show="isOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" class="fixed inset-0 transition-opacity">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen"></span>&#8203;
            
            <div x-show="isOpen" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-headline">
                                {{ $isEdit ? 'Edit Exam Detail' : 'Add New Exam Detail' }}
                            </h3>
                            <div class="mt-4 w-full">
                                <form wire:submit.prevent="submitForm">
                                    <div class="space-y-4">
                                        <!-- Basic Information -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="session_id" class="block text-sm font-medium text-gray-700">Session *</label>
                                                <select 
                                                    wire:model.defer="session_id" 
                                                    id="session_id" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('session_id') border-red-500 @enderror"
                                                    required
                                                >
                                                    <option value="">-- Select Session --</option>
                                                    @foreach($sessions as $session)
                                                        <option value="{{ $session->id }}">{{ $session->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('session_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <div>
                                                <label for="exam_name_id" class="block text-sm font-medium text-gray-700">Exam Name *</label>
                                                <select 
                                                    wire:model.defer="exam_name_id" 
                                                    id="exam_name_id" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('exam_name_id') border-red-500 @enderror"
                                                    required
                                                >
                                                    <option value="">-- Select Exam Name --</option>
                                                    @foreach($examNames as $exam)
                                                        <option value="{{ $exam->id }}">{{ $exam->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('exam_name_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <!-- Classes Selection (Horizontal checkboxes) -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Classes *</label>
                                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-2">
                                                @foreach($classes as $class)
                                                    <div class="flex items-center">
                                                        <input 
                                                            type="checkbox" 
                                                            value="{{ $class->id }}" 
                                                            id="class_{{ $class->id }}"
                                                            wire:model="selectedClasses"
                                                            class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                        >
                                                        <label for="class_{{ $class->id }}" class="ml-2 text-sm text-gray-700">{{ $class->name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('selectedClasses') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>

                                        <!-- Exam Types Selection (Checkboxes) -->
                                        <div class="mb-4">
                                            <label class="block text-sm font-medium text-gray-700 mb-2">Select Exam Types *</label>
                                            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                                                @foreach($types as $type)
                                                    <div class="flex items-center">
                                                        <input 
                                                            type="checkbox" 
                                                            value="{{ $type->id }}" 
                                                            id="type_{{ $type->id }}"
                                                            wire:model="selectedExamTypes"
                                                            class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                        >
                                                        <label for="type_{{ $type->id }}" class="ml-2 text-sm text-gray-700">{{ $type->name }}</label>
                                                    </div>
                                                @endforeach
                                            </div>
                                            @error('selectedExamTypes') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>

                                        <!-- Exam Parts Selection for Selected Exam Types -->
                                        @if($selectedExamTypes && count($selectedExamTypes) > 0)
                                            <div class="mb-4">
                                                <label class="block text-sm font-medium text-gray-700 mb-2">Select Exam Parts for Selected Types</label>
                                                <div class="space-y-4">
                                                    @foreach($selectedExamTypes as $examTypeId)
                                                        @php
                                                            $examType = $types->firstWhere('id', $examTypeId);
                                                        @endphp
                                                        @if($examType)
                                                            <div class="border border-gray-200 rounded p-3 bg-gray-50">
                                                                <h4 class="font-medium text-gray-800 mb-2">{{ $examType->name }}</h4>
                                                                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-2">
                                                                    @foreach($parts as $part)
                                                                        <div class="flex items-center">
                                                                            <input 
                                                                                type="checkbox" 
                                                                                value="{{ $part->id }}" 
                                                                                id="part_{{ $examTypeId }}_{{ $part->id }}"
                                                                                wire:model="selectedExamParts.{{ $examTypeId }}"
                                                                                class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                                                                            >
                                                                            <label for="part_{{ $examTypeId }}_{{ $part->id }}" class="ml-2 text-sm text-gray-700">{{ $part->name }}</label>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                                @error('selectedExamParts') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                        @endif

                                        <!-- Exam Mode Selection (Option buttons) -->
                                        <div class="mb-4">
                                            <label for="exam_mode_id" class="block text-sm font-medium text-gray-700">Exam Mode *</label>
                                            <select wire:model.defer="exam_mode_id" id="exam_mode_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('exam_mode_id') border-red-500 @enderror" required>
                                                <option value="">-- Select Exam Mode --</option>
                                                @foreach($modes as $mode)
                                                    <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('exam_mode_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>

                                        <!-- Other form fields -->
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="name" class="block text-sm font-medium text-gray-700">Exam Detail Name *</label>
                                                <input 
                                                    type="text" 
                                                    wire:model.defer="name" 
                                                    id="name" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('name') border-red-500 @enderror"
                                                    placeholder="Enter exam detail name"
                                                    required
                                                >
                                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <div>
                                                <label for="order_index" class="block text-sm font-medium text-gray-700">Order Index</label>
                                                <input 
                                                    type="number" 
                                                    wire:model.defer="order_index" 
                                                    id="order_index" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('order_index') border-red-500 @enderror"
                                                    placeholder="Enter order index"
                                                >
                                                @error('order_index') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                            <textarea 
                                                wire:model.defer="description" 
                                                id="description" 
                                                rows="3"
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('description') border-red-500 @enderror"
                                                placeholder="Enter description"
                                            ></textarea>
                                            @error('description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="school_id" class="block text-sm font-medium text-gray-700">School</label>
                                                <select 
                                                    wire:model.defer="school_id" 
                                                    id="school_id" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('school_id') border-red-500 @enderror"
                                                >
                                                    <option value="">-- Select School --</option>
                                                    @foreach($schools as $school)
                                                        <option value="{{ $school->id }}">{{ $school->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('school_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <div>
                                                <label for="user_id" class="block text-sm font-medium text-gray-700">Created By</label>
                                                <select 
                                                    wire:model.defer="user_id" 
                                                    id="user_id" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('user_id') border-red-500 @enderror"
                                                >
                                                    <option value="">-- Select User --</option>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('user_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                            <div>
                                                <label for="is_optional" class="block text-sm font-medium text-gray-700">Is Optional</label>
                                                <select 
                                                    wire:model.defer="is_optional" 
                                                    id="is_optional" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('is_optional') border-red-500 @enderror"
                                                >
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                                @error('is_optional') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <div>
                                                <label for="is_active" class="block text-sm font-medium text-gray-700">Is Active</label>
                                                <select 
                                                    wire:model.defer="is_active" 
                                                    id="is_active" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('is_active') border-red-500 @enderror"
                                                >
                                                    <option value="1">Yes</option>
                                                    <option value="0">No</option>
                                                </select>
                                                @error('is_active') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <div>
                                                <label for="is_finalized" class="block text-sm font-medium text-gray-700">Is Finalized</label>
                                                <select 
                                                    wire:model.defer="is_finalized" 
                                                    id="is_finalized" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('is_finalized') border-red-500 @enderror"
                                                >
                                                    <option value="0">No</option>
                                                    <option value="1">Yes</option>
                                                </select>
                                                @error('is_finalized') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <label for="approved_by" class="block text-sm font-medium text-gray-700">Approved By</label>
                                                <select 
                                                    wire:model.defer="approved_by" 
                                                    id="approved_by" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('approved_by') border-red-500 @enderror"
                                                >
                                                    <option value="">-- Select Approver --</option>
                                                    @foreach($users as $user)
                                                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('approved_by') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>

                                            <div>
                                                <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                                                <input 
                                                    type="text" 
                                                    wire:model.defer="status" 
                                                    id="status" 
                                                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('status') border-red-500 @enderror"
                                                    placeholder="Enter status"
                                                >
                                                @error('status') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <label for="remarks" class="block text-sm font-medium text-gray-700">Remarks</label>
                                            <input 
                                                type="text" 
                                                wire:model.defer="remarks" 
                                                id="remarks" 
                                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm @error('remarks') border-red-500 @enderror"
                                                placeholder="Enter remarks"
                                            >
                                            @error('remarks') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button 
                        wire:click.prevent="submitForm" 
                        type="button" 
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                        {{ $isEdit ? 'Update' : 'Create' }}
                    </button>
                    <button 
                        @click="isOpen = false" 
                        type="button" 
                        class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                    >
                        Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>