<?php

use App\Http\Controllers\MealController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {

    Route::controller(UserController::class)->group(function () {
        Route::get('users', 'index')->name('users-index');
        Route::post('users/update/{id}', 'update')->name('users-update');
        Route::get('users/{id}', 'show')->name('users-show');
        Route::delete('users', 'destroy')->name('users-destroy');
    });

    Route::controller(MealController::class)->group(function () {
        Route::get('meals', 'index')->name('meals-index');
        Route::post('meals/new', 'store')->name('meals-store');
        Route::post('meals/update/{id}', 'update')->name('meals-update');
        Route::get('meals/{id}', 'show')->name('meals-show');
        Route::delete('meals', 'destroy')->name('meals-destroy');
    });
});
