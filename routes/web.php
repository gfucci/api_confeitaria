<?php

use App\Http\Controllers\CandyController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;

Route::apiResource('customer', CustomerController::class);
Route::apiResource('candy', CandyController::class)->only('index', 'show');
Route::apiResource('order', OrderController::class)->only('index', 'store', 'show');