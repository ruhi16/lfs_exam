<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MyclassSection;
use App\Models\Myclass;
use App\Models\Section;
use App\Models\Studentcr;
use App\Models\Exam05Detail;
use App\Models\Exam01Name;
use App\Models\Exam03Part;
use App\Models\Exam06ClassSubject;
use App\Models\Exam10MarksEntry;
use App\Models\MyclassSubject;
use PDF;

class ExamMarksPdfController extends Controller
{
    public function downloadMarksPdf($classId)
    {
        $activeClass = Myclass::find($classId);

        if (!$activeClass) {
            return redirect()->back()->with('error', 'Class not found.');
        }

        // 1. Load Sections for this class
        $sections = MyclassSection::where('myclass_id', $classId)
            ->with('section')
            ->orderBy('section_id')
            ->get();

        // 2. Load Students for this class
        $students = Studentcr::where('myclass_id', $classId)
            ->with(['studentdb', 'section'])
            ->orderBy('section_id')
            ->orderBy('roll_no')
            ->get();

        // 3. Load Subjects for this class
        $classSubjects = MyclassSubject::where('myclass_id', $classId)
            ->with(['subject.subjectType'])
            ->get()
            ->sortByDesc(function ($ms) {
                return $ms->subject->subject_type_id ?? 0;
            });

        // 4. Load Exam Details
        $examDetails = Exam05Detail::where('myclass_id', $classId)
            ->with(['examName', 'examPart', 'examType'])
            ->orderBy('exam_name_id')
            ->orderBy('exam_part_id')
            ->get();

        // Group exam details
        $examDetailsGrouped = [];
        foreach ($examDetails as $detail) {
            $examDetailsGrouped[$detail->exam_name_id][$detail->exam_part_id][] = $detail;
        }

        // 5. Load Exam Class Subjects (The mapping/pivot)
        $ecs = Exam06ClassSubject::where('myclass_id', $classId)->get();
        $examClassSubjectMap = [];
        foreach ($ecs as $item) {
            $examClassSubjectMap[$item->exam_detail_id][$item->subject_id] = [
                'id' => $item->id,
                'full_marks' => $item->full_marks,
                'pass_marks' => $item->pass_marks
            ];
        }

        // 6. Load Marks
        $marksData = [];
        $sectionIds = $sections->pluck('id');

        $marksEntries = Exam10MarksEntry::whereIn('myclass_section_id', $sectionIds)
            ->get();

        foreach ($marksEntries as $entry) {
            $key = $entry->studentcr_id . '_' . $entry->exam_class_subject_id;
            $marksData[$key] = [
                'exam_marks' => $entry->exam_marks,
                'is_absent' => $entry->is_absent,
            ];
        }

        $data = [
            'activeClass' => $activeClass,
            'sections' => $sections,
            'students' => $students,
            'examDetailsGrouped' => $examDetailsGrouped,
            'classSubjects' => $classSubjects,
            'examClassSubjectMap' => $examClassSubjectMap,
            'marksData' => $marksData,
        ];

        $pdf = PDF::loadView('exports.exam12-exam-marks-register-pdf', $data, [], [
            'orientation' => 'L'
        ]);

        return $pdf->stream('MarkRegister-' . \Illuminate\Support\Str::slug($activeClass->name) . '.pdf');
    }

    public function downloadStudentMarksheetPdf($studentId)
    {
        $school = \App\Models\School::find(1);
        $student = Studentcr::with(['studentdb', 'section', 'myclass'])->find($studentId);
        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }

        $classId = $student->myclass_id;
        $activeClass = Myclass::find($classId);
        if (!$activeClass) {
            return redirect()->back()->with('error', 'Class not found for the student.');
        }

        // Sections for context (optional in template)
        $sections = MyclassSection::where('myclass_id', $classId)
            ->with('section')
            ->orderBy('section_id')
            ->get();

        // Subjects for this class
        $classSubjects = MyclassSubject::where('myclass_id', $classId)
            ->with(['subject.subjectType'])
            ->get()
            ->sortByDesc(function ($ms) {
                return $ms->subject->subject_type_id ?? 0;
            });

        // Exam Details for this class
        $examDetails = Exam05Detail::where('myclass_id', $classId)
            ->with(['examName', 'examPart', 'examType'])
            ->orderBy('exam_name_id')
            ->orderBy('exam_part_id')
            ->get();

