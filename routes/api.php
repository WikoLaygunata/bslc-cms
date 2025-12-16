<?php

use App\Http\Controllers\DivisionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/divisions/all', [DivisionController::class, 'all']);

Route::get('/divisions', [DivisionController::class, 'index']);
Route::post('/divisions', [DivisionController::class, 'store']);
Route::get('/divisions/{division}', [DivisionController::class, 'show']);
Route::put('/divisions/{division}', [DivisionController::class, 'update']);
Route::delete('/divisions/{division}', [DivisionController::class, 'destroy']);

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::put('/users/{user}', [UserController::class, 'update']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);

// Route::apiResource('divisions', DivisionController::class);

// Route::apiResource('users', UserController::class);