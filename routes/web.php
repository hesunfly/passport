<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    dd(Auth::user()->name);
});

Route::get('/register', 'AuthController@showRegisterForm');
Route::post('/register', 'AuthController@register');

Route::get('/login', 'AuthController@showLoginForm');
Route::post('/login', 'AuthController@login');
Route::get('/loginCheck', 'AuthController@loginCheck');

Route::get('logout', 'AuthController@logout');

//管理员登录
Route::get('/admin/login', 'AuthController@showLoginForm');
Route::post('/admin/login', 'AuthController@login');

Route::get('/getAccessToken', 'AppController@getAccessToken');

Route::get('/getUser', 'AuthController@getUser');

Route::group([
    'prefix' => 'apps',
], function () {
    Route::get('/', 'AppController@index');
    Route::get('/create', 'AppController@create');
    Route::post('/store', 'AppController@store');
    Route::get('/edit/{id}', 'AppController@edit')->where('id', '[0-9]+');
    Route::put('/save/{id}', 'AppController@save')->where('id', '[0-9]+');
    Route::delete('/destroy/{id}', 'AppController@destroy')->where('id', '[0-9]+');
});

//用户管理
Route::group([
    'prefix' => 'users',
], function () {
    Route::get('/', 'UserController@index');
    Route::get('/create', 'UserController@create');
    Route::post('/store', 'UserController@store');
    Route::get('/edit/{id}', 'UserController@edit')->where('id', '[0-9]+');
    Route::put('/save/{id}', 'UserController@save')->where('id', '[0-9]+');
});

Route::get('/init', function () {
    \App\Models\User::create([
        'name' => 'admin',
        'password' => '123456',
        'email' => 'hesunfly@163.com',
        'uuid' => generateUuid(),
    ]);
});

