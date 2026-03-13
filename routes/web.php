<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PwdController;
use App\Http\Controllers\SeniorController;
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
            Route::post('/{id}/reset-password', 'resetPassword')->name('user.resetPassword');
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

Route::prefix('beneficiary')
    ->middleware('auth')->group(function(){
        Route::controller(BeneficiaryController::class)->group(function(){
            Route::get('/', 'index')->name('beneficiary.index');
            Route::get('/streets/{id}', 'getStreets')->name('beneficiary.getStreets');

        });
    });

Route::prefix('senior')
    ->middleware('auth')->group(function(){
        Route::controller(SeniorController::class)->group(function(){
            Route::get('/create', 'create')->name('senior.create');

        });
    });

Route::prefix('pwd')
    ->middleware(['auth'])->group(function(){
        Route::controller(PwdController::class)->group(function(){
            Route::get('/create', 'create')->name('pwd.create');
            Route::post('/', 'store')->name('pwd.store');
            Route::get('/{pwd}/edit', 'edit')->name('pwd.edit'); 
            Route::put('/{pwd}', 'update')->name('pwd.update');
            Route::get('/{pwd}', 'show')->name('pwd.show');
            Route::delete('/{pwd}/archive', 'archive')->name('pwd.archive');
            Route::delete('/{pwd}', 'destroy')->name('pwd.destroy');
            Route::post('/pwd/import', 'import')->name('pwd.import');
        });
    });