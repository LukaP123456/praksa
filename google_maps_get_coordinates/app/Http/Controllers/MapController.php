<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class MapController extends Controller
{
    public function index(string $address)
    {
        //Converts address into Lat and Lng
        $result = Http::post("https://maps.googleapis.com/maps/api/geocode/json?address=$address&key" . env('GOOGLE_MAP_KEY'));
        dd($result->body());
    }
}


