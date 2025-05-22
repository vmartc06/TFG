<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfNotAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            $routeName = $request->route()->getName();
            return redirect()
                ->route('login')
                ->with('redirect_error', "You must be logged in order to access $routeName page.")
                ->with('redirect_route_name', $routeName);
        }
        return $next($request);
    }
}
