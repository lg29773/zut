<?php

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
Route::get('/base64','Base64ViewController@index');
Route::resource('/base64/convert','CRUD\Base64Controller');
Route::get('/email','mailController@showEmail');
Route::post('/send_email','mailController@sendEmail');

Route::get('/', function () {
    return view('welcome');
});
