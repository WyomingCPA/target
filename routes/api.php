<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\ApiController;
use App\Http\Controllers\api\TaskController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'smoke',], function () {
    Route::post('store-smoke', [ApiController::class, 'storeSmoke']);
    Route::post('time-since-last', [ApiController::class, 'timeSinceLast']);
});
Route::group(['prefix' => 'task',], function () {
    Route::post('stale', [TaskController::class, 'stale']);
    Route::post('/{task}/toggle-status', [TaskController::class, 'toggleStatus']);
});