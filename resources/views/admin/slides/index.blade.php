@extends('admin.layout')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Slides</h2>
                    </div>
                    <div class="card-body">
                        @include('admin.partials.flash')
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>#</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                            @php
                                $i = 1
                                @endphp
                                @forelse ($slides as $slide)
                                    <tr>    
                                    <td>{{ $i++ }}</td>
                                        <td>{{ $slide->title }}</td>
                                        <td><img src="{{ asset('storage/'. $slide->small) }}" /></td>
                                        <td>
                                            @if ($slide->prevSlide())
                                                <a href="{{ url('admin/slides/'. $slide->id .'/up') }}">up</a>
                                            @else
                                                up
                                            @endif
                                             | 
                                            @if ($slide->nextSlide())
                                                <a href="{{ url('admin/slides/'. $slide->id .'/down') }}">down</a>
                                            @else
                                                down
                                            @endif
                                        </td>
                                        <td>{{ $slide->status }}</td>
                                        <td>
                                            
                                                <a href="{{ url('admin/slides/'. $slide->id .'/edit') }}" class="btn btn-warning btn-sm">edit</a>
                                            

                                            
                                                {!! Form::open(['url' => 'admin/slides/'. $slide->id, 'class' => 'delete', 'style' => 'display:inline-block']) !!}
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
                        {{ $slides->links() }}
                        </div>
                    </div>

                    
                        <div class="card-footer text-right">
                            <a href="{{ url('admin/slides/create') }}" class="btn btn-primary">Add New</a>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection