<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Cleaning Up Database Inconsistencies ===\n";

$fixed = 0;
            
// Step 1: Find teachers with invalid user_id assignments
$teachersWithInvalidUsers = App\Models\Teacher::whereNotIn('user_id', function($query) {
    $query->select('id')->from('users')->where('id', '>', 0);
})->where('user_id', '>', 0)->get();

foreach($teachersWithInvalidUsers as $teacher) {
    echo "Clearing invalid user_id for teacher {$teacher->id} ({$teacher->name})\n";
    $teacher->user_id = 0;
    $teacher->save();
    $fixed++;
}

// Step 2: Find users with invalid teacher_id assignments
$usersWithInvalidTeachers = App\Models\User::whereNotIn('teacher_id', function($query) {
    $query->select('id')->from('teachers')->where('id', '>', 0);
})->where('teacher_id', '>', 0)->get();

foreach($usersWithInvalidTeachers as $user) {
    echo "Clearing invalid teacher_id for user {$user->id} ({$user->name})\n";
    $user->teacher_id = 0;
    $user->save();
    $fixed++;
}

// Step 3: Fix bidirectional inconsistencies
$users = App\Models\User::where('teacher_id', '>', 0)->get();
foreach($users as $user) {
    $teacher = App\Models\Teacher::find($user->teacher_id);
    if($teacher && $teacher->user_id != $user->id) {
        // Clear conflicts first
        if($teacher->user_id > 0) {
            $conflictUser = App\Models\User::find($teacher->user_id);
            if($conflictUser && $conflictUser->id != $user->id) {
                echo "Clearing conflicting assignment for user {$conflictUser->id} ({$conflictUser->name})\n";
                $conflictUser->teacher_id = 0;
                $conflictUser->save();
            }
        }
        
        echo "Fixing bidirectional link: User {$user->id} ({$user->name}) <-> Teacher {$teacher->id} ({$teacher->name})\n";
        $teacher->user_id = $user->id;
        $teacher->save();
        $fixed++;
    }
}

echo "\nCleanup completed! Fixed {$fixed} inconsistencies.\n";

// Show the result
echo "\n=== After Cleanup - Bidirectional Relationship Check ===\n";
$users = App\Models\User::where('teacher_id', '>', 0)->get();
foreach($users as $u) {
    $teacher = App\Models\Teacher::find($u->teacher_id);
    if($teacher) {
        $bidirectional = ($teacher->user_id == $u->id) ? 'OK' : 'BROKEN';
        echo "User {$u->id} ({$u->name}) -> Teacher {$u->teacher_id} ({$teacher->name}): {$bidirectional}\n";
    } else {
        echo "User {$u->id} ({$u->name}) -> Teacher {$u->teacher_id}: INVALID (Teacher not found)\n";
    }
}

echo "\n=== Available Teachers After Cleanup ===\n";
$availableTeachers = App\Models\Teacher::query()
    ->where(function ($q) {
        $q->where('user_id', '<=', 0)
          ->orWhereNull('user_id')
          ->orWhereNotIn('user_id', function ($subQuery) {
              $subQuery->select('id')
                  ->from('users')
                  ->whereColumn('users.teacher_id', 'teachers.id');
          });
    })
    ->where(function ($q) {
        $q->where('status', 'active')
          ->orWhereNull('status')
          ->orWhere('status', '')
          ->orWhere('status', 'Active');
    })
    ->orderBy('name')
    ->get();

$availableCount = 0;
foreach($availableTeachers as $t) {
    $userWithThisTeacher = App\Models\User::where('teacher_id', $t->id)->first();
    if (!$userWithThisTeacher) {
        $availableCount++;
        echo "Available: ID {$t->id} - {$t->name} (user_id: {$t->user_id})\n";
    }
}

echo "\nTotal truly available teachers: {$availableCount}\n";