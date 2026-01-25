<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MyclassSection extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    protected $table = 'myclass_sections';


    public function section(){
        return $this->belongsTo(Section::class, 'section_id', 'id');
        // 'section_id' is the foreign key in the 'myclass_sections' tablet
        // 'id' is the primary key in the 'sections' table
    }

    public function myclass(){
        return $this->belongsTo(Myclass::class, 'myclass_id', 'id');
        // 'myclass_id' is the foreign key in the 'myclass_sections' tablet
        // 'id' is the primary key in the 'myclasses' table
    }

    public function teacher(){
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id');
        // 'teacher_id' is the foreign key in the 'myclass_sections' table
        // 'id' is the primary key in the 'teachers' table
    }

}