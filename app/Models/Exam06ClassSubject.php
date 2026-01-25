<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam06ClassSubject extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    // protected $fillable = [
    //     'name',
    //     'description',
    //     'exam_detail_id',
    //     'myclass_id',
    //     'subject_id',
    //     'exam_name_id',
    //     'exam_type_id',
    //     'exam_part_id',
    //     'full_marks',
    //     'pass_marks',
    //     'time_in_minutes',
    //     'is_additional',
    //     'is_combined',
    //     'order_index',
    //     'is_optional',
    //     'exam_weightage',
    //     'session_id',
    //     'school_id',
    //     'user_id',
    //     'approved_by',
    //     'is_active',
    //     'is_finalized',
    //     'status',
    //     'remarks'
    // ];
    
    protected $casts = [
        'is_additional' => 'boolean',
        'is_combined' => 'boolean',
        'is_optional' => 'boolean',
        'is_active' => 'boolean',
        'is_finalized' => 'boolean',
        'full_marks' => 'integer',
        'pass_marks' => 'integer',
        'time_in_minutes' => 'integer',
        'order_index' => 'integer',
        'exam_weightage' => 'integer',
    ];
    
    // Relationships
    public function myclass()
    {
        return $this->belongsTo(Myclass::class, 'myclass_id');
    }
    
    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
    
    public function examDetail()
    {
        return $this->belongsTo(\App\Models\Exam05Detail::class, 'exam_detail_id');
    }
    
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    
    public function approvedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by');
    }
}