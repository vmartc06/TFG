<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Web\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
