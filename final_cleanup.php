<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Final Cleanup - Clear Orphaned user_id References ===\n";

// Clear teachers that have user_id pointing to users who don't point back
$orphanedTeachers = App\Models\Teacher::where('user_id', '>', 0)
    ->whereNotIn('id', function($query) {
        $query->select('teacher_id')
            ->from('users')
            ->where('teacher_id', '>', 0);
    })
    ->get();

$fixed = 0;
foreach($orphanedTeachers as $teacher) {
    echo "Clearing orphaned user_id {$teacher->user_id} from teacher {$teacher->id} ({$teacher->name})\n";
    $teacher->user_id = 0;
    $teacher->save();
    $fixed++;
}

echo "\nCleared {$fixed} orphaned user_id references.\n";

// Now test assignment
echo "\n=== Testing Teacher Assignment ===\n";
$userId = 1; // User
$teacherId = 7; // Barnali Bahalia (should be available now)

$user = App\Models\User::find($userId);
$teacher = App\Models\Teacher::find($teacherId);

echo "Before assignment:\n";
echo "User {$userId} ({$user->name}) teacher_id: {$user->teacher_id}\n";
echo "Teacher {$teacherId} ({$teacher->name}) user_id: {$teacher->user_id}\n";

// Since User 1 already has teacher_id: 5, let's revoke it first
if ($user->teacher_id > 0) {
    $prevTeacher = App\Models\Teacher::find($user->teacher_id);
    if ($prevTeacher) {
        $prevTeacher->user_id = 0;
        $prevTeacher->save();
        echo "Cleared previous teacher assignment: Teacher ID {$prevTeacher->id}\n";
    }
}

// Now assign the new teacher
$user->teacher_id = $teacherId;
$user->save();

$teacher->user_id = $userId;
$teacher->save();

echo "\nAfter assignment:\n";
echo "User {$userId} ({$user->name}) teacher_id: {$user->teacher_id}\n";
echo "Teacher {$teacherId} ({$teacher->name}) user_id: {$teacher->user_id}\n";

echo "\nSUCCESS: Teacher assignment completed!\n";

// Show final available teachers
echo "\n=== Final Available Teachers ===\n";
$availableTeachers = App\Models\Teacher::query()
    ->where(function ($q) {
        $q->where('user_id', '<=', 0)
          ->orWhereNull('user_id');
    })
    ->whereNotIn('id', function ($subQuery) {
        $subQuery->select('teacher_id')
            ->from('users')
            ->where('teacher_id', '>', 0);
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
    $availableCount++;
    echo "Available: ID {$t->id} - {$t->name} (user_id: {$t->user_id})\n";
}

echo "\nTotal available teachers: {$availableCount}\n";