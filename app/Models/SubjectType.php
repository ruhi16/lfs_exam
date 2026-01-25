<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectType extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function subjects(){
        return $this->hasMany(\App\Models\Subject::class, 'subject_type_id', 'id');
    }

}
