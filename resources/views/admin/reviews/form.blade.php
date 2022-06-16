@extends('admin.layout')

@section('content')
	
@php
	$formTitle = !empty($productReview) ? 'Update' : 'New'    
@endphp

<div class="content">
	<div class="row">
		<div class="col-lg-12">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom">
						<h2>{{ $formTitle }} News</h2>
				</div>
				<div class="card-body">
					@include('admin.partials.flash', ['$errors' => $errors])
					@if (!empty($productReview))
						{!! Form::model($productReview, ['url' => ['admin/reviews', $productReview->id], 'method' => 'PUT']) !!}
						{!! Form::hidden('id') !!}
					@else
						{!! Form::open(['url' => 'admin/reviews']) !!}
					@endif
						
						<div class="form-group">
                            {!! Form::label('product', 'Product') !!}
                            {!! Form::select('product_id', $products, !empty($review) ? $productID : null, ['class' => 'form-control', 'placeholder' => '-- Choose Product --']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('rate', 'Rate') !!}
                            {!! Form::number('rate', null, ['class' => 'form-control', 'max' => '5', 'step' => '1']) !!}
                        </div>

						<div class="form-group">
							{!! Form::label('review', 'Review') !!}
							{!! Form::textarea('review', null, ['class' => 'form-control editor1', 'rows' => 3, 'id' => 'editor']) !!}
						</div>
						
						<div class="form-group">
							{!! Form::label('status', 'Status') !!}
							{!! Form::select('status', $statuses , null, ['class' => 'form-control', 'placeholder' => '-- Set Status --']) !!}
						</div>
						<div class="form-footer pt-5 border-top">
							<button type="submit" class="btn btn-primary btn-default">Save</button>
							<a href="{{ url('admin/reviews') }}" class="btn btn-secondary btn-default">Back</a>
						</div>
					{!! Form::close() !!}
				</div>
			</div>  
		</div>
	</div>
</div>
@endsection