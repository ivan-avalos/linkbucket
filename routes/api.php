<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/register', 'Auth\RegisterController@_register');
Route::post('/login', 'Auth\LoginController@_login');

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('/retrieve', 'ApiController@retrieve');
    Route::get('/retrieve/{id}', 'ApiController@single');
    Route::post('/add', 'ApiController@add');
    Route::post('/edit/{id}', 'ApiController@update');
    Route::post('/delete/{id}', 'ApiController@remove');
    Route::post('/logout', 'ApiController@logout');
});