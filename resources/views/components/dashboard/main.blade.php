<!doctype html>
<html lang="es">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
        <title>{{ $title }}</title>
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
        <link rel="stylesheet" href="">
        <link rel="stylesheet" href="{{ asset('views/dashboard/css/bootstrap.min.css') }}" />
        <x-dashboard.fonts />
        <link rel="stylesheet" href="{{ asset('views/dashboard/css/ready.css') }}" />
        <link rel="stylesheet" href="{{ asset('views/dashboard/css/demo.css') }}" />
        {{ $css ?? "" }}
    </head>
    <body>
        <div class="wrapper">
            <x-dashboard.header />

            <x-dashboard.sidebar
                :activeMenu="$activeMenu"
                :device="$device"
            />

            {{ $slot }}
        </div>
        <script src="{{ asset('views/dashboard/js/core/jquery.3.2.1.min.js') }}"></script>
        <script src="{{ asset('views/dashboard/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js') }}"></script>
        <script src="{{ asset('views/dashboard/js/core/popper.min.js') }}"></script>
        <script src="{{ asset('views/dashboard/js/core/bootstrap.min.js') }}"></script>
        <script src="{{ asset('views/dashboard/js/plugin/chartist/chartist.min.js') }}"></script>
        <script src="{{ asset('views/dashboard/js/plugin/chartist/plugin/chartist-plugin-tooltip.min.js') }}"></script>
        <script src="{{ asset('views/dashboard/js/plugin/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
        <script src="{{ asset('views/dashboard/js/plugin/bootstrap-toggle/bootstrap-toggle.min.js') }}"></script>
        <script src="{{ asset('views/dashboard/js/plugin/jquery-mapael/jquery.mapael.min.js') }}"></script>
        <script src="{{ asset('views/dashboard/js/plugin/jquery-mapael/maps/world_countries.min.js') }}"></script>
        <script src="{{ asset('views/dashboard/js/plugin/chart-circle/circles.min.js') }}"></script>
        <script src="{{ asset('views/dashboard/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js') }}"></script>
        <script src="{{ asset('views/dashboard/js/ready.min.js') }}"></script>
        <script src="{{ asset('views/dashboard/js/demo.js') }}"></script>
        {{ $scripts ?? "" }}
    </body>
</html>