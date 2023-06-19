<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use Modules\Transformation\Api\v1\FonctionResourceController;
use Modules\Transformation\Api\v1\MarinResourceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'v1', 'middleware' => ['forcejson', 'auth:sanctum'], "as" => "api.v1."], function () {

    Route::apiResource('fonctions', FonctionResourceController::class);
    Route::apiResource('marins', MarinResourceController::class);
});
