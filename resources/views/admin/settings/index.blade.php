@extends('admin.layout')

@section('content')

<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-default">
            <div class="card-footer text-right">
            @if (!empty($setting))
                            <a href="{{ url('admin/setting/edit') }}" class="btn btn-primary">Update</a>
                        @else 
                            <a href="{{ url('admin/setting/create') }}" class="btn btn-primary">Add New</a>
                        @endif
                        </div>
                <div class="card-header card-header-border-bottom">
                    <h2>Setting</h2>
                </div>
                <div class="card-body">
                    @include('admin.partials.flash')
                    <div class="row">
                        <div class="col-12">
                            <p class="mb-5">Alerts provide contextual feedback messages for typical user actions with the handful of available and flexible alert messages. Read bootstrap documentaion for <a href="https://getbootstrap.com/docs/4.4/components/alerts/" target="_blank"> more details.</a></p>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label for="primary">Nama</label>
                                <div class="">
                                    <h5>
                                    {{ $title }}
                                    </h5>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="primary">Alamat</label>
                                <div class="">
                                    <h5>
                                    {{ $address }}
                                    </h5>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="primary">Telpon</label>
                                <div class="">
                                    <h5>
                                    {{ $phone }}
                                    </h5>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="primary">Email</label>
                                <div class="">
                                    <h5>
                                    {{ $email }}
                                    </h5>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="primary">Deskripsi</label>
                                <div class="">
                                    <h5>
                                    {{ $description }}
                                    </h5>
                                </div>
                            </div>

                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection