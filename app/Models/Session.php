<?php

namespace App\Models;

use App\Models\School;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    protected $casts = [
        'stdate' => 'date',
        'entdate' => 'date',
    ];

    // protected $fillable = [
    //     'name',
    //     'details',
    //     'stdate',
    //     'entdate',
    //     'status',
    //     'remark',
    //     'prev_session_id',
    //     'next_session_id',
    //     'school_id'
    // ];
    private static $table_type = "Basic";


    public function scopeCurrentlyActive($query)
    {
        return $query->where('status', 'active');
    }


    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'id');
    }



    public function myclasses()
    {
        return $this->hasMany(Myclass::class, 'session_id', 'id');
    }

    public function sections()
    {
        return $this->hasMany(Section::class, 'session_id', 'id');
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class, 'session_id', 'id');
    }


    public function studentdbs()
    {
        return $this->hasMany(Studentdb::class, 'session_id', 'id');
    }

    public function studentcrs()
    {
        return $this->hasMany(Studentcr::class, 'session_id', 'id');
    }

    public function exams()
    {
        return $this->hasMany(Exam01Name::class, 'session_id', 'id');
    }

    public function examModes()
    {
        return $this->hasMany(Exam04Mode::class, 'session_id', 'id');
    }

    public function examTypes()
    {
        return $this->hasMany(Exam02Type::class, 'session_id', 'id');
    }

    public function examParts()
    {
        return $this->hasMany(Exam03Part::class, 'session_id', 'id');
    }

    public function examDetails()
    {
        return $this->hasMany(Exam05Detail::class, 'session_id', 'id');
    }

    public function answerScriptDistributions()
    {
        return $this->hasMany(Exam07AnsscrDist::class, 'session_id', 'id');
    }

    public function marksEntries()
    {
        return $this->hasMany(Exam10MarksEntry::class, 'session_id', 'id');
    }

    public function teachers()
    {
        return $this->hasMany(Teacher::class, 'session_id', 'id');
    }

    public function previousSession()
    {
        return $this->belongsTo(Session::class, 'prev_session_id', 'id');
    }

    public function nextSession()
    {
        return $this->belongsTo(Session::class, 'next_session_id', 'id');
    }
}
