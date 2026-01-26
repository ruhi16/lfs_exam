<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Exam Marks Register</h1>
        <p class="text-gray-600 mt-2">Enter and manage student examination marks by class, section, and subject.</p>
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
                $subjectGroups = $this->getExamClassSubjectsGroupedByType($activeClass->id);
                $examDetailsGrouped = $this->getExamDetailsGroupedByExamNameAndPart($activeClass->id);
            @endphp
            
            @if($classSections->count() > 0 && $subjectGroups->count() > 0)
                <div class="space-y-8 p-6">
                    <!-- Sections Loop -->
                    @foreach($classSections as $section)
                        <div class="border border-gray-200 rounded-lg">
                            <div class="bg-gray-50 px-6 py-3 border-b border-gray-200">
                                <h3 class="text-lg font-medium text-gray-900">Section: {{ $section->section->name ?? 'N/A' }}</h3>
                            </div>
                            
                            <div class="overflow-x-auto">
                                @php
                                    $studentsInSection = $this->getStudentsInSection($section->id);
                                @endphp
                                
                                @if($studentsInSection->count() > 0)
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                                    Student
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">
                                                    Exam Details
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50">
                                                    Marks
                                                </th>
                                            </tr>
                                        </thead>
                                        
                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($studentsInSection as $student)
                                                <!-- Main student row -->
                                                <tr class="hover:bg-gray-50">
                                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white z-10 border-r border-gray-200" rowspan="{{ (is_array($examDetailsGrouped) ? count($examDetailsGrouped) : 0) + 1 }}">
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
                                                </tr>
                                                
                                                <!-- Exam Name rows for this student -->
                                                @if(is_array($examDetailsGrouped) && count($examDetailsGrouped) > 0)
                                                    @foreach($examDetailsGrouped as $examNameId => $examPartsGrouped)
                                                        @php
                                                            $examName = $examNames->firstWhere('id', $examNameId);
                                                            $totalExamParts = count($examPartsGrouped);
                                                        @endphp
                                                        <!-- Exam Name sub-row with exam parts as sub-rows in next column -->
                                                        <tr class="bg-blue-50">
                                                            <td class="px-6 py-2 text-sm font-bold text-blue-800 bg-blue-100 border-b border-blue-200">
                                                                {{ $examName->name ?? 'Unknown Exam' }}
                                                            </td>
                                                            <td class="px-6 py-2 text-sm text-gray-900 bg-blue-100 border-b border-blue-200">
                                                                <!-- Exam Parts listed in this column -->
                                                                @foreach($examPartsGrouped as $examPartId => $details)
                                                                    @php
                                                                        $examPart = $examParts->firstWhere('id', $examPartId);
                                                                        $firstDetail = $details[0] ?? null;
                                                                        $examType = $firstDetail ? $examTypes->firstWhere('id', $firstDetail->exam_type_id) : null;
                                                                    @endphp
                                                                    <div class="mb-2 p-2 bg-white rounded border border-gray-200">
                                                                        <div class="font-medium text-gray-800">
                                                                            {{ $examPart->name ?? 'Unknown Part' }}
                                                                        </div>
                                                                        <div class="text-xs text-gray-500 mb-1">
                                                                            {{ $examType->name ?? 'Unknown Type' }}
                                                                        </div>
                                                                        <!-- Marks for this exam part -->
                                                                        <div class="flex flex-wrap gap-1">
                                                                            @foreach($subjectGroups as $subjectTypeId => $subjectsOfType)
                                                                                @foreach($subjectsOfType as $classSubject)
                                                                                    @php
                                                                                        // Find the exam detail for this subject in this exam part
                                                                                        $detailForSubject = null;
                                                                                        foreach($details as $detail) {
                                                                                            if($detail->subject_id == $classSubject->subject_id) {
                                                                                                $detailForSubject = $detail;
                                                                                                break;
                                                                                            }
                                                                                        }
                                                                                        
                                                                                        if($detailForSubject) {
                                                                                            $existingRecord = $this->getExistingMarksEntry($section->id, $detailForSubject->id, $student->id);
                                                                                            $marks = $existingRecord ? $existingRecord->getDisplayMarks() : '';
                                                                                            if ($existingRecord && $existingRecord->isAbsent()) {
                                                                                                $marks = 'AB';
                                                                                            }
                                                                                        } else {
                                                                                            $marks = '';
                                                                                        }
                                                                                    @endphp
                                                                                    <div class="flex items-center space-x-1 bg-gray-50 px-2 py-1 rounded text-xs">
                                                                                        <span class="text-gray-600">{{ $classSubject->subject->name ?? 'N/A' }}:</span>
                                                                                        <span class="font-medium">{{ $marks }}</span>
                                                                                    </div>
                                                                                @endforeach
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                    @if(!$loop->last)
                                                                        <div class="border-t border-gray-200 my-2"></div>
                                                                    @endif
                                                                @endforeach
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @else
                                                    <tr>
                                                        <td colspan="2" class="px-6 py-4 text-center text-gray-500">
                                                            No exam details found for this class
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="text-center py-8">
                                        <div class="text-gray-400 mb-2">
                                            <svg class="mx-auto h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                            </svg>
                                        </div>
                                        <p class="text-gray-500">No students found in this section.</p>
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
            @elseif($subjectGroups->count() == 0)
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No Subjects Found</h3>
                    <p class="text-gray-500">No subjects are assigned to this class.</p>
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
        Showing marks register for {{ $classes->count() ?? 0 }} classes
    </div>
</div>
