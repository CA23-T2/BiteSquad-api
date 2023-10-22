<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\MealController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\SettingsController;
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
    return view('mails.invoice_mail');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth', 'role:all'])->group(function () {

    Route::controller(MealController::class)->group(function () {
        Route::get('meals', 'index')->name('meals-index');
        Route::get('meals/new', 'create')->name('meals-create');
        Route::get('meals/{id}', 'show')->name('meals-show');
        Route::get('meals/edit/{id}', 'edit')->name('meals-edit');
        Route::post('meals/update/{id}', 'update')->name('meals-update');
        Route::post('meals/new', 'store')->name('meals-store');
        Route::delete('meals/{id}', 'destroy')->name('meals-destroy');
    });

    Route::controller(OrderController::class)->group(function () {
        Route::get('orders', 'index')->name('orders-index');
        Route::get('orders/all', 'all')->name('orders-all');
        Route::get('orders/today/done', 'done')->name('orders-done');
        Route::get('orders/{id}', 'show')->name('orders-show');
        Route::post('orders/update/{id}', 'update')->name('orders-update');
    });

});

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::controller(UserController::class)->group(function () {
        Route::get('users', 'index')->name('users-index');
        Route::get('users/new', 'create')->name('users-create');
        Route::post('users/new', 'store')->name('users-store');

        Route::get('users/edit/{id}', 'edit')->name('users-edit');
        Route::post('users/update/{id}', 'update')->name('users-update');
        Route::get('users/{id}', 'show')->name('users-show');
        Route::delete('users/{id}', 'destroy')->name('users-destroy');
    });

    Route::controller(InvoiceController::class)->group(function () {
        Route::get('invoices', 'index')->name('invoice-index');
        Route::get('invoice/month/current', 'newInvoice')->name('invoice-newInvoice');
    });

    Route::controller(SettingsController::class)->group(function () {
        Route::get('settings', 'index')->name('settings-index');
        Route::patch('settings/{id}/update', 'update')->name('settings-update');
    });
});


