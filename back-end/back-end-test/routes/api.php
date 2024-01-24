<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EpresenceController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->group(function() {
    Route::post('/presence/create', [EpresenceController::class, 'createPresence']);
    Route::get('/presence/get', [EpresenceController::class, 'getPresence']);
    Route::post('/presence/approve/{id}', [EpresenceController::class, 'approvePresence']);
    Route::post('/presence/reject/{id}', [EpresenceController::class, 'rejectPresence']);
});

Route::post('/login', [AuthController::class, 'login']);
