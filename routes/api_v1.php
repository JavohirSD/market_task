<?php

use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\MerchantsController;
use App\Http\Controllers\v1\ShopsController;
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
Route::post('/auth/login', [AuthController::class,'login'])->name('login');
Route::post('/auth/register', [AuthController::class,'register'])->name('register');

Route::middleware(['auth:sanctum'])->group(function () {

    Route::prefix('merchant')->group(function () {
        Route::get('index',   [MerchantsController::class, 'index'])->name('merchant.index');
        Route::post('store',  [MerchantsController::class, 'store'])->name('merchant.store');
        Route::post('update', [MerchantsController::class, 'update'])->name('merchant.update');

        Route::get('show/{id}', [MerchantsController::class, 'show'])
            ->name('merchant.show')
            ->where('id', '[0-9]+');

        Route::delete('delete/{id}', [MerchantsController::class, 'delete'])
             ->name('merchant.delete')
             ->where('id', '[0-9]+');
    });


    Route::prefix('shop')->group(function () {
        Route::post('store',  [ShopsController::class, 'store'])->name('shop.store');
        Route::get('index',   [ShopsController::class, 'index'])->name('shop.index');
        Route::get('nearest', [ShopsController::class, 'nearestShops'])->name('shop.nearest');

        Route::get('show/{id}', [ShopsController::class, 'show'])
             ->name('shop.show')
             ->where('id', '[0-9]+');

        Route::post('update/{id}', [ShopsController::class, 'update'])
             ->name('shop.update')
             ->where('id', '[0-9]+');

        Route::delete('delete/{id}', [ShopsController::class, 'delete'])
             ->name('shop.delete')
             ->where('id', '[0-9]+');
    });
});

