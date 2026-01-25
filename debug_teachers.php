<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Teachers Data ===\n";
$teachers = App\Models\Teacher::all();
foreach($teachers as $t) {
    echo "ID: {$t->id}, Name: {$t->name}, user_id: {$t->user_id}, status: {$t->status}\n";
}

echo "\n=== Users with teacher_id ===\n";
$users = App\Models\User::whereNotNull('teacher_id')->where('teacher_id', '>', 0)->get();
foreach($users as $u) {
    echo "User ID: {$u->id}, Name: {$u->name}, teacher_id: {$u->teacher_id}\n";
}

echo "\n=== Bidirectional Relationship Check ===\n";
foreach($users as $u) {
    $teacher = App\Models\Teacher::find($u->teacher_id);
    if($teacher) {
        $bidirectional = ($teacher->user_id == $u->id) ? 'OK' : 'BROKEN';
        echo "User {$u->id} -> Teacher {$u->teacher_id}: {$bidirectional} (Teacher says user_id: {$teacher->user_id})\n";
    } else {
        echo "User {$u->id} -> Teacher {$u->teacher_id}: INVALID (Teacher not found)\n";
    }
}

echo "\n=== Available Teachers (using new logic) ===\n";
$availableTeachers = App\Models\Teacher::query()
    ->where(function ($q) {
        // Either no user_id assigned or invalid assignment
        $q->where('user_id', '<=', 0)
          ->orWhereNull('user_id')
          // Or assigned to a user that doesn't reciprocate the relationship
          ->orWhereNotIn('user_id', function ($subQuery) {
              $subQuery->select('id')
                  ->from('users')
                  ->whereColumn('users.teacher_id', 'teachers.id');
          });
    })
    ->where(function ($q) {
        // Only active teachers or teachers without status field
        $q->where('status', 'active')
          ->orWhereNull('status')
          ->orWhere('status', '')
          ->orWhere('status', 'Active');
    })
    ->orderBy('name')
    ->get();

foreach($availableTeachers as $t) {
    // Additional check: is this teacher already assigned to a user?
    $userWithThisTeacher = App\Models\User::where('teacher_id', $t->id)->first();
    $available = $userWithThisTeacher ? 'UNAVAILABLE' : 'AVAILABLE';
    echo "{$available}: ID: {$t->id}, Name: {$t->name}, user_id: {$t->user_id}\n";
    if($userWithThisTeacher) {
        echo "  -> Assigned to User: {$userWithThisTeacher->id} ({$userWithThisTeacher->name})\n";
    }
}