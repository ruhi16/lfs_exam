<?php

namespace App\Http\Controllers;

use App\Models\Marksentry;
use App\Models\Exam05Detail;
use App\Models\Exam06ClassSubject;
use App\Models\Exam10MarksEntry;
use App\Models\MyclassSection;
use App\Models\Studentcr;
use Illuminate\Http\Request;

class MarksentryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'myclass_id' => 'required|integer',
            'studentcr_id' => 'required|integer',
            'subject_id' => 'required|integer',
            'exam_marks' => 'nullable|numeric',
            'is_absent' => 'nullable|boolean',
            'myclass_section_id' => 'nullable|integer',
            'exam_detail_id' => 'nullable|integer',
            'exam_name_id' => 'nullable|integer',
            'exam_type_id' => 'nullable|integer',
            'exam_part_id' => 'nullable|integer',
        ]);

        $classId = $validated['myclass_id'];
        $studentId = $validated['studentcr_id'];
        $subjectId = $validated['subject_id'];
        $isAbsent = (bool)($validated['is_absent'] ?? false);
        $marks = $validated['exam_marks'] ?? null;

        $examDetailId = $validated['exam_detail_id'] ?? null;
        if (!$examDetailId) {
            $examNameId = $validated['exam_name_id'] ?? null;
            $examTypeId = $validated['exam_type_id'] ?? null;
            $examPartId = $validated['exam_part_id'] ?? null;
            $detail = Exam05Detail::where('myclass_id', $classId)
                ->when($examNameId, fn($q) => $q->where('exam_name_id', $examNameId))
                ->when($examTypeId, fn($q) => $q->where('exam_type_id', $examTypeId))
                ->when($examPartId, fn($q) => $q->where('exam_part_id', $examPartId))
                ->first();
            if (!$detail) {
                return response()->json(['error' => 'Invalid exam detail'], 422);
            }
            $examDetailId = $detail->id;
        }

        $ecs = Exam06ClassSubject::where('myclass_id', $classId)
            ->where('subject_id', $subjectId)
            ->where('exam_detail_id', $examDetailId)
            ->first();
        if (!$ecs) {
            return response()->json(['error' => 'Invalid subject mapping for exam detail'], 422);
        }

        $myclassSectionId = $validated['myclass_section_id'] ?? null;
        if (!$myclassSectionId) {
            $student = Studentcr::find($studentId);
            if (!$student) {
                return response()->json(['error' => 'Invalid student'], 422);
            }
            $section = MyclassSection::where('myclass_id', $classId)
                ->where('section_id', $student->section_id)
                ->first();
            if (!$section) {
                return response()->json(['error' => 'Invalid class section'], 422);
            }
            $myclassSectionId = $section->id;
        }

        $record = Exam10MarksEntry::updateOrCreate(
            [
                'myclass_section_id' => $myclassSectionId,
                'studentcr_id' => $studentId,
                'exam_class_subject_id' => $ecs->id,
                'exam_detail_id' => $examDetailId,
            ],
            [
                'exam_marks' => $isAbsent ? null : $marks,
                'is_absent' => $isAbsent,
                'session_id' => session('session_id') ?? null,
                'user_id' => auth()->id() ?? null,
                'is_active' => true,
                'status' => 'active',
            ]
        );

        return response()->json(['id' => $record->id, 'message' => 'Saved']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Marksentry  $marksentry
     * @return \Illuminate\Http\Response
     */
    public function show(Marksentry $marksentry)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marksentry  $marksentry
     * @return \Illuminate\Http\Response
     */
    public function edit(Marksentry $marksentry)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Marksentry  $marksentry
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marksentry $marksentry)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Marksentry  $marksentry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marksentry $marksentry)
    {
        //
    }
}
