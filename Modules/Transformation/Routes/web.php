<?php

use Illuminate\Support\Facades\Route;
use Modules\Transformation\Http\Controllers\FonctionController;
use Modules\Transformation\Http\Controllers\CompagnonageController;
use Modules\Transformation\Http\Controllers\TacheController;
use Modules\Transformation\Http\Controllers\ObjectifController;
use Modules\Transformation\Http\Controllers\SousObjectifController;
use Modules\Transformation\Http\Controllers\StageController;
use Modules\Transformation\Http\Controllers\StatistiqueController;
use Modules\Transformation\Http\Controllers\TransformationController;
use Modules\Transformation\Http\Controllers\TransformationHistoryController;
use Modules\Transformation\Http\Controllers\ArchivageController;
use Modules\Transformation\Http\Controllers\HomeController;
use Modules\Transformation\Http\Controllers\ImportExportParcours;

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

Route::name('transformation::')->group(function () {
    Route::group(['middleware' => ['auth', 'permission']], function () {
        Route::prefix(env('APP_PREFIX'))->group(function () {

            Route::get('transformation/home', [HomeController::class, "index"])->name('transformation.homeindex');

            Route::resource('fonctions',      FonctionController::class);
            Route::get('fonctions/{fonction}/ajoutecompagnonage', [FonctionController::class, 'choisircompagnonage'])->name('fonctions.choisircompagnonage');
            Route::post('fonctions/{fonction}/ajoutecompagnonage', [FonctionController::class, 'ajoutercompagnonage'])->name('fonctions.ajoutercompagnonage');
            Route::post('fonctions/{fonction}/removecompagnonage/{compagnonage}', [FonctionController::class, 'removecompagnonage'])->name('fonctions.removecompagnonage');
            Route::get('fonctions/{fonction}/ajoutestage', [FonctionController::class, 'choisirstage'])->name('fonctions.choisirstage');
            Route::post('fonctions/{fonction}/ajoutestage', [FonctionController::class, 'ajouterstage'])->name('fonctions.ajouterstage');
            Route::post('fonctions/{fonction}/removestage/{stage}', [FonctionController::class, 'removestage'])->name('fonctions.removestage');
            Route::get('fonctions/{fonction}/validergroupe', [FonctionController::class, 'choixmarins'])->name('fonctions.choixmarins');
            Route::post('fonctions/{fonction}/validergroupe', [FonctionController::class, 'validermarins'])->name('fonctions.validermarins');
            Route::get('fonctions/{fonction}/listemarinsfonction', [FonctionController::class, 'listemarinsfonction'])->name('fonctions.listemarinsfonction');

            Route::resource('compagnonages',  CompagnonageController::class);
            Route::get('compagnonages/{compagnonage}/ajoutetache', [CompagnonageController::class, 'choisirtache'])->name('compagnonages.choisirtache');
            Route::post('compagnonages/{compagnonage}/ajoutetache', [CompagnonageController::class, 'ajoutertache'])->name('compagnonages.ajoutertache');
            Route::post('compagnonages/{compagnonage}/removetache/{tache}', [CompagnonageController::class, 'removetache'])->name('compagnonages.removetache');

            Route::resource('taches',         TacheController::class);
            Route::get('taches/{tach}/ajouteobjectif', [TacheController::class, 'choisirobjectif'])->name('taches.choisirobjectif');
            Route::post('taches/{tach}/ajouteobjectif/{objectif}', [TacheController::class, 'ajouterobjectif'])->name('taches.ajouterobjectif');
            Route::post('taches/{tach}/removeobjectif/{objectif}', [TacheController::class, 'removeobjectif'])->name('taches.removeobjectif');

            Route::resource('objectifs', ObjectifController::class);

            Route::resource('sous-objectifs', SousObjectifController::class);
            Route::post('sous-objectifs/multipleupdate', [SousObjectifController::class, 'multipleupdate'])->name('sous-objectifs.multipleupdate');

            Route::resource('stages',         StageController::class);
            Route::post('stages/{stage}/validergroupe', [StageController::class, 'validermarins'])->name('stages.validermarins');
            Route::post('stages/{stage}/attribuerstage', [StageController::class, 'attribuerstage'])->name('stages.attribuerstage');
            Route::post('stages/{stage}/retirerstage', [StageController::class, 'annulermarins'])->name('stages.annulermarins');
            Route::get('stages_du_marin/{user}', [StageController::class, 'stages_du_marin'])->name('users.stages');

            Route::group(['prefix' => 'transformation'], function () {
                Route::get('/', [TransformationController::class, 'index'])->name('transformation.index');
                Route::get('/parfonction', [TransformationController::class, 'indexparfonction'])->name('transformation.indexparfonction');
                Route::get('/parcomp', [TransformationController::class, 'indexparcomp'])->name('transformation.indexparcomp');
                Route::get('/parstage', [TransformationController::class, 'indexparstage'])->name('transformation.indexparstage');
                Route::get('/{user}/choisirfonction', [TransformationController::class, 'choisirfonction'])->name('users.choisirfonction');
                Route::post('/{user}/choisirfonction', [TransformationController::class, 'attribuerfonction'])->name('users.attribuerfonction');
                Route::post('/{user}/retirerfonction', [TransformationController::class, 'retirerfonction'])->name('users.retirerfonction');
                Route::get('/{user}/livret', [TransformationController::class, 'livret'])->name('transformation.livret');
                Route::get('/{user}/livretpdf', [TransformationController::class, 'livretpdf'])->name('transformation.livretpdf');
                Route::get('/{user}/progression', [TransformationController::class, 'progression'])->name('transformation.progression');
                Route::get('/{user}/fichebilan', [TransformationController::class, 'fichebilan'])->name('transformation.fichebilan');
                Route::get('/{user}/fichebilanpdf', [TransformationController::class, 'fichebilanpdf'])->name('transformation.fichebilanpdf');
                Route::get('/mafichebilan', [TransformationController::class, 'mafichebilan'])->name('transformation.mafichebilan');
                Route::get('/parcoursfichebilan', [TransformationController::class, 'parcoursfichebilan'])->name('transformation.parcoursfichebilan');
                Route::get('/monlivret', [TransformationController::class, 'monlivret'])->name('transformation.monlivret');
                Route::get('/maprogression', [TransformationController::class, 'maprogression'])->name('transformation.maprogression');
                Route::get('/exportparcours', [ImportExportParcours::class, 'ExportParcoursVersExcel'])->name('transformation.exportparcours');
                Route::get('/recalcultransfo', [TransformationController::class, 'recalcultransfo'])->name('transformation.recalcultransfo');
            });

            Route::get('statistiques/', [StatistiqueController::class, 'index'])->name('statistiques.index');
            Route::get('statistiques/parservice', [StatistiqueController::class, 'pourtuteurs'])->name('statistiques.pourtuteurs');
            Route::get('statistiques/parservice/{service}', [StatistiqueController::class, 'parservice'])->name('statistiques.parservice');
            Route::get('statistiques/global', [StatistiqueController::class, 'pourem'])->name('statistiques.pourem');
            Route::get('statistiques/stages', [StatistiqueController::class, 'pour2ps'])->name('statistiques.pour2ps');
            Route::get('statistiques/dashboard', [StatistiqueController::class, 'dashboard'])->name('statistiques.dashboard');
            Route::get('statistiques/dashboardarchive', [StatistiqueController::class, 'dashboardarchive'])->name('statistiques.dashboardarchive');
            //Route::get('statistiques/parcomp', [StatistiqueController::class, 'parcomp'])->name('statistiques.parcomp');
            //Route::get('/{compagnonage}/statistiques.transfoparcomp', 'StatistiqueController@transfoparcomp')->name('statistiques.transfoparcomp');

            Route::group(['prefix' => 'historique'], function () {
                Route::get('/', [TransformationHistoryController::class, 'index'])->name('historique.index');
            });

            Route::get('archivage', [ArchivageController::class, 'index'])->name('archivage.index');
            Route::get('archivage/{user}/restauravecdonnees', [ArchivageController::class, 'conservcpte'])->name('archivage.conservcpte');
            Route::get('archivage/{user}/restaursansdonnees', [ArchivageController::class, 'effacecpte'])->name('archivage.effacecpte');
            Route::get('archivage/{user}/impression', [ArchivageController::class, 'imprimer'])->name('archivage.imprimer');
            Route::get('archivage/{user}/archivage', [ArchivageController::class, 'archiver'])->name('archivage.archiver');
            Route::get('archivage/{user}/suppr', [ArchivageController::class, 'supprimer'])->name('archivage.supprimer');
        });
    });
});
