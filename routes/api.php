<?php

use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\ProfileController;
use App\Http\Controllers\API\TaskController;
use Illuminate\Support\Facades\Route;

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

/*Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});*/

// Guest Routes
Route::prefix('auth')
    ->middleware('guest:sanctum')
    ->group(function () {
        Route::post('login', LoginController::class);
    });
// Auth Routes
Route::middleware('auth:sanctum')
    ->group(function () {

// Profile
        Route::prefix('profile')->controller(ProfileController::class)->group(function () {
            Route::get('', 'show');
            Route::get('logout', 'logout');
        });

// Task
        Route::prefix('task')
            ->controller(TaskController::class)
            ->group(function () {
//        ?filter=completed
                Route::get('', 'index')->name('index');
                Route::get('{id}', 'details')->name('details');
                Route::post('store', 'store')->name('store');
                Route::put('update', 'update')->name('update');
                Route::delete('{id}', 'delete')->name('delete');
            });

    });
