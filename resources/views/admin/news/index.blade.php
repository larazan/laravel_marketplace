@extends('admin.layout')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>News</h2>
                    </div>
                    <div class="card-body">
                        @include('admin.partials.flash')
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>#</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Body</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                            @php
                                $i = 1
                                @endphp
                                @forelse ($posts as $post)
                                    <tr>    
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $post->title }}</td>
                                        <td>category</td>
                                        <td>{{ $post->body }}</td>
                                        <td><img src="{{ asset('storage/'. $post->postImages->first()->small) }}" /></td>
                                       
                                        <td>{{ $post->status }}</td>
                                        <td>
                                            
                                                <a href="{{ url('admin/posts/'. $post->id .'/edit') }}" class="btn btn-warning btn-sm">edit</a>
                                            

                                            
                                                {!! Form::open(['url' => 'admin/posts/'. $post->id, 'class' => 'delete', 'style' => 'display:inline-block']) !!}
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
                        {{ $posts->links('admin.partials.paginator') }}
                        </div>
                        
                    </div>

                    
                        <div class="card-footer text-right">
                            <a href="{{ url('admin/posts/create') }}" class="btn btn-primary">Add New</a>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection