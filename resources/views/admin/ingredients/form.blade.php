@extends('admin.layout')

@section('content')
	
@php
	$formTitle = !empty($ingredient) ? 'Update' : 'New'    
@endphp

<div class="content">
	<div class="row">
		<div class="col-lg-6">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom">
						<h2>{{ $formTitle }} ingredient</h2>
				</div>
				<div class="card-body">
					@include('admin.partials.flash', ['$errors' => $errors])
					@if (!empty($ingredient))
						{!! Form::model($ingredient, ['url' => ['admin/ingredients', $ingredient->id], 'method' => 'PUT']) !!}
						{!! Form::hidden('id') !!}
					@else
						{!! Form::open(['url' => 'admin/ingredients']) !!}
					@endif
						<div class="form-group">
							{!! Form::label('name', 'Name') !!}
							{!! Form::text('name', null, ['class' => 'form-control']) !!}
						</div>
						
						<div class="form-group">
							{!! Form::label('status', 'Status') !!}
							{!! Form::select('status', $statuses , null, ['class' => 'form-control', 'placeholder' => '-- Set Status --']) !!}
						</div>
						<div class="form-footer pt-5 border-top">
							<button type="submit" class="btn btn-primary btn-default">Save</button>
							<a href="{{ url('admin/ingredients') }}" class="btn btn-secondary btn-default">Back</a>
						</div>
					{!! Form::close() !!}
				</div>
			</div>  
		</div>
	</div>
</div>
@endsection
