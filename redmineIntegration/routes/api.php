<?php

use App\Http\Controllers\RepoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/BaseProjects', [RepoController::class, 'getProjects']);
Route::get('/BaseIssues', [RepoController::class, 'getIssues']);
Route::get('/BaseAgileInfo', [RepoController::class, 'getAgileInfo']);
Route::get('/BaseGetUsers', [RepoController::class, 'getUsers']);
Route::get('/BaseGetTimeEntries', [RepoController::class, 'getUsers']);



