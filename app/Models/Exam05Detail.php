<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam05Detail extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    
    
    // protected $fillable = [
    //     'name',
    //     'description',
    //     'myclass_id',
    //     'exam_name_id',
    //     'exam_type_id',
    //     'exam_part_id',
    //     'exam_mode_id',
    //     'order_index',
    //     'is_optional',
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
        'is_optional' => 'boolean',
        'is_active' => 'boolean',
        'is_finalized' => 'boolean',
    ];
    
    // Relationships
    public function myclass()
    {
        return $this->belongsTo(\App\Models\Myclass::class, 'myclass_id');
    }
    
    public function examName()
    {
        return $this->belongsTo(\App\Models\Exam01Name::class, 'exam_name_id');
    }
    
    public function examType()
    {
        return $this->belongsTo(\App\Models\Exam02Type::class, 'exam_type_id');
    }
    
    public function examPart()
    {
        return $this->belongsTo(\App\Models\Exam03Part::class, 'exam_part_id');
    }
    
    public function examMode()
    {
        return $this->belongsTo(\App\Models\Exam04Mode::class, 'exam_mode_id');
    }

    // public function myclassSection(){
    //     return $this->belongsTo(\App\Models\MyclassSection::class, 'myclass_section_id');
    // }

    public function session()
    {
        return $this->belongsTo(\App\Models\Session::class, 'session_id');
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
