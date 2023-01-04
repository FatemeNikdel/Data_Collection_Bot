<?php

use Illuminate\Support\Facades\Route;

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
/*
Route::get('/', function () {
    return view('welcome');
});*/
Route::get('/twoweeksreport/'.env('HASHNUMBER'), 'TelegramController@twoWeeksReport')->name('twoweeks.repoert');
Route::get('/all/'.env('HASHNUMBER'), 'ReportController@joinedTables');
Route::get('/download_voices/'.env('HASHNUMBER'), 'ReportController@voices');
