<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TeamController;
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

Route::controller(AuthController::class)
    ->group(function () {
        Route::post('login', 'login');
        Route::post('register', 'register');
});

Route::middleware('auth:api')
    ->group(function () {

        // Auth
        Route::controller(AuthController::class)
            ->group(function () {
                Route::post('logout', 'logout');
                Route::post('refresh', 'refresh');
        });

        // Teams
        Route::resource('teams', TeamController::class);
        Route::post('teams/{team}/add-member', [TeamController::class, 'addMember']);

        // Project
        Route::resource('projects', ProjectController::class);

        // Tasks
        Route::resource('projects/{project}/tasks', TaskController::class)->scoped();
    });
