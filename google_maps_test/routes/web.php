<?php

use GoogleMaps\GoogleMaps;
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

    $result = new GoogleMaps();
    dd($result);
//    $result2 = $result->load('geocoding')->setParam(['address' => 'gunduliceva 63'])->get();
    $result2 = $result->load('geocoding');
    dd($result2);
//    return \GoogleMaps::load('geocoding')
//        ->setParam([
//            'address' => 'gunduliceva 63',
//        ])
//        ->get();
});
