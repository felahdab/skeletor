<?php

use Illuminate\Support\Facades\Route;

use App\Api\v1\SkeletorController;
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

Route::group(['namespace' => 'App\Api\v1' , 'prefix' => 'v1', 'middleware' => ['forcejson', 'auth:sanctum'], "as" => "api.v1."], function() 
    {
    Route::get('/whoami', [SkeletorController::class, 'who_am_i']);
    Route::get('/status', [SkeletorController::class, 'status']);
    Route::get('/status-detailed', [SkeletorController::class, 'status_detailed']);

    
});