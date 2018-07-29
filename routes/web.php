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
    else return redirect('/login');
});

Auth::routes();

// Views
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/edit/{id}', 'HomeController@edit')->middleware('auth');
Route::get('/tags/{tag}', 'HomeController@tags')->middleware('auth');
Route::get('/search', 'HomeController@search')->middleware('auth');

// Information views
Route::get('/site/about', 'HomeController@site_about');
Route::get('/site/open-source', 'HomeController@site_oss');
Route::get('/site/api', 'HomeController@site_api');

// DB Functions
Route::post('/add', 'MainController@add')->middleware('auth');
Route::get('/remove/{id}', 'MainController@remove')->middleware('auth');
Route::post('/update/{id}', 'MainController@update')->middleware('auth');

// Import functions
Route::get('/import', 'PocketController@import')->middleware('auth');
Route::get('/import2', 'PocketController@import2')->middleware('auth');