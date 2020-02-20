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

Route::get('/', 'CitiesController@index');

Auth::routes();

Route::get('/home', 'CitiesController@index')->name('home');

Route::post('/weather', 'CitiesController@store');

Route::get('/weather/{city}', 'CitiesController@show');

Route::post('/checkWind/{cityId}', 'UsersCitiesController@store')->middleware('auth');
