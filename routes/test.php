<?php

use Illuminate\Support\Facades\Route;
use App\Http\Livewire\TeacherMarksEntryComp;
use App\Http\Livewire\StudentProfileComponent;
use App\Http\Livewire\SimpleStudentProfileComponent;
use App\Http\Livewire\DebugStudentProfileComponent;
use App\Http\Livewire\StudentProgressReportComp;

// ================================
// INDEX & DASHBOARD ROUTES
// ================================
// Test Index Page
Route::get('/test-index', function () {
    return view('test-index');
})->name('test.index');

// Main Test Dashboard
Route::get('/test-dashboard-main', function () {
    return view('test-dashboard', [
        'totalComponents' => 20,
        'basicComponents' => 6,
        'examComponents' => 5,
        'otherComponents' => 9
    ]);
})->name('test.dashboard.main');

// Test route for Dashboard component
Route::get('/test-dashboard', function () {
    return view('test-dashboard');
})->name('test.dashboard');

// Test route for Student Profile view
Route::get('/test-student-profile-view', function () {
    return view('test-student-profile');
})->name('test.student.profile.view');

// Test route for Authentication Test
Route::get('/test-auth', function () {
    return view('test-auth');
})->name('test.auth');

// Test route for Debug Component Test
Route::get('/debug-component-test', function () {
    return view('debug-component-test');
})->name('debug.component.test');

// ================================
// BASIC COMPONENT ROUTES
// ================================
// Test route for Session component
Route::get('/test-session', function () {
    return view('test-session');
})->name('test.session');

// Test route for Session Component
Route::get('/test-session-comp', function () {
    return view('test-session-comp');
})->name('test.session.comp');

// Test route for Myclass component
Route::get('/test-myclass', function () {
    return view('test-myclass');
})->name('test.myclass');

// Test route for Section component
Route::get('/test-section', function () {
    return view('test-section');
})->name('test.section');

// Test route for Myclass Section component
Route::get('/test-myclass-section', function () {
    return view('test-myclass-section');
})->name('test.myclass.section');

// Test route for Subject Type component
Route::get('/test-subject-type', function () {
    return view('test-subject-type');
})->name('test.subject.type');

// Test route for Subject component
Route::get('/test-subject', function () {
    return view('test-subject');
})->name('test.subject');

// Test route for Myclass Subject component
Route::get('/test-myclass-subject', function () {
    return view('test-myclass-subject');
})->name('test.myclass.subject');

// Test route for School component
Route::get('/test-school', '\\App\\Http\\Livewire\\Basic01SchoolComp')
    ->name('test.school');

// Test route for Session component
Route::get('/test-session', '\\App\\Http\\Livewire\\Basic02SessionComp')
    ->name('test.session');

// Test route for Class component
Route::get('/test-class', '\\App\\Http\\Livewire\\Basic03ClassComp')
    ->name('test.class');

// Test route for Section component
Route::get('/test-section', '\\App\\Http\\Livewire\\Basic04SectionComp')
    ->name('test.section');

// Test route for Subject component
Route::get('/test-subject', '\\App\\Http\\Livewire\\Basic06SubjectComp')
    ->name('test.subject');

// Test route for Class Section component
Route::get('/test-class-section', '\\App\\Http\\Livewire\\Basic10ClassSectionComp')
    ->name('test.class-section');

// Test route for Class Subject component
Route::get('/test-class-subject', '\\App\\Http\\Livewire\\Basic11ClassSubjectComp')
    ->name('test.class-subject');

// Test route for Teacher component
Route::get('/test-teacher', '\\App\\Http\\Livewire\\Basic07TeacherComp')
    ->name('test.teacher');

// Test route for Teacher Modal component
Route::get('/test-teacher-modal', function () {
    return view('test-teacher-modal');
})->name('test.teacher.modal');

// Test route for Teacher Modal component
Route::get('/test-teacher-modal', function () {
    return view('test-teacher-modal');
})->name('test.teacher.modal');

// Test route for Subject Teacher component
Route::get('/test-subject-teacher', function () {
    return view('test-subject-teacher');
})->name('test.subject.teacher');

// Test route for Student Database component
Route::get('/test-student-db', function () {
    return view('test-student-db');
})->name('test.student.db');

// Test route for Student CR component
Route::get('/test-student-cr', function () {
    return view('test-student-cr');
})->name('test.student.cr');

// Test route for Student Profile component
Route::get('/test-student-profile', StudentProfileComponent::class)
    ->name('test.student.profile');
    
// Test route for Simple Student Profile component
Route::get('/simple-student-profile', SimpleStudentProfileComponent::class)
    ->name('simple.student.profile');
    
// Test route for Debug Student Profile component
Route::get('/debug-student-profile', DebugStudentProfileComponent::class)
    ->name('debug.student.profile');

// Test route for Student Progress Report component
Route::get('/test-student-progress-report', StudentProgressReportComp::class)
    ->name('test.student.progress.report');

// ================================
// EXAM CONFIGURATION ROUTES
// ================================
// Test route for Exam Setting (without auth for testing)
Route::get('/test-exam-setting', function () {
    return view('test-exam-setting');
})->name('test.exam.setting');

// Test route for Updated Exam Setting with FMPM component
Route::get('/test-updated-exam-setting', function () {
    return view('test-fmpm');
})->name('test.updated.exam.setting');

