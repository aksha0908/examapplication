<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\Student\StudentController;
use App\Http\Controllers\Admin\Teacher\TeacherController;
use App\Http\Controllers\Auth\AuthController as AuthAuthController;

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
    return view('welcome');
});



//Student Auth Routes
Route::get('student/login', [AuthAuthController::class, 'index'])->name('student.login');
Route::post('student-login', [AuthAuthController::class, 'postLogin'])->name('login.post'); 
Route::get('student-logout', [AuthAuthController::class, 'logout'])->name('student.logout');
Route::get('registration', [AuthAuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthAuthController::class, 'postRegistration'])->name('register.post');

// Route::get('teacher/home', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');



//Admin Auth
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login'); 
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::group(["prefix" => "admin", "as" => 'admin.'], function () {

    Route::group(["prefix" => "student", "as" => 'student.'], function () {
        // Route::get('home', [AuthController::class, 'dashboard'])->name('dashboard');
        Route::get('index', [StudentController::class, 'index'])->name('index');
        Route::get('create', [StudentController::class, 'create'])->name('create');

    });

    Route::group(["prefix" => "question", "as" => 'question.'], function () {
        Route::get('index', [QuestionController::class, 'index'])->name('index');
        Route::get('create', [QuestionController::class, 'create'])->name('create');
        Route::post('store', [QuestionController::class, 'store'])->name('store');
    });

    Route::group(["prefix" => "teacher", "as" => 'teacher.'], function () {
        Route::get('index', [TeacherController::class, 'index'])->name('index');
        Route::get('create', [TeacherController::class, 'create'])->name('create');
        Route::get('edit/??', [TeacherController::class, 'edit'])->name('edit');
        Route::post('store', [TeacherController::class, 'store'])->name('store');
    
    });
    
});

Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
Route::get('student/dashboard', [AuthAuthController::class, 'dashboard'])->name('student.dashboard')->middleware(['is_verify_email']); 
Route::get('account/verify/{token}', [AuthAuthController::class, 'verifyAccount'])->name('user.verify'); 