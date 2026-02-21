<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('index');




Route::prefix('user')
    ->middleware(['auth', 'role:super_admin'])->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/', 'index')->name('user.index');
            Route::post('/store', 'store')->name('user.store');
        });
    });



Route::controller(LoginController::class)->group(function(){
    Route::post('/login', 'login')->name('user.login');
    Route::post('/logout', 'logout')->name('user.logout');
});


Route::prefix('admin-dashboard')
    ->middleware(['auth', 'role:barangay_admin'])->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/', 'adminIndex')->name('barangay_admin.dashboard');
        });
    });


Route::prefix('super-admin')
    ->middleware(['auth', 'role:super_admin'])->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/', 'superAdminIndex')->name('super_admin.dashboard');
        });
    });