// Test route for simple FMPM component
Route::get('/test-fmpm-simple', function () {
    return view('test-fmpm-simple');
})->name('test.fmpm.simple');

// Test page for Modular Exam Setting Implementation
Route::get('/test-modular-exam-setting', function () {
    return view('test-modular-exam-setting');
})->name('test.modular.exam.setting');

// Test route for Modular Exam Setting (direct access)
Route::get('/exam-setting-modular', App\Http\Livewire\ExamSetting\ExamSettingContainer::class)
    ->name('exam.setting.modular');

// Test route for Legacy Exam Setting (direct access)
Route::get('/exam-setting-legacy', App\Http\Livewire\ExamSettingWithFmpm::class)
    ->name('exam.setting.legacy');

// Test route for Exam Setting with FMPM component (with feature flag)
Route::get('/exam-setting-fmpm', function () {
    // Feature flag for modular vs monolithic component
    $useModularExamSetting = config('app.use_modular_exam_setting', true);
    
    if ($useModularExamSetting) {
        return App\Http\Livewire\ExamSetting\ExamSettingContainer::class;
    } else {
        return App\Http\Livewire\ExamSettingWithFmpm::class;
    }
})->name('exam.setting.fmpm');

// Test route for Class Exam Subject component
Route::get('/test-class-exam-subject', function () {
    return view('test-class-exam-subject');
})->name('test.class.exam.subject');

// Test route for Subject Grouping
Route::get('/test-subject-grouping', function () {
    return view('test-subject-grouping');
})->name('test.subject.grouping');

// Test route for Class Exam Subject Finalization
Route::get('/test-class-exam-finalization', function () {
    return view('test-class-exam-finalization');
})->name('test.class.exam.finalization');

// ================================
// MARKS ENTRY ROUTES
// ================================
// Test route for Marks Entry component
Route::get('/test-marks-entry', function () {
    return view('test-marks-entry');
})->name('test.marks.entry');

// Marks Entry routes
Route::get('/marks-entry', App\Http\Livewire\MarksEntryComp::class)
    ->name('marks-entry');

Route::get('/marks-entry/detail/{examDetailId}/{subjectId}/{sectionId}', App\Http\Livewire\MarksEntryDetailComp::class)
    ->name('marks-entry.detail');

// Test route for Formative Marks Entry component
Route::get('/test-formative-marks-entry/{exam_detail_id}/{myclass_section_id}', App\Http\Livewire\MarksEntryFormativeComp::class)
    ->name('test.formative.marks.entry');

Route::get('/test-formative-marks-entry', function () {
    return view('test-formative-marks-entry');
})->name('test.formative.marks.entry.info');

// Test route for Teacher Wise Marks Entry component
Route::get('/test-teacher-wise-marks-entry', function () {
    return view('livewire.marks-entry-comp');
})->name('test-teacher-wise-marks-entry');

// Test route for Answer Script Distribution component
Route::get('/test-test', TeacherMarksEntryComp::class);

// Test route for Class Section Tasks component
Route::get('/test-class-section-tasks', App\Http\Livewire\ClassSectionTasksComp::class)->name('test.class.section.tasks');

Route::get('/test-class-section-tasks-info', function () {
    return view('test-class-section-tasks');
})->name('test.class.section.tasks.info');

// Test route for Mark Register component
Route::get('/test-mark-register', function () {
    return view('test-mark-register');
})->name('test.mark.register');

// Test route for Grades
Route::get('/test-grades', function () {
    $examDetail = \App\Models\Exam05Detail::find(1);    // only Formative
    $examTypeId = $examDetail->exam_type_id;
    $grades = \App\Models\Exam08Grade::where('exam_type_id', $examTypeId)
        ->where('is_active', true)
        ->orderBy('order_index')
        ->get();
        
    return view('test-grades', compact('grades', 'examDetail', 'examTypeId'));
})->name('test.grades');

// ================================
// TASK FINALIZATION ROUTES
// ================================
// Task Finalization & Lock Status route
Route::get('/task-finalize-lock-status', App\Http\Livewire\TaskFinalizeLockStatusComp::class)
    ->name('task.finalize.lock.status');

// ================================
// USER MANAGEMENT ROUTES
// ================================
// Test route for User Role component
Route::get('/test-user-role', function () {
    return view('test-user-role');
})->name('test.user.role');

// User Role Management route
Route::get('/user-role-management', App\Http\Livewire\UserRoleComp::class)
    ->name('user.role.management');

// Test route for Exam Setting View component
Route::get('/test-exam-setting-view', App\Http\Livewire\ExamSettingsView::class)
    ->name('test.exam.setting.view');

// Test routes for Exam Detail and Marks Entry components
Route::get('/test-exam-detail', App\Http\Livewire\Exam05DetailComp::class)
    ->name('test.exam.detail');
    
Route::get('/test-marks-entry-management', App\Http\Livewire\Exam10MarksEntryComp::class)
    ->name('test.marks.entry.management');

// ================================
// UTILITY & MISC ROUTES
// ================================
// Test route for Logs Viewer component
Route::get('/test-logs-viewer', function () {
    return view('test-logs-viewer');
})->name('test.logs.viewer');

// Simple Modal Test
Route::get('/test-modal-simple', function () {
    return view('test-modal-simple');
})->name('test.modal.simple');