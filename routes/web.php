<?php

use Illuminate\Support\Facades\Route;
use TCG\Voyager\Facades\Voyager;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