        // Group exam details by exam_name then exam_part
        $examDetailsGrouped = [];
        foreach ($examDetails as $detail) {
            $examDetailsGrouped[$detail->exam_name_id][$detail->exam_part_id][] = $detail;
        }

        // Exam Class Subject mapping
        $ecs = Exam06ClassSubject::where('myclass_id', $classId)->get();
        $examClassSubjectMap = [];
        foreach ($ecs as $item) {
            $examClassSubjectMap[$item->exam_detail_id][$item->subject_id] = [
                'id' => $item->id,
                'full_marks' => $item->full_marks,
                'pass_marks' => $item->pass_marks
            ];
        }

        // Marks for this student only
        $marksEntries = Exam10MarksEntry::where('studentcr_id', $studentId)->get();
        $marksData = [];
        foreach ($marksEntries as $entry) {
            $marksData[$entry->exam_class_subject_id] = [
                'exam_marks' => $entry->exam_marks,
                'is_absent' => $entry->is_absent,
            ];
        }

        $data = [
            'school' => $school,
            'activeClass' => $activeClass,
            'student' => $student,
            'sections' => $sections,
            'examDetailsGrouped' => $examDetailsGrouped,
            'classSubjects' => $classSubjects,
            'examClassSubjectMap' => $examClassSubjectMap,
            'marksData' => $marksData,
        ];

        $pdf = PDF::loadView('exports.exam20-student-mark-sheet-pdf', $data, [], [
            'orientation' => 'P'
        ]);

