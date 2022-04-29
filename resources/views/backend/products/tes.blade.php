<!-- {{ var_dump($products) }} -->

@extends('backend.layout')

@section('content')

@forelse ($products as $product)
    {{ $product->id }}
    {{ $product->name }}
    {{ $product->slug }}
    {{ number_format($product->price) }}
    {{ $product->statusLabel() }}
    {{ $product->sku }}
    @empty
@endforelse

<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Products List</h2>
            <p>Lorem ipsum dolor sit amet.</p>
        </div>
        <div>
            <a href="{{ url('user/products/create') }}" class="btn btn-primary btn-sm rounded">Create new</a>
        </div>
    </div>
    @include('backend.partials.flash')
    <div class="card mb-4">
        <header class="card-header">
            <div class="row align-items-center">
                <div class="col col-check flex-grow-0">
                    <div class="form-check ms-2">
                        <input class="form-check-input" type="checkbox" value="" />
                    </div>
                </div>
                <div class="col-md-3 col-12 me-auto mb-md-0 mb-3">
                    <select class="form-select">
                        <option selected>All category</option>
                        <option>Electronics</option>
                        <option>Clothes</option>
                        <option>Automobile</option>
                    </select>
                </div>
                <div class="col-md-2 col-6">
                    <input type="date" value="02.05.2021" class="form-control" />
                </div>
                <div class="col-md-2 col-6">
                    <select class="form-select">
                        <option selected>Status</option>
                        <option>Active</option>
                        <option>Disabled</option>
                        <option>Show all</option>
                    </select>
                </div>
            </div>
        </header>
        <!-- card-header end// -->
        <div class="card-body">
            @php
            $i = 1
            @endphp
            @forelse ($products as $product)
            <article class="itemlist">
                <div class="row align-items-center">
                    <div class="col col-check flex-grow-0">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-4 col-8 flex-grow-1 col-name">
                        <a class="itemside" href="#">
                            <div class="left">
                                <img src="{{ URL::asset('dashboard/assets/imgs/items/1.jpg') }}" class="img-sm img-thumbnail" alt="Item" />
                            </div>
                            <div class="info">
                                <h6 class="mb-0">{{ $product->name }}</h6>
                            </div>
                        </a>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-4 col-price"><span>{{ number_format($product->price) }}</span></div>
                    <div class="col-lg-2 col-sm-2 col-4 col-status">
                        
                        <span class="badge rounded-pill alert-success">{{ $product->statusLabel() }}</span>
                    </div>
                    <div class="col-lg-1 col-sm-2 col-4 col-date">
                        <span>{{ $product->sku }}</span>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-4 col-action text-end">
                        <a href="{{ url('product/'. $product->slug) }}" class="btn btn-sm btn-light font-sm rounded"> <i class=fi-rs-eye"></i> Show </a>
                        <a href="{{ url('user/products/'. $product->id .'/edit') }}" class="btn btn-sm font-sm rounded btn-brand"> <i class="material-icons md-edit"></i> Edit </a>
                        <!-- <a href="#" class="btn btn-sm font-sm btn-light rounded"> <i class="material-icons md-delete_forever"></i> Delete </a> -->
                        {!! Form::open(['url' => 'user/products/'. $product->id, 'class' => 'delete', 'style' => 'display:inline-block']) !!}
                        {!! Form::hidden('_method', 'DELETE') !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-sm font-sm btn-danger btn-sm rounded']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
                <!-- row .// -->
            </article>
            <!-- itemlist  .// -->
            @empty
            <article>
                <div>No records found</div>
            </article>
            @endforelse
            <!-- itemlist  .// -->
        </div>
        <!-- card-body end// -->
    </div>
    <!-- card end// -->
    {{ $products->links('backend.partials.paginator') }}
</section>

@endsection