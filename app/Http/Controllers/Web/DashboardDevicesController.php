<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardDevicesController extends Controller
{
    public function load(Request $request): object
    {
        $devices = auth()->user()->devices()->get();
        return view('protected.dashboard.devices', [
            'device' => $request->query('device', ''),
            'devices' => $devices
        ]);
    }
}
