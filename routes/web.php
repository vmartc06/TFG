<?php

use App\Http\Controllers\Web\DashboardDevicesController;
use App\Http\Controllers\Web\DashboardMainController;
use App\Http\Controllers\Web\DevicesController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Middleware\RedirectIfNoDevices;
use App\Http\Middleware\RedirectIfNotAuthenticated;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public/index');
});

Route::get('/register', function () {
    return view('public/register');
})->name('register');

Route::get('/login', function () {
    return view('public/login');
})->name('login');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::middleware([RedirectIfNotAuthenticated::class])->group(function() {
    Route::middleware([RedirectIfNoDevices::class])->group(function() {
        Route::get('/dashboard', [DashboardMainController::class, 'load'])
            ->name('dashboard');
        Route::get('/dashboard/devices', [DashboardDevicesController::class, 'load'])
            ->name('dashboard.devices');
    });

    Route::get('/devices/add', [DevicesController::class, 'renderDeviceAdd'])
        ->name('protected.devices.add');
});

