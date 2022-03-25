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
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/sweetalert2.min.css') }}" />
    
     
    </head>

    <body>
{{-- @section('content') --}}
<main class="main pages">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Pages <span></span> My Account
            </div>
        </div>
    </div>
    <div class="page-content pt-50 pb-50">
        <div class="container">
            <div class="row">
                <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                    <div class="row">
                        <div class="col-lg-6 col-md-8">
                            <div class="login_wrap widget-taber-content background-white">
                                <div class="padding_eight_all bg-white">
                                    <div class="heading_s1">
                                        <h1 class="mb-5">Daftar Akun</h1>
                                        <p class="mb-30">Sudah punya akun? <a href="page-login.html">Login</a></p>
                                    </div>
                                    <form class="form" id="form_register" action="{{route('form_register_action')}}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <input type="text" required="" name="nama" placeholder="nama_lengkap" />
                                        </div>
                                        <div class="form-group">
                                            <input type="number" required="" name="no_ponsel" placeholder="No Telp (wa)" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" required="" name="email" placeholder="Email" />
                                        </div>
                                        <div class="form-group">
                                            <input type="text" required="" name="username" placeholder="Username" />
                                        </div>
                                        <div class="form-group">
                                            <input required="" type="password" name="password" placeholder="Password" />
                                        </div>
                                        <div class="form-group">
                                            <input required="" type="password" name="repassword" placeholder="Confirm password" />
                                        </div>
                                        <div class="login_footer form-group">
                                            <div class="chek-form">
                                                <input type="text"  placeholder="Security code *" />
                                            </div>
                                            <span class="security-code">
                                                <b class="text-new">8</b>
                                                <b class="text-hot">6</b>
                                                <b class="text-sale">7</b>
                                                <b class="text-best">5</b>
                                            </span>
                                        </div>
                                        {{-- <div class="payment_option mb-50">
                                            <div class="custome-radio">
                                                <input class="form-check-input" required="" type="radio" name="payment_option" id="exampleRadios3" checked="" />
                                                <label class="form-check-label" for="exampleRadios3" data-bs-toggle="collapse" data-target="#bankTranfer" aria-controls="bankTranfer">I am a customer</label>
                                            </div>
                                            <div class="custome-radio">
                                                <input class="form-check-input" required="" type="radio" name="payment_option" id="exampleRadios4" checked="" />
                                                <label class="form-check-label" for="exampleRadios4" data-bs-toggle="collapse" data-target="#checkPayment" aria-controls="checkPayment">I am a vendor</label>
                                            </div>
                                        </div> --}}
                                        <div class="login_footer form-group mb-50">
                                            <div class="chek-form">
                                                <div class="custome-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox12" value="" />
                                                    <label class="form-check-label" for="exampleCheckbox12"><span>I agree to terms &amp; Policy.</span></label>
                                                </div>
                                            </div>
                                            <a href="page-privacy-policy.html"><i class="fi-rs-book-alt mr-5 text-muted"></i>Lean more</a>
                                        </div>
                                        <div class="row">
                                            <div class="form-group mb-30">
                                            
                                            <button type="submit" class="btn btn-fill-out btn-block hover-up font-weight-bold" name="login">Submit &amp; Register</button>
                                            {{-- <a href="{{route('form_login')}}" class="btn btn-outline-secondary">Kembali ke halaman Login</a> --}}
                                            
                                            </div>
                                        </div>
                                        <p class="font-xs text-muted"><strong>Note:</strong>Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our privacy policy</p>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 pr-30 d-none d-lg-block">
                            <div class="card-login mt-115">
                                <a href="#" class="social-login facebook-login">
                                    <img src="assets/imgs/theme/icons/logo-facebook.svg" alt="" />
                                    <span>Continue with Facebook</span>
                                </a>
                                <a href="#" class="social-login google-login">
                                    <img src="assets/imgs/theme/icons/logo-google.svg" alt="" />
                                    <span>Continue with Google</span>
                                </a>
                                <a href="#" class="social-login apple-login">
                                    <img src="assets/imgs/theme/icons/logo-apple.svg" alt="" />
                                    <span>Continue with Apple</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
{{-- @endsection --}}

<!-- Vendor JS-->
<script src="{{ asset('frontend/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('frontend/assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
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
<script src="{{ asset('frontend/assets/js/plugins/jquery.elevatezoom.js') }}"></script>
<script src="{{ asset('frontend/assets/js/plugins/sweetalert2.all.min.js') }}"></script>
<!-- Template  JS -->
<script src="{{ asset('frontend/assets/js/main.js?v=4.0') }}"></script>
<script src="{{ asset('frontend/assets/js/shop.js?v=4.0') }}"></script>

<script type="text/javascript">
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $("#form_register").submit(function(e){
                e.preventDefault();
                var datas = $("#form_register").serialize();
                $('.text-danger').remove();
                var nama = $("input[name='nama']").val();
                var email = $("input[name='email']").val();
                var username = $("input[name='username']").val();
                var no_ponsel = $("input[name='no_ponsel']").val();
                var password = $("input[name='password']").val();
                var repassword = $("input[name='repassword']").val();
                // var agree = $('input[name=agree]:checked').length;
                // var captcha_key = $('input[name=captcha_code]').val();
                $.ajax({
                    url: "{{route('form_register_action')}}",
                    type:'POST',
                    // data:datas,
                    data: {
                        nama:nama, 
                        email:email, 
                        username:username, 
                        no_ponsel:no_ponsel, 
                        password:password, 
                        repassword:repassword
                        // agree:agree, 
                        // captcha:captcha_key
                    },
                    success: function(data) {
                        if($.isEmptyObject(data.error)){
                            // console.log();
                            if(data.status == true){
                                location.href = data.redirect;
                                // console.log();
                            }else if(data.status == false){
                                swal.fire("Ups", "Terjadi kesalahan pada sistem. Mohon refresh halaman ini", "error");
                            }
                        }else{
                            $.each(data.error, function(key, value) {
                                var element = $('#' + key);
                                element.closest('div.form-control')
                                .removeClass('text-danger')
                                .addClass(value.length > 0 ? 'text-danger' : '')
                                .find('#error_' + key).remove();
                                element.after('<div id="error_'+ key +'" class="text-danger">' + value + '</div>');
                            });
                            if (data.error) {
                                $('#signup_submit').removeAttr('disabled');
                                $('#form_error').append(data.error);
                            }


                        
                            // printErrorMsg(data.error);
                            $("html, body").animate({ scrollTop: 0 }, "slow");
                        }
                    },error: function(){
                        swal.fire("Ups", "Terjadi kesalahan pada sistem. Mohon refresh halaman ini", "warning");
                    }
                });
            }); 
      
    });


    </script>
</body>
</html>

