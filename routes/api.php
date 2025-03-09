<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('analytic/{position_type}', AnalyticController::class);
Route::get('analytic-csv/{year}/{month}', AnalyticCsvController::class);
