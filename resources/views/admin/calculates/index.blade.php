@extends('admin.layout')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Calculates</h2>
                    </div>
                    <div class="card-body">
                        @include('admin.partials.flash')
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>#</th>
                                <th>Jenis Sorgum</th>
                                <th>Kota</th>
                                <th>Produk yang dijual</th>
                                <th>Hasil Penjualan (Rp)</th>
                                <th>Modal (Rp)</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @php
                                $i = 1
                                @endphp
                                @forelse ($items as $item)
                                    <tr>    
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $item->ingredient_id }}</td>
                                        <td>{{ $item->number }}</td>
                                        <td>{{ $item->prod_sell_number }}</td>
                                        <td>{{ $item->income_rank }}</td>
                                        <td>{{ $item->capital_id }}</td>
                                        <td>
                                            
                                            <a href="{{ url('admin/items/'. $item->id_order .'/edit') }}" class="btn btn-warning btn-sm">edit</a>
                                            {!! Form::open(['url' => 'admin/items/'. $item->id_order, 'class' => 'delete', 'style' => 'display:inline-block']) !!}
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
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection