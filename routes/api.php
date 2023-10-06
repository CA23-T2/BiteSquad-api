<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MealController;
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

    Route::controller(MealController::class)->group(function () {
        Route::get('meals', 'index')->name('api-meals-index');
    });
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
