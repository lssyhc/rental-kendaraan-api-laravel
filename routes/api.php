<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckRoleAdmin;
use App\Http\Middleware\CheckRoleCustomer;
use App\Http\Controllers\ChattingController;
use App\Http\Controllers\KendaraanController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CustomerController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Public routes
Route::post('/user/register', [UserController::class, 'register']);
Route::post('/user/login', [UserController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    // User routes
    Route::post('/user/logout', [UserController::class, 'logout']);
    Route::put('/user/member', [UserController::class, 'member']);

    // Both Customer and Admin routes
    Route::get('/kendaraan', [KendaraanController::class, 'index']);
    Route::get('/kendaraan/{id_kendaraan}', [KendaraanController::class, 'show']);
    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::get('/transaksi/{id_transaksi}', [TransaksiController::class, 'show']);
    Route::get('/customer/{id_customer}', [CustomerController::class, 'show']);

    // Admin routes
    Route::middleware([CheckRoleAdmin::class])->group(function () {
        Route::post('/kendaraan', [KendaraanController::class, 'store']);
        Route::put('/kendaraan/{id_kendaraan}', [KendaraanController::class, 'update']);
        Route::delete('/kendaraan/{id_kendaraan}', [KendaraanController::class, 'destroy']);
        Route::put('/chatting/balas/{id_chat}', [ChattingController::class, 'update']);
        Route::get('/customer', [CustomerController::class, 'index']);
        Route::put('/customer/{id_customer}', [CustomerController::class, 'update']);
        Route::delete('/customer/{id_customer}', [CustomerController::class, 'destroy']);
    });

    // Customer routes
    Route::middleware([CheckRoleCustomer::class])->group(function () {
        Route::post('/transaksi', [TransaksiController::class, 'store']);
        Route::post('/chatting', [ChattingController::class, 'store']);
    });
});