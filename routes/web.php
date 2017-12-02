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

Route::get('/', 'AuthController@getLogin');
Route::get('login', 'AuthController@getLogin');
Route::post('login', 'AuthController@postLogin')->name('login');
Route::get('logout', 'AuthController@getLogout')->name('logout');

Route::get('resetpw', 'AuthController@getResetPW')->name('resetpw');
Route::post('resetpw', 'AuthController@postResetPW')->name('resetpw');

Route::get('register', 'AuthController@getRegister')->name('register');
Route::post('register', 'AuthController@postRegister')->name('register');

Route::get('home', 'HomeController@index')->name('home');
