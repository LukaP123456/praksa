<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::post('/map/coordinates/{address}', function ($address) {
//    $address1 = $address;
//    $client = new Client();
//    $response = $client->get('https://maps.googleapis.com/maps/api/geocode/json', [
//        'query' => [
//            'address' => $address1,
//            'key' => env('GOOGLE_MAP_KEY'),
//        ],
//    ]);
//
//    $data = json_decode($response->getBody(), true);
//
//    if ($data['status'] === 'OK') {
//        $location = $data['results'][0]['geometry']['location'];
//        return response()->json([
//            'latitude' => $location['lat'],
//            'longitude' => $location['lng'],
//        ]);
//    }
//
//    return response()->json([
//        'error' => 'Address not found',
//    ], 400);
//});

Route::post('/map/coordinates', function (Request $request) {
    $address = $request->input('address');

    // Geocode the address using Google Maps API
    $url = "https://maps.googleapis.com/maps/api/geocode/json?address=" . urlencode($address) . "&key=" . env('GOOGLE_MAP_KEY');
    $resp = file_get_contents($url);
    $resp = json_decode($resp, true);

    // Extract the latitude and longitude from the API response
    $latitude = $resp['results'][0]['geometry']['location']['lat'];
    $longitude = $resp['results'][0]['geometry']['location']['lng'];

    return response()->json([
        'latitude' => $latitude,
        'longitude' => $longitude
    ]);
});
