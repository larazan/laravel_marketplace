@extends('backend.layout')

@section('content')

@php
$formTitle = !empty($product) ? 'Update' : 'Tambah Baru'
@endphp

<section class="content-main">
    <div class="row">
        <div class="col-9">
            <div class="content-header">
                <h2 class="content-title">{{ $formTitle }} Produk</h2>
                <!-- <div>
                    <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Save to draft</button>
                    <button class="btn btn-md rounded font-sm hover-up">Publich</button>
                </div> -->
            </div>
        </div>
        @include('admin.partials.flash', ['$errors' => $errors])
        <div class="col-lg-6">
            @if (!empty($product))
            {!! Form::model($product, ['url' => ['user/products', $product->id], 'method' => 'PUT']) !!}
            {!! Form::hidden('id') !!}
            {!! Form::hidden('type') !!}
            @else
            {!! Form::open(['url' => 'user/products']) !!}
            @endif
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row gx-3">
                        @include('backend.products.menu')
                        <div class="mb-4">
                            {!! Form::label('type', 'Tipe', ['class' => 'form-label']) !!}
                            {!! Form::select('type', $types , !empty($product) ? $product->type : null, ['class' => 'form-control product-type', 'placeholder' => '-- Pilih Produk Tipe --', 'disabled' => !empty($product)]) !!}
                            <!-- {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'name']) !!} -->
                        </div>
                        <div class="mb-4">
                            {!! Form::label('name', 'Nama Barang', ['class' => 'form-label']) !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'nama barang']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('sku', 'SKU', ['class' => 'form-label']) !!}
                            {!! Form::text('sku', null, ['class' => 'form-control', 'id' => 'sku', 'placeholder' => 'sku']) !!}
                        </div>

                        <div class="col-6 mb-3">
                            {!! Form::label('weight', 'Berat (gram)', ['class' => 'form-label']) !!}
                            {!! Form::text('weight', null, ['class' => 'form-control', 'placeholder' => 'berat']) !!}
                        </div>
                        <div class="col-6 mb-3">
                            {!! Form::label('qty', 'Qty', ['class' => 'form-label']) !!}
                            {!! Form::text('qty', null, ['class' => 'form-control', 'placeholder' => 'kuantitas']) !!}
                        </div>

                        <div class="mb-4">
                            {!! Form::label('brand', 'Merk', ['class' => 'form-label']) !!}
                            {!! Form::select('brand_id', $brands, !empty($product) ? $brandID : null, ['class' => 'form-control', 'placeholder' => '-- Pilih Merk --']) !!}
                            <!-- {!! Form::text('brand', null, ['class' => 'form-control', 'placeholder' => 'brand']) !!} -->
                        </div>
                        <div class="mb-4">
                            {!! Form::label('category_ids', 'Kategori', ['class' => 'form-label']) !!}
                            {!! General::selectMultiLevel('category_ids[]', $categories, ['class' => 'form-control select-multiple', 'id' => 'category_ids', 'multiple' => true, 'selected' => !empty(old('category_ids')) ? old('category_ids') : $categoryIDs, 'placeholder' => '-- Pilih Kategori --']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('price', 'Harga', ['class' => 'form-label']) !!}
                            {!! Form::text('price', null, ['class' => 'form-control', 'placeholder' => 'harga']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- card end// -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-4">
                        {!! Form::label('description', 'Deskripsi', ['class' => 'form-label']) !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'deskripsi', 'rows' => '4']) !!}
                    </div>
                    <!-- SIMPLE -->
                    <div class="row gx-3">
                        <div class="col-md-4 mb-3">
                            {!! Form::label('length', 'Panjang', ['class' => 'form-label']) !!}
                            {!! Form::text('length', null, ['class' => 'form-control', 'placeholder' => 'panjang']) !!}
                        </div>
                        <div class="col-md-4 mb-3">
                            {!! Form::label('width', 'Lebar', ['class' => 'form-label']) !!}
                            {!! Form::text('width', null, ['class' => 'form-control', 'placeholder' => 'lebar']) !!}
                        </div>
                        <div class="col-md-4 mb-3">
                            {!! Form::label('height', 'Tinggi', ['class' => 'form-label']) !!}
                            {!! Form::text('height', null, ['class' => 'form-control', 'placeholder' => 'tinggi']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- card end// -->
            @if (!empty($configurableAttributes) && empty($product))
            <div class="card mb-4">
                <div class="card-body">
                <label class="form-label text-primary">Configurable Attributes</label>
                <hr>
                    <div class="configurable-attributes">
                        @foreach ($configurableAttributes as $attribute)
                        <div class="form-group">
                            {!! Form::label($attribute->code, $attribute->name, ['class' => 'form-label']) !!}
                            {!! Form::select($attribute->code. '[]', $attribute->attributeOptions->pluck('name','id'), null, ['class' => 'form-control select-multiple', 'multiple' => true]) !!}
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <div class="card mb-4">
                <div class="card-body">

                    <div class="mb-4">
                        {!! Form::label('status', 'Status', ['class' => 'form-label']) !!}
                        {!! Form::select('status', $statuses , null, ['class' => 'form-select', 'placeholder' => '-- Set Status --']) !!}
                    </div>

                    <button class="btn btn-primary" type="submit">Submit</button>
                    <a href="{{ url('user/products') }}" class="btn btn-secondary btn-default">Kembali</a>
                </div>
            </div>

        </div>
        
        {!! Form::close() !!}
    </div>
</section>

@endsection

@section('scripts')
<script>
    function showHideConfigurableAttributes() {
        var productType = $(".product-type").val();

        if (productType == 'configurable') {
            $(".configurable-attributes").show();
        } else {
            $(".configurable-attributes").hide();
        }
    }

    $(function() {
        showHideConfigurableAttributes();
        $(".product-type").change(function() {
            showHideConfigurableAttributes();
        });
    });
</script>
@endsection