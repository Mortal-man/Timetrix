<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\FacultyController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::resource('departments', DepartmentController::class);
Route::resource('courses', CourseController::class);
Route::resource('instructors', InstructorController::class);
Route::resource('classrooms', ClassroomController::class);
Route::resource('schedules', ScheduleController::class);
Route::resource('timetables', TimetableController::class);
Route::resource('faculties', FacultyController::class);

Route::get('/instructors-by-department/{department_id}', [CourseController::class, 'getInstructorsByDepartment']);

Route::get('/timetable/generate', [TimetableController::class, 'generate'])->name('timetable.generate');
Route::get('/timetable', [TimetableController::class, 'index'])->name('timetable.index');
Route::get('/timetable/view', [TimetableController::class, 'view'])->name('timetable.view');
Route::post('/timetable/update', [TimetableController::class, 'update'])->name('timetable.update');

Route::get('/timetable/manual', [TimetableController::class, 'manual'])->name('timetable.manual');
Route::post('/timetable/manual', [TimetableController::class, 'storeManual'])->name('timetable.storeManual');
Route::get('/timetable/pdf', [TimetableController::class, 'generatePDF'])->name('timetable.pdf');

require __DIR__.'/auth.php';
