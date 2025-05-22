<!doctype html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>TFG</title>
        <x-layout.head />
        <link href="{{ asset('views/dashboard/css/main.css') }}" />
    </head>
    <body>
        <div class="container-fluid">
            <div class="row">

                <!-- Sidebar -->
                <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
                    <div class="sidebar">
                        <h5 class="text-center mb-4">Menu</h5>
                        <ul class="nav flex-column px-3">
                            <li class="nav-item">
                                <a class="nav-link active" href="#">Dashboard</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Devices</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Settings</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Reports</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#">Reports</a>
                            </li>
                        </ul>
                    </div>
                </nav>

                <!-- Main Content -->
                <main class="col main-content">
                    <div class="container">
                        <h2 class="mb-4 text-center">Select a Device</h2>

                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                            <div class="col">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Device A</h5>
                                        <p class="card-text">Serial: ABC123</p>
                                        <button class="btn btn-primary">Select</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Device B</h5>
                                        <p class="card-text">Serial: DEF456</p>
                                        <button class="btn btn-primary">Select</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col">
                                <div class="card h-100">
                                    <div class="card-body text-center">
                                        <h5 class="card-title">Device C</h5>
                                        <p class="card-text">Serial: XYZ789</p>
                                        <button class="btn btn-primary">Select</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Add more device cards as needed -->

                        </div>
                    </div>
                </main>

            </div>
        </div>

        <!--
        <h1>DASHBOARD</h1>
        <a href="{{ route('test') }}">Goto test</a>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-link">Logout</button>
        </form>
        -->

        <x-layout.scripts />
        <script src="{{ asset('views/dashboard/js/main.js') }}"></script>
    </body>
</html>