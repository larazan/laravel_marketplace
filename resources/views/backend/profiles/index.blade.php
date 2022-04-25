@extends('backend.layout')

@section('content')

<section class="content-main">
    
    <div class="card mb-4">
        <div class="card-header bg-brand-2" style="height: 150px"></div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl col-lg flex-grow-0" style="flex-basis: 230px">
                    <div class="img-thumbnail shadow w-100 bg-white position-relative text-center" style="height: 200px; width: 200px; margin-top: -120px">
                        <img src="{{ Avatar::create(Auth::user()->first_name.' '.Auth::user()->last_name)->setShape('square')->setDimension(200, 200)->toBase64() }}" class="center-xy img-fluid" alt="Logo Brand" />
                    </div>
                </div>
                <!--  col.// -->
                <!-- <div class="col-xl col-lg">
                    <h3>Noodles Co.</h3>
                    <p>3891 Ranchview Dr. Richardson, California 62639</p>
                </div> -->
                <!--  col.// -->
                <div class="col-xl-4 text-md-end">
                    <a href="{{  url('user/profile/reset') }}" class="btn btn-light rounded font-sm mr-5 text-body hover-up">Reset Password</a>
                    <a href="{{  url('user/profile/edit') }}" class="btn btn-primary">Update Profil</a>
                </div>
                <!--  col.// -->
            </div>
            <!-- card-body.// -->
            <hr class="my-4" />
            <div class="row g-4">
                
                <!--  col.// -->
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <h6>Nama Depan</h6>
                    <p>
                        {{ $user->first_name }}
                    </p>
                </div>
                <!--  col.// -->
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <h6>Nama Belakang</h6>
                    <p>
                        {{ $user->last_name }}
                    </p>
                </div>
                <!--  col.// -->
                <!--  col.// -->
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <h6>Kontak</h6>
                    <p>
                    {{ $user->email }} <br />
                    {{ $user->phone }}
                    </p>
                </div>
                <!--  col.// -->
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <h6>Alamat</h6>
                    <p>
                    {{ $user->address1 }} <br />
                        Kodepos: {{ $user->postcode }}
                    </p>
                </div>
                <!--  col.// -->
                
            </div>
            <!--  row.// -->
        </div>
        <!--  card-body.// -->
    </div>
    <!--  card.// -->
    
    <!--  card.// -->
    
</section>

@endsection