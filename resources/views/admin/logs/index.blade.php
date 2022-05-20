@extends('admin.layout')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Log Activity Lists</h2>
                    </div>
                    <div class="card-body">
                        @include('admin.partials.flash')
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>No</th>
                                <th>Subject</th>
                                <th>URL</th>
                                <th>Method</th>
                                <th>Ip</th>
                                <th>User Agent</th>
                                <th>User Id</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @php
                                $i = 1
                                @endphp
                                @forelse ($logs as $log)
                                    <tr>    
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $log->subject }}</td>
                                        <td class="text-success">{{ $log->url }}</td>
                                        <td><label class="label label-info">{{ $log->method }}</label></td>
                                        <td class="text-warning">{{ $log->ip }}</td>
                                        <td class="text-danger">{{ $log->agent }}</td>
                                        <td>{{ $log->user_id }}</td>
                                        <td>
                                            
                                                {!! Form::open(['url' => 'admin/logs/'. $log->id, 'class' => 'delete', 'style' => 'display:inline-block']) !!}
                                                {!! Form::hidden('_method', 'DELETE') !!}
                                                {!! Form::submit('remove', ['class' => 'btn btn-danger btn-sm']) !!}
                                                {!! Form::close() !!}
                                            
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8">No records found</td>
                                    </tr>
                                @endforelse
                                
                            </tbody>
                        </table>
                        <div class="pagination-style">
                        </div>
                    </div>

                    
        
                    
                </div>
            </div>
        </div>
    </div>
@endsection