<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\School;

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
            $key = $entry->studentcr_id . '_' . $entry->exam_detail_id . '_' . $entry->exam_class_subject_id;
            $marksData[$key] = [
                'exam_marks' => $entry->exam_marks == -99 ? null : $entry->exam_marks,
                'is_absent' => $entry->exam_marks == -99 || $entry->is_absent,
            ];
        }

        // 7. Calculate highest marks for each subject in the class
        $highestMarksBySubject = [];
        $highestFirstTermMarksBySubject = [];
        $highestSecondTermMarksBySubject = [];
        $highestFirstTermRollNosBySubject = [];
        $highestSecondTermRollNosBySubject = [];
        $firstTermMarksByStudentSubject = [];
        $secondTermMarksByStudentSubject = [];

        // Prepare exam categorization
        $firstHalfExamIds = [];
        $secondHalfExamIds = [];

        foreach ($examDetailsGrouped as $examNameId => $examParts) {
            $examName = \App\Models\Exam01Name::find($examNameId);
            $name = strtolower($examName->name ?? '');
            if (str_contains($name, 'first') || str_contains($name, 'half') || str_contains($name, '1st')) {
                foreach ($examParts as $examPartId => $details) {
                    foreach ($details as $detail) {
                        $firstHalfExamIds[] = $detail->id;
                    }
                }
            } else if (str_contains($name, '2nd') || str_contains($name, 'second') || str_contains($name, 'annual')) {
                foreach ($examParts as $examPartId => $details) {
                    foreach ($details as $detail) {
                        $secondHalfExamIds[] = $detail->id;
                    }
                }
            }
        }

        foreach ($marksEntries as $entry) {
            if (!$entry->is_absent && $entry->exam_marks !== null) {
                // Find the corresponding exam class subject mapping
                foreach ($examClassSubjectMap as $examDetailId => $subjects) {
                    foreach ($subjects as $subjectId => $mapping) {
                        if ($mapping['id'] == $entry->exam_class_subject_id) {
                            // Determine which term this belongs to
                            if (in_array($examDetailId, $firstHalfExamIds)) {
                                $key = $entry->studentcr_id . '_' . $subjectId;
                                if (!isset($firstTermMarksByStudentSubject[$key])) {
                                    $firstTermMarksByStudentSubject[$key] = 0;
                                }
                                $firstTermMarksByStudentSubject[$key] += $entry->exam_marks;
                            } elseif (in_array($examDetailId, $secondHalfExamIds)) {
                                $key = $entry->studentcr_id . '_' . $subjectId;
                                if (!isset($secondTermMarksByStudentSubject[$key])) {
                                    $secondTermMarksByStudentSubject[$key] = 0;
                                }
                                $secondTermMarksByStudentSubject[$key] += $entry->exam_marks;
                            }
                            break 2; // break both loops once we find the match
                        }
                    }
                }
            }
        }

        // Create student roll number lookup
        $studentRollNumbers = [];
        foreach ($students as $student) {
            $studentRollNumbers[$student->id] = $student->roll_no;
        }

        // Calculate highest total marks per subject for first term
        $subjectTotalsFirst = [];
        foreach ($firstTermMarksByStudentSubject as $key => $totalMarks) {
            $parts = explode('_', $key);
            $studentId = $parts[0];
            $subjectId = $parts[1];

            if (!isset($subjectTotalsFirst[$subjectId])) {
                $subjectTotalsFirst[$subjectId] = [];
            }
            $subjectTotalsFirst[$subjectId][] = ['marks' => $totalMarks, 'student_id' => $studentId];
        }

        foreach ($subjectTotalsFirst as $subjectId => $totals) {
            // Find the entry with the highest marks
            $maxEntry = null;
            foreach ($totals as $entry) {
                if (!$maxEntry || $entry['marks'] > $maxEntry['marks']) {
                    $maxEntry = $entry;
                }
            }
            if ($maxEntry) {
                $highestFirstTermMarksBySubject[$subjectId] = $maxEntry['marks'];
                $highestFirstTermRollNosBySubject[$subjectId] = $studentRollNumbers[$maxEntry['student_id']] ?? 'N/A';
            }
        }

        // Calculate highest total marks per subject for second term
        $subjectTotalsSecond = [];
        foreach ($secondTermMarksByStudentSubject as $key => $totalMarks) {
            $parts = explode('_', $key);
            $studentId = $parts[0];
            $subjectId = $parts[1];

            if (!isset($subjectTotalsSecond[$subjectId])) {
                $subjectTotalsSecond[$subjectId] = [];
            }
            $subjectTotalsSecond[$subjectId][] = ['marks' => $totalMarks, 'student_id' => $studentId];
        }

        foreach ($subjectTotalsSecond as $subjectId => $totals) {
            // Find the entry with the highest marks
            $maxEntry = null;
            foreach ($totals as $entry) {
                if (!$maxEntry || $entry['marks'] > $maxEntry['marks']) {
                    $maxEntry = $entry;
                }
            }
            if ($maxEntry) {
                $highestSecondTermMarksBySubject[$subjectId] = $maxEntry['marks'];
                $highestSecondTermRollNosBySubject[$subjectId] = $studentRollNumbers[$maxEntry['student_id']] ?? 'N/A';
            }
        }

        $data = [
            'activeClass' => $activeClass,
            'sections' => $sections,
            'students' => $students,
            'examDetailsGrouped' => $examDetailsGrouped,
            'classSubjects' => $classSubjects,
            'examClassSubjectMap' => $examClassSubjectMap,
            'marksData' => $marksData,
            'highestFirstTermMarksBySubject' => $highestFirstTermMarksBySubject,
            'highestSecondTermMarksBySubject' => $highestSecondTermMarksBySubject,
            'highestFirstTermRollNosBySubject' => $highestFirstTermRollNosBySubject,
            'highestSecondTermRollNosBySubject' => $highestSecondTermRollNosBySubject,
        ];

        $pdf = \PDF::loadView('exports.exam12-exam-marks-register-pdf', $data, [], [
            'orientation' => 'L'
        ]);

        return $pdf->stream('MarkRegister-' . \Illuminate\Support\Str::slug($activeClass->name) . '.pdf');
    }

    public function downloadStudentMarksheetPdf($studentId)
    {
        $student = Studentcr::with(['studentdb', 'myclass', 'section'])->find($studentId);
        if (!$student) {
            return redirect()->back()->with('error', 'Student not found.');
        }
        $classId = $student->myclass_id;
        $activeClass = Myclass::find($classId);
        $school = School::orderBy('id')->first();
        $sections = MyclassSection::where('myclass_id', $classId)
            ->with('section')
            ->orderBy('section_id')
            ->get();
        $classSubjects = MyclassSubject::where('myclass_id', $classId)
            ->with(['subject.subjectType'])
            ->get()
            ->sortByDesc(function ($ms) {
                return $ms->subject->subject_type_id ?? 0;
            });
        $examDetails = Exam05Detail::where('myclass_id', $classId)
            ->with(['examName', 'examPart', 'examType', 'examMode'])
            ->orderBy('exam_name_id')
            ->orderBy('exam_part_id')
            ->get();
        $examDetailsGrouped = [];
        foreach ($examDetails as $detail) {
            $examDetailsGrouped[$detail->exam_name_id][$detail->exam_part_id][] = $detail;
        }
        $ecs = Exam06ClassSubject::where('myclass_id', $classId)->get();
        $examClassSubjectMap = [];
        foreach ($ecs as $item) {
            $examClassSubjectMap[$item->exam_detail_id][$item->subject_id] = [
                'id' => $item->id,
                'full_marks' => $item->full_marks,
                'pass_marks' => $item->pass_marks
            ];
        }
        $marksData = [];
        $entries = Exam10MarksEntry::where('studentcr_id', $studentId)->get();
        foreach ($entries as $entry) {
            $key = $entry->studentcr_id . '_' . $entry->exam_detail_id . '_' . $entry->exam_class_subject_id;
            $marksData[$key] = [
                'exam_marks' => $entry->exam_marks == -99 ? null : $entry->exam_marks,
                'is_absent' => $entry->exam_marks == -99 || $entry->is_absent,
            ];
        }

        // Calculate highest marks for each subject in the class
        $marksEntries = Exam10MarksEntry::whereIn('myclass_section_id', $sections->pluck('id'))->get();

        $highestFirstTermMarksBySubject = [];
        $highestSecondTermMarksBySubject = [];
        $highestFirstTermRollNosBySubject = [];
        $highestSecondTermRollNosBySubject = [];
        $firstTermMarksByStudentSubject = [];
        $secondTermMarksByStudentSubject = [];

        // Build exam detail type lookup from already-loaded exam details
        $examDetailTypes = [];
        foreach ($examDetails as $detail) {
            $examDetailTypes[$detail->id] = optional($detail->examType)->name;
        }

        // Prepare exam categorization (include all detail IDs per term)
        $firstHalfExamIds = [];
        $secondHalfExamIds = [];

        foreach ($examDetailsGrouped as $examNameId => $examParts) {
            $examName = \App\Models\Exam01Name::find($examNameId);
            $name = strtolower($examName->name ?? '');
            if (str_contains($name, 'first') || str_contains($name, 'half') || str_contains($name, '1st')) {
                foreach ($examParts as $examPartId => $details) {
                    foreach ($details as $detail) {
                        $firstHalfExamIds[] = $detail->id;
                    }
                }
            } else if (str_contains($name, '2nd') || str_contains($name, 'second') || str_contains($name, 'annual')) {
                foreach ($examParts as $examPartId => $details) {
                    foreach ($details as $detail) {
                        $secondHalfExamIds[] = $detail->id;
                    }
                }
            }
        }

        foreach ($marksEntries as $entry) {
            if (!$entry->is_absent && $entry->exam_marks !== null && $entry->exam_marks != -99) {
                $examDetailId = $entry->exam_detail_id;

                // Only accumulate Summative marks for highest calculation
                if (($examDetailTypes[$examDetailId] ?? '') !== 'Summative') {
                    continue;
                }

                // Find subject ID directly from the exam class subject map using entry's exam_detail_id
                $subjectId = null;
                if (isset($examClassSubjectMap[$examDetailId])) {
                    foreach ($examClassSubjectMap[$examDetailId] as $sid => $mapping) {
                        if ($mapping['id'] == $entry->exam_class_subject_id) {
                            $subjectId = $sid;
                            break;
                        }
                    }
                }

                if ($subjectId !== null) {
                    $roundedMarks = intval(round($entry->exam_marks));
                    if (in_array($examDetailId, $firstHalfExamIds)) {
                        $key = $entry->studentcr_id . '_' . $subjectId;
                        if (!isset($firstTermMarksByStudentSubject[$key])) {
                            $firstTermMarksByStudentSubject[$key] = 0;
                        }
                        $firstTermMarksByStudentSubject[$key] += $roundedMarks;
                    } elseif (in_array($examDetailId, $secondHalfExamIds)) {
                        $key = $entry->studentcr_id . '_' . $subjectId;
                        if (!isset($secondTermMarksByStudentSubject[$key])) {
                            $secondTermMarksByStudentSubject[$key] = 0;
                        }
                        $secondTermMarksByStudentSubject[$key] += $roundedMarks;
                    }
                }
            }
        }

        // Create student roll number lookup
        $studentRollNumbers = [];
        $allStudents = Studentcr::where('myclass_id', $classId)->get();
        foreach ($allStudents as $stud) {
            $studentRollNumbers[$stud->id] = $stud->roll_no;
        }

        // Calculate highest total marks per subject for first term
        $subjectTotalsFirst = [];
        foreach ($firstTermMarksByStudentSubject as $key => $totalMarks) {
            $parts = explode('_', $key);
            $studentId = $parts[0];
            $subjectId = $parts[1];

            if (!isset($subjectTotalsFirst[$subjectId])) {
                $subjectTotalsFirst[$subjectId] = [];
            }
            $subjectTotalsFirst[$subjectId][] = ['marks' => $totalMarks, 'student_id' => $studentId];
        }

        foreach ($subjectTotalsFirst as $subjectId => $totals) {
            // Find the entry with the highest marks
            $maxEntry = null;
            foreach ($totals as $entry) {
                if (!$maxEntry || $entry['marks'] > $maxEntry['marks']) {
                    $maxEntry = $entry;
                }
            }
            if ($maxEntry) {
                $highestFirstTermMarksBySubject[$subjectId] = $maxEntry['marks'];
                $highestFirstTermRollNosBySubject[$subjectId] = $studentRollNumbers[$maxEntry['student_id']] ?? 'N/A';
            }
        }

        // Calculate highest total marks per subject for second term
        $subjectTotalsSecond = [];
        foreach ($secondTermMarksByStudentSubject as $key => $totalMarks) {
            $parts = explode('_', $key);
            $studentId = $parts[0];
            $subjectId = $parts[1];

            if (!isset($subjectTotalsSecond[$subjectId])) {
                $subjectTotalsSecond[$subjectId] = [];
            }
            $subjectTotalsSecond[$subjectId][] = ['marks' => $totalMarks, 'student_id' => $studentId];
        }

        foreach ($subjectTotalsSecond as $subjectId => $totals) {
            // Find the entry with the highest marks
            $maxEntry = null;
            foreach ($totals as $entry) {
                if (!$maxEntry || $entry['marks'] > $maxEntry['marks']) {
                    $maxEntry = $entry;
                }
            }
            if ($maxEntry) {
                $highestSecondTermMarksBySubject[$subjectId] = $maxEntry['marks'];
                $highestSecondTermRollNosBySubject[$subjectId] = $studentRollNumbers[$maxEntry['student_id']] ?? 'N/A';
            }
        }

        $data = [
            'school' => $school,
            'activeClass' => $activeClass,
            'student' => $student,
            'examDetailsGrouped' => $examDetailsGrouped,
            'classSubjects' => $classSubjects,
            'examClassSubjectMap' => $examClassSubjectMap,
            'marksData' => $marksData,
            'highestFirstTermMarksBySubject' => $highestFirstTermMarksBySubject,
            'highestSecondTermMarksBySubject' => $highestSecondTermMarksBySubject,
            'highestFirstTermRollNosBySubject' => $highestFirstTermRollNosBySubject,
            'highestSecondTermRollNosBySubject' => $highestSecondTermRollNosBySubject,
        ];
        $config = [
            'format' => 'A4-L' // 'A4-L' for landscape, 'A4-P' for portrait
        ];

        $pdf = \PDF::loadView('exports.exam20-student-mark-sheet-pdf', $data, [], $config);
        return $pdf->stream('StudentMarkSheet-' . \Illuminate\Support\Str::slug($student->studentdb->name ?? 'student') . '.pdf');
    }
}
