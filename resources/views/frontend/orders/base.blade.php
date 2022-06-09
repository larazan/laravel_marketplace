<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="zpoypNYWqegiblyV5g2RW1hHcXtDnXHaQ4AoKuRf" />
    <title>Laravel Multipurpose eCommerce Script</title>
    <link rel="shortcut icon" href="https://nest.botble.com/storage/general/favicon.png" />
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('checkout/vendor/core/core/base/libraries/font-awesome/css/fontawesome.min.css') }}" />
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('checkout/vendor/core/plugins/ecommerce/css/front-theme.css?v=1.0.13') }}" />
    <link media="all" type="text/css" rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/toastr.min.css') }}">
    <script src="{{ asset('checkout/vendor/core/plugins/ecommerce/js/checkout.js?v=1.0.13') }}" type="0ab58ca346103f3edbff2076-text/javascript"></script>
</head>

<body class="checkout-page">
    <div class="checkout-content-wrap">
        <div class="container">
            <div class="row">

                @yield('content')

            </div>
        </div>
    </div>
    <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>
    <script src="{{ asset('checkout/vendor/core/plugins/ecommerce/js/utilities.js') }}" type="0ab58ca346103f3edbff2076-text/javascript"></script>
    <script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
    <!-- <script src="{{ asset('checkout/vendor/core/core/base/libraries/toastr/toastr.min.js') }}" type="0ab58ca346103f3edbff2076-text/javascript"></script> -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script >
      window.messages = {
        error_header: 'Error',
        success_header: 'Success',
      }
    </script>
    <script>
      $(document).ready(function() {
        toastr.options = {
                    'closeButton': true,
                    'debug': false,
                    'newestOnTop': false,
                    'progressBar': false,
                    'positionClass': 'toast-top-right',
                    'preventDuplicates': false,
                    'showDuration': '1000',
                    'hideDuration': '1000',
                    'timeOut': '5000',
                    'extendedTimeOut': '1000',
                    'showEasing': 'swing',
                    'hideEasing': 'linear',
                    'showMethod': 'fadeIn',
                    'hideMethod': 'fadeOut',
                }
        toastr.success('Hello World');
        toastr.error('tes tes');
      });
    </script>
    <script type="0ab58ca346103f3edbff2076-text/javascript">
        window.messages = {
            error_header: 'Error',
            success_header: 'Success',
        }
    </script>
    <script type="0ab58ca346103f3edbff2076-text/javascript">
        $(document).ready(function() {
            MainCheckout.showNotice('success', 'Checkout successfully!');
        });
    </script>
    <script src="/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js" data-cf-settings="0ab58ca346103f3edbff2076-|49" defer=""></script>
    @stack('scripts')
</body>

</html>