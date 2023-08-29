<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ArticleController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

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

Route::middleware('auth:sanctum')->prefix('v1')->group(function() {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    Route::apiResource('/articles', ArticleController::class);
});

Route::prefix('v1')->group(function() {
    Route::post('/get_token', [AuthenticatedSessionController::class, 'get_token'])->name('auth.get_token');
});

