<?php

namespace App\View\Components\dashboard;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\View\Component;
use Illuminate\View\ComponentAttributeBag;

class Main extends Component
{
    public string $title;
    public string $activeMenu;
    public string $device;

    /**
     * Create a new component instance.
     */
    public function __construct(string $currentView = "dashboard", string $device = "")
    {
        $this->title = 'Main';
        $this->activeMenu = $currentView;
        $this->device = $device;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.main', [
            'device' => $this->device
        ]);
    }
}
