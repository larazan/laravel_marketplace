@extends('backend.layout')

@section('content')

<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Gambar Produk</h2>
            <!-- <p>Lorem ipsum dolor sit amet.</p> -->
        </div>
        <div>
            <a href="{{ url('user/products/'.$productID.'/add-image') }}" class="btn btn-primary btn-sm rounded">Tambah Gambar</a>
        </div>
    </div>
    @include('backend.partials.flash')
    <div class="card mb-4">
        <!-- <header class="card-header">
            
            @include('backend.products.menu')
            
        </header> -->
        <!-- card-header end// -->
        <div class="card-body">
        <div class="row gx-3">
                    @include('backend.products.menu')
        </div>
        @forelse ($productImages as $image)
            <article class="itemlist">
                <div class="row align-items-center">
                    
                    <div class="col-lg-4 col-sm-4 col-8 flex-grow-1 col-name">
                        <a class="itemside" href="#">
                            <div class="left">
                                @if ($image->path)
                                    <img src="{{ asset('storage/'.$image->path) }}" class="img-sm img-thumbnail" alt="Item" />
                                @else
                                    <img src="{{ URL::asset('dashboard/assets/imgs/items/1.jpg') }}" class="img-sm img-thumbnail" alt="Item" />
                                @endif
                            </div>
                        </a>
                    </div>
                    
                    <div class="col-lg-1 col-sm-2 col-4 col-date">
                        <span>{{ $image->created_at }}</span>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-4 col-action text-end">                        
                        {!! Form::open(['url' => 'user/products/images/'. $image->id, 'class' => 'delete', 'style' => 'display:inline-block']) !!}
                        {!! Form::hidden('_method', 'DELETE') !!}
                        {!! Form::submit('Delete', ['class' => 'btn btn-sm font-sm btn-danger rounded']) !!}
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
    <a href="{{ url('user/products') }}" class="btn btn-secondary btn-default">Kembali</a>
    <!-- card end// -->
</section>

@endsection