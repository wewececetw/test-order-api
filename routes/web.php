<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\OrderSummaryController;
use App\Http\Controllers\ConsistencyCheckController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/orders/summary', [OrderSummaryController::class, 'summary']);
Route::get('/orders/consistency-check', [ConsistencyCheckController::class, 'check']);
