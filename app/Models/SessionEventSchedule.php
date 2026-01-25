<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionEventSchedule extends Model
{
    use HasFactory;

    protected $guarded = ['id'];


    public function sessionEnvent(){
        return $this->belongsTo(SessionEvent::class, 'session_event_id', 'id');
        // 'session_event_id' is the foreign key of the 'session_event_schedules' table
        // 'id' is the primary key of the 'session_events' table
    }
}
