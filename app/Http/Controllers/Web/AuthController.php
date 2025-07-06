<?php

namespace App\Http\Controllers\Web;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
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

    public function register(Request $request): RedirectResponse
    {
        $validate = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required|string'
        ]);

        User::create([
            'name' => $validate['name'],
            'email' => $validate['email'],
            'password' => Hash::make($validate['password'])
        ]);

        $credentials = $request->only('email', 'password');

        if (!Auth::attempt($credentials, $request->filled('remember'))) {
            return back()->route('login')->withErrors([
                'login_error' => 'Failed to login after registration.',
            ]);
        }

        $request->session()->regenerate();
        return redirect()->intended('dashboard');
    }

    public function logout(Request $request): Redirector|RedirectResponse
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}