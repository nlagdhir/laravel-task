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
    return redirect('films');
});


Route::get('films','FilmsController@index')->name('films');
Route::get('films/create','FilmsController@create')->name('film.create');
Route::post('films/create','FilmsController@store')->name('film.store');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
