<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredGuardianController;
use App\Http\Controllers\Auth\RegisteredStudentController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
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

Route::get('/', function () {
    return view('home');
})->name('home');
// Auth::routes(['verify' => true]);


Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/no-permission', function () {
        return view('nopermission');
    })->name('nopermission');


    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/{user}', [ProfileController::class, 'index'])->name('index');
        Route::get('/edit/{user}', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/update/{user}', [ProfileController::class, 'update'])->name('update');
    });

    Route::group(['middleware' => ['checkrole:admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/', [AdminController::class, 'index'])->name('index');
        Route::get('/student', [AdminController::class, 'student'])->name('student.index');
        Route::get('/student/register', [AdminController::class, 'createStudent'])->name('student.register');
        Route::post('/student/register', [RegisteredStudentController::class, 'store'])->name('student.register');
        Route::get('/student/edit/{student}', [AdminController::class, 'editStudent'])->name('student.edit');
        Route::put('/student/edit/{student}', [AdminController::class, 'updateStudent'])->name('student.update');
        Route::delete('/student/{student}', [AdminController::class, 'destroyStudent'])->name('student.delete');
    });

    Route::group(['middleware' => ['checkrole:student']], function () {
        Route::get('/student', [StudentController::class, 'index'])->name('student');
    });

    Route::group(['middleware' => ['checkrole:guardian'], 'prefix' => 'guardian', 'as' => 'guardian.'], function () {
        Route::get('/', [GuardianController::class, 'index'])->name('index');
        Route::get('/view/{student}', [GuardianController::class, 'showStudent'])->name('show.student');
    });

    Route::group(['middleware' => ['checkrole:professor']], function () {
        Route::get('/professor', [ProfessorController::class, 'index'])->name('professor');
    });
});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/guardian/register', [RegisteredGuardianController::class, 'create'])->name('guardian.register');
    Route::post('/guardian/register', [RegisteredGuardianController::class, 'store'])->name('guardian.register');
});


require __DIR__ . '/auth.php';