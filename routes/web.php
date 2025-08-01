<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group([
    'middleware' => 'auth'
], function () {
    Route::get('/dashboard', [\App\Http\Controllers\PageController::class, 'dashboard'])->name('dashboard');
    Route::get('/orders/create', [\App\Http\Controllers\OrderController::class, 'create'])->name('orders.create')->middleware(['choosed_buyer']);
    Route::post('/orders', [\App\Http\Controllers\OrderController::class, 'store'])->name('orders.store');
    Route::get('/spinner', [\App\Http\Controllers\PageController::class, 'spinner'])->name('spinner')->middleware(['choosed_buyer']);
});


require __DIR__ . '/auth.php';
