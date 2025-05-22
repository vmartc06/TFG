<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Web\LoginController;
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
    Route::get('/dashboard', function () {
        return view('protected/dashboard');
    })->name('dashboard');
    Route::get('/test', function () {
        return view('protected/test');
    })->name('test');
});

