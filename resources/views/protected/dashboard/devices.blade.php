<x-dashboard.main
        :currentView="'devices'"
        :device="$device">
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <h4 class="page-title">Dispositivos</h4>
                <div class="row">
                    <div class="col-md">
                        <div class="card" id="devices-list">
                            <div class="card-header">
                                <h4 class="card-title">Dispositivos enlazados</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th scope="col">Nombre</th>
                                                <th scope="col">Marca</th>
                                                <th scope="col">Modelo</th>
                                                <th scope="col">Versión de Android</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($devices as $device)
                                                @if($device->isEnrolled())
                                                <tr>
                                                    <td>{{ $device->name }}</td>
                                                    <td>{{ $device->info->brand }}</td>
                                                    <td>{{ $device->info->model }}</td>
                                                    <td>{{ $device->info->getAndroidVersion() }}</td>
                                                </tr>
                                                @endif
                                            @endforeach
                                            @if(!empty($devices))
                                                <tr>
                                                    <td colspan="4">
                                                        <button class="btn btn-primary">Agregar dispositivo</button>
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="card" id="device-add-form-container">
                            <div class="card-header">
                                <h4 class="card-title">Dispositivos no enlazados</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                        <tr>
                                            <th scope="col">Nombre</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($devices as $device)
                                            @if(!$device->isEnrolled())
                                                <tr>
                                                    <td>{{ $device->name }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-dashboard.footer />
    </div>
    <x-slot name="scripts">
        <script src="{{ asset('views/dashboard-devices/js/adb.js') }}"></script>
    </x-slot>
</x-dashboard.main>