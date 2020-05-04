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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('request_meeting');

Auth::routes();

Route::get('/history_meeting', 'HomeController@history_meeting')->name('history');

Auth::routes();

Route::post('meetings/request_meeting', 'HomeController@request_meeting');