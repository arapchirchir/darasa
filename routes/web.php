<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/home', function () {
    return redirect()->route('home');
});

Auth::routes();

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::middleware(['teacher'])->controller(TeacherController::class)->group(function () {
    Route::get('teacher', 'index')->name('teacher');
    Route::get('assignments', 'Assignments')->name('assignments');
    Route::post('assignments', 'StoreAssignment')->name('assignment.store');
    Route::get('assignment/{id}', 'ViewAssignment')->name('assignments.view');
    Route::post('assignment/award', 'AwardAssignment')->name('assignment.award');
});

Route::middleware(['student'])->controller(StudentController::class)->group(function () {
    Route::get('student', 'index')->name('student');
    Route::get('assignment/{id}/view', 'GetAssignment');
    Route::post('assignment/submit', 'SubmitAssignment')->name('assignment.submit');
});
