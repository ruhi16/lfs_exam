<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "=== Testing Teacher Assignment Logic ===\n";

// Test 1: Try to assign an available teacher to a user
$userId = 1; // User
$teacherId = 7; // Barnali Bahalia (should be available)

echo "\nTest 1: Assign Teacher {$teacherId} to User {$userId}\n";

$user = App\Models\User::find($userId);
$teacher = App\Models\Teacher::find($teacherId);

echo "Before assignment:\n";
echo "User {$userId} teacher_id: {$user->teacher_id}\n";
echo "Teacher {$teacherId} user_id: {$teacher->user_id}\n";

// Simulate the assignment logic from UserRoleComp::assignTeacher()
try {
    // Check if teacher is already assigned to another user
    if ($teacher->user_id > 0 && $teacher->user_id != $userId) {
        $assignedUser = App\Models\User::find($teacher->user_id);
        $assignedUserName = $assignedUser ? $assignedUser->name : 'Unknown User';
        echo "ERROR: Selected teacher is already assigned to {$assignedUserName} (ID: {$teacher->user_id}).\n";
    } else {
        // Check if another user has this teacher_id assigned
        $existingUserWithTeacher = App\Models\User::where('teacher_id', $teacherId)
            ->where('id', '!=', $userId)
            ->first();
        
        if ($existingUserWithTeacher) {
            echo "ERROR: Selected teacher is already assigned to {$existingUserWithTeacher->name} (User ID: {$existingUserWithTeacher->id}).\n";
        } else {
            // If user already has a teacher, clear the previous assignment
            if ($user->teacher_id > 0 && $user->teacher_id != $teacherId) {
                $prevTeacher = App\Models\Teacher::find($user->teacher_id);
                if ($prevTeacher) {
                    $prevTeacher->user_id = 0;
                    $prevTeacher->save();
                    echo "Cleared previous teacher assignment: Teacher ID {$prevTeacher->id}\n";
                }
            }

            // Update both sides of the relationship
            $user->teacher_id = $teacherId;
            $user->save();
            echo "Updated user {$userId} teacher_id to {$teacherId}\n";

            $teacher->user_id = $userId;
            $teacher->save();
            echo "Updated teacher {$teacherId} user_id to {$userId}\n";

            echo "SUCCESS: Teacher '{$teacher->name}' successfully assigned to user '{$user->name}'.\n";
        }
    }
} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}

// Reload and check the result
$user = App\Models\User::find($userId);
$teacher = App\Models\Teacher::find($teacherId);

echo "\nAfter assignment:\n";
echo "User {$userId} teacher_id: {$user->teacher_id}\n";
echo "Teacher {$teacherId} user_id: {$teacher->user_id}\n";

// Test available teachers count
echo "\n=== Available Teachers After Assignment ===\n";
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
        echo "Available: ID {$t->id} - {$t->name}\n";
    }
}

echo "\nTotal truly available teachers: {$availableCount}\n";