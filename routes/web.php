<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminHomeController;

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

Route::get('/', function () {
    return view('log-in');
});

Route::get('/student-home', function () {
    return view('Users.Student.st-homepage');
});

Route::get('/admin-home', [AdminHomeController::class, 'index'])->name('admin.index');
Route::post('/admin-home', [AdminHomeController::class, 'store'])->name('admin.store');\

Route::get('/cohort-details/{id}', [AdminHomeController::class, 'show'])->name('cohort.index');


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__ . '/auth.php';
