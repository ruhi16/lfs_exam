<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Student Mark Sheet</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 11px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: center;
        }

        th {
            background-color: #f0f0f0;
        }

        .text-left {
            text-align: left;
        }

        .muted {
            color: #6b7280;
            font-size: 10px;
        }

        .header {
            margin-bottom: 10px;
        }

        .section-title {
            background-color: #e5e7eb;
            padding: 6px;
            font-weight: bold;
            border: 1px solid #ccc;
            border-bottom: none;
        }

        .title-container {
            text-align: center;
            height: 100px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        h1 {
            font-size: 26px;
            height: 20px;
            margin: 0;
        }

        h2 {
            font-size: 14px;
            height: 18px;
            margin: 0;
        }

        h3 {
            font-size: 12px;
            height: 16px;
            margin: 0;
        }

        .student-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 16px;
            min-height: 90px;
        }

        .student-left-part {
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9fafb;
        }

        .student-right-part {
            padding: 10px;
            border: 1px solid #ccc;
            background-color: #f9fafb;
        }
    </style>
</head>

<body>
    <div class="header title-container">
        <h1>{{ $school->name }}</h1>
        <h3>{{ $school->vill }},{{ $school->po }},{{ $school->dist }}</h3>
        <h2>Student Mark Sheet - {{ $school->activeSession->first()->name ?? 'Exam' }}</h2>
    </div>

    <div class="student-container">
        <table>
            <tbody>
                <tr>
                    <td style="text-align: left; font-size: 16px;">
                        @if($student)
                            <div><strong>Name:</strong> {{ $student->studentdb->name ?? 'N/A' }} </div>
                            <div><strong>Class:</strong> {{ $student->myClass->name ?? 'N/A' }} |
                                <strong>Section:</strong> {{ optional($student->section)->name ?? 'N/A' }} |
                                <strong>Roll:</strong> {{ $student->roll_no ?? 'N/A' }}
                            </div>
                        @endif
                    </td>
                    <td style="text-align: left;">Picture
                        {{-- @if($student && $student->studentdb && $student->studentdb->img_ref_profile)
                        <img class="profile-box" src="{{ asset('storage/' . $student->studentdb->img_ref_profile) }}"
                            alt="Profile" style="width: 40px; height: 40px;object-fit: cover;">
                        @else
                        <div class="profile-box no-image">{{ asset('storage/' . $student->studentdb->img_ref_profile) ??
                            'N/A' }}</div>
                        @endif --}}
                    </td>

                </tr>
                </thead>
        </table>
    </div>
    @php
        // Count total columns for exam parts across all exam names
        $totalExamCols = 0;
        foreach ($examDetailsGrouped as $examNameId => $examParts) {
            foreach ($examParts as $examPartId => $details) {
                $totalExamCols += 1; // one column per part block (taking first detail)
            }
        }
    @endphp
    
    @php
        // Helper functions for calculating subject marks
        function calculateSubjectTotalMarks($subjectId, $exams, $examClassSubjectMap, $marksData, $examType, $studentId) {
            $totalMarks = 0;
            foreach($exams as $examNameId => $examParts) {
                foreach($examParts as $examPartId => $details) {
                    $selectedDetail = collect($details)->first(function($d) use ($examType) {
                        return optional($d->examType)->name === $examType;
                    }) ?? collect($details)->first();
                        
                    if ($selectedDetail) {
                        $mapping = $examClassSubjectMap[$selectedDetail->id][$subjectId] ?? null;
                        if ($mapping) {
                            $key = $studentId . '_' . $selectedDetail->id . '_' . $mapping['id'];
                            $entry = $marksData[$key] ?? null;
                            if ($entry && !$entry['is_absent'] && isset($entry['exam_marks']) && $entry['exam_marks'] !== null) {
                                $totalMarks += intval(round($entry['exam_marks']));
                            }
                        }
                    }
                }
            }
            return $totalMarks;
        }
            
        function calculateSubjectFullMarks($subjectId, $exams, $examClassSubjectMap, $examType) {
            $totalFull = 0;
            foreach($exams as $examNameId => $examParts) {
                foreach($examParts as $examPartId => $details) {
                    $selectedDetail = collect($details)->first(function($d) use ($examType) {
                        return optional($d->examType)->name === $examType;
                    }) ?? collect($details)->first();
                        
                    if ($selectedDetail) {
                        $mapping = $examClassSubjectMap[$selectedDetail->id][$subjectId] ?? null;
                        if ($mapping) {
                            $totalFull += intval($mapping['full_marks'] ?? 0);
                        }
                    }
                }
            }
            return $totalFull;
        }
    @endphp
    
    @php
        $summativeSubjects = collect($classSubjects)->filter(function($ms){
            return (optional($ms->subject)->subject_type_id ?? null) === 2;
        });
        $formativeSubjects = collect($classSubjects)->filter(function ($ms) {
            return (optional($ms->subject)->subject_type_id ?? null) === 1;
        });
    @endphp

    @php
        // Separate exams into first half (First Term, Half Yearly) and second half (2nd Term, Annual)
        $firstHalfExams = [];
        $secondHalfExams = [];
        foreach ($examDetailsGrouped as $examNameId => $examParts) {
            $examName = \App\Models\Exam01Name::find($examNameId);
            $name = strtolower($examName->name ?? '');
            if (str_contains($name, 'first') || str_contains($name, 'half') || str_contains($name, '1st')) {
                $firstHalfExams[$examNameId] = $examParts;
            } else if (str_contains($name, '2nd') || str_contains($name, 'second') || str_contains($name, 'annual')) {
                $secondHalfExams[$examNameId] = $examParts;
            }
        }

        // Count columns for each half
        $firstHalfCols = 0;
        foreach ($firstHalfExams as $examParts) {
            $firstHalfCols += count($examParts);
        }
        $secondHalfCols = 0;
        foreach ($secondHalfExams as $examParts) {
            $secondHalfCols += count($examParts);
        }
    @endphp

    <table class="no-break bg-white">
        <tr>
            <td>
                @if($summativeSubjects->count() && count($firstHalfExams) > 0)
                    <div class="section-title">Summative Subjects - First Term & Half Yearly</div>
                    <table class="no-break">
                        <thead>
                            <tr>
                                <th class="text-left">Subject</th>
                                @foreach($firstHalfExams as $examNameId => $examParts)
                                    @php
                                        $examName = \App\Models\Exam01Name::find($examNameId);
                                        $colspan = count($examParts);
                                    @endphp
                                    <th colspan="{{ $colspan }}">{{ $examName->name ?? 'Exam' }}</th>
                                @endforeach
                                <th>Total Marks</th>
                                <th>Grade</th>
                                <th>Highest in Class</th>
                            </tr>
                            <tr>
                                <th class="text-left">-</th>
                                @foreach($firstHalfExams as $examNameId => $examParts)
                                    @foreach($examParts as $examPartId => $details)
                                        @php
                                            $examPart = \App\Models\Exam03Part::find($examPartId);
                                        @endphp
                                        <th>
                                            <div class="muted">
                                                {{ $examPart->name ?? 'Part' }}                                                
                                            </div>
                                        </th>
                                    @endforeach
                                @endforeach
                                <th>-</th>
                                <th>-</th>
                                <th>-</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $firstHalfTotalMarks = 0;
                            $firstHalfTotalFull = 0; @endphp
                            @foreach($summativeSubjects as $ms)
                                @php
                                    $subjectFirstHalfMarks = 0;
                                    $subjectFirstHalfFull = 0;
                                @endphp
                                <tr>
                                    <td class="text-left">
                                        <div>{{ optional($ms->subject)->name ?? 'Subject' }}</div>
                                    </td>
                                    @foreach($firstHalfExams as $examNameId => $examParts)
                                        @foreach($examParts as $examPartId => $details)
                                            @php
                                                $selectedDetail = collect($details)->first(function ($d) {
                                                    return optional($d->examType)->name === 'Summative';
                                                }) ?? collect($details)->first();
                                                $mapping = $selectedDetail ? ($examClassSubjectMap[$selectedDetail->id][$ms->subject_id] ?? null) : null;
                                                $key = ($mapping && $selectedDetail) ? ($student->id . '_' . $selectedDetail->id . '_' . $mapping['id']) : null;
                                                $entry = $key ? ($marksData[$key] ?? null) : null;
                                            @endphp
                                            <td>
                                                @if($mapping)
                                                    @if(isset($entry['is_absent']) && $entry['is_absent'])
                                                        <span style="color: red; font-weight: bold;">AB</span>
                                                    @elseif(isset($entry['exam_marks']) && $entry['exam_marks'] !== null)
                                                        @php
                                                            $rounded = intval(round($entry['exam_marks']));
                                                            $fm = intval($mapping['full_marks'] ?? 0);
                                                            $subjectFirstHalfMarks += $rounded;
                                                            $subjectFirstHalfFull += $fm;
                                                        @endphp
                                                        <span style="font-weight: bold;">{{ $rounded }}</span>
                                                    @else
                                                        -
                                                    @endif
                                                @else
                                                    <span class="muted">N/A</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    @endforeach
                                    @php
                                        $subjectGrade = '';
                                        if ($subjectFirstHalfFull > 0) {
                                            $subjectGrade = \App\Models\Exam08Grade::calculateGrade($subjectFirstHalfMarks, 'summative', $ms->subject_id, $subjectFirstHalfFull);
                                        }
                                    @endphp
                                    @php $firstHalfTotalMarks += $subjectFirstHalfMarks;
                                    $firstHalfTotalFull += $subjectFirstHalfFull; @endphp
                                    <td>{{ $subjectFirstHalfMarks }} / {{ $subjectFirstHalfFull }}</td>
                                    <td>{{ $subjectGrade }}</td>
                                    <td>{{ round($highestFirstTermMarksBySubject[$ms->subject_id], 0) ?? '-' }}
                                        ({{ $highestFirstTermRollNosBySubject[$ms->subject_id] ?? 'N/A' }})</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="text-left"><strong>Grand Total</strong></td>
                                @for($i = 0; $i < $firstHalfCols; $i++)
                                    <td>-</td>
                                @endfor
                                <td><strong>{{ $firstHalfTotalMarks }} / {{ $firstHalfTotalFull }}</strong></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                @endif
            </td>
            <td>
                @if($formativeSubjects->count())
                    <div class="section-title">Formative Subjects - Consolidated (All Terms)</div>
                    <table class="no-break">
                        <thead>
                            <tr>
                                <th class="text-left">Subject</th>
                                @foreach($examDetailsGrouped as $examNameId => $examParts)
                                    @php
                                        $examName = \App\Models\Exam01Name::find($examNameId);
                                        $partsForCol = collect($examParts)->filter(function ($details) {
                                            return collect($details)->contains(function ($d) {
                                                return optional($d->examType)->name === 'Formative';
                                            });
                                        });
                                        $colspan = $partsForCol->count();
                                    @endphp
                                    @if($colspan > 0)
                                        <th colspan="{{ $colspan }}">{{ $examName->name ?? 'Exam' }}</th>
                                    @endif
                                @endforeach
                            </tr>
                            <tr>
                                <th class="text-left">-</th>
                                @foreach($examDetailsGrouped as $examNameId => $examParts)
                                    @php
                                        $partsForCol = collect($examParts)->filter(function ($details) {
                                            return collect($details)->contains(function ($d) {
                                                return optional($d->examType)->name === 'Formative';
                                            });
                                        });
                                    @endphp
                                    @foreach($partsForCol as $examPartId => $details)
                                        @php
                                            $examPart = \App\Models\Exam03Part::find($examPartId);
                                        @endphp
                                        <th>
                                            <div class="muted">{{ $examPart->name ?? 'Part' }}</div>
                                        </th>
                                    @endforeach
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @php $formGrandMarks = 0;
                            $formGrandFull = 0; @endphp
                            @foreach($formativeSubjects as $ms)
                                <tr>
                                    <td class="text-left">
                                        <div>{{ optional($ms->subject)->name ?? 'Subject' }}</div>
                                    </td>
                                    @foreach($examDetailsGrouped as $examNameId => $examParts)
                                        @php
                                            $partsForCol = collect($examParts)->filter(function ($details) {
                                                return collect($details)->contains(function ($d) {
                                                    return optional($d->examType)->name === 'Formative';
                                                });
                                            });
                                        @endphp
                                        @foreach($partsForCol as $examPartId => $details)
                                            @php
                                                $selectedDetail = collect($details)->first(function ($d) {
                                                    return optional($d->examType)->name === 'Formative';
                                                }) ?? collect($details)->first();
                                                $mapping = $selectedDetail ? ($examClassSubjectMap[$selectedDetail->id][$ms->subject_id] ?? null) : null;
                                                $key = ($mapping && $selectedDetail) ? ($student->id . '_' . $selectedDetail->id . '_' . $mapping['id']) : null;
                                                $entry = $key ? ($marksData[$key] ?? null) : null;
                                            @endphp
                                            <td>
                                                @if($mapping)
                                                    @if(isset($entry['is_absent']) && $entry['is_absent'])
                                                        <span style="color: red; font-weight: bold;">AB</span>
                                                    @elseif(isset($entry['exam_marks']) && $entry['exam_marks'] !== null)
                                                        @php
                                                            $roundedF = intval(round($entry['exam_marks']));
                                                            $fmF = intval($mapping['full_marks'] ?? 0);
                                                            $formGrandMarks += $roundedF;
                                                            $formGrandFull += $fmF;
                                                            $gradeF = $fmF > 0 ? \App\Models\Exam08Grade::calculateGrade($roundedF, 'formative', $ms->subject_id, $fmF) : '';
                                                        @endphp
                                                        <span style="font-weight: bold;"></span>@if($gradeF) <span>{{ $gradeF }}</span>@endif
                                                    @else
                                                        -
                                                    @endif
                                                @else
                                                    <span class="muted">N/A</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </td>
            <td>
                @if($summativeSubjects->count() && count($secondHalfExams) > 0)
                    <div class="section-title">Summative Subjects - 2nd Term & Annual</div>
                    <table class="no-break">
                        <thead>
                            <tr>
                                <th class="text-left">Subject</th>
                                @foreach($secondHalfExams as $examNameId => $examParts)
                                    @php
                                        $examName = \App\Models\Exam01Name::find($examNameId);
                                        $colspan = count($examParts);
                                    @endphp
                                    <th colspan="{{ $colspan }}">{{ $examName->name ?? 'Exam' }}</th>
                                @endforeach
                                <th>Total Marks</th>
                                <th>Grade</th>
                                <th>Highest in Class</th>
                            </tr>
                            <tr>
                                <th class="text-left">-</th>
                                @foreach($secondHalfExams as $examNameId => $examParts)
                                    @foreach($examParts as $examPartId => $details)
                                        @php
                                            $examPart = \App\Models\Exam03Part::find($examPartId);
                                        @endphp
                                        <th>
                                            <div class="muted">{{ $examPart->name ?? 'Part' }}</div>
                                        </th>
                                    @endforeach
                                @endforeach
                                <th>-</th>
                                <th>-</th>
                                <th>-</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $secondHalfTotalMarks = 0;
                            $secondHalfTotalFull = 0; @endphp
                            @foreach($summativeSubjects as $ms)
                                @php
                                    $subjectSecondHalfMarks = 0;
                                    $subjectSecondHalfFull = 0;
                                @endphp
                                <tr>
                                    <td class="text-left">
                                        <div>{{ optional($ms->subject)->name ?? 'Subject' }}</div>
                                    </td>
                                    @foreach($secondHalfExams as $examNameId => $examParts)
                                        @foreach($examParts as $examPartId => $details)
                                            @php
                                                $selectedDetail = collect($details)->first(function ($d) {
                                                    return optional($d->examType)->name === 'Summative';
                                                }) ?? collect($details)->first();
                                                $mapping = $selectedDetail ? ($examClassSubjectMap[$selectedDetail->id][$ms->subject_id] ?? null) : null;
                                                $key = ($mapping && $selectedDetail) ? ($student->id . '_' . $selectedDetail->id . '_' . $mapping['id']) : null;
                                                $entry = $key ? ($marksData[$key] ?? null) : null;
                                            @endphp
                                            <td>
                                                @if($mapping)
                                                    @if(isset($entry['is_absent']) && $entry['is_absent'])
                                                        <span style="color: red; font-weight: bold;">AB</span>
                                                    @elseif(isset($entry['exam_marks']) && $entry['exam_marks'] !== null)
                                                        @php
                                                            $rounded = intval(round($entry['exam_marks']));
                                                            $fm = intval($mapping['full_marks'] ?? 0);
                                                            $subjectSecondHalfMarks += $rounded;
                                                            $subjectSecondHalfFull += $fm;
                                                        @endphp
                                                        <span style="font-weight: bold;">{{ $rounded }}</span>
                                                    @else
                                                        -
                                                    @endif
                                                @else
                                                    <span class="muted">N/A</span>
                                                @endif
                                            </td>
                                        @endforeach
                                    @endforeach
                                    @php
                                        $subjectGrade = '';
                                        if ($subjectSecondHalfFull > 0) {
                                            $subjectGrade = \App\Models\Exam08Grade::calculateGrade($subjectSecondHalfMarks, 'summative', $ms->subject_id, $subjectSecondHalfFull);
                                        }
                                    @endphp
                                    @php $secondHalfTotalMarks += $subjectSecondHalfMarks;
                                    $secondHalfTotalFull += $subjectSecondHalfFull; @endphp
                                    <td>{{ $subjectSecondHalfMarks }} / {{ $subjectSecondHalfFull }}</td>
                                    <td>{{ $subjectGrade }}</td>
                                    <td>{{ round($highestSecondTermMarksBySubject[$ms->subject_id], 0) ?? '-' }}
                                        ({{ $highestSecondTermRollNosBySubject[$ms->subject_id] ?? 'N/A' }})</td>
                                </tr>
                            @endforeach
                            <tr>
                                <td class="text-left"><strong>Grand Total</strong></td>
                                @for($i = 0; $i < $secondHalfCols; $i++)
                                    <td>-</td>
                                @endfor
                                <td><strong>{{ $secondHalfTotalMarks }} / {{ $secondHalfTotalFull }}</strong></td>
                                <td></td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                @endif
            </td>
        </tr>
    </table>

    {{--
    @if($summativeSubjects->count() && count($firstHalfExams) > 0)
    <div class="section-title">Summative Subjects - First Term & Half Yearly</div>
    <table class="no-break">
        <thead>
            <tr>
                <th class="text-left">Subject</th>
                @foreach($firstHalfExams as $examNameId => $examParts)
                @php
                $examName = \App\Models\Exam01Name::find($examNameId);
                $colspan = count($examParts);
                @endphp
                <th colspan="{{ $colspan }}">{{ $examName->name ?? 'Exam' }}</th>
                @endforeach
                <th>Total Marks</th>
                <th>Grade</th>
            </tr>
            <tr>
                <th class="text-left">-</th>
                @foreach($firstHalfExams as $examNameId => $examParts)
                @foreach($examParts as $examPartId => $details)
                @php
                $examPart = \App\Models\Exam03Part::find($examPartId);
                @endphp
                <th>
                    <div class="muted">{{ $examPart->name ?? 'Part' }}</div>
                </th>
                @endforeach
                @endforeach
                <th>-</th>
                <th>-</th>
            </tr>
        </thead>
        <tbody>
            @php $firstHalfTotalMarks = 0; $firstHalfTotalFull = 0; @endphp
            @foreach($summativeSubjects as $ms)
            @php
            $subjectFirstHalfMarks = 0;
            $subjectFirstHalfFull = 0;
            @endphp
            <tr>
                <td class="text-left">
                    <div>{{ optional($ms->subject)->name ?? 'Subject' }}</div>
                </td>
                @foreach($firstHalfExams as $examNameId => $examParts)
                @foreach($examParts as $examPartId => $details)
                @php
                $selectedDetail = collect($details)->first(function($d){
                return optional($d->examType)->name === 'Summative';
                }) ?? collect($details)->first();
                $mapping = $selectedDetail ? ($examClassSubjectMap[$selectedDetail->id][$ms->subject_id] ?? null) :
                null;
                $key = ($mapping && $selectedDetail) ? ($student->id . '_' . $selectedDetail->id . '_' . $mapping['id']) : null;
                $entry = $key ? ($marksData[$key] ?? null) : null;
                @endphp
                <td>
                    @if($mapping)
                    @if(isset($entry['is_absent']) && $entry['is_absent'])
                    <span style="color: red; font-weight: bold;">AB</span>
                    @elseif(isset($entry['exam_marks']) && $entry['exam_marks'] !== null)
                    @php
                    $rounded = intval(round($entry['exam_marks']));
                    $fm = intval($mapping['full_marks'] ?? 0);
                    $subjectFirstHalfMarks += $rounded;
                    $subjectFirstHalfFull += $fm;
                    @endphp
                    <span style="font-weight: bold;">{{ $rounded }}</span>
                    @else
                    -
                    @endif
                    @else
                    <span class="muted">N/A</span>
                    @endif
                </td>
                @endforeach
                @endforeach
                @php
                $subjectGrade = '';
                if($subjectFirstHalfFull > 0){
                $subjectGrade = \App\Models\Exam08Grade::calculateGrade($subjectFirstHalfMarks, 'summative',
                $ms->subject_id, $subjectFirstHalfFull);
                }
                @endphp
                @php $firstHalfTotalMarks += $subjectFirstHalfMarks; $firstHalfTotalFull += $subjectFirstHalfFull;
                @endphp
                <td>{{ $subjectFirstHalfMarks }} / {{ $subjectFirstHalfFull }}</td>
                <td>{{ $subjectGrade }}</td>
            </tr>
            @endforeach
            <tr>
                <td class="text-left"><strong>Grand Total</strong></td>
                @for($i=0; $i < $firstHalfCols; $i++) <td>-</td>
                    @endfor
                    <td><strong>{{ $firstHalfTotalMarks }} / {{ $firstHalfTotalFull }}</strong></td>
                    <td></td>
            </tr>
        </tbody>
    </table>
    @endif

    @if($formativeSubjects->count())
    <div class="section-title">Formative Subjects - Consolidated (All Terms)</div>
    <table class="no-break">
        <thead>
            <tr>
                <th class="text-left">Subject</th>
                @foreach($examDetailsGrouped as $examNameId => $examParts)
                @php
                $examName = \App\Models\Exam01Name::find($examNameId);
                $partsForCol = collect($examParts)->filter(function($details){
                return collect($details)->contains(function($d){
                return optional($d->examType)->name === 'Formative';
                });
                });
                $colspan = $partsForCol->count();
                @endphp
                @if($colspan > 0)
                <th colspan="{{ $colspan }}">{{ $examName->name ?? 'Exam' }}</th>
                @endif
                @endforeach
            </tr>
            <tr>
                <th class="text-left">-</th>
                @foreach($examDetailsGrouped as $examNameId => $examParts)
                @php
                $partsForCol = collect($examParts)->filter(function($details){
                return collect($details)->contains(function($d){
                return optional($d->examType)->name === 'Formative';
                });
                });
                @endphp
                @foreach($partsForCol as $examPartId => $details)
                @php
                $examPart = \App\Models\Exam03Part::find($examPartId);
                @endphp
                <th>
                    <div class="muted">{{ $examPart->name ?? 'Part' }}</div>
                </th>
                @endforeach
                @endforeach
            </tr>
        </thead>
        <tbody>
            @php $formGrandMarks = 0; $formGrandFull = 0; @endphp
            @foreach($formativeSubjects as $ms)
            <tr>
                <td class="text-left">
                    <div>{{ optional($ms->subject)->name ?? 'Subject' }}</div>
                </td>
                @foreach($examDetailsGrouped as $examNameId => $examParts)
                @php
                $partsForCol = collect($examParts)->filter(function($details){
                return collect($details)->contains(function($d){
                return optional($d->examType)->name === 'Formative';
                });
                });
                @endphp
                @foreach($partsForCol as $examPartId => $details)
                @php
                $selectedDetail = collect($details)->first(function($d){
                return optional($d->examType)->name === 'Formative';
                }) ?? collect($details)->first();
                $mapping = $selectedDetail ? ($examClassSubjectMap[$selectedDetail->id][$ms->subject_id] ?? null) :
                null;
                $key = ($mapping && $selectedDetail) ? ($student->id . '_' . $selectedDetail->id . '_' . $mapping['id']) : null;
                $entry = $key ? ($marksData[$key] ?? null) : null;
                @endphp
                <td>
                    @if($mapping)
                    @if(isset($entry['is_absent']) && $entry['is_absent'])
                    <span style="color: red; font-weight: bold;">AB</span>
                    @elseif(isset($entry['exam_marks']) && $entry['exam_marks'] !== null)
                    @php
                    $roundedF = intval(round($entry['exam_marks']));
                    $fmF = intval($mapping['full_marks'] ?? 0);
                    $formGrandMarks += $roundedF;
                    $formGrandFull += $fmF;
                    $gradeF = $fmF > 0 ? \App\Models\Exam08Grade::calculateGrade($roundedF, 'formative',
                    $ms->subject_id, $fmF) : '';
                    @endphp
                    <span style="font-weight: bold;">{{ $roundedF }}</span>@if($gradeF) <span class="muted">({{ $gradeF
                        }})</span>@endif
                    @else
                    -
                    @endif
                    @else
                    <span class="muted">N/A</span>
                    @endif
                </td>
                @endforeach
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif

    @if($summativeSubjects->count() && count($secondHalfExams) > 0)
    <div class="section-title">Summative Subjects - 2nd Term & Annual</div>
    <table class="no-break">
        <thead>
            <tr>
                <th class="text-left">Subject</th>
                @foreach($secondHalfExams as $examNameId => $examParts)
                @php
                $examName = \App\Models\Exam01Name::find($examNameId);
                $colspan = count($examParts);
                @endphp
                <th colspan="{{ $colspan }}">{{ $examName->name ?? 'Exam' }}</th>
                @endforeach
                <th>Total Marks</th>
                <th>Grade</th>
            </tr>
            <tr>
                <th class="text-left">-</th>
                @foreach($secondHalfExams as $examNameId => $examParts)
                @foreach($examParts as $examPartId => $details)
                @php
                $examPart = \App\Models\Exam03Part::find($examPartId);
                @endphp
                <th>
                    <div class="muted">{{ $examPart->name ?? 'Part' }}</div>
                </th>
                @endforeach
                @endforeach
                <th>-</th>
                <th>-</th>
            </tr>
        </thead>
        <tbody>
            @php $secondHalfTotalMarks = 0; $secondHalfTotalFull = 0; @endphp
            @foreach($summativeSubjects as $ms)
            @php
            $subjectSecondHalfMarks = 0;
            $subjectSecondHalfFull = 0;
            @endphp
            <tr>
                <td class="text-left">
                    <div>{{ optional($ms->subject)->name ?? 'Subject' }}</div>
                </td>
                @foreach($secondHalfExams as $examNameId => $examParts)
                @foreach($examParts as $examPartId => $details)
                @php
                $selectedDetail = collect($details)->first(function($d){
                return optional($d->examType)->name === 'Summative';
                }) ?? collect($details)->first();
                $mapping = $selectedDetail ? ($examClassSubjectMap[$selectedDetail->id][$ms->subject_id] ?? null) :
                null;
                $key = ($mapping && $selectedDetail) ? ($student->id . '_' . $selectedDetail->id . '_' . $mapping['id']) : null;
                $entry = $key ? ($marksData[$key] ?? null) : null;
                @endphp
                <td>
                    @if($mapping)
                    @if(isset($entry['is_absent']) && $entry['is_absent'])
                    <span style="color: red; font-weight: bold;">AB</span>
                    @elseif(isset($entry['exam_marks']) && $entry['exam_marks'] !== null)
                    @php
                    $rounded = intval(round($entry['exam_marks']));
                    $fm = intval($mapping['full_marks'] ?? 0);
                    $subjectSecondHalfMarks += $rounded;
                    $subjectSecondHalfFull += $fm;
                    @endphp
                    <span style="font-weight: bold;">{{ $rounded }}</span>
                    @else
                    -
                    @endif
                    @else
                    <span class="muted">N/A</span>
                    @endif
                </td>
                @endforeach
                @endforeach
                @php
                $subjectGrade = '';
                if($subjectSecondHalfFull > 0){
                $subjectGrade = \App\Models\Exam08Grade::calculateGrade($subjectSecondHalfMarks, 'summative',
                $ms->subject_id, $subjectSecondHalfFull);
                }
                @endphp
                @php $secondHalfTotalMarks += $subjectSecondHalfMarks; $secondHalfTotalFull += $subjectSecondHalfFull;
                @endphp
                <td>{{ $subjectSecondHalfMarks }} / {{ $subjectSecondHalfFull }}</td>
                <td>{{ $subjectGrade }}</td>
            </tr>
            @endforeach
            <tr>
                <td class="text-left"><strong>Grand Total</strong></td>
                @for($i=0; $i < $secondHalfCols; $i++) <td>-</td>
                    @endfor
                    <td><strong>{{ $secondHalfTotalMarks }} / {{ $secondHalfTotalFull }}</strong></td>
                    <td></td>
            </tr>
        </tbody>
    </table>
    @endif
    --}}


    <table style="width: 100%; margin-top: 6px;">
        <tr>
            {{-- <td style="width: 33.33%; vertical-align: top;">
                <div class="section-title">Summative Result</div>
                <table>
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Marks</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $firstHalfPerc = ($firstHalfTotalFull ?? 0) > 0 ? round((($firstHalfTotalMarks ?? 0) /
                        ($firstHalfTotalFull ?? 0)) * 100, 2) : 0;
                        @endphp
                        <tr>
                            <td>First Half</td>
                            <td>{{ $firstHalfTotalMarks ?? 0 }}/{{ $firstHalfTotalFull ?? 0 }}</td>
                            <td>{{ $firstHalfPerc }}%</td>
                        </tr>
                        @php
                        $secondHalfPerc = ($secondHalfTotalFull ?? 0) > 0 ? round((($secondHalfTotalMarks ?? 0) /
                        ($secondHalfTotalFull ?? 0)) * 100, 2) : 0;
                        @endphp
                        <tr>
                            <td>Second Half</td>
                            <td>{{ $secondHalfTotalMarks ?? 0 }}/{{ $secondHalfTotalFull ?? 0 }}</td>
                            <td>{{ $secondHalfPerc }}%</td>
                        </tr>
                    </tbody>
                </table>
            </td> --}}

            {{-- <td style="width: 33.33%; vertical-align: top;">
                <div class="section-title">Second Half Result</div>
                <table>
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Marks</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $secondHalfPerc = ($secondHalfTotalFull ?? 0) > 0 ? round((($secondHalfTotalMarks ?? 0) /
                        ($secondHalfTotalFull ?? 0)) * 100, 2) : 0;
                        @endphp
                        <tr>
                            <td>Summative</td>
                            <td>{{ $secondHalfTotalMarks ?? 0 }}/{{ $secondHalfTotalFull ?? 0 }}</td>
                            <td>{{ $secondHalfPerc }}%</td>
                        </tr>
                    </tbody>
                </table>
            </td> --}}

            {{-- <td style="width: 33.33%; vertical-align: top;">
                <div class="section-title">Overall Result</div>
                <table>
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Marks</th>
                            <th>%</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $grandTotalMarks = ($firstHalfTotalMarks ?? 0) + ($secondHalfTotalMarks ?? 0);
                        $grandTotalFull = ($firstHalfTotalFull ?? 0) + ($secondHalfTotalFull ?? 0);
                        $sumPerc = $grandTotalFull > 0 ? round(($grandTotalMarks / $grandTotalFull) * 100, 2) : 0;
                        $formPerc = ($formGrandFull ?? 0) > 0 ? round(($formGrandMarks / $formGrandFull) * 100, 2) : 0;
                        $overallObt = $grandTotalMarks + ($formGrandMarks ?? 0);
                        $overallFull = $grandTotalFull + ($formGrandFull ?? 0);
                        $overallPerc = $overallFull > 0 ? round(($overallObt / $overallFull) * 100, 2) : 0;
                        @endphp
                        <tr>
                            <td>Summative</td>
                            <td>{{ $grandTotalMarks }}/{{ $grandTotalFull }}</td>
                            <td>{{ $sumPerc }}%</td>
                        </tr>
                        <tr>
                            <td>Formative</td>
                            <td>{{ $formGrandMarks ?? 0 }}/{{ $formGrandFull ?? 0 }}</td>
                            <td>{{ $formPerc }}%</td>
                        </tr>
                        <tr>
                            <td><strong>Total</strong></td>
                            <td><strong>{{ $overallObt }}/{{ $overallFull }}</strong></td>
                            <td><strong>{{ $overallPerc }}%</strong></td>
                        </tr>
                    </tbody>
                </table>
            </td> --}}
        </tr>
    </table>

    <div style="margin-top: 20px;">
        {{-- <div class="section-title">Signatures</div> --}}
        <table>
            <tbody>
                <tr>
                    <td style="height: 40px;"></td>
                    <td></td>
                    <td></td>
                </tr>
            </tbody>
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Class Teacher</th>
                    <th>Principal</th>
                </tr>
            </thead>
        </table>
    </div>

    {{-- <div class="muted">This marksheet is system generated and valid without signature.</div> --}}
    
    <!-- Second Page -->
    <div style="page-break-before: always;"></div>
    
    <table style="width: 100%; border-collapse: collapse; font-family: sans-serif; font-size: 12px;">
        <tr>
            <!-- Left Column -->
            <td style="width: 50%; padding: 20px; vertical-align: top;">
            
            <!-- Grade Details Section -->
            <div style="margin-bottom: 30px;">
                <div style="background-color: #e5e7eb; padding: 8px; font-weight: bold; border: 1px solid #ccc; border-bottom: none; text-align: center;">
                    Grade Details
                </div>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr>
                            <th style="border: 1px solid #ccc; padding: 6px; text-align: left;">Type</th>
                            <th style="border: 1px solid #ccc; padding: 6px; text-align: left;">Grade Ranges</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Summative Row -->
                        <tr>
                            <td style="border: 1px solid #ccc; padding: 6px; text-align: left; font-weight: bold;">Summative</td>
                            <td style="border: 1px solid #ccc; padding: 6px; text-align: left;">
                                @php
                                    // Get all summative subjects to calculate overall performance
                                    $summativePercentages = [];
                                    foreach($summativeSubjects as $ms) {
                                        $subjectFirstHalfMarks = calculateSubjectTotalMarks($ms->subject_id, $firstHalfExams, $examClassSubjectMap, $marksData, 'Summative', $student->id);
                                        $subjectSecondHalfMarks = calculateSubjectTotalMarks($ms->subject_id, $secondHalfExams, $examClassSubjectMap, $marksData, 'Summative', $student->id);
                                        $subjectFirstHalfFull = calculateSubjectFullMarks($ms->subject_id, $firstHalfExams, $examClassSubjectMap, 'Summative');
                                        $subjectSecondHalfFull = calculateSubjectFullMarks($ms->subject_id, $secondHalfExams, $examClassSubjectMap, 'Summative');
                                        
                                        $totalMarks = $subjectFirstHalfMarks + $subjectSecondHalfMarks;
                                        $totalFull = $subjectFirstHalfFull + $subjectSecondHalfFull;
                                        if ($totalFull > 0) {
                                            $percentage = round(($totalMarks / $totalFull) * 100, 2);
                                            $summativePercentages[] = $percentage;
                                        }
                                    }
                                    
                                    // Get grade ranges for summative (assuming standard grading system)
                                    $summativeGradeRanges = [
                                        'A+' => '90-100%',
                                        'A' => '80-89%',
                                        'B+' => '70-79%',
                                        'B' => '60-69%',
                                        'C' => '50-59%',
                                        'D' => '40-49%',
                                        'F' => '0-39%'
                                    ];
                                @endphp
                                @foreach($summativeGradeRanges as $grade => $range)
                                    <div style="margin-bottom: 2px;">{{ $grade }}: {{ $range }}</div>
                                @endforeach
                            </td>
                        </tr>
                        
                        <!-- Formative Row -->
                        <tr>
                            <td style="border: 1px solid #ccc; padding: 6px; text-align: left; font-weight: bold;">Formative</td>
                            <td style="border: 1px solid #ccc; padding: 6px; text-align: left;">
                                @php
                                    // Get all formative subjects to calculate overall performance
                                    $formativePercentages = [];
                                    foreach($formativeSubjects as $ms) {
                                        $formTotalMarks = calculateSubjectTotalMarks($ms->subject_id, $examDetailsGrouped, $examClassSubjectMap, $marksData, 'Formative', $student->id);
                                        $formTotalFull = calculateSubjectFullMarks($ms->subject_id, $examDetailsGrouped, $examClassSubjectMap, 'Formative');
                                        
                                        if ($formTotalFull > 0) {
                                            $percentage = round(($formTotalMarks / $formTotalFull) * 100, 2);
                                            $formativePercentages[] = $percentage;
                                        }
                                    }
                                    
                                    // Get grade ranges for formative (assuming standard grading system)
                                    $formativeGradeRanges = [
                                        'A+' => '90-100%',
                                        'A' => '80-89%',
                                        'B+' => '70-79%',
                                        'B' => '60-69%',
                                        'C' => '50-59%',
                                        'D' => '40-49%',
                                        'F' => '0-39%'
                                    ];
                                @endphp
                                @foreach($formativeGradeRanges as $grade => $range)
                                    <div style="margin-bottom: 2px;">{{ $grade }}: {{ $range }}</div>
                                @endforeach
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <!-- Teacher Remarks Section -->
            <div style="margin-bottom: 30px;">
                <div style="background-color: #e5e7eb; padding: 8px; font-weight: bold; border: 1px solid #ccc; border-bottom: none; text-align: center;">
                    Teacher Remarks
                </div>
                <div style="border: 1px solid #ccc; padding: 10px; min-height: 60px;">
                    <!-- Two rows for teacher remarks -->
                    <div style="margin-bottom: 15px; min-height: 20px; border-bottom: 1px dotted #ccc;"></div>
                    <div style="min-height: 20px;"></div>
                </div>
            </div>
            
            <!-- Attendance Details -->
            <div style="margin-bottom: 30px;">
                <div style="background-color: #e5e7eb; padding: 8px; font-weight: bold; border: 1px solid #ccc; border-bottom: none; text-align: center;">
                    Attendance Details
                </div>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="border: 1px solid #ccc; padding: 8px; width: 50%;">Total Working Days:</td>
                        <td style="border: 1px solid #ccc; padding: 8px;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ccc; padding: 8px;">Days Present:</td>
                        <td style="border: 1px solid #ccc; padding: 8px;"></td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ccc; padding: 8px;">Attendance Percentage:</td>
                        <td style="border: 1px solid #ccc; padding: 8px;"></td>
                    </tr>
                </table>
            </div>
            
            <!-- Rules and Regulations -->
            <div>
                <div style="background-color: #e5e7eb; padding: 8px; font-weight: bold; border: 1px solid #ccc; border-bottom: none; text-align: center;">
                    Rules and Regulations
                </div>
                <div style="border: 1px solid #ccc; padding: 10px; font-size: 10px; line-height: 1.4;">
                    <ol style="margin: 0; padding-left: 15px;">
                        <li>Students must maintain regular attendance in all classes.</li>
                        <li>Academic dishonesty will result in disciplinary action.</li>
                        <li>Students are expected to follow the school code of conduct.</li>
                        <li>All assignments and examinations must be completed on time.</li>
                        <li>Parents are requested to monitor their child's academic progress regularly.</li>
                        <li>Any concerns should be addressed to the class teacher or school administration.</li>
                    </ol>
                </div>
            </div>
            
            </td>
            
            <!-- Right Column -->
            <td style="width: 50%; padding: 20px; vertical-align: top;">
            
            <!-- School Information -->
            <div style="margin-bottom: 30px; text-align: center;">
                <div style="font-size: 18px; font-weight: bold; margin-bottom: 10px;">{{ $school->name ?? 'School Name' }}</div>
                <div style="font-size: 12px; margin-bottom: 5px;">{{ $school->vill ?? '' }}{{ $school->po ? ', ' . $school->po : '' }}{{ $school->dist ? ', ' . $school->dist : '' }}</div>
                <div style="font-size: 12px; margin-bottom: 15px;">{{ $school->state ?? '' }}{{ $school->pin ? ' - ' . $school->pin : '' }}</div>
                
                <!-- School Logo Area -->
                <div style="margin: 20px 0; height: 100px; display: flex; align-items: center; justify-content: center; border: 1px dashed #ccc;">
                    <div style="color: #999; font-style: italic;">School Logo</div>
                </div>
            </div>
            
            <!-- Student Details -->
            <div>
                <div style="background-color: #e5e7eb; padding: 8px; font-weight: bold; border: 1px solid #ccc; border-bottom: none; text-align: center;">
                    Student Details
                </div>
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="border: 1px solid #ccc; padding: 8px; width: 40%; font-weight: bold;">Name:</td>
                        <td style="border: 1px solid #ccc; padding: 8px;">{{ $student->studentdb->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ccc; padding: 8px; font-weight: bold;">Address:</td>
                        <td style="border: 1px solid #ccc; padding: 8px;">{{ $student->studentdb->address ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ccc; padding: 8px; font-weight: bold;">Class:</td>
                        <td style="border: 1px solid #ccc; padding: 8px;">{{ $student->myClass->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ccc; padding: 8px; font-weight: bold;">Section:</td>
                        <td style="border: 1px solid #ccc; padding: 8px;">{{ optional($student->section)->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ccc; padding: 8px; font-weight: bold;">Roll No:</td>
                        <td style="border: 1px solid #ccc; padding: 8px;">{{ $student->roll_no ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ccc; padding: 8px; font-weight: bold;">Reg No:</td>
                        <td style="border: 1px solid #ccc; padding: 8px;">{{ $student->studentdb->reg_no ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ccc; padding: 8px; font-weight: bold;">Session:</td>
                        <td style="border: 1px solid #ccc; padding: 8px;">{{ $school->activeSession->first()->name ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #ccc; padding: 8px; font-weight: bold;">House:</td>
                        <td style="border: 1px solid #ccc; padding: 8px;">{{ $student->studentdb->house ?? 'N/A' }}</td>
                    </tr>
                </table>
            </div>
            
            </td>
        </tr>
    </table>
    
</body>

</html>