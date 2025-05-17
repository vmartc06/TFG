<?php

namespace App\Http\Middleware;

use App\Models\Device;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class DeviceAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $providedKey = $request->header('device-key');

        if (!$providedKey) {
            return response()->noContent(401);
        }

        $device = Device::all()->first(function ($device) use ($providedKey) {
            return Hash::check($providedKey, $device->api_key_encrypted);
        });

        if (!$device) {
            return response()->noContent(401);
        }

        $request->setUserResolver(fn() => $device);

        return $next($request);
    }
}
