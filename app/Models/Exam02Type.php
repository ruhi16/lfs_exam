<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam02Type extends Model
{
    use HasFactory;
    
    protected $table = 'exam02_types';
    protected $guarded = ['id'];
    
    public function examDetails(){
        return $this->hasMany(Exam05Detail::class, 'exam_type_id', 'id');
    }


    public function examGrades(){
        return $this->hasMany(Exam08Grade::class, 'exam_type_id', 'id');
        // exam_type_id is the 'foreign key' in the exam_grades table
        // id is the 'primary key' in the exam_types table
    }
}
