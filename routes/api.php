<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MealController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\RatingController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
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


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login')->name('api-login');
    Route::post('register', 'register')->name('api-register');
});


Route::middleware('auth:sanctum')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::get('users', 'index')->name('api-users-index');
        Route::post('users/update', 'update')->name('api-users-update');
        Route::get('users/{id}', 'show')->name('api-users-show');
        Route::delete('users', 'destroy')->name('api-users-destroy');
    });

    Route::controller(RatingController::class)->group(function () {
        Route::get('meals/rating/{id}', 'show')->name('api-rating-show');
        Route::patch('meals/rating/{id}', 'update')->name('api-rating-update');
        Route::delete('meals/rating/{id}', 'destroy')->name('api-ratings-destroy');
        Route::get('meals/{id}/ratings', 'index')->name('api-ratings-index');
        Route::post('meals/{id}/ratings/new', 'store')->name('api-ratings-store');
    });

    Route::controller(MealController::class)->group(function () {
        Route::get('meals', 'index')->name('api-meals-index');
        Route::get('meals/{id}', 'show')->name('api-meals-show');
    });

    Route::controller(OrderController::class)->group(function () {
        Route::get('orders', 'index')->name('api-orders-index');
        Route::get('orders/{id}', 'show')->name('api-orders-show');
        Route::patch('orders/edit/{id}', 'update')->name('api-orders-update');
        Route::post('orders/new', 'store')->name('api-orders-store');
        Route::delete('orders/{id}', 'destroy')->name('api-orders-destroy');
    });

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
