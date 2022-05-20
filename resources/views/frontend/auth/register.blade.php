@extends('frontend.layout') 

@section('content')

<main class="main pages">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                <span></span> Register
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
                                        <h1 class="mb-5">Buat Akun</h1>
                                        <p class="mb-30">sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
                                    </div>
                                    <form method="POST" action="{{ route('register') }}">
                                    @csrf
                                        <div class="form-group">
                                            <input type="text" class="form-control @error('first_name') is-invalid @enderror" name="first_name" value="{{ old('first_name') }}" required autocomplete="first_name" autofocus placeholder="Nama depan" />
                                            @error('first_name')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control @error('last_name') is-invalid @enderror" name="last_name" value="{{ old('last_name') }}" required autocomplete="last_name" autofocus placeholder="Nama belakang" />
                                            @error('last_name')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
                                        </div>
                                        <div class="form-group">
                                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Alamat email" />
                                            @error('email')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
                                        </div>
                                        <div class="form-group">
                                            <input required="" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Password" />
                                            @error('password')
												<span class="invalid-feedback" role="alert">
													<strong>{{ $message }}</strong>
												</span>
											@enderror
                                        </div>
                                        <div class="form-group">
                                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi password" />
                                        </div>
                                        
                                        
                                        <div class="login_footer form-group mb-50">
                                            <div class="chek-form">
                                                <div class="custome-checkbox">
                                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox12" value="" />
                                                    <label class="form-check-label" for="exampleCheckbox12"><span>I agree to terms &amp; Policy.</span></label>
                                                </div>
                                            </div>
                                            <!-- <a href="page-privacy-policy.html"><i class="fi-rs-book-alt mr-5 text-muted"></i>Lean more</a> -->
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

@endsection 