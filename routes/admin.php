<?php

use App\Http\Controllers\Admin\auth\AuthController;
use App\Http\Controllers\Admin\DiseasesController;
use App\Http\Controllers\Admin\PatientsController;
use App\Http\Controllers\Admin\VaccinationSchedulesController;
use App\Http\Controllers\Admin\VaccsinesController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {

    // đăng nhập
    Route::get('login', [AuthController::class, 'Showlogin'])->name('ShowLogin');
    Route::post('login', [AuthController::class, 'login'])->name('login_admin');
    // tạo tài khoản
    Route::get('register', [AuthController::class, 'Showregister'])->name('ShowRegister');
    Route::post('register', [AuthController::class, 'register'])->name('register');
    // đăng xuất
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/dashboard', function () {
        return view('Admin.pages.dashboard.dashboard');
    })->middleware('auth')->name('dashboard');
    // Route::get('/listdata', function () {
    //     return view('Admin.pages.listdata.listdata');
    // });


    // disease
    Route::prefix('disease')->middleware('auth')->group(function () {

        Route::get('',                  [DiseasesController::class, 'index'])->name('disease');
        Route::get('add',               [DiseasesController::class, 'create'])->name('diseaseCreate');
        Route::post('add',              [DiseasesController::class, 'store'])->name('diseaseStore');
        Route::get('edit/{id}',         [DiseasesController::class, 'edit'])->name('diseaseEdit');
        Route::put('update/{id}',       [DiseasesController::class, 'update'])->name('diseaseUpdate');
        Route::delete('delete/{id}',    [DiseasesController::class, 'delete'])->name('diseaseDelete');
    });

    // vaccsine
    Route::prefix('vaccsine')->middleware('auth')->group(function () {
        Route::get('',                  [VaccsinesController::class, 'index'])->name('vaccsine');
        Route::get('add',               [VaccsinesController::class, 'create'])->name('vaccsineCreate');
        Route::post('add',              [VaccsinesController::class, 'store'])->name('vaccsineStore');
        Route::get('edit/{id}',         [VaccsinesController::class, 'edit'])->name('vaccsineEdit');
        Route::put('update/{id}',       [VaccsinesController::class, 'update'])->name('vaccsineUpdate');
        Route::delete('delete/{id}',    [VaccsinesController::class, 'delete'])->name('vaccsineDelete');
    });

    // patient
    Route::prefix('patient')->middleware('auth')->group(function () {

        Route::get('',                  [PatientsController::class, 'index'])->name('patient');
        Route::get('add',               [PatientsController::class, 'create'])->name('patientCreate');
        Route::post('add',              [PatientsController::class, 'store'])->name('patientStore');
        Route::get('edit/{id}',         [PatientsController::class, 'edit'])->name('patientEdit');
        Route::put('update/{id}',       [PatientsController::class, 'update'])->name('patientUpdate');
        Route::delete('delete/{id}',    [PatientsController::class, 'delete'])->name('patientDelete');
    });

    // vaccsine-schedule
    Route::prefix('vaccsine-schedule')->middleware('auth')->group(function () {

        Route::get('',                  [VaccinationSchedulesController::class, 'index'])->name('vaccsineschedule');
        Route::get('add',               [VaccinationSchedulesController::class, 'create'])->name('vaccsinescheduleCreate');
        Route::post('add',              [VaccinationSchedulesController::class, 'store'])->name('vaccsinescheduleStore');
        Route::get('edit/{id}',         [VaccinationSchedulesController::class, 'edit'])->name('vaccsinescheduleEdit');
        Route::put('update/{id}',       [VaccinationSchedulesController::class, 'update'])->name('vaccsinescheduleUpdate');
        Route::delete('delete/{id}',    [VaccinationSchedulesController::class, 'delete'])->name('vaccsinescheduleDelete');
    });
});

// Route::get('/', function () {
//     return view('index');
// });  
// Route::get('/login', function () {
//     return view('Admin.pages.auth.login');
// });  
// Route::get('/register', function () {
//     return view('Admin.pages.auth.register');
// });  
