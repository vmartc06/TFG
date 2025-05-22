<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    public function login(Request $request): RedirectResponse
    {
        $validate = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'redirect_route_name' => 'sometimes|string'
        ]);

        $redirectRouteName = $validate['redirect_route_name'] ?? "";
        $credentials = $request->only('email', 'password');

        Log::debug("Route name: $redirectRouteName");

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();
            if (!empty($redirectRouteName)) {
                return redirect()->intended($redirectRouteName);
            }
            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'login_error' => 'Invalid credentials.',
        ])->withInput();
    }

    public function logout(Request $request): Redirector|RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}