<?php

use Illuminate\Support\Facades\Route;

Route::get('/suggestions', [App\Http\Controllers\SuggestionController::class, 'index']);
Route::get('/sent-requests', [App\Http\Controllers\RequestController::class, 'index']);
Route::get('/received-requests', [App\Http\Controllers\RequestController::class, 'show']);
Route::get('/withdraw-request/{id}', [App\Http\Controllers\RequestController::class, 'update']);
Route::get('/accept-request/{id}', [App\Http\Controllers\RequestController::class, 'store']);
Route::get('/connections', [App\Http\Controllers\ConnectionController::class, 'index']);
Route::get('/connection/remove/{id}', [App\Http\Controllers\ConnectionController::class, 'destroy']);
Route::post('/connection/store', [App\Http\Controllers\ConnectionController::class, 'store']);
