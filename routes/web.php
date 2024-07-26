<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\MindefConnectUserController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ChangeUserCurrentRole;
use App\Http\Controllers\ChangeUserPassword;
use App\Http\Controllers\MailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\BugReportController;
use App\Http\Controllers\AnnudefController;
use App\Http\Controllers\GroupementController;
use App\Http\Controllers\SecteurController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserPreferencesController;
use App\Http\Controllers\ParamaccueilsController;
use App\Http\Controllers\ArchivesController;

use App\Http\Middleware\RestrictVisibility;
use App\Livewire\TestComponent;
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

        Route::group(['prefix' => 'mindefconnect'], function () {
            Route::get('/', [MindefConnectUserController::class, 'index'])->name('mindefconnect.index');
            Route::get('/{user}', [MindefConnectUserController::class, 'edit'])->name('mindefconnect.edit');
            Route::post('/{user}', [MindefConnectUserController::class, 'store'])->name('mindefconnect.store');
            Route::delete('/{user}', [MindefConnectUserController::class, 'destroy'])->name('mindefconnect.destroy');
            Route::get('/{mcuser}/conservcpte', [MindefConnectUserController::class, 'conservcpte'])->name('mindefconnect.conservcpte');
            Route::get('/{mcuser}/effacecpte', [MindefConnectUserController::class, 'effacecpte'])->name('mindefconnect.effacecpte');
        });
        Route::group(['prefix' => 'annudef'], function () {
            Route::get('/', [AnnudefController::class, 'index'])->name('annudef.index');
        });
        
        /**
         * User Routes
         */
        Route::group(['middleware' => [RestrictVisibility::class]], function () {
            Route::group(['prefix' => 'users'], function () {
                Route::get('/', [UsersController::class, 'index'])->name('users.index');
                Route::get('/create', [UsersController::class, 'create'])->name('users.create');
                Route::post('/create', [UsersController::class, 'store'])->name('users.store');
                Route::get('/{user}/show', [UsersController::class, 'show'])->name('users.show');
                Route::get('/{user}/edit', [UsersController::class, 'edit'])->name('users.edit');
                Route::patch('/{user}/update', [UsersController::class, 'update'])->name('users.update');
                Route::delete('/{user}/delete', [UsersController::class, 'destroy'])->name('users.destroy');
                Route::get('/currentrole', [ChangeUserCurrentRole::class, 'index'])->name('currentrole.show');
                Route::post('/currentrole', [ChangeUserCurrentRole::class, 'store'])->name('currentrole.store');
                Route::get('/{user}/changepasswd', [ChangeUserPassword::class,  'index'])->name('changepasswd.show');
                Route::post('/{user}/changepasswd', [ChangeUserPassword::class,  'store'])->name('changepasswd.store');
            });
            Route::group(['prefix' => 'mails'], function () {
                Route::get('/', [MailController::class, 'index'])->name('mails.index');
                Route::get('/edit/{mail}', [MailController::class, 'edit'])->name('mails.edit');
                Route::get('/create', [MailController::class, 'create'])->name('mails.create');
            });
    
        });

        Route::resource('roles',          RolesController::class);
        Route::resource('permissions',    PermissionsController::class);

        Route::post('bugreport', [BugReportController::class, 'store'])->name('bugreports.store');

        Route::resource('liens', LienController::class);

        Route::group(['prefix' => 'secteurs'], function () {
            Route::get('/', [SecteurController::class, 'index'])->name('secteurs.index');
            Route::get('/create', [SecteurController::class, 'create'])->name('secteurs.create');
            Route::post('/create', [SecteurController::class, 'store'])->name('secteurs.store');
            Route::get('/{secteur}/show', [SecteurController::class, 'show'])->name('secteurs.show');
            Route::get('/{secteur}/edit', [SecteurController::class, 'edit'])->name('secteurs.edit');
            Route::patch('/{secteur}/update', [SecteurController::class, 'update'])->name('secteurs.update');
            Route::delete('/{secteur}/delete', [SecteurController::class, 'destroy'])->name('secteurs.destroy');
        });

        Route::group(['prefix' => 'groupements'], function () {
            Route::get('/', [GroupementController::class, 'index'])->name('groupement.index');
            Route::get('/create', [GroupementController::class, 'create'])->name('groupement.create');
            Route::post('/create', [GroupementController::class, 'store'])->name('groupement.store');
            Route::get('/{groupement}/show', [GroupementController::class, 'show'])->name('groupement.show');
            Route::get('/{groupement}/edit', [GroupementController::class, 'edit'])->name('groupement.edit');
            Route::patch('/{groupement}/update', [GroupementController::class, 'update'])->name('groupement.update');
            Route::delete('/{groupement}/delete', [GroupementController::class, 'destroy'])->name('groupement.destroy');
        });
        Route::group(['prefix' => 'services'], function () {
            Route::get('/', [ServiceController::class, 'index'])->name('services.index');
            Route::get('/create', [ServiceController::class, 'create'])->name('services.create');
            Route::post('/create', [ServiceController::class, 'store'])->name('services.store');
            Route::get('/{service}/show', [ServiceController::class, 'show'])->name('services.show');
            Route::get('/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
            Route::patch('/{service}/update', [ServiceController::class, 'update'])->name('services.update');
            Route::delete('/{service}/delete', [ServiceController::class, 'destroy'])->name('services.destroy');
        });
        
        Route::group(['prefix' => 'paramaccueils'], function () {
            Route::get('/', [ParamaccueilsController::class, 'index'])->name('paramaccueils.index');
            Route::patch('/', [ParamaccueilsController::class, 'update'])->name('paramaccueils.update');
        });
 
        Route::get('archives', [ArchivesController::class, 'index'])->name('archives.index');
        Route::get('archives/{user}/restore', [ArchivesController::class, 'restore'])->name('archives.restore');
        Route::get('archives/{user}/delete', [ArchivesController::class, 'destroy'])->name('archives.destroy');
 

    });
});
