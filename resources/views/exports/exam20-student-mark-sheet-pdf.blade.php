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
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $school->name }}</h1>
        <h2>Student Mark Sheet</h2>
        @if($activeClass)
            <div><strong>Class:</strong> {{ $activeClass->name }}</div>
        @endif
        @if($student)
            <div><strong>Name:</strong> {{ $student->studentdb->name ?? 'N/A' }}</div>
            <div><strong>Roll:</strong> {{ $student->roll_no ?? 'N/A' }}</div>
            <div><strong>Section:</strong> {{ optional($student->section)->name ?? 'N/A' }}</div>
        @endif
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

    <table>
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
                            <div class="muted">{{ optional($firstDetail->examMode)->name ?? 'Mode' }}</div>
                        </th>
                    @endforeach
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach($classSubjects as $ms)
                <tr>
                    <td class="text-left">
                        <div>{{ optional($ms->subject)->name ?? 'Subject' }}</div>
                        <div class="muted">{{ optional($ms->subject)->code }}</div>
                    </td>
                    @foreach($examDetailsGrouped as $examNameId => $examParts)
                        @foreach($examParts as $examPartId => $details)
                            @php
                                // Prefer summative if available, otherwise take the first detail
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
                                        <span style="font-weight: bold;">{{ $entry['exam_marks'] }}</span>
                                        <div class="muted">FM: {{ $mapping['full_marks'] ?? '-' }}</div>
                                    @else
                                        -
                                    @endif
                                    <div class="muted">ECS: {{ $mapping['id'] }}</div>
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

    <div class="muted">This marksheet is system generated and valid without signature.</div>
</body>
</html>
