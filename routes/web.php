<?php

use App\Http\Controllers\CandyController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

Route::apiResource('customer', CustomerController::class);
Route::apiResource('candy', CandyController::class)->only('index', 'show');