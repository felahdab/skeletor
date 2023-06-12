<?php

use Illuminate\Support\Facades\Route;
use Modules\Transformation\Http\Controllers\FonctionController;
use Modules\Transformation\Http\Controllers\CompagnonageController;
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

Route::prefix(env('APP_PREFIX'))->group(function () {
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
});
