<?php

use App\Http\Controllers\Web\DashboardDevicesController;
use App\Http\Controllers\Web\DashboardController;
use App\Http\Controllers\Web\DevicesWizardController;
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
        Route::get('/dashboard', [DashboardController::class, 'main'])
            ->name('dashboard');
        Route::get('/dashboard/apps', [DashboardController::class, 'apps'])
            ->name('dashboard.appManagement');
        Route::get('/dashboard/remote', [DashboardController::class, 'remote'])
            ->name('dashboard.remoteControl');
        Route::get('/dashboard/templates', [DashboardController::class, 'templates'])
            ->name('dashboard.templateManagement');
        Route::get('/dashboard/device', [DashboardController::class, 'device'])
            ->name('dashboard.device');
        Route::get('/dashboard/devices', [DashboardController::class, 'devices'])
            ->name('dashboard.devices');

    });

    Route::get('/devices/add', [DevicesWizardController::class, 'renderDeviceAdd'])
        ->name('protected.devices.add');
});

