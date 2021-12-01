<?php

use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\AdminCourseSubjectController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminProfessorController;
use App\Http\Controllers\Admin\AdminScheduleController;
use App\Http\Controllers\Admin\AdminSubjectController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Auth\RegisteredGuardianController;
use App\Http\Controllers\Auth\RegisteredStudentController;
use App\Http\Controllers\GatePassController;
use App\Http\Controllers\GuardianController;
use App\Http\Controllers\HomeController;
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

Route::get('/', [HomeController::class, 'index'])->name('home');

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

        Route::prefix('course')->as('course.')->group(function () {
            Route::get('/', [AdminCourseController::class, 'index'])->name('index');
            Route::get('/create', [AdminCourseController::class, 'create'])->name('create');
            Route::post('/create', [AdminCourseController::class, 'store'])->name('create');
            Route::get('/edit/{course:code}', [AdminCourseController::class, 'edit'])->name('edit');
            Route::put('/edit/{course:code}', [AdminCourseController::class, 'update'])->name('update');            
            Route::delete('/{course:code}', [AdminCourseController::class, 'destroy'])->name('delete'); 
        });  

        Route::prefix('subject')->as('subject.')->group(function () {
            Route::get('/', [AdminSubjectController::class, 'index'])->name('index');
            Route::get('/create', [AdminSubjectController::class, 'create'])->name('create');
            Route::post('/create', [AdminSubjectController::class, 'store'])->name('create');
            Route::get('/edit/{subject:code}', [AdminSubjectController::class, 'edit'])->name('edit');
            Route::put('/edit/{subject:code}', [AdminSubjectController::class, 'update'])->name('update');            
            Route::delete('/{subject:code}', [AdminSubjectController::class, 'destroy'])->name('delete'); 
        });   

        Route::prefix('coursesubject')->as('coursesubject.')->group(function () {
            Route::get('/', [AdminCourseSubjectController::class, 'index'])->name('index');
            Route::get('/create', [AdminCourseSubjectController::class, 'create'])->name('create');
            Route::post('/create', [AdminCourseSubjectController::class, 'store'])->name('create');
            Route::get('/edit/{coursesubject}', [AdminCourseSubjectController::class, 'edit'])->name('edit');
            Route::put('/edit/{coursesubject}', [AdminCourseSubjectController::class, 'update'])->name('update');            
            Route::delete('/{coursesubject}', [AdminCourseSubjectController::class, 'destroy'])->name('delete'); 
        });   

        Route::prefix('professor')->as('professor.')->group(function () {
            Route::get('/', [AdminProfessorController::class, 'index'])->name('index');
            Route::get('/register', [AdminProfessorController::class, 'create'])->name('register');
            Route::post('/register', [AdminProfessorController::class, 'store'])->name('register');
            Route::get('/edit/{professor}', [AdminProfessorController::class, 'edit'])->name('edit');
            Route::put('/edit/{professor}', [AdminProfessorController::class, 'update'])->name('update');            
            Route::delete('/{professor}', [AdminProfessorController::class, 'destroy'])->name('delete'); 
        });  
        
        Route::prefix('schedule')->as('schedule.')->group(function () {
            Route::get('/', [AdminScheduleController::class, 'index'])->name('index');
            Route::get('/add', [AdminScheduleController::class, 'create'])->name('add');
            Route::post('/add', [AdminScheduleController::class, 'store'])->name('add');
            Route::get('/edit/{schedule}', [AdminScheduleController::class, 'edit'])->name('edit');
            Route::put('/edit/{schedule}', [AdminScheduleController::class, 'update'])->name('update');            
            Route::delete('/{schedule}', [AdminScheduleController::class, 'destroy'])->name('delete'); 
        });  
        
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

    Route::group(['middleware' => ['checkrole:professor'], 'prefix' => 'professor', 'as'=> 'professor.'], function () {
        Route::get('/', [ProfessorController::class, 'index'])->name('index');
        Route::get('/schedule', [ProfessorController::class, 'showSchedule'])->name('schedule.show');
        Route::get('/class/{schedule}', [ProfessorController::class, 'showClass'])->name('class.show');
        Route::prefix('student')->as('student.')->group(function () {
            Route::post('/data', [ProfessorController::class, 'getStudentData'])->name('data');
            Route::get('/add/{schedule}', [ProfessorController::class, 'addStudent'])->name('add');
            Route::post('/add/{schedule}', [ProfessorController::class, 'storeStudent'])->name('add');
            Route::get('/attendance/{schedule}', [ProfessorController::class, 'createAttendance'])->name('attendance.create');
            Route::post('/attendance/{schedule}', [ProfessorController::class, 'storeAttendance'])->name('attendance.store');
        });
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