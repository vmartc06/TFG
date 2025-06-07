<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Web\DashboardDevicesController;
use App\Http\Controllers\Web\DashboardMainController;
use App\Http\Controllers\Web\DevicesController;
use App\Http\Controllers\Web\LoginController;
use App\Http\Middleware\RedirectIfNoDevices;
use App\Http\Middleware\RedirectIfNotAuthenticated;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('public/index');
});

Route::get('/login', function () {
    return view('public/login');
})->name('login');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('public/register');
})->name('register');

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

