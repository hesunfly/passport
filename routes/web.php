<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', 'AuthController@showRegisterForm');
Route::post('/register', 'AuthController@register');

Route::get('/login', 'AuthController@showLoginForm');
Route::post('/login', 'AuthController@login');

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

