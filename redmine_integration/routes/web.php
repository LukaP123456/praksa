<?php

use Illuminate\Support\Facades\Route;
use app\Repositories\BaseRepository;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test', function () {
    $base_repo = new BaseRepository();
    return $base_repo->CallRepo('redmine.url');
});
