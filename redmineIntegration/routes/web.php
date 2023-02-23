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

Route::get('/BaseProjects', [RepoController::class, 'get_projects']);
Route::get('/BaseProject/{project_id}', [RepoController::class, 'get_single_project']);
Route::get('/BaseProject/{project_id}/{assigned_to_id}', [RepoController::class, 'get_single_project']);
Route::get('/BaseIssues', [RepoController::class, 'get_issues']);
Route::get('/BaseAgileInfo', [RepoController::class, 'get_agile_info']);//todo:Ne radi
Route::get('/BaseGetUsers', [RepoController::class, 'get_users']);//todo:Ne radi
Route::get('/BaseGetTimeEntries', [RepoController::class, 'get_time_entries']);

Route::get('/info', function () {
    return phpinfo();
});


