<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DevicesWizardController extends Controller
{
    public function renderDeviceAdd(Request $request): View|Closure|string
    {
        $showWelcome = $request->session()->get('welcome', false);
        $apiToken = auth()->user()->createToken('api-token')->plainTextToken;
        return view('protected.devices.add', [
            'showWelcome' => $showWelcome,
            'apiToken' => $apiToken
        ]);
    }
}
