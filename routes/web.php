<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TelegramWebhookController;

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

\DB::listen(function ($query) {
    \Log::info($query->sql);
    \Log::info($query->bindings);
    \Log::info($query->time);
    // \Log::info(DB::getQueryLog());

    // dd($query);
    // \Log::info($query);

    // do something with the above. Log it, stream it via pusher, etc
});

Route::get('/', function () {
    return view('welcome');
});

// Route::middleware(['logger'])->group(function () {
Route::post('/webhook', [TelegramWebhookController::class, 'handle']);
// });




// после редактирования nginx работает и без роута, можно его отключить
// Route::get('storage/app/uploaded_files/visitors_inquiry_forms/{image}', function () {
//     return response()->view("404", [
//         "exception" =>  "exception"
//     ], 404);

// });
