<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::redirect('/', '/en');

Route::group(['prefix' => '{language}'], function () {

});

Route::get('/profile', function () {
    return view('profile');
});

Route::get('/profile/{lang}', function ($lang) {
    App::setLocale($lang);
    return view('profile');
});

