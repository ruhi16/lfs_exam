<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Student Mark Sheet</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ccc; padding: 6px; text-align: center; }
        th { background-color: #f0f0f0; }
        .text-left { text-align: left; }
        .muted { color: #6b7280; font-size: 10px; }
        .header { margin-bottom: 10px; }
        .section-title { background-color: #e5e7eb; padding: 6px; font-weight: bold; border: 1px solid #ccc; border-bottom: none; }
        .title-container { text-align: center; height: 100px; display: flex; flex-direction: column; align-items: center; justify-content: center; }
        h1 { font-size: 26px; height: 20px; margin: 0; }
        h2 { font-size: 14px; height: 18px; margin: 0; }
        h3 { font-size: 12px; height: 16px; margin: 0; }
        .student-container { display: grid; grid-template-columns: 1fr 1fr; align-items: center; gap: 16px; min-height: 90px; }
        .student-left-part { padding: 10px; border: 1px solid #ccc; background-color: #f9fafb; }
        .student-right-part { padding: 10px; border: 1px solid #ccc; background-color: #f9fafb; }
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
                            <strong>Section:</strong> {{ optional($student->section)->name ?? 'N/A' }}  |
                            <strong>Roll:</strong> {{ $student->roll_no ?? 'N/A' }} </div>
                    @endif
                    </td>
                    <td style="text-align: left;">
                        {{-- @if($student && $student->studentdb && $student->studentdb->img_ref_profile)
                            <img class="profile-box" src="{{ asset('storage/' . $student->studentdb->img_ref_profile) }}"alt="Profile" style="width: 40px; height: 40px;object-fit: cover;">
                        @else
                            <div class="profile-box no-image">{{ asset('storage/' . $student->studentdb->img_ref_profile) ?? 'N/A' }}</div>
                        @endif --}}
                    </td>
                    
                </tr>
            </thead>
        </table>            
    </div>
    @php
        // Count total columns for exam parts across all exam names
        $totalExamCols = 0;
        foreach($examDetailsGrouped as $examNameId => $examParts){
            foreach($examParts as $examPartId => $details){
                $totalExamCols += 1; // one column per part block (taking first detail)
            }
        }
    @endphp

    @php
        $summativeSubjects = collect($classSubjects)->filter(function($ms){
            return (optional($ms->subject)->subject_type_id ?? null) === 2;
        });
        $formativeSubjects = collect($classSubjects)->filter(function($ms){
            return (optional($ms->subject)->subject_type_id ?? null) === 1;
        });
    @endphp

    @if($summativeSubjects->count())
        <div class="section-title">Summative Subjects</div>
        <table class="no-break">
            <thead>
                <tr>
                    <th class="text-left">Subject</th>
                    @foreach($examDetailsGrouped as $examNameId => $examParts)
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
                    @foreach($examDetailsGrouped as $examNameId => $examParts)
                        @foreach($examParts as $examPartId => $details)
                            @php
                                $examPart = \App\Models\Exam03Part::find($examPartId);
                                $firstDetail = collect($details)->first();
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
                @php $grandTotalMarks = 0; $grandTotalFull = 0; @endphp
                @foreach($summativeSubjects as $ms)
                    @php
                        $subjectGrandMarks = 0;
                        $subjectGrandFull = 0;
                    @endphp
                    <tr>
                        <td class="text-left">
                            <div>{{ optional($ms->subject)->name ?? 'Subject' }}</div>
                            {{-- <div class="muted">{{ optional($ms->subject)->code }}</div> --}}
                        </td>
                        @foreach($examDetailsGrouped as $examNameId => $examParts)
                            @foreach($examParts as $examPartId => $details)
                                @php
                                    $selectedDetail = collect($details)->first(function($d){
                                        return optional($d->examType)->name === 'Summative';
                                    }) ?? collect($details)->first();
                                    $mapping = $selectedDetail ? ($examClassSubjectMap[$selectedDetail->id][$ms->subject_id] ?? null) : null;
                                    $entry = $mapping ? ($marksData[$mapping['id']] ?? null) : null;
                                @endphp
                                <td>
                                    @if($mapping)
                                        @if(isset($entry['is_absent']) && $entry['is_absent'])
                                            <span style="color: red; font-weight: bold;">AB</span>
                                        @elseif(isset($entry['exam_marks']) && $entry['exam_marks'] !== null)
                                            @php
                                                $rounded = intval(round($entry['exam_marks']));
                                                $fm = intval($mapping['full_marks'] ?? 0);
                                                $subjectGrandMarks += $rounded;
                                                $subjectGrandFull += $fm;
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
                            if($subjectGrandFull > 0){
                                $subjectGrade = \App\Models\Exam08Grade::calculateGrade($subjectGrandMarks, 'summative', $ms->subject_id, $subjectGrandFull);
                            }
                        @endphp
                        @php $grandTotalMarks += $subjectGrandMarks; $grandTotalFull += $subjectGrandFull; @endphp
                        <td>{{ $subjectGrandMarks }} / {{ $subjectGrandFull }}</td>
                        <td>{{ $subjectGrade }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td class="text-left"><strong>Grand Total</strong></td>
                    @for($i=0; $i < $totalExamCols; $i++)
                        <td>-</td>
                    @endfor
                    <td><strong>{{ $grandTotalMarks }} / {{ $grandTotalFull }}</strong></td>
                    <td></td>
                </tr>
            </tbody>
        </table>
    @endif

    @if($formativeSubjects->count())
        <div class="section-title">Formative Subjects</div>
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
                        <th colspan="{{ $colspan }}">{{ $examName->name ?? 'Exam' }}</th>
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
                                $firstDetail = collect($details)->first();
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
                            {{-- <div class="muted">{{ optional($ms->subject)->code }}</div> --}}
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
                                    $mapping = $selectedDetail ? ($examClassSubjectMap[$selectedDetail->id][$ms->subject_id] ?? null) : null;
                                    $entry = $mapping ? ($marksData[$mapping['id']] ?? null) : null;
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
                                            <span style="font-weight: bold;">{{ $roundedF }}</span>@if($gradeF) <span class="muted">({{ $gradeF }})</span>@endif
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

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 8px; margin-top: 6px;">
        <div>
            <div class="section-title">Overall Result</div>
            <table>
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Obtained</th>
                        <th>Full Marks</th>
                        <th>Percentage</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $sumPerc = ($grandTotalFull ?? 0) > 0 ? round(($grandTotalMarks / $grandTotalFull) * 100, 2) : 0;
                        $formPerc = ($formGrandFull ?? 0) > 0 ? round(($formGrandMarks / $formGrandFull) * 100, 2) : 0;
                        $overallObt = ($grandTotalMarks ?? 0) + ($formGrandMarks ?? 0);
                        $overallFull = ($grandTotalFull ?? 0) + ($formGrandFull ?? 0);
                        $overallPerc = $overallFull > 0 ? round(($overallObt / $overallFull) * 100, 2) : 0;
                    @endphp
                    <tr>
                        <td>Summative</td>
                        <td>{{ $grandTotalMarks ?? 0 }}</td>
                        <td>{{ $grandTotalFull ?? 0 }}</td>
                        <td>{{ $sumPerc }}%</td>
                    </tr>
                    <tr>
                        <td>Formative</td>
                        <td>{{ $formGrandMarks ?? 0 }}</td>
                        <td>{{ $formGrandFull ?? 0 }}</td>
                        <td>{{ $formPerc }}%</td>
                    </tr>
                    <tr>
                        <td><strong>Overall</strong></td>
                        <td><strong>{{ $overallObt }}</strong></td>
                        <td><strong>{{ $overallFull }}</strong></td>
                        <td><strong>{{ $overallPerc }}%</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div>
            {{-- <div class="section-title">Signature</div> --}}
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
    </div>

    {{-- <div class="muted">This marksheet is system generated and valid without signature.</div> --}}
</body>
</html>
