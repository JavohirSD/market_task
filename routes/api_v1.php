<?php

use App\Http\Controllers\v1\AuthController;
use App\Http\Controllers\v1\MerchantsController;
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
    Route::get('/merchant/index', [MerchantsController::class, 'index'])->name('merchant.index');
    Route::post('/merchant/store', [MerchantsController::class, 'store'])->name('merchant.store');
    Route::post('/merchant/update', [MerchantsController::class, 'update'])->name('merchant.update');

    Route::get('/merchant/show/{id}', [MerchantsController::class, 'show'])
        ->name('merchant.show')
        ->where('id', '[0-9]+');

    Route::delete('/merchant/delete/{id}', [MerchantsController::class, 'delete'])
        ->name('merchant.delete')
        ->where('id', '[0-9]+');

});

