@extends('admin.layout')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Categories</h2>
                    </div>
                    <div class="card-body">
                        @include('admin.partials.flash')
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>#</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Parent</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                            @php
                                $i = 1
                                @endphp
                                @forelse ($categories as $category)
                                    <tr>    
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->slug }}</td>
                                        <td>{{ $category->parent ? $category->parent->name : '' }}</td>
                                        <td>
                                            
                                                <a href="{{ url('admin/category_articles/'. $category->id .'/edit') }}" class="btn btn-warning btn-sm">edit</a>
                                            

                                            
                                                {!! Form::open(['url' => 'admin/category_articles/'. $category->id, 'class' => 'delete', 'style' => 'display:inline-block']) !!}
                                                {!! Form::hidden('_method', 'DELETE') !!}
                                                {!! Form::submit('remove', ['class' => 'btn btn-danger btn-sm']) !!}
                                                {!! Form::close() !!}
                                            
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="pagination-style">
                        {{ $categories->links() }}
                        </div>
                    </div>

                    
                        <div class="card-footer text-right">
                            <a href="{{ url('admin/category_articles/create') }}" class="btn btn-primary">Add New</a>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection