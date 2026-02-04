<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Annual Marks Sheet</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; margin: 24px; color: #111827; }
        h1,h2,h3,h4 { margin: 0; }
        .center { text-align: center; }
        .muted { color: #6b7280; }
        .header { margin-bottom: 16px; }
        .line { margin: 4px 0; }
        .title { font-size: 24pt; font-weight: bold; }
        .subtitle { font-size: 16pt; font-weight: bold; }
        .ribbon { display: grid; grid-template-columns: 2fr 1fr; gap: 12px; align-items: center; background: #f3f4f6; border: 1px solid #d1d5db; padding: 12px; margin-bottom: 16px; }
        .rbox { padding: 8px; }
        .rlabel { font-weight: bold; }
        .photo { width: 100px; height: 100px; border: 1px solid #9ca3af; background: #fff; display: flex; align-items: center; justify-content: center; font-size: 10px; }
        .qr { width: 100px; height: 100px; border: 1px dashed #9ca3af; display: flex; align-items: center; justify-content: center; font-size: 10px; margin-left: 8px; }
        .logo { width: 28px; height: 28px; object-fit: contain; vertical-align: middle; margin-right: 6px; }
        .right-inline { display: flex; align-items: center; justify-content: flex-end; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #d1d5db; padding: 6px; text-align: center; }
        th { background: #f9fafb; font-weight: 600; }
        .text-left { text-align: left; }
        .ab { color: #ef4444; font-weight: bold; }
        .totals { font-weight: 700; background: #f3f4f6; }
        .section-title { margin-top: 18px; font-weight: bold; }
        .sign-row { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; margin-top: 24px; }
        .sign { border: 1px solid #d1d5db; height: 100px; padding: 8px; }
        .footer { margin-top: 18px; font-size: 10px; }
        .bold { font-weight: 700; }
    </style>
    </head>
<body>
    <div class="header center">
        <div class="line title"><img class="logo" src="{{ asset('lfs_logo.png') }}" alt="School Logo"/> {{ $school->name ?? '' }}</div>
        <div class="line font-bold">{{ $school->address ?? '' }}</div>
        <div class="line subtitle">ANNUAL MARKS SHEET</div>
        <div class="line font-bold">Session: {{ $session->name ?? '' }}</div>
    </div>

    <div class="ribbon">
        <div class="rbox">
            <div><span class="rlabel">Name:</span> {{ $student->studentdb->name ?? '' }}</div>
            <div><span class="rlabel">Gender:</span> {{ $student->studentdb->ssex ?? '' }}</div>
            <div><span class="rlabel">Class:</span> {{ optional($student->myclass)->name ?? '' }}</div>
            <div><span class="rlabel">Section:</span> {{ optional($student->section)->name ?? '' }}</div>
            <div><span class="rlabel">Roll No:</span> {{ $student->roll_no ?? '' }}</div>
            <div><span class="rlabel">DOB:</span> {{ optional($student->studentdb)->dob ? \Carbon\Carbon::parse($student->studentdb->dob)->format('d/m/Y') : '' }}</div>
            <div><span class="rlabel">UUID:</span> {{ $student->studentdb->uuid_auto ?? '' }}</div>
        </div>
        <div class="right-inline">
            @php
                $profilePath = $student->studentdb->img_ref_profile ?? null;
            @endphp
            <div class="photo">
                @if($profilePath)
                    <img src="{{ asset('storage/' . $profilePath) }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;"/>
                @else
                    Photo
                @endif
            </div>
            <div class="qr">QR: {{ ($student->studentdb->name ?? '') }}, {{ ($student->roll_no ?? '') }}, {{ ($student->studentdb->uuid_auto ?? '') }}</div>
        </div>
    </div>

    @php
        $blocks = [
            ['label' => 'Summative', 'type' => $summativeType ?? null, 'grouped' => $examDetailsSummativeGrouped ?? collect()],
            ['label' => 'Formative', 'type' => $formativeType ?? null, 'grouped' => $examDetailsFormativeGrouped ?? collect()],
        ];
    @endphp
    @foreach($blocks as $block)
        @php
            $typeObj = $block['type'];
            $typeId = $typeObj->id ?? null;
            $examDetailsGroupedByType = $block['grouped'];
            $subjectsToRender = ($classSubjects ?? collect())->filter(function($ms) use ($block) {
                $stype = $ms->subject->subject_type_id ?? null;
                if (strtolower($block['label']) === 'summative') {
                    return $stype === 2;
                }
                if (strtolower($block['label']) === 'formative') {
                    return $stype === 1;
                }
                return true;
            });
        @endphp
        @if($subjectsToRender->count() > 0)
            <div class="section-title">{{ $block['label'] }} Assessment</div>
            @php $isSummative = strtolower($block['label']) === 'summative'; @endphp
            <table>
                <thead>
                    <tr>
                        <th class="text-left">Subject</th>
                        @foreach($examDetailsGroupedByType as $examNameId => $examDetailsByType)
                            @php
                                $examName = $examNames->firstWhere('id', $examNameId);
                                $colspan = 0;
                                foreach($examDetailsByType->groupBy('exam_type_id') as $typeDetails){
                                    $colspan += $typeDetails->groupBy('exam_part_id')->count();
                                }
                            @endphp
                            @if($examName && $colspan > 0)
                                <th colspan="{{ $colspan }}">{{ $examName->name }}</th>
                            @endif
                        @endforeach
                        @if($isSummative)
                            <th>Total Marks</th>
                            <th>Grade</th>
                        @endif
                    </tr>
                    <tr>
                        <th class="text-left">-</th>
                        @foreach($examDetailsGroupedByType as $examNameId => $examDetailsByType)
                            @foreach($examDetailsByType->groupBy('exam_type_id') as $examTypeId => $typeDetails)
                                @php
                                    $partsCount = $typeDetails->groupBy('exam_part_id')->count();
                                    $examType = $examTypes->firstWhere('id', $examTypeId);
                                @endphp
                                @if($examType && $partsCount > 0)
                                    <th colspan="{{ $partsCount }}">{{ $examType->name }}</th>
                                @endif
                            @endforeach
                        @endforeach
                        @if($isSummative)
                            <th>-</th>
                            <th>-</th>
                        @endif
                    </tr>
                    <tr>
                        <th class="text-left">-</th>
                        @foreach($examDetailsGroupedByType as $examNameId => $examDetailsByType)
                            @foreach($examDetailsByType->groupBy('exam_type_id') as $examTypeId => $typeDetails)
                                @foreach($typeDetails->groupBy('exam_part_id') as $examPartId => $partDetails)
                                    @php
                                        $examPartObj = $examParts->firstWhere('id', $examPartId);
                                        $firstDetail = $partDetails->first();
                                    @endphp
                                    <th>
                                        <div class="muted">{{ $examPartObj ? $examPartObj->name : 'N/A' }}</div>
                                        <div class="muted">
                                            @php
                                                $modeName = method_exists($firstDetail, 'examMode') ? optional($firstDetail->examMode)->name : null;
                                            @endphp
                                            {{ $modeName ?? 'Mode' }}
                                        </div>
                                    </th>
                                @endforeach
                            @endforeach
                        @endforeach
                        @if($isSummative)
                            <th>-</th>
                            <th>-</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @php $sumMarks = 0; $sumFull = 0; @endphp
                    @foreach($subjectsToRender as $ms)
                        @php
                            $subjectGrandMarks = 0;
                            $subjectGrandFull = 0;
                            $subjectId = $ms->subject_id;
                        @endphp
                        <tr>
                            <td class="text-left">
                                <div>{{ $ms->subject->name ?? 'Subject' }}</div>
                                <div class="muted">{{ $ms->subject->code ?? '' }}</div>
                            </td>
                            @foreach($examDetailsGroupedByType as $examNameId => $examDetailsByType)
                                @foreach($examDetailsByType->groupBy('exam_type_id') as $examTypeId => $typeDetails)
                                    @foreach($typeDetails->groupBy('exam_part_id') as $examPartId => $partDetails)
                                        @php
                                            $examDetail = $partDetails->first();
                                            $mapping = $examClassSubjectMap[$examDetail->id][$subjectId] ?? null;
                                            $entry = $mapping ? ($marksData[$mapping['id']] ?? null) : null;
                                            $val = $entry['exam_marks'] ?? null;
                                            $isAbsent = $entry['is_absent'] ?? false;
                                            $fm = $mapping['full_marks'] ?? null;
                                            if(!$isAbsent && !is_null($val) && !is_null($fm)){
                                                $subjectGrandMarks += (int)round($val);
                                                $subjectGrandFull += (int)$fm;
                                                $sumMarks += (int)round($val);
                                                $sumFull += (int)$fm;
                                            }
                                        @endphp
                                        <td>
                                            @if(!is_null($val))
                                                @if($val < 0 || $isAbsent)
                                                    <span class="ab">AB</span>
                                                @else
                                                    @php
                                                        $roundedVal = intval(round($val));
                                                        $gradeCell = null;
                                                        if(!$isSummative && $fm){
                                                            $gradeCell = \App\Models\Exam08Grade::calculateGrade($roundedVal, 'formative', null, $fm);
                                                        }
                                                    @endphp
                                                    {{ $roundedVal }}@if(!$isSummative && $gradeCell) ({{ $gradeCell }}) @endif
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                    @endforeach
                                @endforeach
                            @endforeach
                            @php
                                $subjectPercent = $subjectGrandFull > 0 ? round(($subjectGrandMarks / $subjectGrandFull) * 100, 2) : null;
                                $subjectGrade = $subjectPercent !== null ? \App\Models\Exam08Grade::calculateGrade($subjectPercent, strtolower($block['label']), null, 100) : '';
                            @endphp
                            @if($isSummative)
                                <td class="totals">{{ $subjectGrandMarks }}</td>
                                <td class="totals">{{ $subjectGrade }}</td>
                            @endif
                        </tr>
                    @endforeach
                    @if($isSummative)
                        @php
                            $totalPercent = $sumFull > 0 ? round(($sumMarks / $sumFull) * 100, 2) : null;
                            $totalGrade = $totalPercent !== null ? \App\Models\Exam08Grade::calculateGrade($totalPercent, 'summative', null, 100) : '';
                        @endphp
                        <tr class="totals">
                            <td class="text-left">Grand Total</td>
                            <td colspan="{{ $examDetailsGroupedByType->sum(function($examDetailsByType) { return $examDetailsByType->groupBy('exam_type_id')->sum(function($typeDetails){ return $typeDetails->groupBy('exam_part_id')->count(); }); }) }}">{{ $sumMarks }} / {{ $sumFull }}</td>
                            <td>{{ $sumMarks }}</td>
                            <td>{{ $totalGrade }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        @endif
    @endforeach

    <div class="section-title">Result Summary</div>
    <table>
        <tbody>
            <tr>
                <td class="text-left bold">Overall Result</td>
                <td>{{ $overallResult }}</td>
            </tr>
            <tr>
                <td class="text-left bold">Percentage</td>
                <td>{{ $overallPercent ?? 0 }}%</td>
            </tr>
            <tr>
                <td class="text-left bold">Grade Distribution</td>
                <td>
                    A: {{ $gradeCounts['A'] ?? 0 }} |
                    B: {{ $gradeCounts['B'] ?? 0 }} |
                    C: {{ $gradeCounts['C'] ?? 0 }} |
                    D: {{ $gradeCounts['D'] ?? 0 }} |
                    E/F: {{ ($gradeCounts['E'] ?? 0) + ($gradeCounts['F'] ?? 0) }}
                </td>
            </tr>
            <tr>
                <td class="text-left bold">Remarks</td>
                <td>Performance evaluated for the annual session.</td>
            </tr>
        </tbody>
    </table>

    <div class="sign-row">
        <div class="sign">
            <div class="bold">Class Teacher</div>
            <div style="margin-top: 48px; border-top: 1px solid #d1d5db;"></div>
        </div>
        <div class="sign">
            <div class="bold">Principal</div>
            <div style="margin-top: 48px; border-top: 1px solid #d1d5db;"></div>
        </div>
        <div class="sign">
            <div class="bold">School Stamp/Seal</div>
        </div>
    </div>

    <div class="footer">
        <div class="bold">General Rules</div>
        <ol>
            <li>Marks are not up for re-evaluation.</li>
            <li>Original certificate required for verification.</li>
            <li>AB indicates absence in any exam component.</li>
            <li>Grades are computed per exam type policy.</li>
            <li>Unauthorized alterations invalidate this document.</li>
            <li>Contact school office for discrepancies.</li>
            <li>This marksheet is valid without signature.</li>
        </ol>
    </div>
</body>
</html>
