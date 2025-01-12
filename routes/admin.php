<?php

use App\Http\Controllers\Admin\auth\AuthController;
use App\Http\Controllers\Admin\DiseasesController;
use App\Http\Controllers\Admin\PatientsController;
use App\Http\Controllers\Admin\VaccinationSchedulesController;
use App\Http\Controllers\Admin\VaccinesController;
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

    // vaccine
    Route::prefix('vaccine')->middleware('auth')->group(function () {
        Route::get('',                  [VaccinesController::class, 'index'])->name('vaccine');
        Route::get('add',               [VaccinesController::class, 'create'])->name('vaccineCreate');
        Route::post('add',              [VaccinesController::class, 'store'])->name('vaccineStore');
        Route::get('edit/{id}',         [VaccinesController::class, 'edit'])->name('vaccineEdit');
        Route::put('update/{id}',       [VaccinesController::class, 'update'])->name('vaccineUpdate');
        Route::delete('delete/{id}',    [VaccinesController::class, 'delete'])->name('vaccineDelete');
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

    // vaccine-schedule
    Route::prefix('vaccine-schedule')->middleware('auth')->group(function () {

        Route::get('',                  [VaccinationSchedulesController::class, 'index'])->name('vaccineschedule');
        Route::get('detail/{id}',       [VaccinationSchedulesController::class, 'showService'])->name('VCDetail');
        Route::get('detail/{id}/add',   [VaccinationSchedulesController::class, 'create'])->name('vaccinescheduleCreate');
        Route::post('add',              [VaccinationSchedulesController::class, 'store'])->name('vaccinescheduleStore');
        // Route::get('edit/{id}',         [VaccinationSchedulesController::class, 'edit'])->name('vaccinescheduleEdit');
        Route::put('update-status/{id}',       [VaccinationSchedulesController::class, 'updateStatus'])->name('vaccinescheduleUpdateStatus');
        Route::delete('delete-schedule/{id}',    [VaccinationSchedulesController::class, 'delete_schedule'])->name('vaccinescheduleDelete');
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
