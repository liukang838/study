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

Route::get('/', function () {
    return view('element');
});

Route::any('index', 'DebugController@index');
Route::any('sort', 'DebugController@sort');
Route::any('kafka', 'DebugController@production');
