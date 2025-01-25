<?php

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;

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

Route::middleware('auth:sanctum')->group(function () {

    Route::middleware('role:Admin')->group(function () {
        Route::post('/create-users', [AdminController::class, 'createUser']);
        Route::post('/create-projects', [AdminController::class, 'createProject']);
        Route::get('/getall-projects', [AdminController::class, 'getAllProjects']);
        Route::get('/get-project/{id}', [AdminController::class, 'getProjectById']);
        Route::put('/update-project/{id}', [AdminController::class, 'updateProject']);
        Route::delete('/delete-project/{id}', [AdminController::class, 'deleteProject']);
    });



    // Manager Routes
    Route::middleware('role:Manager')->group(function () {
        Route::post('/tasks', [ManagerController::class, 'createTask']);
        Route::get('/projects', [ManagerController::class, 'viewProjects']);

    });

    // Team Member Routes
    Route::middleware('role:Team Member')->group(function () {
        Route::get('/tasks', [TaskController::class, 'viewTasks']);
        Route::put('/tasks/{task}', [TaskController::class, 'updateTask']);
    });

});

Route::post('/register', [RegisteredUserController::class, 'store']);
Route::post('/login', [RegisteredUserController::class, 'login']);

