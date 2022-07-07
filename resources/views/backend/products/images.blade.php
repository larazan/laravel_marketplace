@extends('backend.layout')

@section('content')

<section class="content-main">
   
    <div class="row">
        <div class="col-9">
            <div class="content-header">
                <h2 class="content-title">Gambar Produk</h2>
                <div>
                    <a href="{{ url('user/products/'.$productID.'/add-image') }}" class="btn btn-primary btn-sm rounded">Tambah Gambar</a>
                </div>
            </div>
        </div>
        @include('backend.partials.flash')
        <div class="col-9">
            <div class="card mb-4">

                <div class="card-body">
                    <div class="row gx-3">
                        @include('backend.products.menu')
                        <div class="col-lg-9">
                            <section class="content-body p-xl-4">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th scope="col">Gambar</th>
                                                <th scope="col">Date</th>
                                                <th scope="col" class="text-end">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($productImages as $image)
                                            <tr>
                                                <td>1</td>
                                                <td>
                                                    @if ($image->path)
                                                    <img src="{{ asset('storage/'.$image->path) }}" class="img-sm img-thumbnail" alt="Item" />
                                                    @else
                                                    <img src="{{ URL::asset('dashboard/assets/imgs/items/1.jpg') }}" class="img-sm img-thumbnail" alt="Item" />
                                                    @endif
                                                </td>
                                                <td>{{ $image->created_at }}</td>
                                                <td class="text-end">
                                                    {!! Form::open(['url' => 'user/products/images/'. $image->id, 'class' => 'delete', 'style' => 'display:inline-block']) !!}
                                                    {!! Form::hidden('_method', 'DELETE') !!}
                                                    {!! Form::submit('Delete', ['class' => 'btn btn-sm font-sm btn-danger rounded']) !!}
                                                    {!! Form::close() !!}
                                                </td>
                                            </tr>
                                            @empty
                                            <article>
                                                <tr>
                                                    <td colspan="4">No records found</td>
                                                </tr>
                                            </article>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>

                                <a href="{{ url('user/products') }}" class="btn btn-secondary btn-default">Kembali</a>

                            </section>
                        </div>

                    </div>
                    <!-- card-body end// -->
                </div>

            </div>
        </div>
    </div>

    <!-- card end// -->
</section>

@endsection