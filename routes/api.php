<?php

use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::ApiResource('codes', 'CodeController')->only([
    'index', 'show','store','destroy'
]);
Route::ApiResource('codes.winners', 'WinnerController')->only([
    'index'
]);
Route::prefix('report')->group(function (){
    Route::get('is-winner','ReportController@is_winner');
});
Route::prefix('sms')->group(function (){
    Route::post('receive','SmsController@receive');
});
