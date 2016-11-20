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

Route::group(['prefix' => 'admin'], function () {
    Route::get('/', 'Admin\HomeController@index');
    Route::get('/login', 'Admin\Auth\AuthController@showLoginForm');
    Route::post('/login', 'Admin\Auth\AuthController@login');
    Route::get('/logout', 'Admin\Auth\AuthController@logout');
    Route::post('/password/email', 'Admin\Auth\PasswordController@sendResetLinkEmail');
    Route::post('/password/reset', 'Admin\Auth\PasswordController@reset');
    Route::get('/password/reset/{token?}', 'Admin\Auth\PasswordController@showResetForm');
    Route::get('/register', 'Admin\Auth\AuthController@showRegistrationForm');
    Route::post('/register', 'Admin\Auth\AuthController@register');
    Route::group(['middleware' => 'auth'], function () {
        Route::resource('/users', 'Admin\UserController', ['except' => ['store', 'create']]);
        Route::resource('/children', 'Admin\ChildController');
        Route::resource('/categories', 'Admin\CategoryController');
        Route::resource('/tags', 'Admin\TagController');
        Route::resource('/videos', 'Admin\VideoController');
        Route::resource('/playlists', 'Admin\PlaylistController');
    });
});

Route::group(['prefix' => 'child'], function () {
    Route::get('/login', 'Child\Auth\AuthController@showLoginForm');
    Route::post('/login', 'Child\Auth\AuthController@login');
    Route::get('/logout', 'Child\Auth\AuthController@logout');
    Route::group(['middleware' => 'auth:child'], function () {
        Route::get('/', 'Child\HomeController@index');
    });
});
