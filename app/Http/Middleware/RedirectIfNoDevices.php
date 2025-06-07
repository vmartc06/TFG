<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNoDevices
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $devices = auth()->user()->devices->filter(function ($device) {
            return $device->api_key_encrypted !== null;
        });
        if ($devices->isEmpty()) {
            return redirect()
                ->route('protected.devices.add')
                ->with('welcome', true);
        }
        return $next($request);
    }
}
