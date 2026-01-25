<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionEvent extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function sessionEventCategory(){
        return $this->belongsTo(SessionEventCategory::class, 'session_event_category_id', 'id');
        // 'session_event_category_id' is the foreign key of the 'session_events' table
        // 'id' is the primary key of the 'session_event_categories' table
    }


    public function sessionEventSchedules(){
        return $this->hasMany(SessionEventSchedule::class, 'session_event_id', 'id');
        // 'session_event_id' is the foreign key of the 'session_event_schedules' table
        // 'id' is the primary key of the 'session_events' table
    }


}
