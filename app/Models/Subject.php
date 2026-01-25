<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    // protected $fillable = [
    //     'name',
    //     'description',
    //     'code',
    //     'is_active'
    // ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Relationships
    public function myclassSubjects()
    {
        return $this->hasMany(MyclassSubject::class, 'subject_id');
    }

    public function subjectType()
    {
        return $this->belongsTo(\App\Models\SubjectType::class, 'subject_type_id', 'id');
    }

    public function teachers()
    {
        return $this->belongsToMany(Teacher::class, 'subject_teacher')
            ->withPivot(['is_primary', 'status', 'notes'])
            ->withTimestamps();
    }
}
