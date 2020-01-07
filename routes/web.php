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

Route::get('/', 'KebunMapController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

/*
 * Outlets Routes
 */
Route::get('/our_kebuns', 'KebunMapController@index')->name('kebun_map.index');
Route::resource('kebuns', 'KebunController');
