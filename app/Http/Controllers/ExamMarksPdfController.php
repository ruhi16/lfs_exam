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
}
