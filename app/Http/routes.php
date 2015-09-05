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
Route::get('/index/tours', 'IndexController@tours');
Route::get('/index/attractions', 'IndexController@attractions');
Route::get('/index/events', 'IndexController@events');
Route::get('/index/hires', 'IndexController@hires');
Route::get('/index/check', 'IndexController@check');

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
        Route::resource('pages', 'PagesController');

        Route::post('pages/upload', ['uses' => 'PagesController@upload', 'as' => 'admin.pages.upload']);
    });
});

Route::group(['namespace' => 'Blogs'], function() {
    Route::get('blogs', ['uses' => 'PostsController@index', 'as' => 'blogs.index']);
    Route::get('blogs/{slug}', ['uses' => 'PostsController@show', 'as' => 'blogs.show']);
    Route::get('blogs/category/{category_name}', ['uses' => 'PostsController@category', 'as' => 'blogs.category']);
    Route::get('blogs/tag/{tag_name}', ['uses' => 'PostsController@tag', 'as' => 'blogs.tag']);
});

Route::get('accommodation', ['uses' => 'AccommodationsController@index', 'as' => 'accommodation.index']);
Route::get('accommodation/show/{id}', ['uses' => 'AccommodationsController@show', 'as' => 'accommodation.show']);

Route::get('tours', ['uses' => 'ToursController@index', 'as' => 'tours.index']);
Route::get('tours/show/{id}', ['uses' => 'ToursController@show', 'as' => 'tours.show']);

Route::get('attractions', ['uses' => 'AttractionsController@index', 'as' => 'attractions.index']);
Route::get('attractions/show/{id}', ['uses' => 'AttractionsController@show', 'as' => 'attractions.show']);

Route::get('events', ['uses' => 'EventsController@index', 'as' => 'events.index']);
Route::get('events/show/{id}', ['uses' => 'EventsController@show', 'as' => 'events.show']);

Route::get('hires', ['uses' => 'HiresController@index', 'as' => 'hires.index']);
Route::get('hires/show/{id}', ['uses' => 'HiresController@show', 'as' => 'hires.show']);

Route::post('booking/{type}/{shortname}', ['uses' => 'BookingController@quote', 'as' => 'booking.quote']);
Route::post('booking/make', ['uses' => 'BookingController@make', 'as' => 'booking.make']);

Route::get('invoice/{id}/{code}', ['uses' => 'InvoiceController@show', 'as' => 'invoice.show']);
Route::get('mailinvoice/{id}/{code}', ['uses' => 'InvoiceController@mail', 'as' => 'invoice.mail']);

// Pages
Route::get('{page}', ['uses' => 'PagesController@show', 'as' => 'page.show']);