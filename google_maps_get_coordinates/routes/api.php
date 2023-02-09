<?php

use GuzzleHttp\Client;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::post('/map/coordinates/{address}', function ($address) {
    $address1 = $address;

    $client = new Client();
    $response = $client->get('https://maps.googleapis.com/maps/api/geocode/json', [
        'query' => [
            'address' => $address1,
            'key' => env('GOOGLE_MAP_KEY'),
        ],
    ]);

    $data = json_decode($response->getBody(), true);

    if ($data['status'] === 'OK') {
        $location = $data['results'][0]['geometry']['location'];
        return response()->json([
            'latitude' => $location['lat'],
            'longitude' => $location['lng'],
        ]);
    }

    return response()->json([
        'error' => 'Address not found',
    ], 400);
});
