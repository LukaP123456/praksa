<?php

use App\Http\Controllers\RepoController;
use Illuminate\Support\Facades\Route;

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

Route::get('/BaseProjects', [RepoController::class, 'getProjects']);
Route::get('/BaseIssues', [RepoController::class, 'getIssues']);


