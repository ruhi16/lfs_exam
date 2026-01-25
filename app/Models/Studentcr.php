<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Studentcr extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function studentdb()
    {
        return $this->belongsTo(Studentdb::class, 'studentdb_id', 'id');
        // 'studentdb_id' is the foreign key in the 'studentcrs' tablet
        // 'id' is the primary key in the 'studentdb' table
    }


    public function myclass()
    {
        return $this->belongsTo(Myclass::class, 'myclass_id', 'id');
        // 'myclass_id' is the foreign key in the 'studentcrs' tablet
        // 'id' is the primary key in the 'myclasses' table
    }

    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id', 'id');
        // 'section_id' is the foreign key in the 'studentcrs' tablet
        // 'id' is the primary key in the 'sections' table
    }

    public function myclassSection()
    {
        return $this->belongsTo(MyclassSection::class, 'myclass_section_id', 'id');
        // 'myclass_section_id' is the foreign key in the 'studentcrs' tablet
        // 'id' is the primary key in the 'myclasssections' table
    }
    
    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id', 'id');
        // 'session_id' is the foreign key in the 'studentcrs' table
        // 'id' is the primary key in the 'sessions' table
    }
}