<?php

use Illuminate\Http\Request;
use App\User;
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

// public routes
Route::post('/auth/login', 'AuthController@login')->name('login.api');
Route::post('/auth/register', 'AuthController@signup')->name('register.api');


Route::group(['middleware' => 'auth:api'], function() {
    Route::get('/auth/user','AuthController@user');
    Route::get('/auth/logout', 'AuthController@logout')->name('logout');
});
