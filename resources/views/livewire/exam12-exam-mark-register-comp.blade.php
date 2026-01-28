<div class="container mx-auto px-4 py-6">
    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Exam Marks Register</h1>
        <p class="text-gray-600 mt-2">Enter and manage student examination marks by class, section, and subject.</p>
        
        <!-- ID Legend -->
        <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg text-sm">
            <div class="font-semibold text-blue-800 mb-2">ID Reference Key:</div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-xs">
                <div><span class="font-medium text-purple-700">SCR:</span> StudentCR ID</div>
                <div><span class="font-medium text-blue-700">ED:</span> Exam Detail ID</div>
                <div><span class="font-medium text-green-700">MS:</span> Myclass Section ID</div>
                <div><span class="font-medium text-yellow-700">ECS:</span> Exam Class Subject ID</div>
            </div>
        </div>
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
                    <button wire:click="setActiveTab({{ $index }})"
                        class="py-4 px-1 border-b-2 font-medium text-sm @if($activeTab === $index) border-blue-500 text-blue-600 @else border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 @endif">
                        {{ $class->name }}
                    </button>
                @endforeach
            </nav>
            <div class="space-x-2">
                <button wire:click="$refresh"
                    class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Refresh
                </button>
                <button wire:click="toggleEditEnable"
                    class="px-4 py-2 text-sm font-medium text-white bg-@if($isEditingEnabled) red @else blue @endif-600 border border-@if($isEditingEnabled) red @else blue @endif-600 rounded-md hover:bg-@if($isEditingEnabled) red @else blue @endif-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-@if($isEditingEnabled) red @else blue @endif-500">
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
                                @if(isset($debugInfo))
                                    <div class="text-sm text-gray-600 mt-1">
                                        Marks Data: {{ $debugInfo['filled_cells'] }}/{{ $debugInfo['total_cells'] }} cells filled
                                        ({{ $debugInfo['fill_rate'] }}%)
                                        @if($debugInfo['absent_cells'] > 0)
                                            , {{ $debugInfo['absent_cells'] }} absent
                                        @endif
                                    </div>
                                @endif
                            </div>

                            <div class="overflow-x-auto">
                                @php
                                    $studentsInSection = $this->getStudentsInSection($section->id);
                                @endphp

                                @if($studentsInSection->count() > 0)
                                    <table class="min-w-full divide-y divide-gray-200">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10"
                                                    rowspan="2">
                                                    Student
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50"
                                                    rowspan="2">
                                                    Exam Details
                                                </th>
                                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider bg-gray-50"
                                                    rowspan="2">
                                                    Marks
                                                </th>
                                                <!-- Subject Headers ordered by subject_type_id -->
                                                @foreach($subjectGroups as $subjectTypeId => $subjectsOfType)
                                                    @php
                                                        $subjectType = $subjectTypes->firstWhere('id', $subjectTypeId);
                                                        $colspan = count($subjectsOfType);
                                                    @endphp
                                                    <th class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-green-100"
                                                        colspan="{{ $colspan }}">
                                                        {{ $subjectType->name ?? 'Unknown Type' }}
                                                    </th>
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <!-- Subject Name Headers -->
                                                @foreach($subjectGroups as $subjectTypeId => $subjectsOfType)
                                                    @foreach($subjectsOfType as $classSubject)
                                                        <th
                                                            class="px-3 py-2 text-center text-xs font-medium text-gray-500 uppercase tracking-wider bg-green-50">
                                                            {{ $classSubject->subject->name ?? 'N/A' }}
                                                        </th>
                                                    @endforeach
                                                @endforeach
                                            </tr>
                                        </thead>

                                        <tbody class="bg-white divide-y divide-gray-200">
                                            @foreach($studentsInSection as $student)
                                                    <!-- Main student row -->
                                                    <tr class="hover:bg-gray-50">
                                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 sticky left-0 bg-white z-10 border-r border-gray-200 relative"
                                                            rowspan="{{ (is_array($examDetailsGrouped) ? collect($examDetailsGrouped)->map(function ($parts) {
                                                return count($parts); })->sum() : 0) + 1 }}">
                                                            <!-- Student ID Box -->
                                                            <div class="absolute top-2 right-2 bg-purple-100 border border-purple-300 rounded p-1 text-[9px] font-bold text-purple-800 z-20">
                                                                SCR: {{ $student->id }}
                                                            </div>
                                                            <div class="flex items-center pt-8">
                                                                <div class="ml-4">
                                                                    <div class="font-medium text-gray-900">
                                                                        {{ $student->studentdb->name ?? 'N/A' }}
                                                                    </div>
                                                                    <div class="text-gray-500 text-xs">Roll: {{ $student->roll_no ?? 'N/A' }}
                                                                    </div>
                                                                    <div class="text-gray-500 text-xs mt-1">
                                                                        <span class="font-semibold">Myclass Section ID:</span> {{ $section->id }}
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <!-- Empty cells for Exam Details and Marks columns -->
                                                        <td class="border-r border-gray-200"></td>
                                                        <td class="border-r border-gray-200"></td>
                                                        <!-- Subject marks columns -->
                                                        @foreach($subjectGroups as $subjectTypeId => $subjectsOfType)
                                                            @foreach($subjectsOfType as $classSubject)
                                                                <td class="px-3 py-3 text-center border border-gray-200 bg-white">
                                                                    <span class="text-gray-400">-</span>
                                                                </td>
                                                            @endforeach
                                                        @endforeach
                                                    </tr>

                                                    <!-- Exam Name rows for this student -->
                                                    @if(is_array($examDetailsGrouped) && count($examDetailsGrouped) > 0)
                                                        @foreach($examDetailsGrouped as $examNameId => $examPartsGrouped)
                                                            @php
                                                                $examName = $examNames->firstWhere('id', $examNameId);
                                                                $totalExamParts = count($examPartsGrouped);

                                                                // Get marks data for all students for this exam name and part
                                                                $firstExamPartId = array_key_first($examPartsGrouped);
                                                                $marksData = $this->getStudentMarksData($section->id, $examNameId, $firstExamPartId, $subjectGroups, $studentsInSection);

                                                                // Debug information
                                                                $debugInfo = $this->debugStudentMarksData($section->id, $examNameId, $firstExamPartId, $subjectGroups, $studentsInSection);
                                                            @endphp

                                                            <!-- For all exams, sub-divide by exam parts -->
                                                            @foreach($examPartsGrouped as $examPartId => $details)
                                                                @php
                                                                    $examPart = $examParts->firstWhere('id', $examPartId);
                                                                    $firstDetail = $details[0] ?? null;
                                                                    $examType = $firstDetail ? $examTypes->firstWhere('id', $firstDetail->exam_type_id) : null;
                                                                    $examMode = $firstDetail ? $examModes->firstWhere('id', $firstDetail->exam_mode_id) : null;
                                                                @endphp
                                                                <tr class="bg-blue-50">
                                                                    @if($loop->first)
                                                                        <td class="px-6 py-2 text-sm font-bold text-blue-800 bg-blue-100 border-b border-blue-200"
                                                                            rowspan="{{ $totalExamParts }}">
                                                                            {{ $examName->name ?? 'Unknown Exam' }}
                                                                        </td>
                                                                    @endif
                                                                    <td class="px-6 py-2 text-sm text-gray-900 bg-blue-100 border-b border-blue-200">
                                                                        <div class="mb-2 p-2 bg-white rounded border border-gray-200">
                                                                            <div class="font-medium text-gray-800">
                                                                                {{ $examPart->name ?? 'Unknown Part' }}
                                                                            </div>
                                                                            <div class="text-xs text-gray-500 mb-1">
                                                                                {{ $examType->name ?? 'Unknown Type' }}
                                                                            </div>
                                                                            @if($examMode)
                                                                                <div class="text-xs text-blue-600 font-medium">
                                                                                    Mode: {{ $examMode->name }}
                                                                                </div>
                                                                            @endif
                                                                            <!-- Marks for this exam part -->
                                                                            <div class="text-sm text-gray-600">
                                                                                <!-- Marks are displayed in subject columns -->
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <!-- Subject marks for this exam part row -->
                                                                    @foreach($subjectGroups as $subjectTypeId => $subjectsOfType)
                                                                        @foreach($subjectsOfType as $classSubject)
                                                                            @php
                                                                                // Get marks for this specific student, subject combination
                                                                                $studentMarks = $marksData[$student->id] ?? [];
                                                                                $subjectMarks = $studentMarks[$classSubject->subject_id] ?? [];
                                                                                $partMarks = $subjectMarks['display_marks'] ?? '-';
                                                                                $examMarks = $subjectMarks['exam_marks'] ?? null;
                                                                                $examDetailId = $subjectMarks['exam_detail_id'] ?? null;
                                                                                $examClassSubjectId = $subjectMarks['exam_class_subject_id'] ?? null;

                                                                                // For display purposes
                                                                                $hasMarks = $examMarks !== null;
                                                                                $isAbsent = isset($subjectMarks['is_absent']) && $subjectMarks['is_absent'];
                                                                            @endphp
                                                                            <td class="px-3 py-3 text-center border border-gray-200 bg-white relative">
                                                                                <!-- Four IDs Box -->
                                                                                <div class="absolute top-1 right-1 bg-yellow-100 border border-yellow-300 rounded p-1 text-[8px] leading-tight z-10">
                                                                                    <div class="font-bold text-yellow-800">IDs</div>
                                                                                    <div>SCR: {{ $student->id }}</div>
                                                                                    <div>ED: {{ $examDetailId ?? 'N/A' }}</div>
                                                                                    <div>MS: {{ $section->id }}</div>
                                                                                    <div>ECS: {{ $examClassSubjectId ?? 'N/A' }}</div>
                                                                                </div>
                                                                                
                                                                                <div class="text-sm font-medium mb-1 pt-12">
                                                                                    {{ $partMarks }}
                                                                                </div>
                                                                                
                                                                                <!-- Status indicators -->
                                                                                <div class="text-xs text-gray-500 mt-1">
                                                                                    @if($hasMarks && !$isAbsent)
                                                                                        <span class="text-green-600">{{ $examMarks }}</span>
                                                                                    @elseif($isAbsent)
                                                                                        <span class="text-red-600 font-semibold">ABSENT</span>
                                                                                    @elseif($partMarks === 'No ECS')
                                                                                        <span class="text-orange-600 font-semibold">No ECS Config</span>
                                                                                    @endif
                                                                                </div>
                                                                                
                                                                                <!-- Validation status -->
                                                                                @if($examDetailId && $examClassSubjectId)
                                                                                    <div class="text-[8px] text-green-600 font-semibold mt-1">✓ Valid</div>
                                                                                @elseif($examDetailId && !$examClassSubjectId)
                                                                                    <div class="text-[8px] text-red-600 font-semibold mt-1">✗ Invalid</div>
                                                                                @endif
                                                                            </td>
                                                                        @endforeach
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                        @endforeach
                                                    @else
                                                        <tr>
                                                            <td colspan="2" class="px-6 py-4 text-center text-gray-500 border-r border-gray-200">
                                                                No exam details found for this class
                                                            </td>
                                                            <!-- Subject columns for no exam details row -->
                                                            @foreach($subjectGroups as $subjectTypeId => $subjectsOfType)
                                                                @foreach($subjectsOfType as $classSubject)
                                                                    <td class="px-3 py-3 text-center border border-gray-200 bg-white">
                                                                        <!-- No marks to display -->
                                                                    </td>
                                                                @endforeach
                                                            @endforeach
                                                        </tr>
                                                    @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <div class="text-center py-8">
                                        <div class="text-gray-400 mb-2">
                                            <svg class="mx-auto h-8 w-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z">
                                                </path>
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">No Sections Found</h3>
                    <p class="text-gray-500">No sections are configured for this class.</p>
                </div>
            @elseif($subjectGroups->count() == 0)
                <div class="text-center py-12">
                    <div class="text-gray-400 mb-4">
                        <svg class="mx-auto h-12 w-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
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
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                        </path>
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