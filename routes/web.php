<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

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

Route::get('/auth/redirect', function(){
    return Socialite::driver('keycloak')->stateless()->redirect();
})->name('keycloak.login.redirect');


Route::group(['namespace' => 'App\Http\Controllers'], function()
{   
    Route::get('/auth/callback', 'LoginController@login')->name('keycloak.login.perform');
    
    Route::get('/', 'HomeController@index')->name('home.index');

    Route::group(['middleware' => ['guest']], function() {
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@locallogin')->name('login.perform');

    });

    Route::group(['middleware' => ['auth', 'permission']], function() {
        /**
         * Logout Routes
         */
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
        
        Route::group(['prefix' => 'mindefconnect'], function() {
            Route::get('/', 'MindefConnectUserController@index')->name('mindefconnect.index');
            Route::get('/{user}', 'MindefConnectUserController@edit')->name('mindefconnect.edit');
            Route::post('/{user}', 'MindefConnectUserController@store')->name('mindefconnect.store');
            Route::delete('/{user}', 'MindefConnectUserController@destroy')->name('mindefconnect.destroy');
        });
        
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
            Route::get('/{user}/stages', 'UsersController@stages')->name('users.stages');
            Route::post('/{user}/changepasswd', 'ChangeUserPassword@store')->name('changepasswd.store');
        });

        Route::resource('roles',          RolesController::class);
        Route::resource('permissions',    PermissionsController::class);
        // Route::resource('archivage',    ArchivageController::class);
        Route::get('archivage', 'ArchivageController@index')->name('archivage.index');
        Route::get('archivage/{user}/restauration', 'ArchivageController@restaurer')->name('archivage.restaurer');
        Route::get('archivage/{user}/impression', 'ArchivageController@imprimer')->name('archivage.imprimer');
        Route::get('archivage/{user}/archivage', 'ArchivageController@archiver')->name('archivage.archiver');
        Route::get('archivage/{user}/suppr', 'ArchivageController@supprimer')->name('archivage.supprimer');
        
        
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
        Route::get('fonctions/{fonction}/validergroupe', 'FonctionController@choixmarins')->name('fonctions.choixmarins');
        Route::post('fonctions/{fonction}/validergroupe', 'FonctionController@validermarins')->name('fonctions.validermarins');
        Route::get('fonctions/{fonction}/listemarinsfonction', 'FonctionController@listemarinsfonction')->name('fonctions.listemarinsfonction');

        
        Route::resource('stages',         StageController::class);
        Route::post('stages/{stage}/validergroupe', 'StageController@validermarins')->name('stages.validermarins');
        Route::post('stages/{stage}/attribuerstage', 'StageController@attribuerstage')->name('stages.attribuerstage');
        Route::post('stages/{stage}/retirerstage', 'StageController@annulermarins')->name('stages.annulermarins');
        
        Route::post('bugreport', 'BugReportController@store')->name('bugreports.store');
        
        Route::group(['prefix' => 'transformation'], function() {
            Route::get('/', 'TransformationController@index')->name('transformation.index');
            Route::get('/parfonction', 'TransformationController@indexparfonction')->name('transformation.indexparfonction');
            Route::get('/parstage', 'TransformationController@indexparstage')->name('transformation.indexparstage');
            Route::get('/{user}/choisirfonction', 'UsersController@choisirfonction')->name('users.choisirfonction');
            Route::post('/{user}/choisirfonction', 'UsersController@attribuerfonction')->name('users.attribuerfonction');
            Route::post('/{user}/retirerfonction', 'UsersController@retirerfonction')->name('users.retirerfonction');
            Route::get('/{user}/livret', 'TransformationController@livret')->name('transformation.livret');
            Route::get('/{user}/livretpdf', 'TransformationController@livretpdf')->name('transformation.livretpdf');
            Route::get('/{user}/progression', 'TransformationController@progression')->name('transformation.progression');
            Route::get('/{user}/fichebilan', 'TransformationController@fichebilan')->name('transformation.fichebilan');
            Route::get('/mafichebilan', 'TransformationController@mafichebilan')->name('transformation.mafichebilan');
            Route::get('/monlivret', 'TransformationController@monlivret')->name('transformation.monlivret');
            Route::get('/maprogression', 'TransformationController@maprogression')->name('transformation.maprogression');
            Route::get('/exportparcours', 'ImportExportParcours@ExportParcoursVersExcel')->name('transformation.exportparcours');
            Route::get('/recalcultransfo', 'TransformationController@recalcultransfo')->name('transformation.recalcultransfo');
        });
        
        Route::group(['prefix' => 'historique'], function() {
             Route::get('/', 'TransformationHistoryController@index')->name('historique.index');
        });
        
        Route::get('statistiques/', 'StatistiqueController@index')->name('statistiques.index');
        Route::get('statistiques/pourtuteurs', 'StatistiqueController@pourtuteurs')->name('statistiques.pourtuteurs');
        Route::get('statistiques/parservice/{service}', 'StatistiqueController@parservice')->name('statistiques.parservice');
        Route::get('statistiques/pourem', 'StatistiqueController@pourem')->name('statistiques.pourem');
        Route::get('statistiques/pour2ps', 'StatistiqueController@pour2ps')->name('statistiques.pour2ps');

        Route::resource('liens',          LienController::class);
        
         Route::group(['prefix' => 'annudef'], function() {
             Route::get('/', 'AnnudefController@index')->name('annudef.index');
        });

        Route::group(['prefix' => 'mails'], function() {
             Route::get('/', 'MailController@index')->name('mails.index');
             Route::get('/edit/{mail}', 'MailController@edit')->name('mails.edit');
             Route::get('/create', 'MailController@create')->name('mails.create');
        });

        // if (env('APP_ENV') == "local")
        // {
            Route::get('/test', 'TestController@test')->name('test.test');
        // }
    });
});
