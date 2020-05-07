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
    // auth()->user()->assignRole('customer');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('request_meeting');

Auth::routes();

Route::get('/history_meeting', 'HomeController@history_meeting')->name('history');

Auth::routes();

Route::post('meetings/request_meeting', 'HomeController@request_meeting');

Auth::routes();

Route::post('meetings/approve_meeting', 'HomeController@approve_meeting');

Auth::routes();

Route::get('meetings/detail/{id}', 'DetailMeeting@index');

Route::post('event/add','EventController@store');
Route::get('event','EventController@calender');
