<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Exam Marks Register</title>
    <style>
        body { font-family: sans-serif; font-size: 10px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 4px; text-align: center; }
        th { background-color: #f0f0f0; }
        .text-left { text-align: left; }
        .bg-gray-100 { background-color: #f3f4f6; }
        .bg-blue-100 { background-color: #dbeafe; }
        .bg-yellow-100 { background-color: #fef9c3; }
        .font-bold { font-weight: bold; }
        .text-red { color: red; }
        .text-gray-400 { color: #9ca3af; }
        .text-xs { font-size: 10px; }
    </style>
</head>
<body>
    <h1>Exam Marks Register</h1>
    @if($activeClass)
        <h2>Class: {{ $activeClass->name }}</h2>
        
        @foreach($sections as $section)
            @php
                $sectionStudents = $students->where('section_id', $section->section_id);
                if ($sectionStudents->isEmpty()) continue;
                
                $totalExamRows = 0;
                foreach($examDetailsGrouped as $examNameId => $examParts) {
                    $totalExamRows += count($examParts);
                }
            @endphp
            
            <div style="margin-bottom: 20px;">
                <div style="background-color: #eee; padding: 5px; font-weight: bold; border: 1px solid #ccc; border-bottom: none;">
                    Section: {{ $section->section->name ?? 'N/A' }}
                </div>
                
                <table>
                    <thead>
                        @php
                            $summativeSubjects = $classSubjects->filter(function($ms){ return strtolower($ms->subject->subjectType->name ?? '') === 'summative'; });
                            $formativeSubjects = $classSubjects->filter(function($ms){ return strtolower($ms->subject->subjectType->name ?? '') === 'formative'; });
                        @endphp
                        <tr>
                            <th class="text-left" style="width: 120px;">Student</th>
                            <th class="text-left" style="width: 80px;">Exam</th>
                            <th class="text-left" style="width: 60px;">Part</th>
                            <th colspan="{{ $summativeSubjects->count() + 1 }}">Summative</th>
                            <th colspan="{{ $formativeSubjects->count() + 1 }}">Formative</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th class="bg-blue-100">
                                <div>Summ Detail</div>
                                <div style="font-weight: normal; font-size: 8px;">ID</div>
                            </th>
                            @foreach($summativeSubjects as $ms)
                                <th>
                                    <div>{{ $ms->subject->name ?? 'Sub' }}</div>
                                    {{-- <div style="font-weight: normal; font-size: 8px;">Summ</div> --}}
                                </th>
                            @endforeach
                            <th class="bg-yellow-100">
                                <div>Form Detail</div>
                                <div style="font-weight: normal; font-size: 8px;">ID</div>
                            </th>
                            @foreach($formativeSubjects as $ms)
                                <th>
                                    <div>{{ $ms->subject->name ?? 'Sub' }}</div>
                                    {{-- <div style="font-weight: normal; font-size: 8px;">Form</div> --}}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
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
                                    @endphp
                                    <tr>
                                        <!-- Student Column -->
                                        @if($isFirstStudentRow)
                                            <td rowspan="{{ $totalExamRows }}" class="text-left" style="vertical-align: top;">
                                                <div class="font-bold">{{ $student->studentdb->name ?? 'N/A' }}</div>
                                                <div>Roll: {{ $student->roll_no }}</div>
                                            </td>
                                            @php $isFirstStudentRow = false; @endphp
                                        @endif
                                        
                                        <!-- Exam Name Column -->
                                        @if($isFirstExamRow)
                                            <td rowspan="{{ $examRowCount }}" class="text-left" style="vertical-align: top; background-color: #f9f9f9;">
                                                {{ $examName }}
                                            </td>
                                            @php $isFirstExamRow = false; @endphp
                                        @endif
                                        
                                        <!-- Exam Part Column -->
                                        <td class="bg-gray-100">
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
                                        <td class="bg-blue-100">
                                            <div>{{ $summDetail->id ?? '-' }}</div>
                                            <div class="text-xs">{{ $summMarksSum !== null ? $summMarksSum : '-' }}</div>
                                        </td>
                                        
                                        <!-- Summative Marks -->
                                        @foreach($summativeSubjects as $ms)
                                            @php
                                                $subjectId = $ms->subject_id;
                                                $expectedTypeId = 1;
                                                $selectedDetail = collect($details)->first(function($d) use ($expectedTypeId, $subjectId, $examClassSubjectMap){
                                                    return ($d->exam_type_id ?? null) === $expectedTypeId
                                                        && isset($examClassSubjectMap[$d->id][$subjectId]);
                                                });
                                                $mapping = $selectedDetail ? ($examClassSubjectMap[$selectedDetail->id][$subjectId] ?? null) : null;
                                                $key = $mapping ? ($student->id . '_' . $mapping['id']) : null;
                                                $markEntry = $key ? ($marksData[$key] ?? null) : null;
                                                $bgColor = $mapping ? '' : 'background-color: #f3f4f6;';
                                            @endphp
                                            
                                            <td style="{{ $bgColor }}">
                                                @if($mapping)
                                                    @if(isset($markEntry['is_absent']) && $markEntry['is_absent'])
                                                        <span class="text-red font-bold">AB</span>
                                                    @elseif(isset($markEntry['exam_marks']) && $markEntry['exam_marks'] !== null)
                                                        <span class="font-bold">{{ $markEntry['exam_marks'] }}</span>
                                                    @else
                                                        -
                                                    @endif
                                                    {{-- <div class="text-gray-400" style="font-size: 8px;">ECS: {{ $mapping['id'] }}</div> --}}
                                                @else
                                                    <span class="text-gray-400" style="font-size: 8px;">N/A</span>
                                                @endif
                                            </td>
                                        @endforeach
                                        
                                        
                                        @php
                                            $formDetail = collect($details)->first(function($d){ return ($d->exam_type_id ?? null) === 2; });
                                        @endphp
                                        <td class="bg-yellow-100">
                                            {{ $formDetail->id ?? '-' }}
                                        </td>
                                        
                                        <!-- Formative Marks -->
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
                                                $bgColor = $mapping ? '' : 'background-color: #f3f4f6;';
                                            @endphp
                                            
                                            <td style="{{ $bgColor }}">
                                                @if($mapping)
                                                    @if(isset($markEntry['is_absent']) && $markEntry['is_absent'])
                                                        <span class="text-red font-bold">AB</span>
                                                    @elseif(isset($markEntry['exam_marks']) && $markEntry['exam_marks'] !== null)
                                                        <span class="font-bold">{{ $markEntry['exam_marks'] }}</span>
                                                    @else
                                                        -
                                                    @endif
                                                    <div class="text-gray-400" style="font-size: 8px;">ECS: {{ $mapping['id'] }}</div>
                                                @else
                                                    <span class="text-gray-400" style="font-size: 8px;">N/A</span>
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
        @endforeach
    @else
        <p>No active class selected.</p>
    @endif
</body>
</html>
