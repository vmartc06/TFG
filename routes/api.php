<?php

use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function() {
    Route::get('/test', function() {
        return response()->json([
            "hello" => "world",
            "random_number" => rand(0, 10)
        ]);
    });
});

