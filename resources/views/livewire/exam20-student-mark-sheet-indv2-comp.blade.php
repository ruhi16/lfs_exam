<div class="container mx-auto px-4 py-6">
    <div class="mb-4">
        <h1 class="text-xl font-semibold text-gray-800">Student Mark Sheet</h1>
        <p class="text-gray-600 mt-1 text-xs">Compact view of marks with grades</p>
    </div>

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
            <button 
                wire:click="$refresh"
                class="px-4 py-2 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
            >
                Refresh
            </button>
        </div>
    </div>

    @if(isset($classes[$activeTab]))
        @php
            $activeClass = $classes[$activeTab];
            $classSections = $this->getClassSections($activeClass->id);
            $examDetailsGrouped = $this->getExamDetailsForClass($activeClass->id);
            $groupedClassSubjects = $this->getClassSubjectsGroupedByType($activeClass->id);
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 mb-4">
            <div class="bg-white rounded border p-3">
                <h3 class="text-sm font-semibold text-gray-800 mb-2">School</h3>
                <div class="text-xs text-gray-700 space-y-1">
                    <div><span class="font-medium">Name:</span> {{ $school->name ?? 'N/A' }}</div>
                    <div><span class="font-medium">Address:</span> {{ $school->address ?? 'N/A' }}</div>
                    <div><span class="font-medium">Phone:</span> {{ $school->phone ?? 'N/A' }}</div>
                </div>
            </div>
            <div class="bg-white rounded border p-3">
                <h3 class="text-sm font-semibold text-gray-800 mb-2">Session</h3>
                <div class="text-xs text-gray-700 space-y-1">
                    <div><span class="font-medium">Name:</span> {{ $session->name ?? 'N/A' }}</div>
                    <div><span class="font-medium">Year:</span> {{ $session->year ?? 'N/A' }}</div>
                    <div><span class="font-medium">Status:</span> {{ $session->status ?? 'N/A' }}</div>
                </div>
            </div>
            <div class="bg-white rounded border p-3">
                <h3 class="text-sm font-semibold text-gray-800 mb-2">Student Selection</h3>
                <div class="space-y-2">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Section</label>
                        <select 
                            wire:model="selectedSectionId"
                            wire:change="setSelectedSection($event.target.value)"
                            class="w-full px-2 py-1 text-xs border border-gray-300 rounded-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">-- Select Section --</option>
                            @foreach($classSections as $sec)
                                <option value="{{ $sec->id }}">{{ $sec->section->name ?? 'N/A' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Student</label>
                        <select 
                            wire:model="selectedStudentId"
                            wire:change="setSelectedStudent($event.target.value)"
                            class="w-full px-2 py-1 text-xs border border-gray-300 rounded-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                        >
                            <option value="">-- Select Student --</option>
                            @foreach($students as $stu)
                                <option value="{{ $stu->id }}">{{ $stu->studentdb->name ?? 'N/A' }} (Roll: {{ $stu->roll_no ?? 'N/A' }})</option>
                            @endforeach
                        </select>
                    </div>
                    @if($selectedStudentId)
                        @php
                            $curStudent = $students->firstWhere('id', $selectedStudentId);
                        @endphp
                        <div class="text-xs text-gray-700 space-y-1">
                            <div><span class="font-medium">Name:</span> {{ $curStudent->studentdb->name ?? 'N/A' }}</div>
                            <div><span class="font-medium">Roll:</span> {{ $curStudent->roll_no ?? 'N/A' }}</div>
                            <div><span class="font-medium">Class:</span> {{ $curStudent->myclass->name ?? $activeClass->name }}</div>
                            <div><span class="font-medium">Section:</span> {{ $curStudent->section->name ?? ($classSections->firstWhere('id', $selectedSectionId)->section->name ?? 'N/A') }}</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Tables: Summative and Formative -->
        @php
            $summativeType = $subjectTypes->firstWhere('name', 'Summative');
            $formativeType = $subjectTypes->firstWhere('name', 'Formative');
        @endphp

        @foreach([['label' => 'Summative', 'type' => $summativeType], ['label' => 'Formative', 'type' => $formativeType]] as $block)
            @php
                $typeId = $block['type']->id ?? null;
                $classSubjectsOfType = $typeId ? ($groupedClassSubjects[$typeId] ?? collect()) : collect();
                $examDetailsGroupedByType = $typeId ? $this->getExamDetailsBySubjectType($activeClass->id, $typeId) : collect();
                $isSummative = strtolower($block['label']) === 'summative';
            @endphp
            @if($typeId && $classSubjectsOfType->count() > 0)
                <div class="bg-white rounded border overflow-hidden mb-6">
                    <div class="bg-gray-50 px-4 py-2 border-b border-gray-200 flex justify-between items-center">
                        <h3 class="text-sm font-medium text-gray-900">{{ $block['label'] }} Subjects</h3>
                        <div class="text-xs text-gray-500">Class: {{ $activeClass->name }}</div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200 text-xs">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-3 py-2 text-left font-medium text-gray-600 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                        Subject
                                    </th>
                                    @foreach($examDetailsGroupedByType as $examNameId => $examDetailsByType)
                                        @php
                                            $examName = $examNames->firstWhere('id', $examNameId);
                                            $colspan = 0;
                                            foreach($examDetailsByType->groupBy('exam_type_id') as $typeGroup) {
                                                $colspan += $typeGroup->groupBy('exam_part_id')->count();
                                            }
                                        @endphp
                                        @if($examName && $colspan > 0)
                                            <th colspan="{{ $colspan }}" class="px-3 py-2 text-center font-medium text-gray-600 uppercase tracking-wider bg-blue-50">
                                                {{ $examName->name }}
                                            </th>
                                        @endif
                                    @endforeach
                                </tr>
                                <tr>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                        -
                                    </th>
                                    @foreach($examDetailsGroupedByType as $examNameId => $examDetailsByType)
                                        @foreach($examDetailsByType->groupBy('exam_type_id') as $examTypeId => $typeDetails)
                                            @php
                                                $examType = $examTypes->firstWhere('id', $examTypeId);
                                                $partsCount = $typeDetails->groupBy('exam_part_id')->count();
                                            @endphp
                                            @if($examType && $partsCount > 0)
                                                <th colspan="{{ $partsCount }}" class="px-2 py-1 text-center font-medium text-blue-700 uppercase tracking-wider bg-blue-100 border-l border-r border-gray-200">
                                                    {{ $examType->name }}
                                                </th>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </tr>
                                <tr>
                                    <th class="px-3 py-2 text-left font-medium text-gray-500 uppercase tracking-wider sticky left-0 bg-gray-50 z-10">
                                        -
                                    </th>
                                    @foreach($examDetailsGroupedByType as $examNameId => $examDetailsByType)
                                        @foreach($examDetailsByType->groupBy('exam_type_id') as $examTypeId => $typeDetails)
                                            @foreach($typeDetails->groupBy('exam_part_id') as $examPartId => $partDetails)
                                                @php
                                                    $examPartObj = $examParts->firstWhere('id', $examPartId);
                                                    $firstDetail = $partDetails->first();
                                                @endphp
                                                <th class="px-2 py-1 text-center font-medium text-purple-700 uppercase tracking-wider bg-purple-50 border border-gray-200">
                                                    <div class="text-[10px] text-gray-500 mb-1">
                                                        {{ $examPartObj ? $examPartObj->name : 'N/A' }}
                                                    </div>
                                                    <div class="text-[10px] text-gray-500">
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
                                    $sumMarks = 0;
                                    $sumFull = 0;
                                    $summativeExamType = $examTypes->firstWhere('name', 'Summative');
                                @endphp
                                @foreach($classSubjectsOfType as $classSubject)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-3 py-2 whitespace-nowrap font-medium text-gray-900 sticky left-0 bg-white z-10 border-r border-gray-200">
                                            <div class="flex items-center">
                                                <div class="flex-shrink-0 h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                                                    <span class="text-blue-800 font-medium text-xs">{{ substr($classSubject->subject->name ?? 'N/A', 0, 1) }}</span>
                                                </div>
                                                <div class="ml-4">
                                                    <div class="font-medium text-gray-900 text-sm">{{ $classSubject->subject->name ?? 'N/A' }}</div>
                                                    <div class="text-gray-500 text-[10px]">{{ $classSubject->subject->code ?? '' }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        @foreach($examDetailsGroupedByType as $examNameId => $examDetailsByType)
                                            @foreach($examDetailsByType->groupBy('exam_type_id') as $examTypeId => $typeDetails)
                                                @foreach($typeDetails->groupBy('exam_part_id') as $examPartId => $partDetails)
                                                    @php
                                                        $examDetail = $partDetails->first();
                                                        $entry = ($selectedStudentId) ? $this->getMarkEntry($classSubject->subject_id, $examDetail->id) : null;
                                                        $val = $entry['marks'] ?? null;
                                                        $isAbsent = $entry['is_absent'] ?? false;
                                                        $gradeId = $entry['grade_id'] ?? null;
                                                        $gradeObj = $gradeId ? ($this->gradesMap[$gradeId] ?? null) : null;
                                                        $fm = $this->getFullMarks($classSubject->subject_id, $examDetail->id);
                                                        if($isSummative && !$isAbsent && !is_null($val) && !is_null($fm)){
                                                            $sumMarks += (int)$val;
                                                            $sumFull += (int)$fm;
                                                        }
                                                    @endphp
                                                    <td class="px-2 py-2 whitespace-nowrap text-center border border-gray-200 bg-white">
                                                        @if($selectedStudentId)
                                                            @if(!is_null($val))
                                                                @if($val == -99 || $isAbsent)
                                                                    <span class="inline-block px-2 py-1 bg-gray-100 text-gray-600 rounded font-semibold">AB</span>
                                                                @else
                                                                    <div class="flex flex-col items-center space-y-1">
                                                                        <span class="inline-block px-2 py-1 bg-green-50 text-green-700 rounded font-semibold">{{ intval($val) }}</span>
                                                                        <span class="text-[10px] text-gray-500">{{ $gradeObj->grade ?? '' }}</span>
                                                                        <span class="text-[10px] text-gray-400">FM: {{ $fm ?? '-' }}</span>
                                                                    </div>
                                                                @endif
                                                            @else
                                                                <span class="text-[10px] text-gray-300">-</span>
                                                            @endif
                                                        @else
                                                            <span class="text-[10px] text-gray-400">Select student</span>
                                                        @endif
                                                    </td>
                                                @endforeach
                                            @endforeach
                                        @endforeach
                                    </tr>
                                @endforeach
                                @if($isSummative)
                                    @php
                                        $totalPercent = $sumFull > 0 ? round(($sumMarks / $sumFull) * 100, 2) : null;
                                        $totalGrade = ($summativeExamType && !is_null($totalPercent)) ? $this->computeGradeByPercent($totalPercent, $summativeExamType->id) : '';
                                    @endphp
                                    <tr class="bg-gray-50">
                                        <td class="px-3 py-2 text-right font-semibold text-gray-700 sticky left-0 bg-gray-50 z-10 border-r border-gray-200">Total</td>
                                        <td colspan="{{ $examDetailsGroupedByType->sum(function($examDetailsByType) { return $examDetailsByType->groupBy('exam_type_id')->sum(function($typeDetails){ return $typeDetails->groupBy('exam_part_id')->count(); }); }) }}" class="px-3 py-2 text-center font-semibold text-gray-700">
                                            {{ $sumMarks }} / {{ $sumFull }} &nbsp; ({{ $totalPercent ?? 0 }}%) &nbsp; Grade: {{ $totalGrade }}
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endforeach
        <div class="mt-6 bg-white rounded border">
            <div class="px-4 py-2 border-b text-sm font-medium text-gray-800">Declaration & Rules</div>
            <table class="w-full text-xs">
                <tbody>
                    <tr>
                        <td class="px-4 py-2 border text-gray-700">1. AB indicates absence in the corresponding exam part.</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border text-gray-700">2. Grades are calculated as per the exam type’s grade scheme.</td>
                    </tr>
                    <tr>
                        <td class="px-4 py-2 border text-gray-700">3. This marksheet is system generated and valid without signature.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    @endif
</div>