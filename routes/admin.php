<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {
    
    Route::get('/dashboard', function () {
        return view('Admin.pages.dashboard.dashboard');
    });
    Route::get('/listdata', function () {
        return view('Admin.pages.listdata.listdata');
    });
    
});

Route::get('/', function () {
    return view('index');
});  
Route::get('/login', function () {
    return view('Admin.pages.auth.login');
});  
Route::get('/register', function () {
    return view('Admin.pages.auth.register');
});  
