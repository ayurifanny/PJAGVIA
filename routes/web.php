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
    if (\Auth::check()) {
        if (auth()->user()->hasRole('admin')) {
            return redirect('/admin');;
        }
        return redirect('/home');
    }
    return view('welcome');
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

Route::get('list_request', 'HomeController@list_request');

Route::get('photo_detail/{id}', 'PictureCanvasController@index');

Route::post('save_picture', 'PictureCanvasController@save_picture');

Route::post('send_stroke', 'PictureCanvasController@send_stroke');

Route::get('test1', 'PictureCanvasController@call_event');
Route::get('admin', 'AdminController@index');

Route::post('upload', 'UploadsController@upload');

Route::get('storage/{filename}', function ($filename) {
    return Image::make(storage_path('public/' . $filename))->response();
});

Route::post('add_remarks', 'PictureCanvasController@add_remarks');
Route::post('add_drawing', 'PictureCanvasController@add_drawing');
Route::post('canvas_option', 'PictureCanvasController@canvas_option');
Route::post('update_role', 'AdminController@update');
Route::delete('users/{id}', 'AdminController@destroy');

Route::delete('photo/{id}', 'UploadsController@destroy');

Route::get('/download_pdf/{id}', 'ReportsController@download_pdf');
