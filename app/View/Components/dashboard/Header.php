<?php

namespace App\View\Components\dashboard;

use App\Models\User;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\Component;

class Header extends Component
{
    public string $profilePictureEnc;
    public object $user;

    public function __construct()
    {
        $this->user = auth()->user();
        $userID = $this->user->id;
        $path = "profile_pictures/{$userID}.png";

        if (!Storage::disk('local')->exists($path)) {
            $path = 'profile_pictures/default.png';
        }

        $profilePictureRaw = Storage::disk('local')->get($path);

        if ($profilePictureRaw === null) {
            Log::warning("Unable to read profile picture at {$path}");
        }

        $this->profilePictureEnc = base64_encode($profilePictureRaw);
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard.header', [
            'profilePictureEnc' => $this->profilePictureEnc,
            'user' => $this->user,
        ]);
    }
}
