<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::post('/auth/login', [AuthController::class, 'login']);
Route::get('/books/{title}', [BookController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('posts/export', [PostController::class, 'export'])->name('posts.export');
    Route::patch('posts/{post}/publish', [PostController::class, 'publish'])->name('posts.publish');
    Route::apiResource('posts', PostController::class);
});
