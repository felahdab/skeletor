<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

use App\Http\Controllers\LoginController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\MindefConnectUserController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\ChangeUserCurrentRole;
use App\Http\Controllers\ChangeUserPassword;
use App\Http\Controllers\ArchivageController;
use App\Http\Controllers\TransformationController;
use App\Http\Controllers\StatistiqueController;
use App\Http\Controllers\TacheController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\StageController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\ObjectifController;
use App\Http\Controllers\SousObjectifController;
use App\Http\Controllers\BugReportController;
use App\Http\Controllers\ImportExportParcours;
use App\Http\Controllers\TransformationHistoryController;
use App\Http\Controllers\AnnudefController;

use App\Http\Livewire\UserPreferencesComponent;
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

Route::impersonate();

Route::get('/auth/redirect', function () {
    return Socialite::driver('keycloak')->stateless()->redirect();
})->name('keycloak.login.redirect');


Route::group(['middleware' => ['auth', 'permission']], function () {
    Route::get('/mespreferences', UserPreferencesComponent::class)->name('mespreferences');
});

Route::group(['namespace' => 'App\Http\Controllers'], function () {
    Route::get('/auth/callback', [LoginController::class, 'login'])->name('keycloak.login.perform');

    Route::get('/', [HomeController::class, 'index'])->name('home.index');

    Route::get('/login', [LoginController::class, 'show'])->name('login.show');
    Route::post('/login', [LoginController::class, 'locallogin'])->name('login.perform');

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

        /**
         * User Routes
         */
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
            Route::get('/{user}/stages', [UsersController::class, 'stages'])->name('users.stages');
            Route::post('/{user}/changepasswd', [ChangeUserPassword::class,  'store'])->name('changepasswd.store');
        });

        Route::resource('roles',          RolesController::class);
        Route::resource('permissions',    PermissionsController::class);

        Route::post('bugreport', [BugReportController::class, 'store'])->name('bugreports.store');

        Route::resource('liens', LienController::class);

        Route::group(['prefix' => 'annudef'], function () {
            Route::get('/', [AnnudefController::class, 'index'])->name('annudef.index');
        });

        Route::group(['prefix' => 'mails'], function () {
            Route::get('/', [MailController::class, 'index'])->name('mails.index');
            Route::get('/edit/{mail}', [MailController::class, 'edit'])->name('mails.edit');
            Route::get('/create', [MailController::class, 'create'])->name('mails.create');
        });
    });
});
