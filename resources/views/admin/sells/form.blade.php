@extends('admin.layout')

@section('content')
	
@php
	$formTitle = !empty($sell) ? 'Update' : 'New'    
@endphp

<div class="content">
	<div class="row">
		<div class="col-lg-6">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom">
						<h2>{{ $formTitle }} sell</h2>
				</div>
				<div class="card-body">
					@include('admin.partials.flash', ['$errors' => $errors])
					@if (!empty($sell))
						{!! Form::model($sell, ['url' => ['admin/sells', $sell->id], 'method' => 'PUT']) !!}
						{!! Form::hidden('id') !!}
					@else
						{!! Form::open(['url' => 'admin/sells']) !!}
					@endif
						<div class="form-group">
                            {!! Form::label('product', 'Product', ['class' => 'form-label']) !!}
                            {!! Form::select('product_id', $products, null, ['class' => 'form-control', 'placeholder' => '- Please Select - ', 'required' => true]) !!}                            
						</div>

                        <div class="form-group">
							{!! Form::label('number', 'Number') !!}
							{!! Form::number('prod_sell_number', null, ['class' => 'form-control']) !!}
						</div>
						
						<div class="form-group">
							{!! Form::label('status', 'Status') !!}
							{!! Form::select('status', $statuses , null, ['class' => 'form-control', 'placeholder' => '-- Set Status --']) !!}
						</div>
						<div class="form-footer pt-5 border-top">
							<button type="submit" class="btn btn-primary btn-default">Save</button>
							<a href="{{ url('admin/sells') }}" class="btn btn-secondary btn-default">Back</a>
						</div>
					{!! Form::close() !!}
				</div>
			</div>  
		</div>
	</div>
</div>
@endsection
