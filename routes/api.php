<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DevicesController;
use App\Http\Controllers\Api\ManageController;
use App\Http\Middleware\DeviceAuth;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/devices/enroll', [DevicesController::class, 'enroll']);

    Route::middleware('auth:sanctum')->group(function() {
        Route::get('/devices', [DevicesController::class, 'list'])->name('api.devices');
        Route::post('/devices/add', [DevicesController::class, 'add'])->name('api.devices.add');
        Route::patch('/devices/change', [DevicesController::class, 'change']);
        Route::delete('/devices/delete', [DevicesController::class, 'delete']);
    });

    Route::middleware(DeviceAuth::class)->group(function() {
        Route::get('/manage/ping', [ManageController::class, 'ping']);
    });
});

