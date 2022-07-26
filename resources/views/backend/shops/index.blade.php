@extends('backend.layout')

@section('content')

<section class="content-main">
    <div class="card mb-4">
        <div class="card-header bg-brand-2" style="height: 150px"></div>
        <div class="card-body">
            <div class="row">
                <div class="col-xl col-lg flex-grow-0" style="flex-basis: 230px">
                    <div class="img-thumbnail shadow w-100 bg-white position-relative text-center" style="height: 190px; width: 200px; margin-top: -120px">
                        @if (!empty($shop))
                        <img src="{{ asset('storage/'.$shop->small) }}" class="center-xy img-fluid" alt="Logo Brand" />
                        @else
                        <img src="{{ URL::asset('dashboard/assets/imgs/brands/vendor-2.png') }}" class="center-xy img-fluid" alt="Logo Brand" />
                        @endif
                    </div>
                </div>
                <!--  col.// -->
                <div class="col-xl col-lg">
                @if (!empty($shop))
                    <h3>{{ $shop->name }}</h3>
                    <p>{{ $user->address1 }}</p>
                @else
                    <h3>Noodles Co.</h3>
                    <p>3891 Ranchview Dr. Richardson, California 62639</p>
                @endif
                </div>
                <!--  col.// -->
                <div class="col-xl-4 text-md-end">
                    @if (!empty($shop))
                        <a href="{{ url('user/shop/edit') }}" class="btn btn-primary">Update</a>
                    @else
                        <a href="{{ url('user/shop/create') }}" class="btn btn-primary">Tambah</a>   
                    @endif
                
                </div>
                <!--  col.// -->
            </div>
            <!-- card-body.// -->
            <hr class="my-4" />
            <div class="row g-4">
                
                <!--  col.// -->
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <h6>Kontak</h6>
                    @if (!empty($shop))
                        <p>
                            {{ $shop->name }} <br />
                            {{ $user->email }} <br />
                            {{ $user->phone }}
                        </p>
                    @else
                    <p>
                        Manager: Jerome Bell <br />
                        info@example.com <br />
                        (229) 555-0109, (808) 555-0111
                    </p>
                    @endif
                </div>
                <!--  col.// -->
                <div class="col-sm-6 col-lg-4 col-xl-3">
                    <h6>Alamat</h6>
                    @if (!empty($shop))
                        <p>
                        {{ $user->address1 }} <br />
                        {{ $user->postcode }}
                        </p>
                    @else
                    <p>
                        Address: Ranchview Dr. Richardson <br />
                        Postal code: 62639
                    </p>
                    @endif
                </div>

                <div class="col-md-12 col-lg-4 col-xl-2">
                    <h6>Rekenig</h6>
                    @if (!empty($shop))
                    <p>
                    {{ $shop->rekening }} <br />
                    {{ $shop->bank }} <br />
                        a/n {{ $shop->atasnama }}
                    </p>
                    @else
                    <p>
                        55501090111 <br />
                        BCA <br />
                        a/n ratri
                    </p>
                    @endif
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