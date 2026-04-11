<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\api\ApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'smoke',], function () {
    Route::post('store-smoke', [ApiController::class, 'storeSmoke']);
    Route::post('create-sexy-advert', [ApiController::class, 'createSexyAdvert']);
    Route::post('create-list-button-advert', [ApiController::class, 'createListButtonAdvert']);

    Route::post('update-status-group', [ApiController::class, 'updateStatusGroup']);
    Route::post('get-statistic', [ApiController::class, 'getStatistic']);
    Route::get('get-status-group', [ApiController::class, 'getStatusGroups']);
});