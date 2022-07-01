@extends('admin.layout')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Products</h2>
                    </div>
                    <div class="card-body">
                        @include('admin.partials.flash')
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>#</th>
                                <th>SKU</th>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th style="width:15%">Action</th>
                            </thead>
                            <tbody>
                            @php
                                $i = 1
                                @endphp
                                @forelse ($products as $product)
                                    <tr>    
                                    <td>{{ $i++ }}</td>
                                        <td>{{ $product->sku }}</td>
                                        <td>{{ $product->type }}</td>
                                        <td>{{ $product->name }}</td>
                                        <td>{{ number_format($product->price) }}</td>
                                        <td>{{ $product->statusLabel() }}</td>
                                        <td>
                                            <a href="{{ url('admin/products/'. $product->id .'/edit') }}" class="btn btn-warning btn-sm">edit</a>
                                            
                                            
                                                {!! Form::open(['url' => 'admin/products/'. $product->id, 'class' => 'delete', 'style' => 'display:inline-block']) !!}
                                                {!! Form::hidden('_method', 'DELETE') !!}
                                                {!! Form::submit('remove', ['class' => 'btn btn-danger btn-sm']) !!}
                                                {!! Form::close() !!}
                                            
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">No records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="pagination-style">
                        {{ $products->links('admin.partials.paginator') }}
                        </div>
                    </div>
                    
                        <div class="card-footer text-right">
                            <a href="{{ url('admin/products/create') }}" class="btn btn-primary">Add New</a>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection