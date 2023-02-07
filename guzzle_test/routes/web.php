<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;
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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/guzzle', function () {
    $client = new Client();
    $res = $client->request('get', 'https://dummyjson.com/products/', [
    ]);

    $response = Http::get('https://dummyjson.com/products/');
    dd($res);
});

