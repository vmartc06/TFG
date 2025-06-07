<?php

namespace App\View\Components\dashboard;

use App\Models\Device;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;
use Illuminate\View\ComponentAttributeBag;

class Sidebar extends Component
{
    public string $dashboardActive;
    public string $devicesActive;

    private Collection $devices;
    private Device $activeDevice;
    private string $activeDeviceDisplayModel;

    /**
     * Create a new component instance.
     */
    public function __construct(string $activeMenu, string $device)
    {
        $this->setupActiveMenu($activeMenu);
        $this->loadDevices($device);
    }

    private function setupActiveMenu(string $activeMenu): void
    {
        $this->dashboardActive = "";
        $this->devicesActive = "";

        switch ($activeMenu)
        {
            case 'dashboard':
                $this->dashboardActive = 'active';
                break;
            case 'devices':
                $this->devicesActive = 'active';
                break;
        }
    }

    private function loadDevices(string $deviceID): void
    {
        $this->activeDeviceDisplayModel = "";
        $user = auth()->user();
        $this->devices = Device::where('user_id', $user->id)->get();
        $this->activeDevice = $this->devices->first();
        if (!empty($deviceID) && is_numeric($deviceID)) {
            foreach ($this->devices as $device) {
                if ($device->id == $deviceID) {
                    $this->activeDevice = $device;
                    break;
                }
            }
        }
        if ($this->activeDevice->info == null) {
            $this->activeDeviceDisplayModel = "Unenrolled";
        } else {
            $this->activeDeviceDisplayModel =
                $this->activeDevice->info->brand . " " .
                $this->activeDevice->info->product_name;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.sidebar', [
            'dashboardActive' => $this->dashboardActive,
            'devicesActive' => $this->devicesActive,
            'devices' => $this->devices,
            'activeDevice' => $this->activeDevice,
            'activeDeviceDisplayModel' => $this->activeDeviceDisplayModel
        ]);
    }
}
