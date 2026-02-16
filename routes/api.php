<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\V1\ProjectController;
use App\Http\Controllers\Api\V1\RoleController;
use App\Http\Controllers\Api\V1\TaskCommentController;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function (): void {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('me', [AuthController::class, 'user']);

    Route::prefix('v1')->name('api.v1.')->middleware('throttle:api')->group(function (): void {
        Route::get('roles', [RoleController::class, 'index'])
            ->middleware('permission:manage-roles');
        Route::get('permissions', [RoleController::class, 'permissions'])
            ->middleware('permission:manage-roles');

        Route::apiResource('users', UserController::class)
            ->middleware('permission:manage-users');

        Route::apiResource('projects', ProjectController::class);
        Route::post('projects/{project}/tasks', [TaskController::class, 'store']);

        Route::apiResource('tasks', TaskController::class)->except(['store']);
        Route::post('tasks/{task}/comments', [TaskCommentController::class, 'store']);
    });
});
