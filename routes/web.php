<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // Protected routes that require authentication
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

Auth::routes();




/*------------------------------------------
--------------------------------------------
All Normal Users Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:students'])->group(function () {
    Route::get('/student/profile', [StudentController::class, 'edit'])->name('student.profile.edit');
    Route::post('/student/profile', [StudentController::class, 'update'])->name('student.profile.update'); 
    Route::get('/student/appointment', [StudentController::class, 'studentAppointment'])->name('student.appointments.index');
    Route::post('/student/appointment/booking', [StudentController::class, 'bookAppointment'])->name('student.appointments.book');  
    Route::get('/student/availability', [StudentController::class, 'availability'])->name('student.availability');
    Route::post('/student/availability', [StudentController::class, 'storeAvailability'])->name('student.availability.store');
    Route::delete('/student/availability/{id}', [StudentController::class, 'destroy'])->name('student.availabilityDelete');
    Route::get('/student/history', [StudentController::class, 'history'])->name('student.history'); 
    Route::get('/home', [HomeController::class, 'index'])->name('home');
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:admin'])->group(function () {

    Route::get('/admin/home', [HomeController::class, 'adminHome'])->name('admin.home');
});

/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::middleware(['auth', 'user-access:lectures'])->group(function () {
    Route::get('/lecturer/availability', [LectureController::class, 'index'])->name('lecturer.availability.index');
    Route::post('/lecturer/availability', [LectureController::class, 'store'])->name('lecturer.availability.store');
    Route::get('/lecturer/appointments', [LectureController::class, 'appointment'])->name('lecturer.appointments');
    Route::delete('/lecturer/availability/{id}', [LectureController::class, 'destroy'])->name('lecturer.availabilityDelete');
    Route::get('lecturer/students', [LectureController::class, 'students'])->name('lecturer.students.index');
    Route::post('lecturer/book/{student}', [LectureController::class, 'bookAppointment'])->name('lecturer.book');
    Route::get('/manager/home', [HomeController::class, 'managerHome'])->name('manager.home');
    Route::get('/lecturer/profile', [LectureController::class, 'show'])->name('lecturer.profile');
    Route::post('/lecturer/profile', [LectureController::class, 'updateLecture'])->name('lecturer.profile.update');
    Route::post('/lecturer/department', [LectureController::class, 'updateDepartment'])->name('lecturer.department.update');
});
