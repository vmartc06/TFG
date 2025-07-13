<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardController extends Controller
{
    public function main(Request $request): object
    {
        return view('protected.dashboard.main', [
            'device' => $request->query('device', ''),
        ]);
    }

    public function apps(Request $request): object
    {
        return view('protected.dashboard.apps', [
            'device' => $request->query('device', ''),
        ]);
    }

    public function remote(Request $request): object
    {
        return view('protected.dashboard.remote', [
            'device' => $request->query('device', ''),
        ]);
    }

    public function templates(Request $request): object
    {
        return view('protected.dashboard.templates', [
            'device' => $request->query('device', ''),
        ]);
    }

    public function device(Request $request): object
    {
        return view('protected.dashboard.device', [
            'device' => $request->query('device', ''),
        ]);
    }

    public function devices(Request $request): object
    {
        $devices = auth()->user()->devices()->get();
        return view('protected.dashboard.devices', [
            'device' => $request->query('device', ''),
            'devices' => $devices
        ]);
    }
}
