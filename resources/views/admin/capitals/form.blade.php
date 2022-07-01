@extends('admin.layout')

@section('content')
	
@php
	$formTitle = !empty($capital) ? 'Update' : 'New'    
@endphp

<div class="content">
	<div class="row">
		<div class="col-lg-6">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom">
						<h2>{{ $formTitle }} capital</h2>
				</div>
				<div class="card-body">
					@include('admin.partials.flash', ['$errors' => $errors])
					@if (!empty($capital))
						{!! Form::model($capital, ['url' => ['admin/capitals', $capital->id], 'method' => 'PUT']) !!}
						{!! Form::hidden('id') !!}
					@else
						{!! Form::open(['url' => 'admin/capitals']) !!}
					@endif
						
                        <div class="form-group">
                            {!! Form::label('mini', 'Minimum') !!}
                            {!! Form::text('mini', null, ['class' => 'form-control', 'placeholder' => 'minimum capital']) !!}
                        </div>

                        <div class="form-group">
                            {!! Form::label('maxi', 'Maximum') !!}
                            {!! Form::text('maxi', null, ['class' => 'form-control', 'placeholder' => 'maximum capital']) !!}
                        </div>

                        <div class="form-group">
							{!! Form::label('rank', 'Rank') !!}
							{!! Form::number('rank', null, ['class' => 'form-control']) !!}
						</div>
						
						<div class="form-group">
							{!! Form::label('status', 'Status') !!}
							{!! Form::select('status', $statuses , null, ['class' => 'form-control', 'placeholder' => '-- Set Status --']) !!}
						</div>
						<div class="form-footer pt-5 border-top">
							<button type="submit" class="btn btn-primary btn-default">Save</button>
							<a href="{{ url('admin/capitals') }}" class="btn btn-secondary btn-default">Back</a>
						</div>
					{!! Form::close() !!}
				</div>
			</div>  
		</div>
	</div>
</div>
@endsection
