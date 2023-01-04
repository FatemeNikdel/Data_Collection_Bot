<?php

use Illuminate\Http\Request;
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

/*Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});*/

Route::get('/setWebhook/{url}', 'TelegramController@setWebhook');
Route::get('/setMacWebhook/{url}', 'TelegramController@setMacWebhook');
Route::get('/getWebhook', 'TelegramController@getWebhook');
Route::get('/deleteWebhook', 'TelegramController@deleteWebhook');

Route::post('/'.env('HASHNUMBER'), 'TelegramController@getUpdate');

Route::get('/downloadAll/'.env('HASHNUMBER'), 'ReportController@downloadAll');
Route::get('/downloadUnreported/'.env('HASHNUMBER'), 'ReportController@downloadUnreported');

Route::get('/downloadAllTwoWeeks/'.env('HASHNUMBER'), 'ReportController@downloadAllTwoWeeks');
Route::get('/downloadUnreportedTwoWeeks/'.env('HASHNUMBER'), 'ReportController@downloadUnreportedTwoWeeks');


