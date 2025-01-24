<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\DashboardController;

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

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
require __DIR__.'/auth.php';
