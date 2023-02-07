<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

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

Route::post('/imgUpload', function (Request $request) {
    if ($request->hasFile('avatar')) {
        $file = $request->file('avatar');
        $filename = $file->getClientOriginalName();
        $file->storeAs('avatars/' . mt_rand(1, 99), $filename, 's3');
        var_dump($file);
    } else {
        return response('no photo');
    }
});

Route::get('/imgGet', function () {
    return Storage::disk('s3')->response('avatars/61/a069488725d84cbc924db4a30a0b5136_1080.jpg');
});


