<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Answer Script Distribution</h1>
        <p class="text-gray-600 mt-2">Assign teachers to evaluate answer scripts for Summative subjects by class and section.</p>
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
                $classSections = $this->getClassSections($activeClass->id);
                $summativeSubjects = $this->getSummativeSubjects($activeClass->id);
                $formativeSubjects = $this->getFormativeSubjects($activeClass->id);
            @endphp
            
            @if($classSections->count() > 0 && ($summativeSubjects->count() > 0 || $formativeSubjects->count() > 0))
                <div class="space-y-8 p-6">
                    <!-- Sections Loop -->
                    @foreach($classSections as $section)
                        <div class="border border-gray-200 rounded-lg">
                            <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Section: {{ $section->section->name ?? 'N/A' }}</h3>
                            </div>
                            
                            <div class="overflow-x-auto">
                                @php
                                    $examDetailsGrouped = $this->getExamDetailsForClass($activeClass->id);
                                @endphp
                                
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                                Subject
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
                                        
                                        <!-- Exam Part with Mode Headers -->
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                                -
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
                                        <!-- Summative Subjects Group -->
                                        @if($summativeSubjects->count() > 0)
                                            <tr class="bg-blue-50">
                                                <td colspan="100" class="px-6 py-2 text-sm font-bold text-blue-800 bg-blue-100 border-b border-blue-200">
                                                    SUMMATIVE SUBJECTS
                                                </td>
                                            </tr>
                                            @foreach($summativeSubjects as $classSubject)
                                                <tr class="hover:bg-blue-50">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-blue-50 z-10 border-r border-gray-200">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10 bg-blue-200 rounded-full flex items-center justify-center">
                                                                <span class="text-blue-800 font-medium">{{ substr($classSubject->subject->name ?? 'N/A', 0, 1) }}</span>
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="font-medium text-gray-900">{{ $classSubject->subject->name ?? 'N/A' }}</div>
                                                                <div class="text-gray-500 text-xs">{{ $classSubject->subject->code ?? '' }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    
                                                    <!-- Teacher Assignment Cells -->
                                                    @foreach($examDetailsGrouped as $examNameId => $examDetailsByType)
                                                        @foreach($examDetailsByType->groupBy('exam_type_id') as $examTypeId => $typeDetails)
                                                            @foreach($typeDetails->groupBy('exam_part_id') as $examPartId => $partDetails)
                                                                @php
                                                                    $examDetail = $partDetails->first();
                                                                    $existingRecord = $this->getExistingDistribution($section->id, $examDetail->id);
                                                                    $cellKey = $section->id . '_' . $examDetail->id;
                                                                @endphp
                                                                <td class="px-3 py-3 whitespace-nowrap text-center border border-gray-200 bg-blue-50">
                                                                    <div class="space-y-2">
                                                                        <select 
                                                                            wire:model="formData.{{ $cellKey }}.teacher_id"
                                                                            class="w-full px-2 py-1 text-xs border border-blue-300 rounded focus:ring-blue-500 focus:border-blue-500 @if(!$isEditingEnabled) bg-blue-100 cursor-not-allowed @endif"
                                                                            @if(!$isEditingEnabled) disabled @endif
                                                                        >
                                                                            <option value="">-- Select Teacher --</option>
                                                                            @foreach($teachers as $teacher)
                                                                                <option value="{{ $teacher->id }}">
                                                                                    {{ $teacher->user->name ?? 'N/A' }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <br/>
                                                                        <button 
                                                                            wire:click="saveDistribution({{ $section->id }}, {{ $examDetail->id }})"
                                                                            class="w-full px-2 py-1 text-xs bg-blue-600 text-white rounded hover:bg-blue-700 @if(!$isEditingEnabled) opacity-50 cursor-not-allowed @endif"
                                                                            @if(!$isEditingEnabled) disabled @endif
                                                                        >
                                                                            Save
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            @endforeach
                                                        @endforeach
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        @endif
                                        
                                        <!-- Formative Subjects Group -->
                                        @if($formativeSubjects->count() > 0)
                                            <tr class="bg-green-50">
                                                <td colspan="100" class="px-6 py-2 text-sm font-bold text-green-800 bg-green-100 border-b border-green-200">
                                                    FORMATIVE SUBJECTS
                                                </td>
                                            </tr>
                                            @foreach($formativeSubjects as $classSubject)
                                                <tr class="hover:bg-green-50">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-green-50 z-10 border-r border-gray-200">
                                                        <div class="flex items-center">
                                                            <div class="flex-shrink-0 h-10 w-10 bg-green-200 rounded-full flex items-center justify-center">
                                                                <span class="text-green-800 font-medium">{{ substr($classSubject->subject->name ?? 'N/A', 0, 1) }}</span>
                                                            </div>
                                                            <div class="ml-4">
                                                                <div class="font-medium text-gray-900">{{ $classSubject->subject->name ?? 'N/A' }}</div>
                                                                <div class="text-gray-500 text-xs">{{ $classSubject->subject->code ?? '' }}</div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    
                                                    <!-- Teacher Assignment Cells -->
                                                    @foreach($examDetailsGrouped as $examNameId => $examDetailsByType)
                                                        @foreach($examDetailsByType->groupBy('exam_type_id') as $examTypeId => $typeDetails)
                                                            @foreach($typeDetails->groupBy('exam_part_id') as $examPartId => $partDetails)
                                                                @php
                                                                    $examDetail = $partDetails->first();
                                                                    $existingRecord = $this->getExistingDistribution($section->id, $examDetail->id);
                                                                    $cellKey = $section->id . '_' . $examDetail->id;
                                                                @endphp
                                                                <td class="px-3 py-3 whitespace-nowrap text-center border border-gray-200 bg-green-50">
                                                                    <div class="space-y-2">
                                                                        <select 
                                                                            wire:model="formData.{{ $cellKey }}.teacher_id"
                                                                            class="w-full px-2 py-1 text-xs border border-green-300 rounded focus:ring-green-500 focus:border-green-500 @if(!$isEditingEnabled) bg-green-100 cursor-not-allowed @endif"
                                                                            @if(!$isEditingEnabled) disabled @endif
                                                                        >
                                                                            <option value="">-- Select Teacher --</option>
                                                                            @foreach($teachers as $teacher)
                                                                                <option value="{{ $teacher->id }}">
                                                                                    {{ $teacher->user->name ?? 'N/A' }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        <br/>
                                                                        <button 
                                                                            wire:click="saveDistribution({{ $section->id }}, {{ $examDetail->id }})"
                                                                            class="w-full px-2 py-1 text-xs bg-green-600 text-white rounded hover:bg-green-700 @if(!$isEditingEnabled) opacity-50 cursor-not-allowed @endif"
                                                                            @if(!$isEditingEnabled) disabled @endif
                                                                        >
                                                                            Save
                                                                        </button>
                                                                    </div>
                                                                </td>
                                                            @endforeach
                                                        @endforeach
                                                    @endforeach
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            @elseif($classSections->count() == 0)
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No Sections Found</h3>
                    <p class="text-gray-500">No sections are configured for this class.</p>
                </div>
            @elseif($summativeSubjects->count() == 0 && $formativeSubjects->count() == 0)
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No Subjects Found</h3>
                    <p class="text-gray-500">No Summative or Formative subjects are assigned to this class.</p>
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
        Showing answer script distribution for {{ $classes->count() ?? 0 }} classes
    </div>
</div>