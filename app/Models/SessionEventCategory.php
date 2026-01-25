<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionEventCategory extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    // protected $table = 'session';

    public function session(){
        return $this->belongsTo(Session::class, 'session_id', 'id');
        // 'session_id' is the foreign key of the 'session_event_categories' table
        // 'id' is the primary key of the 'sessions' table
    }

    public function sessionEvents(){
        return $this->hasMany(SessionEvent::class, 'session_event_category_id', 'id');
        // 'session_event_category_id' is the foreign key of the 'session_events' table
        // 'id' is the primary key of the 'session_event_categories' table
    }

}
