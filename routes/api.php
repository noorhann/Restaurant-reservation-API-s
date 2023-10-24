<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReservationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'auth/'], function () {
    Route::post('/create', [AuthController::class, 'create']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::group(['prefix' => 'menu/'], function () {
    Route::get('/', [MealController::class, 'index']);
});
Route::group(['middleware' => ['auth']], function () {
    
    Route::group(['prefix' => 'reservation/'], function () {
        Route::post('/checkAvailabilty', [ReservationController::class, 'checkAvailability']);
        Route::post('/store', [ReservationController::class, 'store']);
    });

    Route::group(['prefix' => 'order/'], function () {
        Route::post('/create', [OrderController::class, 'create']);
        Route::post('/checkout/{orderId}', [CheckoutController::class, 'checkout']);
    });
});
