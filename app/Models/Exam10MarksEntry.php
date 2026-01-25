<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam10MarksEntry extends Model
{
    use HasFactory;

    protected $table = 'exam10_marks_entries';
    protected $guarded = ['id'];

    protected $casts = [
        'exam_marks' => 'decimal:2',
        'is_active' => 'boolean',
        'is_finalized' => 'boolean',
        'is_absent' => 'boolean',
    ];

    // Relationships
    public function examDetail()
    {
        return $this->belongsTo(Exam05Detail::class, 'exam_detail_id');
    }

    public function examClassSubject()
    {
        return $this->belongsTo(Exam06ClassSubject::class, 'exam_class_subject_id');
    }

    public function myclassSection()
    {
        return $this->belongsTo(MyclassSection::class, 'myclass_section_id');
    }

    public function studentcr()
    {
        return $this->belongsTo(Studentcr::class, 'studentcr_id');
    }

    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function grade()
    {
        return $this->belongsTo(Exam08Grade::class, 'grade_id');
    }

    // Helper methods
    public function isAbsent()
    {
        return $this->exam_marks < 0 || $this->status === 'absent' || $this->is_absent;
    }

    public function getDisplayMarks()
    {
        if ($this->isAbsent()) {
            return 'AB';
        }
        return $this->exam_marks;
    }
}