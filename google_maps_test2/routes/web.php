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
    $response = new GoogleMaps();
    $response->load('geocoding')
        ->setParam([
            'location' => [
                'lat' => -33.8669710,
                'lng' => 151.1958750
            ],
            'accuracy' => 0,
            "name" => "Google Shoes!",
            "address" => "48 Pirrama Road, Pyrmont, NSW 2009, Australia",
            "types" => ["shoe_store"],
            "website" => "http://www.google.com.au/",
            "language" => "en-AU",
            "phone_number" => "(02) 9374 4000"
        ])
        ->get();

    dd($response);
});
