<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'IndexController@welcome');

Route::group(['prefix' => 'admin'], function() {
    Route::get('auth/login', 'Auth\AuthController@getLogin');
    Route::post('auth/login', 'Auth\AuthController@postLogin');
    Route::get('auth/logout', 'Auth\AuthController@getLogout');

    Route::group(['namespace' => 'Admin', 'middleware' => 'auth'], function() {
        Route::resource('/', 'DashboardController');
        Route::resource('users', 'UsersController');
        Route::resource('blogs', 'BlogsController');
    });
});