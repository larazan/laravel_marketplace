@extends('backend.layout')

@section('content')

@php
$formTitle = !empty($product) ? 'Update' : 'Add New'
@endphp

<section class="content-main">
    <div class="row">
        <div class="col-9">
            <div class="content-header">
                <h2 class="content-title">{{ $formTitle }} Product</h2>
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
                            {!! Form::label('type', 'Type', ['class' => 'form-label']) !!}
                            {!! Form::select('type', $types , !empty($product) ? $product->type : null, ['class' => 'form-control product-type', 'placeholder' => '-- Choose Product Type --', 'disabled' => !empty($product)]) !!}
                            <!-- {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'name']) !!} -->
                        </div>
                        <div class="mb-4">
                            {!! Form::label('name', 'Name', ['class' => 'form-label']) !!}
                            {!! Form::text('name', null, ['class' => 'form-control', 'id' => 'name', 'placeholder' => 'name']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('sku', 'SKU', ['class' => 'form-label']) !!}
                            {!! Form::text('sku', null, ['class' => 'form-control', 'id' => 'sku', 'placeholder' => 'sku']) !!}
                        </div>

                        <div class="col-6 mb-3">
                            {!! Form::label('weight', 'Weight', ['class' => 'form-label']) !!}
                            {!! Form::text('weight', null, ['class' => 'form-control', 'placeholder' => 'weight']) !!}
                        </div>
                        <div class="col-6 mb-3">
                            {!! Form::label('qty', 'Qty Inventory', ['class' => 'form-label']) !!}
                            {!! Form::text('qty', null, ['class' => 'form-control', 'placeholder' => 'qty']) !!}
                        </div>

                        <div class="mb-4">
                            {!! Form::label('brand', 'Brand', ['class' => 'form-label']) !!}
                            {!! Form::select('brand_id', $brands, !empty($product) ? $brandID : null, ['class' => 'form-control', 'placeholder' => '-- Choose Brand --']) !!}
                            <!-- {!! Form::text('brand', null, ['class' => 'form-control', 'placeholder' => 'brand']) !!} -->
                        </div>
                        <div class="mb-4">
                            {!! Form::label('category_ids', 'Category', ['class' => 'form-label']) !!}
                            {!! General::selectMultiLevel('category_ids[]', $categories, ['class' => 'form-control select-multiple', 'id' => 'category_ids', 'multiple' => true, 'selected' => !empty(old('category_ids')) ? old('category_ids') : $categoryIDs, 'placeholder' => '-- Choose Category --']) !!}
                        </div>
                        <div class="mb-4">
                            {!! Form::label('price', 'Price', ['class' => 'form-label']) !!}
                            {!! Form::text('price', null, ['class' => 'form-control', 'placeholder' => 'price']) !!}
                        </div>
                    </div>
                </div>
            </div>
            <!-- card end// -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-4">
                        {!! Form::label('description', 'Description', ['class' => 'form-label']) !!}
                        {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'description', 'rows' => '4']) !!}
                    </div>
                    <!-- SIMPLE -->
                    <div class="row gx-3">
                        <div class="col-md-4 mb-3">
                            {!! Form::label('length', 'Length', ['class' => 'form-label']) !!}
                            {!! Form::text('length', null, ['class' => 'form-control', 'placeholder' => 'length']) !!}
                        </div>
                        <div class="col-md-4 mb-3">
                            {!! Form::label('width', 'Width', ['class' => 'form-label']) !!}
                            {!! Form::text('width', null, ['class' => 'form-control', 'placeholder' => 'width']) !!}
                        </div>
                        <div class="col-md-4 mb-3">
                            {!! Form::label('height', 'Height', ['class' => 'form-label']) !!}
                            {!! Form::text('height', null, ['class' => 'form-control', 'placeholder' => 'height']) !!}
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

        </div>
        <div class="col-lg-3">
            <div class="card mb-4">
                <div class="card-body">

                    <div class="mb-4">
                        {!! Form::label('status', 'Status', ['class' => 'form-label']) !!}
                        {!! Form::select('status', $statuses , null, ['class' => 'form-select', 'placeholder' => '-- Set Status --']) !!}
                    </div>

                    <button class="btn btn-primary" type="submit">Submit</button>
                    <a href="{{ url('user/products') }}" class="btn btn-secondary btn-default">Back</a>
                </div>
            </div>
            <!-- card end// -->
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