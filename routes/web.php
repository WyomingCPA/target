<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\ai\AiController;
use App\Http\Controllers\goal\GoalController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::group(['prefix' => 'dashboard', 'middleware' => 'auth',], function () {
    Route::get('', [DashboardController::class, 'index'])->name('main');
});
Route::group(['prefix' => 'ai', 'middleware' => 'auth',], function () {
    Route::get('', [AiController::class, 'index'])->name('main');
    Route::get('idea', [AiController::class, 'idea'])->name('idea');
    Route::get('decomposition-task', [AiController::class, 'decompositionTask'])->name('decomposition-task');
    Route::get('plan', [AiController::class, 'plan'])->name('plan');
});
Route::group(['prefix' => 'goal', 'middleware' => 'auth',], function () {
    Route::get('', [GoalController::class, 'index'])->name('goal.main');
    Route::get('create', [GoalController::class, 'create'])->name('goal.create');
    Route::post('store', [GoalController::class, 'store'])->name('goal.store');
    Route::get('/edit/{id}', [GoalController::class, 'edit'])->name('goal.edit');
    Route::post('delete/{id}', [GoalController::class, 'delete'])->name('goal.delete');
    Route::post('/update/{id}', [GoalController::class, 'update'])->name('goal.update');
});
