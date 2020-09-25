<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', 'AuthController@showRegisterForm');
Route::post('/register', 'AuthController@register');

Route::get('/login', 'AuthController@register');
Route::post('/login', 'AuthController@register');



Route::get('/init', function () {
    \App\Models\User::create([
        'name' => 'admin',
        'password' => '123456',
        'email' => 'hesunfly@163.com',
        'uuid' => generateUuid(),
    ]);
});

