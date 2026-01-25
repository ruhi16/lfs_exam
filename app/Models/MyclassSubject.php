<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyclassSubject extends Model
{
    use HasFactory;

    protected $table = "myclass_subjects";
    protected $guarded = ['id'];

    // protected $fillable = [
    //     'name',
    //     'description',
    //     'order_index',
    //     'is_optional',
    //     'myclass_id',
    //     'subject_id',
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
        'order_index' => 'integer',
    ];

    // Relationships
    public function myclass()
    {
        return $this->belongsTo(\App\Models\Myclass::class, 'myclass_id', 'id');
    }

    public function subject()
    {
        return $this->belongsTo(\App\Models\Subject::class, 'subject_id', 'id');
    }


    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(\App\Models\User::class, 'approved_by', 'id');
    }
}
