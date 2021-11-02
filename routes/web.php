<?php

use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Auth\RegisteredGuardianController;
use App\Http\Controllers\Auth\RegisteredStudentController;
use App\Http\Controllers\GatePassController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\ProfessorController;
use App\Http\Controllers\Profile\ProfileAdminController;
use App\Http\Controllers\Profile\ProfileStudentController;
use App\Http\Controllers\Profile\ProfileController;
use App\Http\Controllers\Profile\ProfileGuardianController;
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
// Auth::routes(['verify' => true]);


Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/no-permission', function () {
        return view('nopermission');
    })->name('nopermission');


    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class, 'index'])->name('index');

        Route::middleware('checkrole:student')->prefix('student')->as('student.')->group(function () {            
            Route::get('/edit', [ProfileStudentController::class, 'edit'])->name('edit');
            Route::put('/update/user', [ProfileStudentController::class, 'updateUser'])->name('update.user');
            Route::put('/update/password', [ProfileStudentController::class, 'updatePassword'])->name('update.password');
        });
        
        Route::middleware('checkrole:admin')->prefix('admin')->as('admin.')->group(function () {            
            Route::get('/edit', [ProfileAdminController::class, 'edit'])->name('edit');
            Route::put('/update/user', [ProfileAdminController::class, 'updateUser'])->name('update.user');
            Route::put('/update/password', [ProfileAdminController::class, 'updatePassword'])->name('update.password');
        });

        Route::middleware('checkrole:guardian')->prefix('guardian')->as('guardian.')->group(function () {            
            Route::get('/edit', [ProfileGuardianController::class, 'edit'])->name('edit');
            Route::put('/update/user', [ProfileGuardianController::class, 'updateUser'])->name('update.user');
            Route::put('/update/password', [ProfileGuardianController::class, 'updatePassword'])->name('update.password');
        });
    });

    Route::group(['middleware' => ['checkrole:admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/',[AdminController::class, 'index'])->name('index');

        Route::prefix('student')->as('student.')->group(function () {
            Route::get('/', [AdminStudentController::class, 'index'])->name('index');
            Route::get('/register', [AdminStudentController::class, 'create'])->name('register');
            Route::post('/register', [RegisteredStudentController::class, 'store'])->name('register');
            Route::get('/edit/{student:student_code}', [AdminStudentController::class, 'edit'])->name('edit');
            Route::put('/edit/{student:student_code}', [AdminStudentController::class, 'update'])->name('update');            
            Route::delete('/{student:student_code}', [AdminStudentController::class, 'destroy'])->name('delete'); 
        });        

        Route::prefix('posts')->as('posts.')->group(function () {
            Route::get('/', [AdminPostController::class, 'index'])->name('index');
            Route::post('/', [AdminPostController::class, 'store'])->name('store');
            Route::get('/edit', [AdminPostController::class, 'edit'])->name('edit');
            Route::delete('/{post}', [AdminPostController::class, 'destroy'])->name('delete');
        });
    });

    Route::group(['middleware' => ['checkrole:student']], function () {
        Route::get('/student', [StudentController::class, 'index'])->name('student');
    });

    Route::group(['middleware' => ['checkrole:guardian'], 'prefix' => 'guardian', 'as' => 'guardian.'], function () {
        Route::get('/', [GuardianController::class, 'index'])->name('index');
        Route::get('/view/{student:student_code}', [GuardianController::class, 'showStudent'])->name('show.student');
        Route::get('/create', [GuardianController::class, 'create'])->name('create.student');
        Route::post('/store/{guardian}', [GuardianController::class, 'store'])->name('store.student');
        Route::delete('/{guardian}/{student}', [GuardianController::class, 'destroy'])->name('delete.student');
    });

    Route::group(['middleware' => ['checkrole:professor']], function () {
        Route::get('/professor', [ProfessorController::class, 'index'])->name('professor');
    });


});

Route::group(['middleware' => 'guest'], function () {
    Route::get('/guardian/register', [RegisteredGuardianController::class, 'create'])->name('guardian.register');
    Route::post('/guardian/register', [RegisteredGuardianController::class, 'store'])->name('guardian.register');
});

//'middleware' => ['checkrole:securityguard']
Route::group(['prefix' => 'gatepass', 'as' => 'gatepass.'], function () {
    Route::get('/', [GatePassController::class, 'index'])->name('index');
    Route::post('/', [GatePassController::class, 'store'])->name('store');
});

Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcement');

require __DIR__ . '/auth.php';