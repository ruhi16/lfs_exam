<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Exam Marks Entry</h1>
        <p class="text-gray-600 mt-2">Manage exam marks entries for students by class and section.</p>
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
    
    <!-- Exam Name and Exam Type Filters -->
    <div class="mb-6 bg-gray-50 p-4 rounded-lg border border-@if($isValidationPassed) green-200 @else red-200 @endif">
        <div class="flex space-x-4">
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Exam Name @if(!$selectedExamNameId)<span class="text-red-500">*</span>@endif</label>
                <select 
                    wire:model="selectedExamNameId"
                    wire:change="setSelectedExamName($event.target.value)"
                    class="w-full px-3 py-2 border @if(!$selectedExamNameId) border-red-300 @else border-green-300 @endif rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                >
                    <option value="">-- Select Exam Name --</option>
                    @foreach($examNames as $examName)
                        <option value="{{ $examName->id }}">{{ $examName->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700 mb-1">Exam Type @if($selectedExamNameId && !$selectedExamTypeId)<span class="text-red-500">*</span>@endif</label>
                <select 
                    wire:model="selectedExamTypeId"
                    wire:change="setSelectedExamType($event.target.value)"
                    class="w-full px-3 py-2 border @if($selectedExamNameId && !$selectedExamTypeId) border-red-300 @else border-@if($selectedExamTypeId) green-300 @else gray-300 @endif @endif rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 @if(!$selectedExamNameId) opacity-50 cursor-not-allowed @endif"
                    @if(!$selectedExamNameId) disabled @endif
                >
                    <option value="">-- Select Exam Type --</option>
                    @foreach($examTypes as $examType)
                        <option value="{{ $examType->id }}">{{ $examType->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        
        @if(!$isValidationPassed)
            <div class="mt-2 text-sm @if(!$selectedExamNameId) text-red-600 @else @if(!$selectedExamTypeId) text-yellow-600 @endif @endif">
                @if(!$selectedExamNameId)
                    <svg class="inline-block w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                    Please select an exam name to enable exam type selection.
                @else
                    @if(!$selectedExamTypeId)
                        <svg class="inline-block w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                        Please select an exam type to enable student selection and marks entry.
                    @endif
                @endif
            </div>
        @else
            <div class="mt-2 text-sm text-green-600">
                <svg class="inline-block w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                Selection valid. You can now select students and enter marks.
            </div>
        @endif
    </div>
    
    <!-- Content Area -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        @if(isset($classes[$activeTab]))
            @php
                $activeClass = $classes[$activeTab];
                $classSections = $this->getClassSections($activeClass->id);
                $examClassSubjects = $this->getExamClassSubjectsForClass($activeClass->id);
                $examParts = $this->getExamPartsForClass($activeClass->id);
            @endphp
            
            @if($classSections->count() > 0 && $examClassSubjects->count() > 0)
                <div class="space-y-8 p-6">
                    <!-- Sections Loop -->
                    @foreach($classSections as $section)
                        <div class="border border-gray-200 rounded-lg">
                            <div class="bg-gray-50 px-6 py-3 border-b border-gray-200 flex justify-between items-center">
                                <h3 class="text-lg font-medium text-gray-900">Section: {{ $section->section->name ?? 'N/A' }}</h3>
                                <button 
                                    wire:click="saveAllEntries"
                                    class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-green-600 rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 @if(!$isEditingEnabled) opacity-50 cursor-not-allowed @endif"
                                    @if(!$isEditingEnabled) disabled @endif
                                >
                                    Save All Entries
                                </button>
                            </div>
                            
                            <div class="overflow-x-auto">
                                @php
                                    $students = $this->getStudentsInSection($section->id);
                                @endphp
                                
                                @if($students->count() > 0)
                                    @if($examParts->count() > 1)
                                        <!-- Display with sub-rows for exam parts -->
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                                        Student
                                                    </th>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">
                                                        Exam Part
                                                    </th>
                                                                                    
                                                    <!-- Exam Class Subjects Headers -->
                                                    @foreach($examClassSubjects as $examClassSubject)
                                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-blue-50">
                                                            {{ $examClassSubject->subject->name ?? 'N/A' }}<br>
                                                            <span class="text-[10px] text-gray-600">{{ $examClassSubject->examDetail->examName->name ?? 'N/A' }} - {{ $examClassSubject->examDetail->examType->name ?? 'N/A' }}</span>
                                                        </th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                                                            
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($students as $student)
                                                    @foreach($examParts as $examPart)
                                                        <tr class="hover:bg-gray-50">
                                                            @if($loop->first)
                                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white z-10 border-r border-gray-200" rowspan="{{ $examParts->count() }}">
                                                                    <div class="flex items-center">
                                                                        <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                                            <span class="text-blue-800 font-medium">{{ $student->roll_no ?? 'N/A' }}</span>
                                                                        </div>
                                                                        <div class="ml-4">
                                                                            <div class="font-medium text-gray-900">{{ $student->studentdb->name ?? 'N/A' }}</div>
                                                                            <div class="text-gray-500 text-xs">Roll: {{ $student->roll_no ?? 'N/A' }}</div>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            @endif
                                                                                            
                                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                                {{ $examPart->examPart->name ?? 'N/A' }}
                                                                <span class="text-xs text-gray-500">({{ $examPart->examMode->name ?? 'N/A' }})</span>
                                                            </td>
                                                                                            
                                                            <!-- Exam Class Subjects Cells -->
                                                            @foreach($examClassSubjects as $examClassSubject)
                                                                @php
                                                                    $cellKey = $section->id . '_' . $student->id . '_' . $examClassSubject->id . '_' . $examPart->id;
                                                                @endphp
                                                                <td class="px-6 py-4 border border-gray-200 bg-white">
                                                                    <div class="flex items-center space-x-2">
                                                                        <input
                                                                            type="number"
                                                                            wire:model="formData.{{ $cellKey }}.marks"
                                                                            class="flex-1 px-2 py-1 text-xs border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 @if(!$isEditingEnabled) bg-gray-100 cursor-not-allowed @endif @if(data_get($this->formData, "{$cellKey}.is_absent")) bg-gray-100 cursor-not-allowed opacity-50 @endif"
                                                                            placeholder="Enter marks"
                                                                            min="0"
                                                                            max="{{ $examClassSubject->full_marks ?? 100 }}"
                                                                            @if(!$isEditingEnabled || data_get($this->formData, "{$cellKey}.is_absent")) disabled @endif
                                                                        />
                                                                        <div class="flex items-center">
                                                                            <input
                                                                                type="checkbox"
                                                                                wire:click="formData.{{ $cellKey }}.marks = null"
                                                                                wire:model="formData.{{ $cellKey }}.is_absent"
                                                                                class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded @if(!$isEditingEnabled) cursor-not-allowed @endif"
                                                                                @if(!$isEditingEnabled) disabled @endif
                                                                            />
                                                                            <span class="ml-1 text-xs text-gray-500">Absent</span>
                                                                        </div>
                                                                    </div>
                                                                </td>
                                                            @endforeach
                                                        </tr>
                                                    @endforeach
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        <!-- Display without sub-rows (original format) -->
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                                        Student
                                                    </th>
                                                                                    
                                                    <!-- Exam Class Subjects Headers -->
                                                    @foreach($examClassSubjects as $examClassSubject)
                                                        <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-blue-50">
                                                            {{ $examClassSubject->subject->name ?? 'N/A' }}<br>
                                                            <span class="text-[10px] text-gray-600">{{ $examClassSubject->examDetail->examName->name ?? 'N/A' }} - {{ $examClassSubject->examDetail->examType->name ?? 'N/A' }}</span>
                                                        </th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                                                            
                                            <tbody class="bg-white divide-y divide-gray-200">
                                                @foreach($students as $student)
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white z-10 border-r border-gray-200">
                                                            <div class="flex items-center">
                                                                <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                                                                    <span class="text-blue-800 font-medium">{{ $student->roll_no ?? 'N/A' }}</span>
                                                                </div>
                                                                <div class="ml-4">
                                                                    <div class="font-medium text-gray-900">{{ $student->studentdb->name ?? 'N/A' }}</div>
                                                                    <div class="text-gray-500 text-xs">Roll: {{ $student->roll_no ?? 'N/A' }}</div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                                                        
                                                        <!-- Exam Class Subjects Cells -->
                                                        @foreach($examClassSubjects as $examClassSubject)
                                                            @php
                                                                $cellKey = $section->id . '_' . $student->id . '_' . $examClassSubject->id;
                                                            @endphp
                                                            <td class="px-6 py-4 border border-gray-200 bg-white">
                                                                <div class="flex items-center space-x-2">
                                                                    <input
                                                                        type="number"
                                                                        wire:model="formData.{{ $cellKey }}.marks"
                                                                        class="flex-1 px-2 py-1 text-xs border border-gray-300 rounded focus:ring-blue-500 focus:border-blue-500 @if(!$isEditingEnabled) bg-gray-100 cursor-not-allowed @endif @if(data_get($this->formData, "{$cellKey}.is_absent")) bg-gray-100 cursor-not-allowed opacity-50 @endif"
                                                                        placeholder="Enter marks"
                                                                        min="0"
                                                                        max="{{ $examClassSubject->full_marks ?? 100 }}"
                                                                        @if(!$isEditingEnabled || data_get($this->formData, "{$cellKey}.is_absent")) disabled @endif
                                                                    />
                                                                    <div class="flex items-center">
                                                                        <input
                                                                            type="checkbox"
                                                                            wire:click="formData.{{ $cellKey }}.marks = null"
                                                                            wire:model="formData.{{ $cellKey }}.is_absent"
                                                                            class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded @if(!$isEditingEnabled) cursor-not-allowed @endif"
                                                                            @if(!$isEditingEnabled) disabled @endif
                                                                        />
                                                                        <span class="ml-1 text-xs text-gray-500">Absent</span>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                @else
                                    <div class="text-center py-12">
                                        <div class="text-gray-400 mb-4">
                                            <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-medium text-gray-900 mb-1">No Students Found</h3>
                                        <p class="text-gray-500">No students are enrolled in this section.</p>
                                    </div>
                                @endif
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
            @elseif($examClassSubjects->count() == 0)
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No Exam Class Subjects Found</h3>
                    <p class="text-gray-500">No exam class subjects are configured for this class.</p>
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
        Showing exam marks entries for {{ $classes->count() ?? 0 }} classes
    </div>
</div>