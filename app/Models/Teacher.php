<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    // protected $fillable = [
    //     'name',
    //     'nickName',
    //     'mobno',
    //     'desig',
    //     'hqual',
    //     'train_qual',
    //     'extra_qual',
    //     'main_subject_id',
    //     'notes',
    //     'img_ref',
    //     'status',
    //     'remark',
    //     'user_id',
    //     'session_id',
    //     'school_id',
    //     'prev_session_pk'
    // ];





    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
        // 'user_id' is the foreign key in the Teacher model
        // 'id' is the primary key in the User model
    }

    // public function Myclassteachers()
    // {
    //     return $this->hasMany(MyclassSectionteacher::class, 'teacher_id', 'id');
    //     // 'teacher_id' is the foreign key in the Myclassteacher table
    //     // 'id' is the primary key in the Teacher table
    // }


    public function getAnswerScripts()
    {
        return $this->hasMany(Exam07AnsscrDist::class, 'teacher_id', 'id');
        // 'teacher_id' is the foreign key in the Answerscriptdistribution table
        // 'id' is the primary key in the Teacher table
    }


    public function subject()
    {
        return $this->belongsTo(Subject::class, 'main_subject_id', 'id');
        // 'subject_id' is the foreign key in the Teacher table
        // 'id' is the primary key in the Subject table
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class, 'subject_teacher')
            ->withPivot(['is_primary', 'status', 'notes'])
            ->withTimestamps();
    }

    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id', 'id');
    }

    public function school()
    {
        return $this->belongsTo(School::class, 'school_id', 'id');
    }
}
