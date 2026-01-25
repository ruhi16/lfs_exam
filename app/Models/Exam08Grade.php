<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam08Grade extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function examType(){
        return $this->belongsTo(Exam02Type::class, 'exam_type_id', 'id');
        // exam_type_id is the 'foreign key' in the exam_08_grades table
        // id is the 'primary key' in the exam_types table
    }


}
