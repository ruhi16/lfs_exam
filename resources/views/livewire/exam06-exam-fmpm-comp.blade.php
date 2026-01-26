<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Exam Full Marks, Pass Marks & Time Configuration</h1>
        <p class="text-gray-600 mt-2">Configure full marks, pass marks, and time allocation for each subject and exam combination.</p>
    </div>
    
    <!-- Status Messages -->
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
    
    <!-- Class Tabs and Action Buttons -->
    <div class="mb-6 border-b border-gray-200">
        <div class="flex justify-between items-center">
            <nav class="flex space-x-8" aria-label="Tabs">
                @foreach($classes as $index => $class)
                    <button
                        wire:click="setActiveTab({{ $index }})"
                        class="py-4 px-1 border-b-2 font-medium text-sm @if($activeTab === $index) border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif"
                    >
                        {{ $class->name }}
                    </button>
                @endforeach
            </nav>
            <div class="space-x-2">
                <button 
                    wire:click="$refresh"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                >
                    Refresh
                </button>
                <button 
                    wire:click="toggleEditEnable"
                    class="px-4 py-2 text-sm font-medium text-white bg-@if($isEditingEnabled) red @else blue @endif-600 border border-@if($isEditingEnabled) red @else blue @endif-600 rounded-md hover:bg-@if($isEditingEnabled) red @else blue @endif-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-@if($isEditingEnabled) red @else blue @endif-500"
                >
                    @if($isEditingEnabled) Disable @else Enable @endif Edit
                </button>
            </div>
        </div>
    </div>
    
    <!-- Content Area -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if(isset($classes[$activeTab]))
            @php
                $activeClass = $classes[$activeTab];
                $classSubjects = $this->getClassSubjects($activeClass->id);
                $examDetailsGrouped = $this->getExamDetailsForClass($activeClass->id);
            @endphp
            
            @if($classSubjects->count() > 0)
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                    Subject
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                    <div class="flex flex-col items-center">
                                        <span class="block">FM</span>
                                        <span class="block">PM</span>
                                        <span class="block">TIME</span>
                                    </div>
                                </th>
                                
                                <!-- Exam Name Headers -->
                                @foreach($examDetailsGrouped as $examNameId => $examDetailsByType)
                                    @php
                                        $examName = $examNames->firstWhere('id', $examNameId);
                                        $colspan = 0;
                                        foreach($examDetailsByType->groupBy('exam_type_id') as $typeGroup) {
                                            $colspan += $typeGroup->groupBy('exam_part_id')->count();
                                        }
                                    @endphp
                                    @if($examName && $colspan > 0)
                                        <th colspan="{{ $colspan }}" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-blue-50">
                                            {{ $examName->name }}
                                        </th>
                                    @endif
                                @endforeach
                            </tr>
                            
                            <!-- Exam Type and Part Headers -->
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                    -
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                    Allocation
                                </th>
                                
                                @foreach($examDetailsGrouped as $examNameId => $examDetailsByType)
                                    @foreach($examDetailsByType->groupBy('exam_type_id') as $examTypeId => $typeDetails)
                                        @php
                                            $examType = $examTypes->firstWhere('id', $examTypeId);
                                            $partsCount = $typeDetails->groupBy('exam_part_id')->count();
                                        @endphp
                                        @if($examType && $partsCount > 0)
                                            <th colspan="{{ $partsCount }}" class="px-4 py-2 text-center text-xs font-medium text-blue-700 uppercase tracking-wider bg-blue-100 border-l border-r border-gray-200">
                                                {{ $examType->name }}
                                            </th>
                                        @endif
                                    @endforeach
                                @endforeach
                            </tr>
                            
                            <!-- Exam Part Headers -->
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                    -
                                </th>
                                <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-100">
                                    &nbsp;
                                </th>
                                
                                @foreach($examDetailsGrouped as $examNameId => $examDetailsByType)
                                    @foreach($examDetailsByType->groupBy('exam_type_id') as $examTypeId => $typeDetails)
                                        @foreach($typeDetails->groupBy('exam_part_id') as $examPartId => $partDetails)
                                            @php
                                                $examPart = $examParts->firstWhere('id', $examPartId);
                                                $firstDetail = $partDetails->first();
                                            @endphp
                                            <th class="px-3 py-2 text-center text-xs font-medium text-purple-700 uppercase tracking-wider bg-purple-50 border border-gray-200">
                                                <div class="text-xs text-gray-500 mb-1">
                                                    {{ $examPart ? $examPart->name : 'N/A' }}
                                                </div>
                                                <div class="text-xs text-gray-500">
                                                    {{ $firstDetail->examMode->name ?? 'Mode N/A' }}
                                                </div>
                                            </th>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            </tr>
                        </thead>
                        
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $groupedClassSubjects = $this->getClassSubjectsGroupedByType($activeClass->id);
                            @endphp
                            @foreach($groupedClassSubjects as $subjectTypeId => $classSubjectsOfType)
                                @if($subjectTypeId)
                                    @php
                                        $subjectType = $subjectTypes->firstWhere('id', $subjectTypeId);
                                    @endphp
                                    @if($subjectType)
                                        <tr class="bg-gray-100">
                                            <td colspan="{{ 2 + $examDetailsGrouped->sum(function($examDetailsByType) {
                                                return $examDetailsByType->groupBy('exam_type_id')->sum(function($typeDetails) {
                                                    return $typeDetails->groupBy('exam_part_id')->count();
                                                });
                                            }) }}" class="px-6 py-2 text-sm font-semibold text-gray-700">
                                                {{ $subjectType->name }}
                                            </td>
                                        </tr>
                                    @endif
                                @endif
                                @foreach($classSubjectsOfType as $classSubject)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white z-10 border-r border-gray-200">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <span class="text-blue-800 font-medium">{{ substr($classSubject->subject->name ?? 'N/A', 0, 1) }}</span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="font-medium text-gray-900">{{ $classSubject->subject->name ?? 'N/A' }}</div>
                                                    <div class="text-gray-500 text-xs">{{ $classSubject->subject->code ?? '' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500 bg-gray-50">
                                            <!-- FM, PM, Time column for all exam combinations -->
                                            <div class="space-y-2">
                                                <div class="flex flex-col space-y-1">
                                                    <span class="inline-block px-2 py-1 bg-white border border-gray-300 rounded text-xs font-semibold text-gray-700">FM</span>
                                                    <span class="inline-block px-2 py-1 bg-white border border-gray-300 rounded text-xs font-semibold text-gray-700">PM</span>
                                                    <span class="inline-block px-2 py-1 bg-white border border-gray-300 rounded text-xs font-semibold text-gray-700">TIME</span>
                                                    <span class="inline-block px-2 py-1 bg-white border border-gray-300 rounded text-xs font-semibold text-gray-700" aria-disabled="true">|</span>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Data Cells -->
                                        @foreach($examDetailsGrouped as $examNameId => $examDetailsByType)
                                            @foreach($examDetailsByType->groupBy('exam_type_id') as $examTypeId => $typeDetails)
                                                @foreach($typeDetails->groupBy('exam_part_id') as $examPartId => $partDetails)
                                                    @php
                                                        $examDetail = $partDetails->first();
                                                        $existingRecord = $this->getExistingRecord($activeClass->id, $classSubject->subject_id, $examDetail->id);
                                                        $cellKey = $activeClass->id . '_' . $classSubject->subject_id . '_' . $examDetail->id;
                                                    @endphp
                                                    <td class="px-3 py-3 whitespace-nowrap text-center border border-gray-200 bg-white">
                                                        @if($existingRecord)
                                                            <!-- Existing Record - Show Edit Form -->
                                                            <div class="space-y-2">
                                                                <div class="flex flex-col space-y-1">
                                                                    <input 
                                                                        type="number" 
                                                                        wire:model="formData.{{ $cellKey }}.full_marks" 
                                                                        value="{{ $this->getFormDataValue($activeClass->id, $classSubject->subject_id, $examDetail->id, 'full_marks') }}"
                                                                        class="w-16 px-1 py-1 text-xs border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-center" 
                                                                        placeholder="FM"
                                                                        min="0"
                                                                        @if(!$isEditingEnabled) disabled @endif
                                                                    >
                                                                    <input 
                                                                        type="number" 
                                                                        wire:model="formData.{{ $cellKey }}.pass_marks" 
                                                                        value="{{ $this->getFormDataValue($activeClass->id, $classSubject->subject_id, $examDetail->id, 'pass_marks') }}"
                                                                        class="w-16 px-1 py-1 text-xs border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-center" 
                                                                        placeholder="PM"
                                                                        min="0"
                                                                        @if(!$isEditingEnabled) disabled @endif
                                                                    >
                                                                    <input 
                                                                        type="number" 
                                                                        wire:model="formData.{{ $cellKey }}.time_in_minutes" 
                                                                        value="{{ $this->getFormDataValue($activeClass->id, $classSubject->subject_id, $examDetail->id, 'time_in_minutes') }}"
                                                                        class="w-16 px-1 py-1 text-xs border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-center" 
                                                                        placeholder="Min"
                                                                        min="0"
                                                                        @if(!$isEditingEnabled) disabled @endif
                                                                    >
                                                                </div>
                                                                <div class="flex space-x-1 justify-center">
                                                                    <button 
                                                                        wire:click="saveRecord({{ $activeClass->id }}, {{ $classSubject->subject_id }}, {{ $examDetail->id }})"
                                                                        class="px-2 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700"
                                                                    >
                                                                        ✓
                                                                    </button>
                                                                    <button 
                                                                        wire:click="deleteRecord({{ $existingRecord->id }})"
                                                                        class="px-2 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700"
                                                                        onclick="return confirm('Are you sure you want to delete this record?')"
                                                                    >
                                                                        ✗
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <!-- New Record - Show Create Form -->
                                                            <div class="space-y-2">
                                                                <div class="flex flex-col space-y-1">
                                                                    <input 
                                                                        type="number" 
                                                                        wire:model="formData.{{ $cellKey }}.full_marks" 
                                                                        value="{{ $this->getFormDataValue($activeClass->id, $classSubject->subject_id, $examDetail->id, 'full_marks') }}"
                                                                        class="w-16 px-1 py-1 text-xs border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-center" 
                                                                        placeholder="FM"
                                                                        min="0"
                                                                        @if(!$isEditingEnabled) disabled @endif
                                                                    >
                                                                    <input 
                                                                        type="number" 
                                                                        wire:model="formData.{{ $cellKey }}.pass_marks" 
                                                                        value="{{ $this->getFormDataValue($activeClass->id, $classSubject->subject_id, $examDetail->id, 'pass_marks') }}"
                                                                        class="w-16 px-1 py-1 text-xs border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-center" 
                                                                        placeholder="PM"
                                                                        min="0"
                                                                        @if(!$isEditingEnabled) disabled @endif
                                                                    >
                                                                    <input 
                                                                        type="number" 
                                                                        wire:model="formData.{{ $cellKey }}.time_in_minutes" 
                                                                        value="{{ $this->getFormDataValue($activeClass->id, $classSubject->subject_id, $examDetail->id, 'time_in_minutes') }}"
                                                                        class="w-16 px-1 py-1 text-xs border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 text-center" 
                                                                        placeholder="Min"
                                                                        min="0"
                                                                        @if(!$isEditingEnabled) disabled @endif
                                                                    >
                                                                </div>
                                                                <button 
                                                                    wire:click="saveRecord({{ $activeClass->id }}, {{ $classSubject->subject_id }}, {{ $examDetail->id }})"
                                                                    class="w-full px-2 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700 disabled:opacity-50"
                                                                    @if(empty($formData[$cellKey]['full_marks']) || empty($formData[$cellKey]['pass_marks']) || !$isEditingEnabled) disabled @endif
                                                                >
                                                                    +
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No Subjects Found</h3>
                    <p class="text-gray-500">No subjects are assigned to this class. Please configure class subjects first.</p>
                </div>
            @endif
        @else
            <div class="text-center py-12">
                <div class="text-gray-400 mb-4">
                    <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-1">No Classes Found</h3>
                <p class="text-gray-500">Please configure classes in the system first.</p>
            </div>
        @endif
    </div>
    
    <!-- Footer Info -->
    <div class="mt-6 text-sm text-gray-500">
        Showing configuration for {{ $classes->count() ?? 0 }} classes
    </div>
</div>