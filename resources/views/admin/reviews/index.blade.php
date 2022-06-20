@extends('admin.layout')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Review</h2>
                    </div>
                    <div class="card-body">
                        @include('admin.partials.flash')
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>#</th>
                                <th>Product</th>
                                <th>User</th>
                                <th>Review</th>
                                <th>Rate</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                            @php
                                $i = 1
                                @endphp
                                @forelse ($reviews as $review)
                                    <tr>    
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $review->product->name }}</td>
                                        <td>{{ $review->user_info->first_name .' '. $review->user_info->last_name }}</td>
                                        <td>{{ \Illuminate\Support\Str::words($review->review, '20') }}</td>
                                        <td>{{ $review->rate }}</td>
                                        <td>{{ $review->status }}</td>
                                        <td>
                                            
                                                <a href="{{ url('admin/reviews/'. $review->id .'/edit') }}" class="btn btn-warning btn-sm">edit</a>
                                            

                                            
                                                {!! Form::open(['url' => 'admin/reviews/'. $review->id, 'class' => 'delete', 'style' => 'display:inline-block']) !!}
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
                        {{ $reviews->links() }}
                        </div>
                        
                    </div>

                    
                        <div class="card-footer text-right">
                            <a href="{{ url('admin/reviews/create') }}" class="btn btn-primary">Add New</a>
                        </div>
                    
                </div>
            </div>
        </div>
    </div>
@endsection