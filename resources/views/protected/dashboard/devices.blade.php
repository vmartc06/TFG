<x-dashboard.main
        :currentView="'devices'"
        :device="$device">
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <h4 class="page-title">Devices</h4>
                <div class="row">
                    <div class="col-md">

                        <div class="card" id="devices-list">
                            <div class="card-header">
                                <h4 class="card-title">Devices list</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Brand</th>
                                                <th scope="col">Model</th>
                                                <th scope="col">Android SDK Version</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($devices as $device)
                                            <tr>
                                                <td>{{ $device->name }}</td>
                                                @if($device->info != null)
                                                    <td>{{ $device->info->brand }}</td>
                                                    <td>{{ $device->info->model }}</td>
                                                    <td>{{ $device->info->andorid_build_sdk }}</td>
                                                @else
                                                    <td colspan="3">Unregistered</td>
                                                @endif
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        <div class="card" id="device-add-form-container">
                            <div class="card-header">
                                <h4 class="card-title">Add a device</h4>
                            </div>
                            <div class="card-body">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <nav class="pull-left">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link" href="http://www.themekita.com">
                                ThemeKita
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">
                                Help
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="https://themewagon.com/license/#free-item">
                                Licenses
                            </a>
                        </li>
                    </ul>
                </nav>
                <div class="copyright ml-auto">
                    2018, made with <i class="la la-heart heart text-danger"></i> by <a href="http://www.themekita.com">ThemeKita</a>
                </div>
            </div>
        </footer>
    </div>
    <x-slot name="scripts">
        <script src="{{ asset('views/dashboard-devices/js/adb.js') }}"></script>
    </x-slot>
</x-dashboard.main>