<div class="container mx-auto py-6">
    <div class="flex flex-col space-y-6">
        <!-- Tabs for Classes -->
        <div class="border-b border-gray-200">
            <nav class="-mb-px flex space-x-2 overflow-x-auto" aria-label="Classes">
                @foreach($classes as $index => $class)
                    <button
                        wire:click="setActiveTab({{ $index }})"
                        class="whitespace-nowrap py-2 px-4 text-sm font-medium rounded-t-lg transition-colors duration-200 {{ $activeTab == $index ? 'text-blue-600 border-b-2 border-blue-600 bg-blue-50' : 'text-gray-500 hover:text-gray-700' }}"
                    >
                        {{ $class->name }}
                    </button>
                @endforeach
            </nav>
        </div>

        <!-- Class Content -->
        @if(isset($classes[$activeTab]))
            @php
                $activeClass = $classes[$activeTab];
                $classSections = $this->getClassSections($activeClass->id);
            @endphp

            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <div class="px-4 py-5 sm:px-6 border-b border-gray-200">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Answer Script Distribution - {{ $activeClass->name }}
                    </h3>
                </div>
                
                <!-- Toggle Edit Button -->
                <div class="px-4 py-3 sm:px-6 bg-gray-50 border-b border-gray-200">
                    <button 
                        wire:click="toggleEditEnable"
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    >
                        {{ $isEditingEnabled ? 'Disable Editing' : 'Enable Editing' }}
                        @if($isEditingEnabled)
                            <span class="ml-2 bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded">Editing Enabled</span>
                        @endif
                    </button>
                </div>

                @forelse($classSections as $section)
                    <div class="mb-8 border border-gray-200 rounded-lg overflow-hidden">
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 border-b border-gray-200">
                            <h4 class="text-md font-medium text-gray-800">
                                Section: {{ $section->section->name ?? 'N/A' }}
                            </h4>
                        </div>
                        
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                            Subject
                                        </th>
                                        
                                        <!-- Exam Name Headers - Will show all available exams -->
                                        @php
                                            $allExamDetailsGrouped = $this->getExamDetailsForClass($activeClass->id);
                                        @endphp
                                        
                                        @foreach($allExamDetailsGrouped as $examNameId => $examDetailsByType)
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
                                        
                                        @foreach($allExamDetailsGrouped as $examNameId => $examDetailsByType)
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
                                        
                                        @foreach($allExamDetailsGrouped as $examNameId => $examDetailsByType)
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
                                    @if($summativeSubjects && $summativeSubjects->count() > 0)
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
                                                
                                                <!-- Teacher Assignment Cells - Only Summative Exams -->
                                                @php
                                                    $summativeExamDetailsGrouped = $this->getExamDetailsForClassAndSubjectType($classSubject->myclass_id, 'Summative');
                                                    $allSummativeDetails = collect([]);
                                                    foreach($summativeExamDetailsGrouped as $examNameId => $examDetailsByType) {
                                                        foreach($examDetailsByType->groupBy('exam_type_id') as $typeDetails) {
                                                            foreach($typeDetails->groupBy('exam_part_id') as $partDetails) {
                                                                foreach($partDetails as $detail) {
                                                                    $allSummativeDetails->push($detail);
                                                                }
                                                            }
                                                        }
                                                    }
                                                    $availableSummativeIds = $allSummativeDetails->pluck('id')->toArray();
                                                    
                                                    // Get all possible exam details for alignment
                                                    $allExamDetails = collect([]);
                                                    foreach($allExamDetailsGrouped as $examNameId => $examDetailsByType) {
                                                        foreach($examDetailsByType->groupBy('exam_type_id') as $typeDetails) {
                                                            foreach($typeDetails->groupBy('exam_part_id') as $partDetails) {
                                                                foreach($partDetails as $detail) {
                                                                    $allExamDetails->push($detail);
                                                                }
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                @foreach($allExamDetails as $examDetail)
                                                    @php
                                                        $cellKey = $section->id . '_' . $classSubject->id . '_' . $examDetail->id;
                                                        $isAvailable = in_array($examDetail->id, $availableSummativeIds);
                                                    @endphp
                                                    @if($isAvailable)
                                                        <td class="px-3 py-3 whitespace-nowrap text-center border border-gray-200 bg-blue-50">
                                                            <div class="space-y-2">
                                                                <select 
                                                                    wire:model="formData.{{ $cellKey }}.teacher_id"
                                                                    class="w-full px-2 py-1 text-xs border border-blue-300 rounded focus:ring-blue-500 focus:border-blue-500 @if(!$isEditingEnabled) bg-blue-100 cursor-not-allowed @endif"
                                                                    @if(!$isEditingEnabled) disabled @endif
                                                                >
                                                                    <option value="">-- Select Teacher --</option>
                                                                    @foreach($teachers as $teacher)
                                                                        @if($teacher->id > 5)
                                                                        <option value="{{ $teacher->id }}">
                                                                            {{ $teacher->user ? $teacher->user->name : ($teacher->name ?? 'N/A') }}
                                                                        </option>
                                                                        @endif
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
                                                    @else
                                                        <td class="px-3 py-3 whitespace-nowrap text-center border border-gray-200 bg-gray-100">
                                                            <div class="text-gray-400 text-xs text-center">N/A</div>
                                                        </td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @endif>
                                    
                                    <!-- Formative Subjects Group -->
                                    @if($formativeSubjects && $formativeSubjects->count() > 0)
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
                                                
                                                <!-- Teacher Assignment Cells - Only Formative Exams -->
                                                @php
                                                    $formativeExamDetailsGrouped = $this->getExamDetailsForClassAndSubjectType($classSubject->myclass_id, 'Formative');
                                                    $allFormativeDetails = collect([]);
                                                    foreach($formativeExamDetailsGrouped as $examNameId => $examDetailsByType) {
                                                        foreach($examDetailsByType->groupBy('exam_type_id') as $typeDetails) {
                                                            foreach($typeDetails->groupBy('exam_part_id') as $partDetails) {
                                                                foreach($partDetails as $detail) {
                                                                    $allFormativeDetails->push($detail);
                                                                }
                                                            }
                                                        }
                                                    }
                                                    $availableFormativeIds = $allFormativeDetails->pluck('id')->toArray();
                                                    
                                                    // Get all possible exam details for alignment
                                                    $allExamDetails = collect([]);
                                                    foreach($allExamDetailsGrouped as $examNameId => $examDetailsByType) {
                                                        foreach($examDetailsByType->groupBy('exam_type_id') as $typeDetails) {
                                                            foreach($typeDetails->groupBy('exam_part_id') as $partDetails) {
                                                                foreach($partDetails as $detail) {
                                                                    $allExamDetails->push($detail);
                                                                }
                                                            }
                                                        }
                                                    }
                                                @endphp
                                                @foreach($allExamDetails as $examDetail)
                                                    @php
                                                        $cellKey = $section->id . '_' . $classSubject->id . '_' . $examDetail->id;
                                                        $isAvailable = in_array($examDetail->id, $availableFormativeIds);
                                                    @endphp
                                                    @if($isAvailable)
                                                        <td class="px-3 py-3 whitespace-nowrap text-center border border-gray-200 bg-green-50">
                                                            <div class="space-y-2">
                                                                <select 
                                                                    wire:model="formData.{{ $cellKey }}.teacher_id"
                                                                    class="w-full px-2 py-1 text-xs border border-green-300 rounded focus:ring-green-500 focus:border-green-500 @if(!$isEditingEnabled) bg-green-100 cursor-not-allowed @endif"
                                                                    @if(!$isEditingEnabled) disabled @endif
                                                                >
                                                                    <option value="">-- Select Teacher --</option>
                                                                    @foreach($teachers as $teacher)
                                                                        @if($teacher->id > 5)
                                                                        <option value="{{ $teacher->id }}">
                                                                            {{ $teacher->user ? $teacher->user->name : ($teacher->name ?? 'N/A') }}
                                                                        </option>
                                                                        @endif
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
                                                    @else
                                                        <td class="px-3 py-3 whitespace-nowrap text-center border border-gray-200 bg-gray-100">
                                                            <div class="text-gray-400 text-xs text-center">N/A</div>
                                                        </td>
                                                    @endif
                                                @endforeach
                                            </tr>
                                        @endforeach
                                    @endif>
                                </tbody>
                            </table>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-8 text-gray-500">
                        No sections found for this class.
                    </div>
                @endforelse>
            </div>
        @else
            <div class="text-center py-8 text-gray-500">
                No class selected or available.
            </div>
        @endif
    </div>
</div>