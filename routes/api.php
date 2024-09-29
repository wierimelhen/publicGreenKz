<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CityController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SpeciesController;
use App\Http\Controllers\TreeOwnerController;
use App\Http\Controllers\TreeVitalityController;
use App\Http\Controllers\TreeController;
use App\Http\Controllers\LogsController;
use \App\Commands\TelegramButtons;
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
Route::options('/{any}', function() {
    return response()->json([], 200);
})->where('any', '.*');

Route::post('/getAListOfCities', [CityController::class, 'getAListOfCities']);


Route::group([

    'middleware' => 'api',
    // 'prefix' => 'auth'

], function ($router) {
    Route::post('/login_auth', [AuthController::class, 'login_auth']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/me', [AuthController::class, 'me']);
});

Route::group(['middleware' => ['jwt.auth']], function () {
    Route::post('/onTreesForUserNoData', [TreeController::class, 'onTreesForUserNoData']);
});

Route::post('/addTree', [TreeController::class, 'addTree']);

Route::post('/getTreeSpecies', [SpeciesController::class, 'getTreeSpecies']);
Route::post('/getTreeOwners', [TreeOwnerController::class, 'getTreeOwners']);
Route::post('/getTreeVitalities', [TreeVitalityController::class, 'getTreeVitalities']);
Route::post('/addAppLog', [LogsController::class, 'addAppLog']);

Route::post('/telegram_buttons', [TelegramButtons::class, 'handle']);

