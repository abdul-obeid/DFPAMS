<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminHomeController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\SPHomepageController;
use App\Http\Controllers\SPProjectDetailsController;
use App\Http\Controllers\SPMeetingLogController;
use App\Http\Controllers\SPSubmissionsController;
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

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

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

Route::get('/supervisor/meeting-log/{projId}/{logNum}', [SPMeetingLogController::class, 'index'])->name('supervisor-meeting-log.index');
Route::post('/supervisor/meeting-log/{projId}/{logNum}/feedback', [SPMeetingLogController::class, 'submitFeedback'])->name('supervisor-meeting-log.feedback');
Route::get('/supervisor/meeting-log/{projId}/{logNum}/download', [SPMeetingLogController::class, 'download'])->name('supervisor-meeting-log.download');

Route::get('/submissions/{projectId}/{submissionType}', [SPSubmissionsController::class, 'show'])->name('submissions.show');
Route::post('/submissions/{submission}/feedback', [SPSubmissionsController::class, 'submitFeedback'])->name('submissions.feedback');
Route::get('/submissions/{submission}/download', [SPSubmissionsController::class, 'download'])->name('submissions.download');
/////////////////////
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
