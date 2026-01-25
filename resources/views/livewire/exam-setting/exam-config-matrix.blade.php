@if($selectedClassId && count($examDetails) > 0)
<div class="overflow-x-auto">
    <table class="min-w-full border border-gray-300">
        <thead>
            {{-- Exam Names Row --}}
            <tr class="bg-blue-50">
                <th class="border border-gray-300 px-4 py-3 text-left text-sm font-semibold text-gray-900">
                    Subject Types / Exams
                </th>
                @foreach($examNames as $examName)
                @php
                $examDetailsForName = collect($examDetails)->where('exam_name_id', $examName->id ?? 0);
                $examTypesForName = $examDetailsForName->groupBy('exam_type_id');
                $totalPartsForName = 0;
                foreach($examTypesForName as $examTypeGroup) {
                $totalPartsForName += count($examTypeGroup);
                }
                @endphp
                <th class="border border-gray-300 px-4 py-3 text-center text-sm font-semibold text-gray-900"
                    colspan="{{ $totalPartsForName }}">
                    {{ $examName->name ?? 'Unknown' }}
                </th>
                @endforeach
            </tr>

            {{-- Exam Types Row --}}
            <tr class="bg-blue-100">
                <th class="border border-gray-300 px-4 py-2 text-left text-xs font-medium text-gray-700">
                    Subjects
                </th>
                @foreach($examNames as $examName)
                @php
                $examDetailsForName = collect($examDetails)->where('exam_name_id', $examName->id ?? 0);
                $examTypesForName = $examDetailsForName->groupBy('exam_type_id');
                @endphp
                @foreach($examTypesForName as $examTypeId => $examTypeGroup)
                @php
                $examType = collect($examTypeGroup)->first()->examType ?? null;
                $partsCount = count($examTypeGroup);
                @endphp
                <th class="border border-gray-300 px-2 py-2 text-center text-xs font-medium text-gray-700"
                    colspan="{{ $partsCount }}">
                    {{ $examType->name ?? 'Unknown' }}
                </th>
                @endforeach
                @endforeach
            </tr>

            {{-- Exam Parts Row with ExamMode --}}
            <tr class="bg-blue-25">
                <th class="border border-gray-300 px-4 py-1 text-left text-xs font-medium text-gray-600">
                    Parts (Mode)
                </th>
                @foreach($examNames as $examName)
                @php
                $examDetailsForName = collect($examDetails)->where('exam_name_id', $examName->id ?? 0);
                $examTypesForName = $examDetailsForName->groupBy('exam_type_id');
                @endphp
                @foreach($examTypesForName as $examTypeId => $examTypeGroup)
                @foreach($examTypeGroup as $examDetail)
                <th class="border border-gray-300 px-1 py-1 text-center text-xs font-medium text-gray-600">
                    @if($examDetail->examPart && $examDetail->examMode)
                    {{ $examDetail->examPart->name }}<br><span class="text-xs text-gray-500">({{
                        $examDetail->examMode->name }})</span>
                    @else
                    {{ $examDetail->examPart ? $examDetail->examPart->name : 'N/A' }}
                    @endif
                </th>
                @endforeach
                @endforeach
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($subjectTypes as $subjectType)
            @php
            $subjectsOfType = $this->getSubjectsByType($subjectType->id);
            @endphp
            @if($subjectsOfType->count() > 0)
            {{-- Subject Type Header --}}
            <tr class="bg-gray-100">
                @php
                $totalCols = 1; // Start with 1 for the subject name column
                foreach($examNames as $examName) {
                $examDetailsForName = collect($examDetails)->where('exam_name_id', $examName->id ?? 0);
                $examTypesForName = $examDetailsForName->groupBy('exam_type_id');
                foreach($examTypesForName as $examTypeGroup) {
                $totalCols += count($examTypeGroup);
                }
                }
                @endphp
                <td class="border border-gray-300 px-4 py-2 font-semibold text-gray-800" colspan="{{ $totalCols }}">
                    {{ $subjectType->name }}
                </td>
            </tr>

            {{-- Subjects Rows --}}
            @foreach($subjectsOfType as $myclassSubject)
            @livewire('exam-setting.subject-row', [
            'subject' => $myclassSubject,
            'examDetails' => $examDetails,
            'subjectType' => $subjectType,
            'classId' => $selectedClassId,
            'selectedSubjects' => $selectedSubjects,
            'savedData' => $savedData,
            'isFinalized' => $isFinalized
            ], key($myclassSubject->id . '_' . $subjectType->id))
            @endforeach
            @endif
            @endforeach
        </tbody>
    </table>
</div>
@elseif($selectedClassId)
<div class="text-center py-8">
    <div class="text-gray-500">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">No Exam Details Found</h3>
        <p class="mt-1 text-sm text-gray-500">
            No exam details are configured for the selected class. Please configure exam details first.
        </p>
    </div>
</div>
@else
<div class="text-center py-8">
    <div class="text-gray-500">
        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
        </svg>
        <h3 class="mt-2 text-sm font-medium text-gray-900">Select a Class</h3>
        <p class="mt-1 text-sm text-gray-500">
            Please select a class to view the exam configuration matrix.
        </p>
    </div>
</div>
@endif