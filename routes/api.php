<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\QrController;
use App\Http\Controllers\TreeController;

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
Route::options('/{any}', function () {
    return response()->json([], 200);
})->where('any', '.*');



Route::group([
    'middleware' => 'api',
    // 'prefix' => 'auth'

], function ($router) {
    Route::post('/parks-by-qr', [QrController::class, 'getParkByQrCode']);
    Route::post('/XYtrees', [TreeController::class, 'latLngToXY']);
});

// Route::group(['middleware' => ['jwt.auth']], function () {
//     Route::post('/onTreesForUserNoData', [TreeController::class, 'onTreesForUserNoData']);
// });
