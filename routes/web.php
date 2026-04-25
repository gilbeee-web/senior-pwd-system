<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AuthorizeEmployeeController;
use App\Http\Controllers\BeneficiaryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PwdController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RequestController;
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


Route::prefix('dashboard')
    ->middleware(['auth'])->group(function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/super-admin', 'superAdminIndex')->name('super_admin.dashboard');
            Route::get('/pwd-admin', 'pwdAdminIndex')->name('pwd_admin.dashboard');
            Route::get('/senior-admin', 'seniorAdminIndex')->name('senior_admin.dashboard');
        });
    });


// Route::prefix('super-admin')
//     ->middleware(['auth', 'role:super_admin'])->group(function () {
//         Route::controller(DashboardController::class)->group(function () {
//             Route::get('/', 'superAdminIndex')->name('super_admin.dashboard');
//         });
//     });

Route::prefix('beneficiary')
    ->middleware('auth')->group(function(){
        Route::controller(BeneficiaryController::class)->group(function(){
            Route::get('/', 'index')->name('beneficiary.index');
            Route::get('/streets/{id}', 'getStreets')->name('beneficiary.getStreets');
            Route::get('/archive/{type}','getArchive')->name('beneficiary.getArchive');
        });
    });

Route::prefix('senior')
    ->middleware('auth')->group(function(){
        Route::controller(SeniorController::class)->group(function(){
            Route::get('/create', 'create')->name('senior.create');
            Route::post('/', 'store')->name('senior.store');
            Route::get('/{senior}/edit', 'edit')->name('senior.edit');
            Route::put('/{senior}', 'update')->name('senior.update');
            Route::get('/{senior}', 'show')->name('senior.show');
            Route::post('/import', 'import')->name('senior.import');
            Route::post('/restore/{id}', 'restore')->name('senior.restore');
            Route::delete('/{senior}/archive', 'archive')->name('senior.archive');
            Route::delete('/{senior}', 'destroy')->name('senior.destroy');
            Route::delete('/delete-all', 'destroyAll')->name('senior.destroyAll');
            Route::post('/print', 'printSenior')->name('senior.print');

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
            Route::post('/import', 'import')->name('pwd.import');
            Route::post('/restore/{id}', 'restore')->name('pwd.restore');
            Route::post('/validate/update', 'bulkUpdateValidate')->name('pwd.validate');
            Route::delete('/delete-all', 'destroyAll')->name('pwd.destroyAll');
            Route::post('/print', 'printPwd')->name('pwd.print');

        });
    });

Route::prefix('reports')
    ->middleware(['auth'])->group(function(){
        Route::controller(ReportController::class)->group(function(){
           Route::get('/', 'index')->name('report.index');
           Route::get('/pwd/export', 'exportPwd')->name('report.pwd.export');
           Route::get('/senior/export', 'exportSenior')->name('report.senior.export');
        });
    });


Route::prefix('/requests')
    ->middleware(['auth', 'role:super_admin,pwd_admin,senior_admin'])->group(function(){
        Route::controller(RequestController::class)->group(function(){
           Route::get('/', 'index')->name('request.index');
           Route::post('/approve/{id}', 'approve')->name('request.approve');
        });
    });

Route::prefix('settings')
    ->middleware(['auth', 'role:super_admin,pwd_admin,senior_admin'])->group(function(){
        Route::controller(AuthorizeEmployeeController::class)->group(function(){
            Route::get('/', 'index')->name('settings.index');
            Route::post('/', 'store')->name('settings.store');
            Route::get('/{id}', 'edit')->name('settings.edit');
            Route::put('/{id}', 'update')->name('settings.update');
            Route::delete('/{id}', 'destroy')->name('settings.destroy');
            Route::put('/{id}/updateStatus', 'updateStatus')->name('settings.updateStatus');
        });
    });