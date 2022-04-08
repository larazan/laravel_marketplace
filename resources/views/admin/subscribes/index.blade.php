@extends('admin.layout')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Email Subscribe</h2>
                    </div>
                    <div class="card-body">
                        @include('admin.partials.flash')
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>#</th>
                                <th>Email</th>
                                
                                <th>Status</th>
                                <th>Date</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                            @php
                                $i = 1
                                @endphp
                                @forelse ($subscribes as $subscribe)
                                    <tr>    
                                    <td>{{ $i++ }}</td>
                                        <td>{{ $subscribe->email }}</td>
                                       
                                        <td>{{ $subscribe->status }}</td>
                                        <td>{{ $subscribe->created_at }}</td>
                                        <td>
                                            
                                                <a href="{{ url('admin/subscribes/'. $subscribe->id .'/edit') }}" class="btn btn-warning btn-sm">edit</a>
                                            
                                                {!! Form::open(['url' => 'admin/subscribes/'. $subscribe->id, 'class' => 'delete', 'style' => 'display:inline-block']) !!}
                                                {!! Form::hidden('_method', 'DELETE') !!}
                                                {!! Form::submit('remove', ['class' => 'btn btn-danger btn-sm']) !!}
                                                {!! Form::close() !!}
                                            @endcan
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
                        {{ $subscribes->links() }}
                        </div>
                        
                    </div>

                    
                </div>
            </div>
        </div>
    </div>
@endsection