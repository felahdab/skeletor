<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\BugReportController;
use App\Http\Controllers\UserPreferencesController;

use App\Livewire\TestComponent;

Route::get('/test', TestComponent::class);

Route::impersonate();

Route::get('/auth/redirect', function () {
    return Socialite::driver('keycloak')->stateless()->redirect();
})->name('keycloak.login.redirect');


Route::group(['middleware' => ['auth', 'permission']], function () {
    Route::get('/mespreferences', [UserPreferencesController::class, 'mespreferences'])->name('mespreferences');
});

/**
 * Reset password
 */
Route::get('/forgotpwd', [LoginController::class, 'indexforgotpwd'])->name('login.indexforgotpwd');
Route::post('/forgotpwd', [LoginController::class, 'forgotpwd'])->name('login.forgotpwd');
Route::get('/resetpwd/{token}/{email}', [LoginController::class, 'resetpwdpage'])->name('password.reset');
Route::post('/resetpwd', [LoginController::class, 'updatepwd'])->name('login.updatepwd');

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/auth/callback', [LoginController::class, 'login'])->name('keycloak.login.perform');

    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'locallogin'])->name('login.perform');
    
    Route::post('/login/{MCuserexist:sub}/newMdc', [LoginController::class, 'newMdcLogin'])->name('login.newMdcLogin');
    
    Route::group(['middleware' => ['auth', 'permission']], function () {
        /**
         * Logout Routes
         */
        Route::get('/logout', [LogoutController::class, 'perform'])->name('logout.perform');

        Route::post('bugreport', [BugReportController::class, 'store'])->name('bugreports.store');

    });
});


