<div class="container mx-auto px-2 py-4">
    <!-- Header -->
    <div class="mb-4 flex justify-between items-center">
        <div>
            <h1 class="text-xl font-bold text-gray-800">Exam Marks Register</h1>
            <p class="text-xs text-gray-600">Compact View</p>
        </div>
        <div>
            @if(!$isEditing)
                <button wire:click="updateMarks" 
                        class="px-3 py-1 bg-blue-600 text-white text-xs font-bold rounded hover:bg-blue-700 uppercase tracking-wider">
                    Enable Editing
                </button>
            @else
                <button wire:click="saveMarks" 
                        class="px-3 py-1 bg-green-600 text-white text-xs font-bold rounded hover:bg-green-700 uppercase tracking-wider mr-2">
                    Save Changes
                </button>
                <button wire:click="cancelEdit" 
                        class="px-3 py-1 bg-gray-500 text-white text-xs font-bold rounded hover:bg-gray-600 uppercase tracking-wider">
                    Cancel
                </button>
            @endif
        </div>
    </div>

    <!-- Status Messages -->
    @if(session()->has('message'))
        <div class="mb-2 p-2 bg-green-100 text-green-700 text-sm rounded border border-green-200">
            {{ session('message') }}
        </div>
    @endif

    @if(session()->has('error'))
        <div class="mb-2 p-2 bg-red-100 text-red-700 text-sm rounded border border-red-200">
            {{ session('error') }}
        </div>
    @endif

    <!-- Class Tabs -->
    <div class="mb-4 border-b border-gray-300">
        <div class="flex space-x-1 overflow-x-auto" aria-label="Tabs">
            @if($classes && $classes->count() > 0)
                @foreach($classes as $index => $class)
                    <button wire:click="setActiveTab({{ $index }})"
                        class="py-2 px-4 font-medium text-xs focus:outline-none transition-colors duration-150
                        @if($activeTab === $index) 
                            bg-blue-600 text-white rounded-t-md shadow-sm 
                        @else 
                            text-gray-600 hover:bg-gray-100 hover:text-gray-800 rounded-t-md
                        @endif">
                        {{ $class->name }}
                    </button>
                @endforeach
            @else
                <div class="py-2 text-xs text-gray-500">No classes available</div>
            @endif
        </div>
    </div>

    <!-- Content Area -->
    <div class="bg-white rounded shadow-sm overflow-hidden border border-gray-200">
        @if($activeClass)
            @if($sections->count() > 0)
                <div class="p-2 space-y-6">
                    @foreach($sections as $section)
                        @php
                            // Filter students for this section (already loaded in $students)
                            $sectionStudents = $students->where('section_id', $section->section_id);
                            if ($sectionStudents->isEmpty()) continue;
                            
                            // Calculate totals for rowspans
                            // Total rows per student = Sum of (ExamTypes * ExamParts)
                            // We can calculate this once since it's the same for all students
                            $totalExamRows = 0;
                            foreach($examDetailsGrouped as $examNameId => $examParts) {
                                $totalExamRows += count($examParts);
                            }
                        @endphp

                        <div class="border border-gray-300">
                            <div class="bg-gray-100 px-3 py-1 border-b border-gray-300 font-bold text-sm text-gray-700">
                                Section: {{ $section->section->name ?? 'N/A' }}
                            </div>

                            <div class="overflow-x-auto">
                                <table class="w-full border-collapse text-xs">
                                    <thead>
                                        @php
                                            $summativeSubjects = $classSubjects->filter(function($ms){ return strtolower($ms->subject->subjectType->name ?? '') === 'summative'; });
                                            $formativeSubjects = $classSubjects->filter(function($ms){ return strtolower($ms->subject->subjectType->name ?? '') === 'formative'; });
                                        @endphp
                                        <tr class="bg-gray-200 text-gray-600 uppercase">
                                            <th class="border border-gray-300 px-2 py-1 text-left w-32">Student</th>
                                            <th class="border border-gray-300 px-2 py-1 text-left w-24">Exam</th>
                                            <th class="border border-gray-300 px-2 py-1 text-left w-24">Part</th>
                                            <th colspan="{{ $summativeSubjects->count() + 1 }}" class="border border-gray-300 px-2 py-1 text-center">Summative</th>
                                            <th colspan="{{ $formativeSubjects->count() + 1 }}" class="border border-gray-300 px-2 py-1 text-center">Formative</th>
                                        </tr>
                                        <tr class="bg-gray-100 text-gray-600 uppercase">
                                            <th class="border border-gray-300 px-2 py-1 text-left w-32"></th>
                                            <th class="border border-gray-300 px-2 py-1 text-left w-24"></th>
                                            <th class="border border-gray-300 px-2 py-1 text-left w-24"></th>
                                            <th class="border border-gray-300 px-1 py-1 text-center min-w-[80px] bg-blue-100">
                                                <div class="font-bold text-gray-800">Summative Detail</div>
                                                <div class="text-[10px] font-normal text-gray-500">ID</div>
                                            </th>
                                            @foreach($summativeSubjects as $ms)
                                                <th class="border border-gray-300 px-1 py-1 text-center min-w-[80px] bg-blue-50">
                                                    <div class="font-bold text-gray-800">{{ $ms->subject->name ?? 'Sub' }}</div>
                                                    <div class="text-[10px] font-normal text-gray-500">S</div>
                                                </th>
                                            @endforeach
                                            <th class="border border-gray-300 px-1 py-1 text-center min-w-[80px] bg-yellow-100">
                                                <div class="font-bold text-gray-800">Formative Detail</div>
                                                <div class="text-[10px] font-normal text-gray-500">ID</div>
                                            </th>
                                            @foreach($formativeSubjects as $ms)
                                                <th class="border border-gray-300 px-1 py-1 text-center min-w-[80px] bg-yellow-50">
                                                    <div class="font-bold text-gray-800">{{ $ms->subject->name ?? 'Sub' }}</div>
                                                    <div class="text-[10px] font-normal text-gray-500">F</div>
                                                </th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                        @foreach($sectionStudents as $student)
                                            @php $isFirstStudentRow = true; @endphp
                                            
                                            @foreach($examDetailsGrouped as $examNameId => $examParts)
                                                @php 
                                                    $examName = $examParts[array_key_first($examParts)][0]->examName->name ?? 'Exam';
                                                    $isFirstExamRow = true;
                                                    $examRowCount = count($examParts);
                                                @endphp
                                                
                                                @foreach($examParts as $examPartId => $details)
                                                    @php 
                                                        $detail = $details[0]; 
                                                        $baseDetail = $detail;
                                                    @endphp
                                                    <tr class="hover:bg-gray-50">
                                                        <!-- Student Column -->
                                                        @if($isFirstStudentRow)
                                                            <td rowspan="{{ $totalExamRows }}" class="border border-gray-300 px-2 py-1 align-top bg-white">
                                                                <div class="font-bold">{{ $student->studentdb->name ?? 'N/A' }}</div>
                                                                <div class="text-gray-500">Roll: {{ $student->roll_no }}</div>
                                                            </td>
                                                            @php $isFirstStudentRow = false; @endphp
                                                        @endif
                                                        
                                                        <!-- Exam Name Column -->
                                                        @if($isFirstExamRow)
                                                            <td rowspan="{{ $examRowCount }}" class="border border-gray-300 px-2 py-1 align-top bg-gray-50 font-medium">
                                                                {{ $examName }}
                                                            </td>
                                                            @php $isFirstExamRow = false; @endphp
                                                        @endif
                                                        
                                                        <!-- Exam Part Column -->
                                                        <td class="border border-gray-300 px-2 py-1 bg-gray-50">
                                                            {{ $detail->examPart->name ?? 'Part' }}
                                                        </td>
                                                        @php
                                                            $summDetail = collect($details)->first(function($d){ return ($d->exam_type_id ?? null) === 1; });
                                                            $summMarksSum = null;
                                                            if ($summDetail) {
                                                                $ecsMap = $examClassSubjectMap[$summDetail->id] ?? [];
                                                                $total = 0;
                                                                $hasAny = false;
                                                                foreach ($ecsMap as $subId => $map) {
                                                                    $key = $student->id . '_' . $map['id'];
                                                                    $entry = $marksData[$key] ?? null;
                                                                    if ($entry && !($entry['is_absent'] ?? false) && isset($entry['exam_marks'])) {
                                                                        $total += $entry['exam_marks'];
                                                                        $hasAny = true;
                                                                    }
                                                                }
                                                                $summMarksSum = $hasAny ? $total : null;
                                                            }
                                                        @endphp
                                                        <td class="border border-gray-300 px-1 py-1 text-center bg-blue-100">
                                                            <div class="font-medium text-gray-800">{{ $summDetail->id ?? '-' }}</div>
                                                            <div class="text-[10px] text-gray-600">{{ $summMarksSum !== null ? $summMarksSum : '-' }}</div>
                                                        </td>
                                                        
                                                        <!-- Marks Cells -->
                                                        @foreach($summativeSubjects as $ms)
                                                            @php
                                                                $subjectId = $ms->subject_id;
                                                                $subjectTypeName = strtolower($ms->subject->subjectType->name ?? '');
                                                                $expectedTypeId = 1;
                                                                $selectedDetail = collect($details)->first(function($d) use ($expectedTypeId, $subjectId, $examClassSubjectMap){
                                                                    return ($d->exam_type_id ?? null) === $expectedTypeId
                                                                        && isset($examClassSubjectMap[$d->id][$subjectId]);
                                                                });
                                                                // Check if mapping exists using our pre-loaded map
                                                                $mapping = $selectedDetail ? ($examClassSubjectMap[$selectedDetail->id][$subjectId] ?? null) : null;
                                                                
                                                                // Key for marks: {student_id}_{exam_class_subject_id}
                                                                $key = $mapping ? ($student->id . '_' . $mapping['id']) : null;
                                                                $markEntry = $key ? ($marksData[$key] ?? null) : null;
                                                                
                                                                $bgColor = $mapping ? 'bg-white' : 'bg-gray-100';
                                                            @endphp
                                                            
                                                            <td class="border border-gray-300 px-1 py-1 text-center {{ $bgColor }}">
                                                                @if($mapping)
                                                                    @if($isEditing)
                                                                        <div class="flex flex-col items-center space-y-1">
                                                                            <input type="number" 
                                                                                   wire:model.defer="marksData.{{ $key }}.exam_marks"
                                                                                   class="w-12 text-center text-xs border border-gray-300 rounded p-1 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                                                                   placeholder="-"
                                                                                   {{ ($markEntry['is_absent'] ?? false) ? 'disabled' : '' }}
                                                                            >
                                                                            <div class="flex items-center space-x-1">
                                                                                <input type="checkbox" 
                                                                                       wire:model.defer="marksData.{{ $key }}.is_absent"
                                                                                       class="h-3 w-3 text-red-600 focus:ring-red-500 border-gray-300 rounded"
                                                                                >
                                                                                <span class="text-[10px] text-gray-500">AB</span>
                                                                            </div>
                                                                            <div class="text-[10px] text-gray-400">ECS: {{ $mapping['id'] }}</div>
                                                                        </div>
                                                                    @else
                                                                        @if(isset($markEntry['is_absent']) && $markEntry['is_absent'])
                                                                            <span class="text-red-600 font-bold">AB</span>
                                                                        @elseif(isset($markEntry['exam_marks']) && $markEntry['exam_marks'] !== null)
                                                                            <span class="font-medium text-gray-800">{{ $markEntry['exam_marks'] }}</span>
                                                                        @else
                                                                            <span class="text-gray-300">-</span>
                                                                        @endif
                                                                        <div class="text-[10px] text-gray-400">ECS: {{ $mapping['id'] }}</div>
                                                                    @endif
                                                                @else
                                                                    <span class="text-gray-300 text-[10px]">N/A</span>
                                                                @endif
                                                            </td>
                                                        @endforeach
                                                        
                                                        @php
                                                            $formDetail = collect($details)->first(function($d){ return ($d->exam_type_id ?? null) === 2; });
                                                        @endphp
                                                        <td class="border border-gray-300 px-1 py-1 text-center bg-yellow-100">
                                                            {{ $formDetail->id ?? '-' }}
                                                        </td>
                                                        
                                                        @foreach($formativeSubjects as $ms)
                                                            @php
                                                                $subjectId = $ms->subject_id;
                                                                $expectedTypeId = 2;
                                                                $selectedDetail = collect($details)->first(function($d) use ($expectedTypeId, $subjectId, $examClassSubjectMap){
                                                                    return ($d->exam_type_id ?? null) === $expectedTypeId
                                                                        && isset($examClassSubjectMap[$d->id][$subjectId]);
                                                                });
                                                                $mapping = $selectedDetail ? ($examClassSubjectMap[$selectedDetail->id][$subjectId] ?? null) : null;
                                                                $key = $mapping ? ($student->id . '_' . $mapping['id']) : null;
                                                                $markEntry = $key ? ($marksData[$key] ?? null) : null;
                                                                $bgColor = $mapping ? 'bg-white' : 'bg-gray-100';
                                                            @endphp
                                                            <td class="border border-gray-300 px-1 py-1 text-center {{ $bgColor }}">
                                                                @if($mapping)
                                                                    @if($isEditing)
                                                                        <div class="flex flex-col items-center space-y-1">
                                                                            <input type="number" 
                                                                                   wire:model.defer="marksData.{{ $key }}.exam_marks"
                                                                                   class="w-12 text-center text-xs border border-gray-300 rounded p-1 focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                                                                   placeholder="-"
                                                                                   {{ ($markEntry['is_absent'] ?? false) ? 'disabled' : '' }}
                                                                            >
                                                                            <div class="flex items-center space-x-1">
                                                                                <input type="checkbox" 
                                                                                       wire:model.defer="marksData.{{ $key }}.is_absent"
                                                                                       class="h-3 w-3 text-red-600 focus:ring-red-500 border-gray-300 rounded"
                                                                                >
                                                                                <span class="text-[10px] text-gray-500">AB</span>
                                                                            </div>
                                                                            <div class="text-[10px] text-gray-400">ECS: {{ $mapping['id'] }}</div>
                                                                        </div>
                                                                    @else
                                                                        @if(isset($markEntry['is_absent']) && $markEntry['is_absent'])
                                                                            <span class="text-red-600 font-bold">AB</span>
                                                                        @elseif(isset($markEntry['exam_marks']) && $markEntry['exam_marks'] !== null)
                                                                            <span class="font-medium text-gray-800">{{ $markEntry['exam_marks'] }}</span>
                                                                        @else
                                                                            <span class="text-gray-300">-</span>
                                                                        @endif
                                                                        <div class="text-[10px] text-gray-400">ECS: {{ $mapping['id'] }}</div>
                                                                    @endif
                                                                @else
                                                                    <span class="text-gray-300 text-[10px]">N/A</span>
                                                                @endif
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="p-8 text-center text-gray-500">
                    No sections found for this class.
                </div>
            @endif
        @endif
    </div>
</div>
