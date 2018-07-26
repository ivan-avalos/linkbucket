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
    if(Auth::check())
        return redirect('/home');
    else return view('welcome');
});

Auth::routes();

// Views
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/edit/{id}', 'HomeController@edit')->middleware('auth');
Route::get('/tags/{tag}', 'HomeController@tags')->middleware('auth');
Route::get('/search', 'HomeController@search')->middleware('auth');

// DB Functions
Route::post('/add', 'MainController@add')->middleware('auth');
Route::get('/remove/{id}', 'MainController@remove')->middleware('auth');
Route::post('/update/{id}', 'MainController@update')->middleware('auth');
