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
        Route::resource('blogs/categories', 'BlogCategoriesController');
        Route::resource('blogs/posts', 'PostsController');
        Route::resource('blogs/tags', 'TagsController');
        Route::resource('blogs', 'BlogsController');
    });
});

Route::group(['namespace' => 'Blogs'], function() {
    Route::get('blogs', ['uses' => 'PostsController@index', 'as' => 'blogs.index']);
    Route::get('blogs/{slug}', ['uses' => 'PostsController@show', 'as' => 'blogs.show']);
    Route::get('blogs/category/{category_name}', ['uses' => 'PostsController@category', 'as' => 'blogs.category']);
    Route::get('blogs/tag/{tag_name}', ['uses' => 'PostsController@tag', 'as' => 'blogs.tag']);
});

Route::get('accommodations', ['uses' => 'AccommodationsController@index', 'as' => 'accommodations.index']);