<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Myclass extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    // protected $fillable = [
    //     'name',
    //     'description',
    //     'order_index',
    //     'school_id',
    //     'session_id',
    //     'user_id',
    //     'approved_by',
    //     'is_active',
    //     'is_finalized',
    //     'status',
    //     'remarks'
    // ];
    
    protected $casts = [
        'is_active' => 'boolean',
        'is_finalized' => 'boolean',
        'order_index' => 'integer',
    ];

    public function studentdb(){
        return $this->hasMany(Studentdb::class, 'myclass_id', 'id');
        // 'myclass_id' is the foreign key in the 'studentdbs' tablet
        // 'id' is the primary key in the 'myclasses' table
    }

    public function studentcrs(){
        return $this->hasMany(Studentcr::class,'myclass_id','id');
        // 'myclass_id' is the foreign key in the 'studentcrs' tablet
        // 'id' is the primary key in the 'myclasses' table
    }

    public function myclass_sections(){
        return $this->hasMany(MyclassSection::class,'myclass_id','id');
        // 'myclass_id' is the foreign key in the 'myclass_sections' tablet
        // 'id' is the primary key in the 'myclasses' table
    }   


    // public function feeStruectures(){
    //     return $this->hasMany(FeeStructure::class,'myclass_id','id');
    //     // 'myclass_id' is the foreign key in the 'fee_structures' tablet
    //     // 'id' is the primary key in the 'myclasses' table
    // }

    // public function mandates(){
    //     return $this->hasMany(FeeMandate::class,'myclass_id','id');
    //     // 'myclass_id' is the foreign key in the 'fee_mandates' tablet
    //     // 'id' is the primary key in the 'myclasses' table
    // }

    public function examDetails(){
        return $this->hasMany(Exam05Detail::class,'myclass_id','id');
        // 'myclass_id' is the foreign key in the 'exam05_details' table
        // 'id' is the primary key in the 'myclasses' table
    }

    public function myclassSubjects(){
        return $this->hasMany(MyclassSubject::class,'myclass_id','id');
        // 'myclass_id' is the foreign key in the 'myclass_subjects' table
        // 'id' is the primary key in the 'myclasses' table
    }

}
