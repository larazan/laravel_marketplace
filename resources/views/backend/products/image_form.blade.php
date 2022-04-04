@extends('backend.layout')

@section('content')
<section class="content-main">
    <div class="row">
        <div class="col-9">
            <div class="content-header">
                <h2 class="content-title">Add New Image Product</h2>

            </div>
        </div>
        @include('backend.partials.flash', ['$errors' => $errors])
        <div class="col-lg-3">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Media</h4>
                </div>
                {!! Form::open(['url' => ['user/products/images', $product->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                <div class="card-body">
                    <div class="input-upload">
                        <img src="assets/imgs/theme/upload.svg" alt="" />
                        {!! Form::file('image', ['class' => 'form-control', 'placeholder' => 'product image']) !!}
                    </div>
                </div>
                <button class="btn btn-primary" type="submit">Save</button>
                {!! Form::close() !!}
            </div>
            <!-- card end// -->

            <!-- card end// -->
        </div>
    </div>
</section>

@endsection