<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\StudentController;
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

Route::get('/', function () {
    return view('home');
})->name('home');



Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/no-permission', function () {
        return view('nopermission');
    })->name('nopermission');

    Route::group(['middleware' => ['checkrole:admin']], function () {
        Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    });

    Route::group(['middleware' => ['checkrole:student']], function () {
        Route::get('/student', [StudentController::class, 'index'])->name('student');
    });

    Route::group(['middleware' => ['checkrole:guardian']], function () {
        Route::get('/guardian', [GuardianController::class, 'index'])->name('guardian');
    });

    Route::group(['middleware' => ['checkrole:professor']], function () {
        Route::get('/guardian', [ProfessorController::class, 'index'])->name('guardian');
    });
});


require __DIR__ . '/auth.php';
