<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class DashboardMainController extends Controller
{
    public function load(Request $request): object
    {
        return view('protected.dashboard.main', [
            'device' => $request->query('device', ''),
        ]);
    }
}