        return $pdf->stream('Marksheet-' . \Illuminate\Support\Str::slug($student->studentdb->name ?? 'student') . '.pdf');
    }

    public function downloadAnnualMarksheetPdf($studentId)
    {
        $school = \App\Models\School::find(1);
        $student = Studentcr::with(['studentdb', 'section', 'myclass', 'session'])->find($studentId);
        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }
        // $school = \App\Models\School::find($student->school_id);
        $session = \App\Models\Session::currentlyActive()->first() ?? $student->session;

        $classId = $student->myclass_id;
        $activeClass = Myclass::find($classId);
        if (!$activeClass) {
            return redirect()->back()->with('error', 'Class not found for the student.');
        }

        $classSubjects = MyclassSubject::where('myclass_id', $classId)
            ->with(['subject.subjectType'])
            ->get();

        $examDetails = Exam05Detail::where('myclass_id', $classId)
            ->with(['examName', 'examPart', 'examType'])
            ->orderBy('exam_name_id')
            ->orderBy('exam_part_id')
            ->get();

        $ecs = Exam06ClassSubject::where('myclass_id', $classId)->get();
        $map = [];
        foreach ($ecs as $item) {
            $map[$item->exam_detail_id][$item->subject_id] = [
                'id' => $item->id,
                'full_marks' => $item->full_marks,
                'pass_marks' => $item->pass_marks
            ];
        }

        $marksEntries = Exam10MarksEntry::where('studentcr_id', $studentId)->get();
        $marksData = [];
        foreach ($marksEntries as $entry) {
            $marksData[$entry->exam_class_subject_id] = [
                'exam_marks' => $entry->exam_marks,
                'is_absent' => $entry->is_absent,
            ];
        }

        $summativeType = \App\Models\Exam02Type::whereRaw('LOWER(name) = ?', ['summative'])->first();
        $formativeType = \App\Models\Exam02Type::whereRaw('LOWER(name) = ?', ['formative'])->first();

        $examNames = Exam01Name::whereIn('id', $examDetails->pluck('exam_name_id')->unique())->get();
        $examTypes = \App\Models\Exam02Type::whereIn('id', $examDetails->pluck('exam_type_id')->unique())->get();
        $examParts = Exam03Part::whereIn('id', $examDetails->pluck('exam_part_id')->unique())->get();
        $groupedClassSubjects = $classSubjects->groupBy(function ($ms) { return $ms->subject->subject_type_id; });
        $examDetailsSummativeGrouped = $summativeType ? $examDetails->where('exam_type_id', $summativeType->id)->groupBy('exam_name_id') : collect();
        $examDetailsFormativeGrouped = $formativeType ? $examDetails->where('exam_type_id', $formativeType->id)->groupBy('exam_name_id') : collect();

        $summativeRows = [];
        $formativeRows = [];
        $grandTotalSummative = 0;
        foreach ($classSubjects as $ms) {
            $subjectId = $ms->subject_id;
            $sumObtained = 0;
            $sumFull = 0;
            $formObtained = 0;
            $formFull = 0;
            foreach ($examDetails as $detail) {
                if (!$detail->exam_type_id || !$detail->exam_part_id) {
                    continue;
                }
                $m = $map[$detail->id][$subjectId] ?? null;
                if (!$m) {
                    continue;
                }
                $entry = $marksData[$m['id']] ?? null;
                $val = $entry['exam_marks'] ?? null;
                $isAbsent = $entry['is_absent'] ?? false;
                if ($detail->exam_type_id === ($summativeType->id ?? -1)) {
                    if (!is_null($val) && !$isAbsent) {
                        $sumObtained += (int)round($val);
                    }
                    $sumFull += (int)$m['full_marks'];
                } elseif ($detail->exam_type_id === ($formativeType->id ?? -1)) {
                    if (!is_null($val) && !$isAbsent) {
                        $formObtained += (int)round($val);
                    }
                    $formFull += (int)$m['full_marks'];
                }
            }
            if ($sumFull > 0 || $sumObtained > 0) {
                $grade = \App\Models\Exam08Grade::calculateGrade($sumObtained, 'summative', $subjectId, $sumFull);
                $summativeRows[] = [
                    'subject_name' => $ms->subject->name ?? 'Subject',
                    'obtained' => $sumObtained,
                    'total' => $sumObtained,
                    'full_marks' => $sumFull,
                    'grade' => $grade,
                ];
                $grandTotalSummative += $sumObtained;
            }
            if ($formFull > 0 || $formObtained > 0) {
                $gradeF = \App\Models\Exam08Grade::calculateGrade($formObtained, 'formative', $subjectId, $formFull);
                $formativeRows[] = [
                    'subject_name' => $ms->subject->name ?? 'Subject',
                    'obtained' => $formObtained,
                    'grade' => $gradeF,
                ];
            }
        }

        $overallFull = array_sum(array_map(function ($r) {
            return $r['full_marks'];
        }, $summativeRows));
        $overallPercent = $overallFull > 0 ? round(($grandTotalSummative / $overallFull) * 100, 2) : null;
        $overallGrade = $overallPercent !== null ? \App\Models\Exam08Grade::calculateGrade($overallPercent, 'summative', null, 100) : '';
        $overallResult = ($overallPercent !== null && $overallPercent >= 40) ? 'Promoted' : 'Fail';

        $gradeCounts = [
            'A' => 0,
            'B' => 0,
            'C' => 0,
            'D' => 0,
            'E' => 0,
            'F' => 0
        ];
        foreach ($summativeRows as $r) {
            $g = strtoupper(substr($r['grade'] ?? '', 0, 1));
            if (isset($gradeCounts[$g])) {
                $gradeCounts[$g] += 1;
            } else {
                $gradeCounts[$g] = 1;
            }
        }

        $data = [
            'school' => $school,
            'session' => $session,
            'activeClass' => $activeClass,
            'student' => $student,
            'classSubjects' => $classSubjects,
            'summativeType' => $summativeType,
            'formativeType' => $formativeType,
            'examNames' => $examNames,
            'examTypes' => $examTypes,
            'examParts' => $examParts,
            'examDetailsSummativeGrouped' => $examDetailsSummativeGrouped,
            'examDetailsFormativeGrouped' => $examDetailsFormativeGrouped,
            'examClassSubjectMap' => $map,
            'marksData' => $marksData,
            'summativeRows' => $summativeRows,
            'formativeRows' => $formativeRows,
            'grandTotalSummative' => $grandTotalSummative,
            'overallPercent' => $overallPercent,
            'overallGrade' => $overallGrade,
            'overallResult' => $overallResult,
            'gradeCounts' => $gradeCounts,
        ];

        $pdf = PDF::loadView('exports.annual-marks-sheet', $data, [], [
            'orientation' => 'P'
        ]);

        return $pdf->stream('Annual-Marksheet-' . \Illuminate\Support\Str::slug($student->studentdb->name ?? 'student') . '.pdf');
    }
}
