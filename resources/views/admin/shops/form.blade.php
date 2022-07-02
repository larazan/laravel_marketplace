@extends('admin.layout')

@section('content')
	
@php
	$formTitle = !empty($shop) ? 'Update' : 'New'    
@endphp

<div class="content">
	<div class="row">
		<div class="col-lg-6">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom">
						<h2>{{ $formTitle }} shop</h2>
				</div>
				<div class="card-body">
					@include('admin.partials.flash', ['$errors' => $errors])
					@if (!empty($shop))
						{!! Form::model($shop, ['url' => ['admin/shops', $shop->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
						{!! Form::hidden('id') !!}
					@else
						{!! Form::open(['url' => 'admin/shops', 'enctype' => 'multipart/form-data']) !!}
					@endif
						<div class="form-group">
							{!! Form::label('name', 'Name') !!}
							{!! Form::text('name', null, ['class' => 'form-control']) !!}
						</div>
						
						<div class="form-group">
                                {!! Form::label('description', 'Description') !!}
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'description']) !!}
                            </div>
							<div class="form-group">
                            {!! Form::label('capital', 'Capital') !!}
							<select class="form-control" name="capital_id">
								<option selected="selected" value="">-- Choose Capital --</option>
								@foreach ($capitals as $capital)
								<option value="{{ $capital->id }}" {{ $capitalID == $capital->id  ? 'selected' : ''}}>{{ \General::priceFormat($capital->mini) }} - {{ \General::priceFormat($capital->maxi) }}</option>
								@endforeach
							</select>
						</div>
						<div class="form-group">
							{!! Form::label('status', 'Status') !!}
							{!! Form::select('is_active', $statuses , null, ['class' => 'form-control', 'placeholder' => '-- Set Status --']) !!}
						</div>
						<div class="form-footer pt-5 border-top">
							<button type="submit" class="btn btn-primary btn-default">Save</button>
							<a href="{{ url('admin/shops') }}" class="btn btn-secondary btn-default">Back</a>
						</div>
					{!! Form::close() !!}
				</div>
			</div>  
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script src="https://cdn.ckeditor.com/4.12.1/standard/ckeditor.js"></script>
	<script type="text/javascript">
		CKEDITOR.replace('editor1', {
			filebrowserUploadUrl: "{{route('ckeditor.upload', ['_token' => csrf_token() ])}}",
			filebrowserUploadMethod: 'form'
		});
	</script>
@endsection