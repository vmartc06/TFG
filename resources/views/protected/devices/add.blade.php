<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Document</title>
        <link rel="stylesheet" href="{{ asset('views/devices-add/css/montserrat-font.css') }}" />
        <link rel="stylesheet" href="{{ asset('views/devices-add/css/style.css') }}" />
        <link rel="stylesheet" href="{{ asset('views/devices-add/css/smart_wizard_all.min.css') }}" />
        <x-layout.head />
    </head>
    <body>
        <div class="page-content" style="background-image: url('{{ asset('views/devices-add/img/wizard-v10-bg.jpg') }}')">
            <div class="wizard-v10-content">
                <div class="wizard-form">
                    <div class="wizard-header">
                        <h3>ADD A DEVICE</h3>
                    </div>
                    <form id="device-wizard" class="form-register" action="#" method="post">
                        @if($showWelcome)
                            <div class="wizard-welcome">
                                <h4>Welcome! Let's set up your first device 🚀</h4>
                                <p>Just a few simple steps to get everything ready for you.</p>
                            </div>
                        @endif
                        <div class="wizard-error" id="wizard-error-box" style="display: none;">
                            <h4 id="step-error"></h4>
                        </div>
                        <div id="smartwizard">
                            <ul class="nav">
                                <li><a class="nav-link" href="#step-1">Step 1<br /><small>Name Device</small></a></li>
                                <li><a class="nav-link" href="#step-2">Step 2<br /><small>Automatic setup</small></a></li>
                                <li><a class="nav-link" href="#step-3">Step 3<br /><small>Manual setup</small></a></li>
                                <li><a class="nav-link" href="#step-4">Step 4<br /><small>Done</small></a></li>
                            </ul>
                            <div class="tab-content">
                                <div id="step-1" class="tab-pane" role="tabpanel">
                                    <div class="inner" style="display: none">
                                        <div class="form-row">
                                            <div class="form-holder form-holder-2">
                                                <label for="device-name">Put a name to your device</label>
                                                <input type="text" class="form-control" id="device-name" name="device-name" placeholder="Mom's phone" />
                                            </div>
                                        </div>
                                        <div class="setup-buttons d-flex flex-column flex-md-row justify-content-center align-items-center mt-3 gap-3">
                                            <button id="btn-step-1a-next" type="button" class="btn btn-primary mb-2 mb-md-0">Automatic setup</button>
                                            <span class="separator-text mx-md-3 my-2 my-md-0">or</span>
                                            <button id="btn-step-1b-next" type="button" class="btn btn-outline-primary">Manual setup</button>
                                        </div>
                                    </div>
                                    <div class="inner">
                                        <div class="form-row justify-content-center mb-4">
                                            <div class="col text-center">
                                                <h5 class="mb-3">Complete these steps to prepare the device</h5>

                                                <ul class="list-group list-group-flush mb-4" style="max-width: 500px; margin: 0 auto;">
                                                    <li class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center mb-2 mb-md-0">
                                                            <i class="bi bi-usb-plug me-2"></i>
                                                            <button id="btn-select-device" type="button" class="btn btn-outline-primary btn-sm">Select a device</button>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span id="manual-device-name"></span>
                                                            <span id="device-step-status" class="badge bg-secondary">Pending</span>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center mb-2 mb-md-0">
                                                            <i class="bi bi-shield-lock me-2"></i>
                                                            <button id="btn-grant-device-permissions" type="button" class="btn btn-outline-primary btn-sm">Grant permissions</button>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span id="permission-step-status" class="badge bg-secondary">Pending</span>

                                                        </div>
                                                    </li>
                                                    <li class="list-group-item d-flex flex-column flex-md-row justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center mb-2 mb-md-0">
                                                            <i class="bi bi-gear-wide-connected me-2"></i>
                                                            <button id="btn-enroll-device" type="button" class="btn btn-outline-primary btn-sm">Enroll device</button>
                                                        </div>
                                                        <div class="d-flex align-items-center gap-2">
                                                            <span id="enroll-step-status" class="badge bg-secondary">Pending</span>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item d-flex flex-column flex-md-row justify-content-center align-items-center">
                                                        <button id="btn-step-3-next" type="button" class="btn btn-outline-primary btn-sm">Continue</button>
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="step-2" class="tab-pane" role="tabpanel">
                                    <div class="inner">
                                        <div class="form-row">
                                            <div class="form-holder form-holder-2 w-100 text-center">
                                                <label>Scan this QR code on your device</label>
                                                <div class="d-flex justify-content-center mt-3">
                                                    <div id="qrcode"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-center mt-3">
                                        <button id="btn-step-2-next" type="button" class="btn btn-primary">Next</button>
                                    </div>
                                </div>
                                <div id="step-3" class="tab-pane" role="tabpanel">
                                    <div class="inner">
                                        <span>Select a device</span>
                                        <span>Device selected: <span id="device-selected-name"></span> </span>
                                        <div class="setup-buttons d-flex flex-column flex-md-row justify-content-center align-items-center mt-3 gap-3">
                                            <button id="btn-step-3-next" type="button" class="btn btn-outline-primary" style="display: none">Next</button>
                                        </div>
                                    </div>
                                </div>
                                <div id="step-4" class="tab-pane" role="tabpanel">
                                    <div class="inner">
                                        <div class="form-row">
                                            <div class="checkmark-container">
                                                <div class="checkmark-circle shadow">
                                                    <div class="checkmark"></div>
                                                </div>
                                                <div class="success-text">Enrollment Successful</div>
                                            </div>
                                        </div>
                                        <div class="setup-buttons d-flex flex-column flex-md-row justify-content-center align-items-center mt-3 gap-3">
                                            <button id="btn-step-4-next" type="button" class="btn btn-outline-primary">Go to dashboard</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>let apiDevicesRoute = "{{ route('api.devices') }}"</script>
        <script>let dashboardRoute = "{{ route('dashboard') }}"</script>
        <script>let apiAddDevicesRoute = "{{ route('api.devices.add') }}"</script>
        <script>let token = "{{ $apiToken }}"</script>
        <script src="{{ asset('views/devices-add/js/qrcode.min.js') }}"></script>
        <script src="{{ asset('views/devices-add/js/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ asset('views/devices-add/js/jquery.smartWizard.min.js') }}"></script>
        @vite('resources/js/devices-add/adb.js')
        @vite('resources/js/devices-add/device-store.js')
        @vite('resources/js/devices-add/wizard.js')
        <x-layout.scripts />
    </body>
</html>