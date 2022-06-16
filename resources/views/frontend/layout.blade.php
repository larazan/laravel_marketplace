<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Sorgum - Marketplace</title>
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <meta name="description" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:title" content="" />
        <meta property="og:type" content="" />
        <meta property="og:url" content="" />
        <meta property="og:image" content="" />
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/imgs/theme/favicon.svg') }}" />
        <!-- Template CSS -->
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/slider-range.css') }}" />
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css?v=4.0') }}" />
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/custom.css') }}" />
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/sweetalert2.min.css') }}" />
        <link media="all" type="text/css" rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/toastr.min.css') }}">
        @stack('style')
    </head>

    <div id="alert-container">
    </div>

    <body>
    @include('frontend.partials.modal')
    @include('frontend.partials.header')

    @yield('content')

    @include('frontend.partials.footer')
    <div class="preloader-loading"></div>
    
    <!-- Preloader Start -->
    <div id="preloader-active">
            <div class="preloader d-flex align-items-center justify-content-center">
                <div class="preloader-inner position-relative">
                    <div class="text-center">
                        <img src="{{ asset('frontend/assets/imgs/theme/loading2.gif') }}" alt="" />
                    </div>
                </div>
            </div>
        </div>
    </div>
     <!-- Vendor JS-->
     <script src="{{ asset('frontend/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/app.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/slick.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/jquery.syotimer.min.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/wow.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/slider-range.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/perfect-scrollbar.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/magnific-popup.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/select2.min.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/waypoints.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/counterup.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/jquery.countdown.min.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/images-loaded.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/isotope.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/scrollup.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/jquery.vticker-min.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/jquery.theia.sticky.js') }}"></script>
     <script src="https://nest.botble.com/vendor/core/core/base/libraries/toastr/toastr.min.js" type="2354b4d8179df5447e9cee2f-text/javascript"></script>
     <script src="{{ asset('frontend/assets/js/plugins/jquery.elevatezoom.js') }}"></script>
     
     <!-- Template  JS -->
     <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.8-beta.17/jquery.inputmask.min.js"></script>
     <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
     
     <script src="{{ asset('frontend/assets/js/main.js?v=4.0') }}"></script>
     @stack('scripts')
     <script src="{{ asset('frontend/assets/extends/js/energeek.js') }}"></script>

    </body>
    
</html>
