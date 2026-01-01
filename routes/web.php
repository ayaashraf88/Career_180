<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\students\CoursesController;
use App\Http\Controllers\students\LogsController;
use App\Http\Controllers\students\StudentsController;
use Illuminate\Support\Facades\Route;
use App\Livewire\Courses\Index;
use App\Livewire\Tweet;

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');
  Route::get('/', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/course/{slug}', Index::class)->name('courses.index');
    Route::get('/tweet', Tweet::class)->name('tweet');

Route::middleware(['auth:student'])->group(function () {
  
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::group(['prefix' => 'student', 'as' => 'student.'], function () {
    Route::get('/profile', [StudentsController::class,'profile'])->name('profile');
    Route::put('/', [StudentsController::class,'update'])->name('profile.update');
    Route::get('/my-courses', [CoursesController::class, 'enrolledCourses'])->name('courses');
    Route::get('/logs', [LogsController::class, 'showLogs'])->name('logs');

    });

});
