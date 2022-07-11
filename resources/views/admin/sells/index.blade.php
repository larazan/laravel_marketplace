@extends('admin.layout')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Product Sell</h2>
                    </div>
                    <div class="card-body">
                        @include('admin.partials.flash')
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>#</th>
                                <th>Product</th>
                                <th>Sell Number</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @php
                                $i = 1
                                @endphp
                                @forelse ($sells as $sell)
                                    <tr>    
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $sell->product_id }}</td>
                                        <td>{{ $sell->prod_sell_number }}</td>
                                        <td>{{ $sell->status }}</td>
                                        <td>
                                            
                                                <a href="{{ url('admin/sells/'. $sell->id .'/edit') }}" class="btn btn-warning btn-sm">edit</a>
                                            
                                                {!! Form::open(['url' => 'admin/sells/'. $sell->id, 'class' => 'delete', 'style' => 'display:inline-block']) !!}
                                                {!! Form::hidden('_method', 'DELETE') !!}
                                                {!! Form::submit('remove', ['class' => 'btn btn-danger btn-sm']) !!}
                                                {!! Form::close() !!}
                                            
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">No records found</td>
                                    </tr>
                                @endforelse
                                
                            </tbody>
                        </table>
                        <div class="pagination-style">
                        {{ $sells->links('admin.partials.paginator') }}
                        </div>
                    </div>

                    
                        <div class="card-footer text-right">
                            <a href="{{ url('admin/sells/create') }}" class="btn btn-primary">Add New</a>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection