@extends('admin.layout')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Regions</h2>
                    </div>
                    <div class="card-body">
                        @include('admin.partials.flash')
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>#</th>
                                <th>City</th>
                                <th>Number</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @php
                                $i = 1
                                @endphp
                                @forelse ($regions as $region)
                                    <tr>    
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $region->city_name }}</td>
                                        <td>{{ $region->number }}</td>
                                        <td>{{ $region->status }}</td>
                                        <td>
                                            
                                                <a href="{{ url('admin/regions/'. $region->id .'/edit') }}" class="btn btn-warning btn-sm">edit</a>
                                            
                                                {!! Form::open(['url' => 'admin/regions/'. $region->id, 'class' => 'delete', 'style' => 'display:inline-block']) !!}
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
                        {{ $regions->links('admin.partials.paginator') }}
                        </div>
                    </div>

                    
                        <div class="card-footer text-right">
                            <a href="{{ url('admin/regions/create') }}" class="btn btn-primary">Add New</a>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection