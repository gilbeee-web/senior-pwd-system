<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('index');


// Route::prefix('user')
//     ->middleware(['auth', 'role:super_admin'])->group(function () {
//         Route::controller(LoginController::class)->group(function () {
//             Route::get('/', 'user')->name('user.register');
//         });
//     });



Route::controller(LoginController::class)->group(function(){
    Route::post('/login', 'login')->name('user.login');
    Route::post('/logout', 'logout')->name('user.logout');
});


Route::prefix('admin-dashboard')
    ->middleware(['auth', 'role:barangay_admin'])->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/', 'adminIndex')->name('admin.dashboard');
        });
    });


Route::prefix('super-admin')
    ->middleware(['auth', 'role:super_admin'])->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/', 'superAdminIndex')->name('super_admin.dashboard');
        });
    });
