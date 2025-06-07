<div class="sidebar">
    <div class="scroll-wrapper scrollbar-inner sidebar-wrapper" style="position: relative;">
        <div class="scrollbar-inner sidebar-wrapper scroll-content" style="height: 887px; margin-bottom: 0; margin-right: 0; max-height: none;">
            <div class="user">
                <div class="photo">
                    <img src="{{ asset('views/dashboard/img/default_profile_picture.jpg') }}" alt="Profile picture" />
                </div>
                <div class="info">
                    <a class="" data-toggle="collapse" href="#collapseExample" aria-expanded="true">
                        <span>
                            {{ $activeDevice->name }}
                            <span class="user-level">{{ $activeDeviceDisplayModel }}</span>
                            <span class="caret"></span>
                        </span>
                    </a>
                    <div class="clearfix"></div>

                    <div class="collapse in" id="collapseExample" aria-expanded="true" style="">
                        <ul class="nav">
                            @foreach($devices as $device)
                                @if($device == $activeDevice)
                                    @continue
                                @endif
                                <li>
                                    <a href="{{ route('dashboard', ['device' => $device->id]) }}" class="d-flex align-items-center">
                                        <img src="{{ asset('views/dashboard/img/default_profile_picture.jpg') }}" alt="Device 1" style="width: 24px; height: 24px; border-radius: 50%; margin-right: 10px;">
                                        <span class="link-collapse">{{ $device->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav">
                <li class="nav-item {{ $dashboardActive }}">
                    <a href="{{ route('dashboard') }}">
                        <i class="la la-dashboard"></i>
                        <p>Dashboard</p>
                        <span class="badge badge-count">5</span>
                    </a>
                </li>
                <li class="nav-item {{ $devicesActive }}">
                    <a href="{{ route('dashboard.devices') }}">
                        <i class="la la-mobile"></i>
                        <p>Devices</p>
                        <span class="badge badge-count">14</span>
                    </a>
                </li>
            </ul>
        </div><div class="scroll-element scroll-x"><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar" style="width: 100px;"></div></div></div><div class="scroll-element scroll-y"><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar" style="height: 85px;"></div></div></div></div>
</div>