<?php

use Illuminate\Support\Facades\Route;

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

Route::group(['namespace' => 'App\Http\Controllers'], function()
{   
    /**
     * Home Routes
     */
    Route::get('/', 'HomeController@index')->name('home.index');

    Route::group(['middleware' => ['guest']], function() {
        /**
         * Register Routes
         */
        //Route::get('/register', 'RegisterController@show')->name('register.show');
        //Route::post('/register', 'RegisterController@register')->name('register.perform');

        /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');

    });

    Route::group(['middleware' => ['auth', 'permission']], function() {
        /**
         * Logout Routes
         */
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');

        /**
         * User Routes
         */
        Route::group(['prefix' => 'users'], function() {
            Route::get('/', 'UsersController@index')->name('users.index');
            Route::get('/create', 'UsersController@create')->name('users.create');
            Route::post('/create', 'UsersController@store')->name('users.store');
            Route::get('/{user}/show', 'UsersController@show')->name('users.show');
            Route::get('/{user}/edit', 'UsersController@edit')->name('users.edit');
            Route::patch('/{user}/update', 'UsersController@update')->name('users.update');
            Route::delete('/{user}/delete', 'UsersController@destroy')->name('users.destroy');
            Route::get('/currentrole', 'ChangeUserCurrentRole@index')->name('currentrole.show');
            Route::post('/currentrole', 'ChangeUserCurrentRole@store')->name('currentrole.store');
            Route::get('/{user}/changepasswd', 'ChangeUserPassword@index')->name('changepasswd.show');
            Route::post('/{user}/changepasswd', 'ChangeUserPassword@store')->name('changepasswd.store');
        });

        Route::resource('roles',          RolesController::class);
        Route::resource('permissions',    PermissionsController::class);
        
        Route::resource('sous-objectifs', SousObjectifController::class);
        Route::post('sous-objectifs/multipleupdate', 'SousObjectifController@multipleupdate')->name('sous-objectifs.multipleupdate');
        
        Route::resource('objectifs', ObjectifController::class);
        Route::resource('compagnonages',  CompagnonageController::class);
        Route::get('compagnonages/{compagnonage}/ajoutetache', 'CompagnonageController@choisirtache')->name('compagnonages.choisirtache');
        Route::post('compagnonages/{compagnonage}/ajoutetache', 'CompagnonageController@ajoutertache')->name('compagnonages.ajoutertache');
        Route::post('compagnonages/{compagnonage}/removetache', 'CompagnonageController@removetache')->name('compagnonages.removetache');
        
        Route::resource('taches',         TacheController::class);
        Route::get('taches/{tach}/ajouteobjectif', 'TacheController@choisirobjectif')->name('taches.choisirobjectif');
        Route::post('taches/{tach}/ajouteobjectif', 'TacheController@ajouterobjectif')->name('taches.ajouterobjectif');
        Route::post('taches/{tach}/removeobjectif', 'TacheController@removeobjectif')->name('taches.removeobjectif');
        
        Route::resource('fonctions',      FonctionController::class);
        Route::get('fonctions/{fonction}/ajoutecompagnonage', 'FonctionController@choisircompagnonage')->name('fonctions.choisircompagnonage');
        Route::post('fonctions/{fonction}/ajoutecompagnonage', 'FonctionController@ajoutercompagnonage')->name('fonctions.ajoutercompagnonage');
        Route::post('fonctions/{fonction}/removecompagnonage', 'FonctionController@removecompagnonage')->name('fonctions.removecompagnonage');
        Route::get('fonctions/{fonction}/ajoutestage', 'FonctionController@choisirstage')->name('fonctions.choisirstage');
        Route::post('fonctions/{fonction}/ajoutestage', 'FonctionController@ajouterstage')->name('fonctions.ajouterstage');
        Route::post('fonctions/{fonction}/removestage', 'FonctionController@removestage')->name('fonctions.removestage');
        
        Route::resource('stages',         StageController::class);
        
		Route::group(['prefix' => 'transformation'], function() {
			Route::get('/', 'TransformationController@index')->name('transformation.index');
			Route::get('/{user}/livret', 'TransformationController@livret')->name('transformation.livret');
			Route::get('/{user}/choisirfonction', 'UsersController@choisirfonction')->name('users.choisirfonction');
			Route::post('/{user}/choisirfonction', 'UsersController@attribuerfonction')->name('users.attribuerfonction');
			Route::post('/{user}/retirerfonction', 'UsersController@retirerfonction')->name('users.retirerfonction');
		});
    });
});