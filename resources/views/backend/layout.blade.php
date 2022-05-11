
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Nest Dashboard</title>
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:title" content="" />
        <meta property="og:type" content="" />
        <meta property="og:url" content="" />
        <meta property="og:image" content="" />
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('dashboard/assets/imgs/theme/favicon.svg') }}" />
        <!-- Template CSS -->
        <link href="{{ URL::asset('dashboard/assets/css/main.css?v=1.1') }}" rel="stylesheet" type="text/css" />
        @yield('style')
    </head>

    <body>
        <div class="screen-overlay"></div>
        @include('backend.partials.sidebar')
        <main class="main-wrap">
        @include('backend.partials.header')
            @yield('content')
            <!-- content-main end// -->
        @include('backend.partials.footer')
        </main>
        <script src="{{ URL::asset('dashboard/assets/js/vendors/jquery-3.6.0.min.js') }}"></script>
        <script src="{{ URL::asset('dashboard/assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ URL::asset('dashboard/assets/js/vendors/select2.min.js') }}"></script>
        <script src="{{ URL::asset('dashboard/assets/js/vendors/perfect-scrollbar.js') }}"></script>
        <script src="{{ URL::asset('dashboard/assets/js/vendors/jquery.fullscreen.min.js') }}"></script>
        <script src="{{ URL::asset('dashboard/assets/js/vendors/chart.js') }}"></script>
        <!-- Main Script -->
        <script src="{{ URL::asset('dashboard/assets/js/main.js?v=1.1') }}" type="text/javascript"></script>
        <script src="{{ URL::asset('dashboard/assets/js/custom-chart.js') }}" type="text/javascript"></script>
    
        @yield('scripts')
    </body>
</html>
