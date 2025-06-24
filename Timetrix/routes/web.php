<?php

use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\Auth\VerifyEmailController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\OtpController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuditController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\ReportController;

// Public welcome page
Route::get('/', fn() => view('welcome'));

// -----------------------------------------------------------------------
// Custom Login + OTP (retain manually)
// -----------------------------------------------------------------------
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login', [LoginController::class, 'login']);
Route::get('otp', [OtpController::class, 'showOtpForm'])->name('otp.form');
Route::post('otp', [OtpController::class, 'verifyOtp'])->name('otp.verify');
Route::post('/otp/resend', [OtpController::class, 'resendOtp'])->name('otp.resend');

// Notice (requires temporary guard)
Route::middleware('auth:temporary')->get('/email/verify', fn() => view('auth.verify-email'))
    ->name('verification.notice');

// Handle verification link
Route::middleware(['signed','throttle:6,1'])
    ->get('/email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])
    ->name('verification.verify');

// Resend verification link
Route::middleware(['auth:temporary','throttle:6,1'])
    ->post('/email/verification-notification', [VerificationController::class, 'resend'])
    ->name('verification.send');

// Static confirmation pages
Route::view('/email/already-verified', 'auth.verification-already')->name('verification.already');
Route::view('/email/verified-success',  'auth.verification-success')->name('verification.success');
// -----------------------------------------------------------------------
// Laravel Built-in Auth (excluding login)
// -----------------------------------------------------------------------
Auth::routes([
    'login'  => false, // We're handling login/OTP manually
    'verify' => true,  // Enable email verification
]);

// -----------------------------------------------------------------------
// Dashboard & Profile (requires full auth + verified email)
// -----------------------------------------------------------------------
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile',[ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile',[ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/validate-password', [ProfileController::class, 'validatePassword'])->name('profile.validatePassword');
});

// -----------------------------------------------------------------------
// Core Resources (requires auth)
// -----------------------------------------------------------------------
Route::middleware('auth')->group(function () {
    Route::resources([
        'departments'  => DepartmentController::class,
        'courses'      => CourseController::class,
        'instructors'  => InstructorController::class,
        'classrooms'   => ClassroomController::class,
        'timetables'   => TimetableController::class,
        'faculties'    => FacultyController::class,
        'institution'  => InstitutionController::class,
        'audits'       => AuditController::class,
        'users'        => UserController::class,
    ]);

    // Timetable extras
    Route::get('/timetable',           [TimetableController::class, 'index'])->name('timetable.index');
    Route::get('/timetable/view',      [TimetableController::class, 'view'])->name('timetable.view');
    Route::get('/timetable/generate',  [TimetableController::class, 'generate'])->name('timetable.generate');
    Route::post('/timetable/update',   [TimetableController::class, 'update'])->name('timetable.update');
    Route::get('/timetable/manual',    [TimetableController::class, 'manual'])->name('timetable.manual');
    Route::post('/timetable/manual',   [TimetableController::class, 'storeManual'])->name('timetable.storeManual');
    Route::get('/timetable/pdf',       [TimetableController::class, 'generatePDF'])->name('timetable.pdf');
    Route::get('/get-departments',     [TimetableController::class, 'getDepartments']);
    Route::get('/instructors-by-department/{department_id}', [CourseController::class, 'getInstructorsByDepartment']);
});

// -----------------------------------------------------------------------
// Academic Reports
// -----------------------------------------------------------------------
Route::middleware('auth')->prefix('reports/academic')->name('reports.academic.')->group(function () {
    Route::view('/', 'reports.academic')->name('index');

    Route::get('instructor-workload',       [ReportController::class, 'instructorWorkload'])->name('instructorWorkload');
    Route::get('instructor-workload/pdf',   [ReportController::class, 'instructorWorkloadPdf'])->name('instructorWorkload.pdf');

    Route::get('course-offering-summary',     [ReportController::class, 'courseOfferingSummary'])->name('courseOfferingSummary');
    Route::get('course-offering-summary/pdf', [ReportController::class, 'courseOfferingSummaryPdf'])->name('courseOfferingSummaryPdf');

    Route::get('enrollment-summary',       [ReportController::class, 'enrollmentSummary'])->name('enrollmentSummary');
    Route::get('enrollment-summary/pdf',   [ReportController::class, 'enrollmentSummaryPdf'])->name('enrollmentSummaryPdf');

    Route::get('instructor-timetable',     [ReportController::class, 'instructorTimetable'])->name('instructorTimetable');
    Route::get('instructor-timetable/pdf', [ReportController::class, 'instructorTimetablePdf'])->name('instructorTimetable.pdf');
});
require __DIR__.'/auth.php';
