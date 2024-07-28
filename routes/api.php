<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CandyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('customer', CustomerController::class);
    Route::apiResource('candy', CandyController::class)->only('index', 'show');
    Route::apiResource('order', OrderController::class)->only('index', 'store', 'show');
});