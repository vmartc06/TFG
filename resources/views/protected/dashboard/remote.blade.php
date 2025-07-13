<x-dashboard.main
        :currentView="'remote-control'"
        :device="$device">
    <div class="main-panel">
        <div class="content">
            <div class="container-fluid">
                <h4 class="page-title">Principal</h4>
                <div class="row">
                    <div class="col-md-4">
                        <div class="card card-stats card-primary">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="icon-big text-center">
                                            <i class="la la-clock-o"></i>
                                        </div>
                                    </div>
                                    <div class="col-8 d-flex align-items-center">
                                        <div class="numbers">
                                            <p class="card-category">Última conexión</p>
                                            <h4 class="card-title">Hace 1 minuto</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-stats card-warning">
                            <div class="card-body ">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="icon-big text-center">
                                            <i class="la la-battery-three-quarters"></i>
                                        </div>
                                    </div>
                                    <div class="col-8 d-flex align-items-center">
                                        <div class="numbers">
                                            <p class="card-category">Batería</p>
                                            <h4 class="card-title">85%</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-stats card-success">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="icon-big text-center">
                                            <i class="la la-bolt"></i>
                                        </div>
                                    </div>
                                    <div class="col-8 d-flex align-items-center">
                                        <div class="numbers">
                                            <p class="card-category">Estado</p>
                                            <h4 class="card-title">Cargando</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-stats card-danger">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="icon-big text-center">
                                            <i class="la la-signal"></i>
                                        </div>
                                    </div>
                                    <div class="col-8 d-flex align-items-center">
                                        <div class="numbers">
                                            <p class="card-category">Cobertura</p>
                                            <h4 class="card-title">Movistar</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-stats card-info">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="icon-big text-center">
                                            <i class="la la-wifi"></i>
                                        </div>
                                    </div>
                                    <div class="col-8 d-flex align-items-center">
                                        <div class="numbers">
                                            <p class="card-category">Wi-Fi</p>
                                            <h4 class="card-title">residenciawifi</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card card-stats card-info">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-4 d-flex justify-content-center align-items-center">
                                        <div class="icon-big text-center" style="width: 40px; height: 40px;">
                                            <img
                                                src="{{ asset('views/dashboard/img/bt-icon.svg') }}"
                                                alt="Bluetooth Icon"
                                                style="width: 100%; height: 100%; object-fit: contain;"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-8 d-flex align-items-center">
                                        <div class="numbers">
                                            <p class="card-category">Bluetooth</p>
                                            <h4 class="card-title">audifonomodelo</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card card-map">
                            <div class="card-header">
                                <h4 class="card-title">Ubicación del dispositivo</h4>
                            </div>
                            <div class="card-body" style="padding: 0;">
                                <div id="deviceMap" style="height: 400px; width: 100%;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-dashboard.footer />
    </div>
</x-dashboard.main>