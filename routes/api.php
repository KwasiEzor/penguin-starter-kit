<?php

use App\Http\Controllers\Api\PostController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum', 'throttle:api'])->group(function (): void {
    Route::get('/user', fn (Request $request) => new UserResource($request->user()));

    Route::apiResource('posts', PostController::class)->names('api.posts');
});
