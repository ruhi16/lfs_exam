<?php

use App\Http\Controllers\ExamController;
use App\Http\Controllers\GoogleAuthController;
use App\Http\Controllers\StudentdbController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Livewire\Contact;
use App\Http\Livewire\Home;
use App\Http\Livewire\About;
use App\Http\Livewire\AdminStudentIdCardComp;
use App\Http\Livewire\SubadminMarksEntryComponent;
use App\Http\Livewire\SubadminMarksEntryEntityComponent;
use App\Http\Livewire\UserDashboardContainerComp;
use Illuminate\Support\Facades\Artisan;






Route::get('/dashboard', function () {
    if (Auth::user() && Auth::user()->role_id == 5) {
        return redirect(route('supAdminDash'));
    }

    if (Auth::user() && Auth::user()->role_id == 4) {
        return redirect(route('adminDash'));
    }

    if (Auth::user() && Auth::user()->role_id == 3) {
        return redirect(route('officeDash'));
    }

    if (Auth::user() && Auth::user()->role_id == 2) {
        return redirect(route('subAdminDash'));
    }

    if (Auth::user() && Auth::user()->role_id == 1) {
        return redirect(route('userDash'));
    }

    if (Auth::user()) {
        // Any other authenticated users (including those with role_id = 0)
        return redirect(route('userDash'));
    }

    // return view('dashboard');
})->middleware(['auth'])
    //   ->middleware(['auth', 'verified'])
    ->name('dashboard');




Route::group(
    ['prefix' => 'sup-admin', 'middleware' => ['web', 'auth', 'isSuperAdmin']],
    function () {
        Route::get('/dashboard', [
            App\Http\Controllers\SuperAdminController::class,
            'dashboard',
        ])->name('supAdminDash');
    }
);

Route::group(
    ['prefix' => 'admin', 'middleware' => ['web', 'auth', 'isAdmin']],
    function () {
        Route::get('/dashboard', [App\Http\Controllers\AdminController::class, 'dashboard'])
            ->name('adminDash');

        Route::get(
            '/marks-entry/{exam_detail_id}/{myclass_section_id}/{myclass_subject_id}',
            [App\Http\Controllers\AdminController::class, 'marksEntry']
        )
            ->name('marksEntryOld');

        Route::get('/marks-entry', [App\Http\Controllers\AdminController::class, 'marksEntry'])
            ->name('marksEntry');
    }
);


Route::group(
    ['prefix' => 'office', 'middleware' => ['web', 'isOffice']],
    function () {
        Route::get('/dashboard', [App\Http\Controllers\OfficeController::class, 'dashboard'])
            ->name('officeDash');
    }
);

Route::group(
    ['prefix' => 'sub-admin', 'middleware' => ['web', 'isSubAdmin']],
    function () {
        Route::get('/dashboard', [App\Http\Controllers\SubAdminController::class, 'dashboard'])
            ->name('subAdminDash');

        Route::get('/marks-entry', \App\Http\Livewire\Subadmin10MarksEntryComp::class)
            ->name('subadmin.marks-entry');

        Route::get('/marks-entry/form/{distributionId}', \App\Http\Livewire\Subadmin10MarksEntryFormComp::class)
            ->name('subadmin.marks-entry.form');
    }
);

Route::group(
    ['prefix' => 'user', 'middleware' => ['web', 'isUser']],
    function () {
        // Route::get('/dashboard', [App\Http\Controllers\UserController::class, 'dashboard'])
        // Route::get('/dashboard', function () {
        // return view('user-dashboard');
        // return view('components.user-dashboard');
        // return view('livewire.user-dashboard-container-comp');
        // return view('livewire.user-dc-wall-comp');
        // })->name('userDash');    
        Route::get('/dashboard', UserDashboardContainerComp::class)
            ->name('userDash');

        Route::get('/profile', function () {
            return view('user-profile');
        })->name('user.profile');
    }
);




Route::get('/', function () {
    return view('welcome');
});

// Test route for Exam12ExamMarkRegisterComp
Route::get('/test-exam-register', function () {
    return view('test-exam-register');
});

// Test route for Home component (main menu)
Route::get('/test-home-menu', function () {
    return view('test-home-menu');
});

// Test route for Exam06ExamMyclassSubjectComp
Route::get('/test-exam-class-subject', function () {
    return view('test-exam-class-subject');
});

// Debug test route
Route::get('/test-livewire-debug', function () {
    return view('test-livewire-debug');
});

// Simple test route
Route::get('/test-simple-component', function () {
    return view('test-simple-component');
});

// Include test routes
// require __DIR__ . '/test.php';


// Exam Marks PDF Route
Route::get('/exam-marks/pdf/{classId}', [App\Http\Controllers\ExamMarksPdfController::class, 'downloadMarksPdf'])
    ->name('exam.exam12-exam-marks-register-pdf.pdf');

// Student Mark Sheet PDF Route (individual)
Route::get('/student-mark-sheet/pdf/{studentId}', [App\Http\Controllers\ExamMarksPdfController::class, 'downloadStudentMarksheetPdf'])
    ->name('exam.student-marksheet-pdf');

// Annual Mark Sheet PDF Route (individual)
Route::get('/annual-marks-sheet/pdf/{studentId}', [App\Http\Controllers\ExamMarksPdfController::class, 'downloadAnnualMarksheetPdf'])
    ->name('exam.annual-marksheet-pdf');



// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'php' => PHP_VERSION,
        'laravel' => app()->version(),
        'time' => now()->toIso8601String(),
    ]);
});
require __DIR__ . '/auth.php';
