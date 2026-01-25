<?php

namespace App\Services;

use App\Models\Exam05Detail;
use App\Models\Exam06ClassSubject;
use App\Models\MyclassSubject;
use App\Models\Myclass;
use App\Models\Subject;
use App\Models\SubjectType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ExamConfigService
{
    /**
     * Get all active classes for the current user's school
     */
    public function getClassesForUser()
    {
        return Myclass::where('is_active', true)
            ->when(Auth::check() && Auth::user()->school_id, function($query) {
                return $query->where('school_id', Auth::user()->school_id);
            })
            ->orderBy('order_index')
            ->get();
    }

    /**
     * Get exam details for a specific class
     */
    public function getExamDetailsForClass($classId)
    {
        return Exam05Detail::with(['examName', 'examType', 'examPart', 'examMode'])
            ->where('myclass_id', $classId)
            ->where('is_active', true)
            ->orderBy('order_index')
            ->get();
    }

    /**
     * Get subjects for a specific class
     */
    public function getSubjectsForClass($classId)
    {
        return MyclassSubject::with(['subject.subjectType'])
            ->where('myclass_id', $classId)
            ->where('is_active', true)
            ->whereHas('subject')
            ->get();
    }

    /**
     * Get all active subject types
     */
    public function getSubjectTypes()
    {
        return SubjectType::where('is_active', true)
            ->when(Auth::check() && Auth::user()->school_id, function($query) {
                return $query->where('school_id', Auth::user()->school_id);
            })
            ->orderBy('order_index')
            ->get();
    }

    /**
     * Get saved exam class subject data for a class
     */
    public function getSavedDataForClass($classId)
    {
        return Exam06ClassSubject::where('myclass_id', $classId)
            ->get()
            ->keyBy(function ($item) {
                return $item->exam_detail_id . '_' . $item->subject_id;
            });
    }

    /**
     * Check if a subject type is enabled for a specific exam detail
     * Based on ExamType-SubjectType matching logic
     */
    public function isSubjectTypeEnabledForExam($subjectTypeId, $examDetail)
    {
        $subjectType = SubjectType::find($subjectTypeId);
        if (!$subjectType || !$examDetail->examType) {
            return false;
        }

        // Match ExamType with SubjectType by name (exact match)
        $subjectTypeName = strtolower(trim($subjectType->name));
        $examTypeName = strtolower(trim($examDetail->examType->name));
        
        return $subjectTypeName === $examTypeName;
    }

    /**
     * Save subject configuration data
     */
    public function saveSubjectConfiguration($examDetailId, $classId, $subjectId, $data)
    {
        $examDetail = Exam05Detail::find($examDetailId);
        $subject = Subject::find($subjectId);
        
        if (!$examDetail || !$subject) {
            throw new \Exception('Invalid exam detail or subject');
        }

        $saveData = [
            'name' => $examDetail->examName->name . ' - ' . $subject->name,
            'description' => 'Auto-generated from exam setting',
            'exam_detail_id' => $examDetailId,
            'myclass_id' => $classId,
            'subject_id' => $subjectId,
            'full_marks' => $data['full_marks'] ?? 0,
            'pass_marks' => $data['pass_marks'] ?? 0,
            'time_in_minutes' => $data['time_in_minutes'] ?? 0,
            'session_id' => $examDetail->session_id,
            'school_id' => $examDetail->school_id,
            'user_id' => Auth::check() ? Auth::id() : 1,
            'is_active' => true,
            'status' => 'active'
        ];

        return Exam06ClassSubject::updateOrCreate(
            [
                'exam_detail_id' => $examDetailId,
                'myclass_id' => $classId,
                'subject_id' => $subjectId
            ],
            $saveData
        );
    }

    /**
     * Delete subject configuration
     */
    public function deleteSubjectConfiguration($examDetailId, $classId, $subjectId)
    {
        return Exam06ClassSubject::where('exam_detail_id', $examDetailId)
            ->where('myclass_id', $classId)
            ->where('subject_id', $subjectId)
            ->delete();
    }

    /**
     * Check if class configuration can be finalized
     */
    public function canFinalizeClass($classId, $selectedSubjects, $fullMarks, $passMarks, $timeAllotted)
    {
        $hasAnyData = false;
        $allDataComplete = true;

        foreach ($selectedSubjects as $key => $isSelected) {
            if ($isSelected) {
                $hasAnyData = true;
                
                // Check if all required fields are filled
                if (empty($fullMarks[$key]) || 
                    empty($passMarks[$key]) || 
                    empty($timeAllotted[$key])) {
                    $allDataComplete = false;
                    break;
                }
            }
        }

        return $hasAnyData && $allDataComplete;
    }

    /**
     * Finalize class configuration
     */
    public function finalizeClassConfiguration($classId)
    {
        try {
            // Update all Exam06ClassSubject records for this class to finalized
            $updated = Exam06ClassSubject::where('myclass_id', $classId)
                ->update([
                    'is_finalized' => true,
                    'updated_at' => now()
                ]);

            Log::info("Finalized class configuration for class ID: {$classId}, Records updated: {$updated}");
            
            return $updated;
        } catch (\Exception $e) {
            Log::error('Error finalizing class configuration: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Check if class is finalized
     */
    public function isClassFinalized($classId)
    {
        return Exam06ClassSubject::where('myclass_id', $classId)
            ->where('is_finalized', true)
            ->exists();
    }

    /**
     * Get subjects by subject type
     */
    public function getSubjectsByType($subjects, $subjectTypeId)
    {
        return $subjects->filter(function ($myclassSubject) use ($subjectTypeId) {
            return $myclassSubject->subject && 
                   $myclassSubject->subject->subject_type_id == $subjectTypeId;
        });
    }

    /**
     * Get exam details filtered by subject type
     */
    public function getExamDetailsBySubjectType($examDetails, $subjectTypeId)
    {
        $subjectType = SubjectType::find($subjectTypeId);
        if (!$subjectType) {
            return collect();
        }

        return $examDetails->filter(function ($examDetail) use ($subjectType) {
            return $examDetail->examType && 
                   (strtolower($examDetail->examType->name) === strtolower($subjectType->name) ||
                    $examDetail->exam_type_id == $subjectType->id);
        });
    }
}