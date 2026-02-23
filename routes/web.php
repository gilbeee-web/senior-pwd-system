<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\User\UserController;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
})->name('index');



Route::prefix('account')
    ->middleware(['auth'])->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/{user}/edit', 'edit')->name('user.edit');
            Route::put('/{id}', 'update')->name('user.update');
        });
    });




Route::prefix('user')
    ->middleware(['auth', 'role:super_admin'])->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('/', 'index')->name('user.index');
            Route::post('/', 'store')->name('user.store');
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
