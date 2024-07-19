<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\SPHomepageController;
use App\Http\Controllers\SPProjectDetailsController;
use App\Http\Controllers\STHomepageController;
use App\Http\Controllers\STMeetingLogController;
use App\Http\Controllers\STSubmissionController;
use App\Http\Controllers\TestController;
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

//Test route
Route::get('/test', [TestController::class, 'index'])->name('test');

/////////////////////////////////////////
//Guest
Route::get('/', [AuthenticatedSessionController::class, 'create'])->name('login.index');
Route::post('/', [AuthenticatedSessionController::class, 'store'])->name('login.auth');


/////////////////////
//Student
Route::get('/student-home', [STHomepageController::class, 'index'])->name('student-homepage.index');

Route::get('/student-meeting-logs/{logNum}', [STMeetingLogController::class, 'index'])->name('student-meeting-logs.index');
Route::post('/student-meeting-logs/{logNum}', [STMeetingLogController::class, 'store'])->name('student-meeting-logs.store');

Route::get('/student-submission/{submissionType}', [STSubmissionController::class, 'index'])->name('student-submission.index');
Route::post('/student-submission/{submissionType}', [STSubmissionController::class, 'store'])->name('student-submission.store');
/////////////////////

/////////////////////
//Coordinator
Route::get('/admin-home', [AdminHomeController::class, 'index'])->name('admin.index');
Route::post('/admin-home', [AdminHomeController::class, 'store'])->name('admin.store');

Route::get('/cohort-details/{id}', [AdminHomeController::class, 'show'])->name('cohort.index');
/////////////////////


/////////////////////
//Supervisor
Route::get('/supervisor-home', [SPHomepageController::class, 'index'])->name('supervisor.index');
Route::post('/supervisor-home', [SPHomepageController::class, 'store'])->name('supervisor.store');

Route::get('/project-details/{projectId}', [SPProjectDetailsController::class, 'index'])->name('project-details.index');

/////////////////////
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
