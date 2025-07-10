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
                        <p>Principal</p>
                    </a>
                </li>
                <li class="nav-item {{ $templateManagementActive }}">
                    <a href="{{ route('dashboard.templateManagement') }}">
                        <img
                                src="{{ asset('views/dashboard/img/manage-templates-icon.png') }}"
                                alt="Dashboard"
                                style="width: 25px; height: 23px; margin-right: 8px;"
                        />
                        <p>Gestionar plantillas</p>
                    </a>
                </li>
                <li class="nav-item {{ $appManagementActive }}">
                    <a href="{{ route('dashboard.appManagement') }}">
                        <img
                            src="{{ asset('views/dashboard/img/manage-apps-icon.png') }}"
                            alt="Dashboard"
                            style="width: 25px; height: 23px; margin-right: 8px;"
                        />
                        <p>Gestionar apps</p>
                    </a>
                </li>
                <li class="nav-item {{ $remoteControlActive }}">
                    <a href="{{ route('dashboard.remoteControl') }}">
                        <img
                            src="{{ asset('views/dashboard/img/remote-control-icon.png') }}"
                            alt="Dashboard"
                            style="width: 25px; height: 23px; margin-right: 8px;"
                        />
                        <p>Control remoto</p>
                    </a>
                </li>
                <li class="nav-item {{ $devicesActive }}">
                    <a href="{{ route('dashboard.devices') }}">
                        <img
                            src="{{ asset('views/dashboard/img/manage-devices-icon.png') }}"
                            alt="Dashboard"
                            style="width: 25px; height: 23px; margin-right: 8px;"
                        />
                        <p>Gestionar dispositivos</p>
                    </a>
                </li>
                <li class="nav-item {{ $deviceActive }}">
                    <a href="{{ route('dashboard.device') }}">
                        <i class="la la-mobile"></i>
                        <p>Mi dispositivo</p>
                    </a>
                </li>
            </ul>
        </div><div class="scroll-element scroll-x"><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar" style="width: 100px;"></div></div></div><div class="scroll-element scroll-y"><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar" style="height: 85px;"></div></div></div></div>
</div>