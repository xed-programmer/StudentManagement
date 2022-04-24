<?php

use App\Http\Controllers\Admin\AdminBuildingController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminDestinationController;
use App\Http\Controllers\Admin\AdminGatepassController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminProfessorController;
use App\Http\Controllers\Admin\AdminScheduleController;
use App\Http\Controllers\Admin\AdminSubjectController;
use App\Http\Controllers\Admin\AdminUserController;
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
use App\Mail\AnnouncementMail;
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
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/no-permission', function () {
        return view('nopermission');
    })->name('nopermission');


    // PROFILE
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

    // ADMIN
    Route::group(['middleware' => ['checkrole:admin'], 'prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/',[AdminController::class, 'index'])->name('index');

        // Gatepass
        Route::prefix('gatepass')->as('gatepass.')->group(function(){
            Route::get('/s', [AdminGatepassController::class, 'student'])->name('student');
            Route::get('/v', [AdminGatepassController::class, 'visitor'])->name('visitor');
        });
        // USERS
        Route::prefix('user')->as('user.')->group(function () {
            Route::get('/', [AdminUserController::class, 'index'])->name('index');
            Route::get('/register', [AdminUserController::class, 'create'])->name('register');
            Route::post('/register', [AdminUserController::class, 'store'])->name('register');
            Route::get('/edit/{user}', [AdminUserController::class, 'edit'])->name('edit');
            Route::put('/edit/{user}', [AdminUserController::class, 'update'])->name('update');            
            Route::delete('/{user}', [AdminUserController::class, 'destroy'])->name('delete'); 
        });        

        // STUDENTS
        Route::prefix('student')->as('student.')->group(function () {
            Route::get('/export', [AdminStudentController::class, 'getExcelStudentListLayout'])->name('studentlayoutxlsx');
            Route::get('/', [AdminStudentController::class, 'index'])->name('index');
            Route::get('/register', [AdminStudentController::class, 'create'])->name('register');
            Route::post('/register', [RegisteredStudentController::class, 'store'])->name('register');
            Route::post('/import', [AdminStudentController::class, 'importStudent'])->name('import');
            Route::get('/edit/{student:student_code}', [AdminStudentController::class, 'edit'])->name('edit');
            Route::put('/edit/{student:student_code}', [AdminStudentController::class, 'update'])->name('update');            
            Route::delete('/{student:student_code}', [AdminStudentController::class, 'destroy'])->name('delete');             
        });

        // POST / ANNOUNCEMENTS
        Route::prefix('posts')->as('posts.')->group(function () {
            Route::get('/', [AdminPostController::class, 'index'])->name('index');
            Route::post('/', [AdminPostController::class, 'store'])->name('store');
            Route::get('/edit/{post}', [AdminPostController::class, 'edit'])->name('edit');
            Route::put('/edit/{post}', [AdminPostController::class, 'update'])->name('update');
            Route::delete('/{post}', [AdminPostController::class, 'destroy'])->name('delete');
        });

        // Building
        Route::prefix('b')->as('building.')->group(function () {
            Route::get('/', [AdminBuildingController::class, 'index'])->name('index');            
            Route::post('/', [AdminBuildingController::class, 'store'])->name('store');
            Route::get('/edit/{building}', [AdminBuildingController::class, 'edit'])->name('edit');
            Route::put('/edit/{building}', [AdminBuildingController::class, 'update'])->name('update');
            Route::delete('/{building}', [AdminBuildingController::class, 'destroy'])->name('delete');
        });

        // Destination
        Route::prefix('d')->as('destination.')->group(function () {
            Route::get('/', [AdminDestinationController::class, 'index'])->name('index');            
            Route::post('/', [AdminDestinationController::class, 'store'])->name('store');
            Route::get('/edit/{destination}', [AdminDestinationController::class, 'edit'])->name('edit');
            Route::put('/edit/{destination}', [AdminDestinationController::class, 'update'])->name('update');
            Route::delete('/{destination}', [AdminDestinationController::class, 'destroy'])->name('delete');
        });
    });


    // STUDENTS
    Route::group(['middleware' => ['checkrole:student']], function () {
        Route::get('/student', [StudentController::class, 'index'])->name('student');
    });

    // GUARDIAN
    Route::group(['middleware' => ['checkrole:guardian'], 'prefix' => 'guardian', 'as' => 'guardian.'], function () {
        Route::get('/', [GuardianController::class, 'index'])->name('index');
        Route::get('/view/{student:student_code}', [GuardianController::class, 'showStudent'])->name('show.student');
        Route::get('/create', [GuardianController::class, 'create'])->name('create.student');
        Route::post('/store/{guardian}', [GuardianController::class, 'store'])->name('store.student');
        Route::delete('/{guardian}/{student}', [GuardianController::class, 'destroy'])->name('delete.student');
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

    Route::get('/v', [GatePassController::class, 'visitor'])->name('visitor.index');
    Route::post('/v', [GatePassController::class, 'store_visitor'])->name('visitor.store');
    Route::post('/v/a', [GatePassController::class, 'add_visitor'])->name('visitor.add');
});

Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcement');


require __DIR__ . '/auth.php';