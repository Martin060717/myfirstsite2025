<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/hello', function () {
    return view('Hello world');
});

Route::get('/snake', function () {
    return view('snake');
});