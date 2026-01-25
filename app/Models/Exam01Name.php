<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam01Name extends Model
{
    use HasFactory;

    protected $table = 'exam01_names';
    protected $guarded = ['id'];
    
    
    // Define any relationships or additional methods here if needed
    public function sessionExam(){        
        return $this->belongsTo(Session::class, 'session_id', 'id');
        // Assuming 'session_id' is the foreign key in this model(Exam01Name)
        // and 'id' is the local key in the related model(Session)
    }

    public function examDetails(){
        return $this->hasMany(Exam05Detail::class, 'exam_name_id', 'id');
        // Assuming 'exam_name_id' is the foreign key in 
        // and 'id' is the 
    }

}
