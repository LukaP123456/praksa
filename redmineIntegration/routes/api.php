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

Route::get('/BaseProjects', [RepoController::class, 'get_projects']);
Route::get('/BaseTrackers', [RepoController::class, 'get_trackers']);
Route::get('/BaseIssues', [RepoController::class, 'get_issues']);
Route::get('/BaseAgileInfo', [RepoController::class, 'get_agile_info']);
Route::get('/BaseGetUsers', [RepoController::class, 'get_users']);
Route::get('/BaseGetTimeEntries', [RepoController::class, 'get_time_entries']);



