<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'] ,'dh' , 'DanhaoController@index');
Route::match(['get', 'post'] ,'txt' , 'DanhaoController@txt');
Auth::routes();
Route::get('excel/export','ExcelController@export');
Route::get('excel/import','ExcelController@import');
Route::get('/home', 'HomeController@index');
