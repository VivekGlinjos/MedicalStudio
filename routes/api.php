<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\CollegeController;

Route::prefix('v1')->group(function () {
    Route::prefix('colleges')->group(function () {
        Route::get('/', [CollegeController::class, 'index']);
        Route::get('/stats', [CollegeController::class, 'stats']);
        Route::get('/search', [CollegeController::class, 'search']);
        Route::get('/state/{stateId}', [CollegeController::class, 'getByState']);
        Route::get('/type/{type}', [CollegeController::class, 'getByType']);
        Route::get('/slug/{slug}', [CollegeController::class, 'showBySlug']);
        Route::get('/{id}', [CollegeController::class, 'show']);
        
        Route::post('/', [CollegeController::class, 'store']);
        Route::put('/{id}', [CollegeController::class, 'update']);
        Route::delete('/{id}', [CollegeController::class, 'destroy']);
    });
});
