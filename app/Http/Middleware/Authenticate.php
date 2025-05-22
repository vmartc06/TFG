<?php

namespace App\Http\Middleware;

class Authenticate
{
    protected function redirectTo($request): ?string
    {
        if (!$request->expectsJson()) {
            return route('login');
        }
        return null;
    }
}