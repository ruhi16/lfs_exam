<div class="bg-white rounded-lg shadow overflow-hidden">
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
                @if(!$isEditing)
                    <button wire:click="startEditing" class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Edit Exam Details
                    </button>
                @else
                    <div class="flex space-x-2 w-full">
                        <button wire:click="saveChanges" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                            Save Changes
                        </button>
                        <button wire:click="cancelEditing" class="flex-1 inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md shadow-sm text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                            Cancel
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Status Message -->
    @if(session()->has('message'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
            {{ session('message') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-md">
            {{ session('error') }}
        </div>
    @endif

    <!-- Exam Details Table -->
    <div class="overflow-x-auto">
        @if($classes->count() > 0 && $examNames->count() > 0)
            <table class="min-w-full divide-y divide-gray-200 border border-gray-200 rounded-lg">
                <!-- Three-level Headers -->
                <thead class="bg-gray-50 sticky top-0">
                    <!-- Exam Names Level -->
                    <tr>
                        <th rowspan="3" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100 border-r">
                            Class
                        </th>
                        
                        @foreach($examNames as $examName)
                            @php
                                // Count total exam types for this exam name
                                $typeSpan = 0;
                                foreach($examStructure[$examName->id]['types'] ?? [] as $examTypeId => $typeData) {
                                    $typeSpan += count($typeData['parts']);
                                }
                                                            
                                // Assign a background color based on exam name index
                                $colorClasses = [
                                    'bg-blue-100', 'bg-green-100', 'bg-yellow-100', 'bg-pink-100',
                                    'bg-purple-100', 'bg-indigo-100', 'bg-red-100', 'bg-teal-100',
                                    'bg-orange-100', 'bg-cyan-100', 'bg-lime-100', 'bg-emerald-100'
                                ];
                                $bgColor = $colorClasses[$loop->index % count($colorClasses)];
                            @endphp
                            @if($typeSpan > 0)
                                <th colspan="{{ $typeSpan }}" class="px-6 py-3 text-center text-xs font-bold text-gray-700 uppercase tracking-wider {{ $bgColor }} border-b">
                                    {{ $examName->name }}
                                </th>
                            @endif
                        @endforeach
                    </tr>
                    
                    <!-- Exam Types Level -->
                    <tr>
                        @foreach($examNames as $examName)
                            @foreach($examStructure[$examName->id]['types'] ?? [] as $examTypeId => $typeData)
                                @php
                                    $partSpan = count($typeData['parts']);
                                    
                                    // Assign a background color based on exam type index
                                    $colorClasses = [
                                        'bg-blue-50', 'bg-green-50', 'bg-yellow-50', 'bg-pink-50',
                                        'bg-purple-50', 'bg-indigo-50', 'bg-red-50', 'bg-teal-50',
                                        'bg-orange-50', 'bg-cyan-50', 'bg-lime-50', 'bg-emerald-50'
                                    ];
                                    $bgColor = $colorClasses[$loop->index % count($colorClasses)];
                                @endphp
                                @if($partSpan > 0)
                                    <th colspan="{{ $partSpan }}" class="px-4 py-2 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider {{ $bgColor }} border-b">
                                        {{ $typeData['name'] }}
                                    </th>
                                @endif
                            @endforeach
                        @endforeach
                    </tr>
                    
                    <!-- Exam Parts Level -->
                    <tr>
                        @foreach($examNames as $examName)
                            @foreach($examStructure[$examName->id]['types'] ?? [] as $examTypeId => $typeData)
                                @foreach($typeData['parts'] as $examPartId => $partData)
                                    @php
                                        // Assign a background color based on exam part index
                                        $colorClasses = [
                                            'bg-blue-25', 'bg-green-25', 'bg-yellow-25', 'bg-pink-25',
                                            'bg-purple-25', 'bg-indigo-25', 'bg-red-25', 'bg-teal-25',
                                            'bg-orange-25', 'bg-cyan-25', 'bg-lime-25', 'bg-emerald-25'
                                        ];
                                        $bgColor = $colorClasses[$loop->index % count($colorClasses)];
                                    @endphp
                                    <th class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider {{ $bgColor }}">
                                        {{ $partData['name'] }}
                                    </th>
                                @endforeach
                            @endforeach
                        @endforeach
                    </tr>
                </thead>
                
                <!-- Table Body -->
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($classes as $class)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 bg-gray-50 border-r">
                                {{ $class->name }}
                            </td>
                            
                            @foreach($examNames as $examName)
                                @foreach($examStructure[$examName->id]['types'] ?? [] as $examTypeId => $typeData)
                                    @foreach($typeData['parts'] as $examPartId => $partData)
                                        @php
                                            $key = $class->id . '_' . $examName->id . '_' . $examTypeId . '_' . $examPartId;
                                            $isSelected = isset($selectedDetails[$key]) && $selectedDetails[$key];
                                            $selectedMode = $selectedModes[$key] ?? null;
                                            
                                            // Assign a background color based on exam name index
                                            $colorClasses = [
                                                'bg-blue-50', 'bg-green-50', 'bg-yellow-50', 'bg-pink-50',
                                                'bg-purple-50', 'bg-indigo-50', 'bg-red-50', 'bg-teal-50',
                                                'bg-orange-50', 'bg-cyan-50', 'bg-lime-50', 'bg-emerald-50'
                                            ];
                                            $bgColor = $colorClasses[$loop->parent->parent->index % count($colorClasses)];
                                        @endphp
                                        <td class="px-3 py-4 text-center {{ $isSelected ? 'bg-green-50' : $bgColor }} border-r">
                                            @if($isEditing)
                                                <div class="flex flex-col items-center space-y-2">
                                                    <!-- Checkbox -->
                                                    <input type="checkbox"
                                                           wire:click="toggleExamDetail({{ $class->id }}, {{ $examName->id }}, {{ $examTypeId }}, {{ $examPartId }})"
                                                           {{ $isSelected ? 'checked' : '' }}
                                                           class="h-5 w-5 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                                    
                                                    <!-- Mode Selection (only when selected) -->
                                                    @if($isSelected)
                                                        <select wire:model="selectedModes.{{ $key }}"
                                                                class="mt-1 block w-full px-2 py-1 text-xs border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                                            @foreach($examModes as $mode)
                                                                <option value="{{ $mode->id }}">{{ $mode->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    @endif
                                                </div>
                                            @else
                                                @if($isSelected)
                                                    <div class="text-center">
                                                        <div class="text-green-600 font-medium">✓ Active</div>
                                                        @if($selectedMode)
                                                            @php
                                                                $mode = $examModes->firstWhere('id', $selectedMode);
                                                            @endphp
                                                            @if($mode)
                                                                <div class="text-xs text-gray-600 mt-1">{{ $mode->name }}</div>
                                                            @endif
                                                        @endif
                                                    </div>
                                                @else
                                                    <div class="text-gray-400 text-xs">-</div>
                                                @endif
                                            @endif
                                        </td>
                                    @endforeach
                                @endforeach
                            @endforeach
                        </tr>
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
                <h3 class="text-lg font-medium text-gray-900 mb-1">No Data Found</h3>
                <p class="text-gray-500">Please configure classes, exam names, types, and parts first.</p>
            </div>
        @endif
    </div>

    <!-- Legend -->
    @if($classes->count() > 0 && $examNames->count() > 0)
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
            <h4 class="text-sm font-medium text-gray-700 mb-2">How to use:</h4>
            <ul class="text-sm text-gray-600 space-y-1">
                @if(!$isEditing)
                    <li>• Click "Edit Exam Details" to enable editing mode</li>
                    <li>• Green cells indicate active exam configurations</li>
                    <li>• Each cell shows the exam mode for that configuration</li>
                @else
                    <li>• Check boxes to activate exam configurations for classes</li>
                    <li>• Select exam modes from the dropdowns for active configurations</li>
                    <li>• Click "Save Changes" to save your configuration</li>
                    <li>• Click "Cancel" to discard changes</li>
                @endif
            </ul>
            <div class="mt-3 pt-3 border-t border-gray-200">
                <h5 class="text-xs font-medium text-gray-700 mb-1">Color Guide:</h5>
                <div class="flex flex-wrap gap-3 text-xs">
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-green-100 rounded mr-1"></div>
                        <span>Active configuration</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-3 h-3 bg-white border rounded mr-1"></div>
                        <span>Inactive configuration</span>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>