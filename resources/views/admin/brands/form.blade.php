@extends('admin.layout')

@section('content')
	
@php
	$formTitle = !empty($brand) ? 'Update' : 'New'    
@endphp

<div class="content">
	<div class="row">
		<div class="col-lg-6">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom">
						<h2>{{ $formTitle }} brand</h2>
				</div>
				<div class="card-body">
					@include('admin.partials.flash', ['$errors' => $errors])
					@if (!empty($brand))
						{!! Form::model($brand, ['url' => ['admin/brands', $brand->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
						{!! Form::hidden('id') !!}
					@else
						{!! Form::open(['url' => 'admin/brands', 'enctype' => 'multipart/form-data']) !!}
					@endif
						<div class="form-group">
							{!! Form::label('name', 'Name') !!}
							{!! Form::text('name', null, ['class' => 'form-control']) !!}
						</div>
						
						<div class="form-group">
							{!! Form::label('image', 'brand Image (1920x643 pixel)') !!}
							@if (!empty($brand))
							<div style="width:fit-content; border: 1px solid grey; padding: 5px; margin: 10px 10px 10px 0;">
								<img src="{{ asset('storage/'. $brand->original) }}" />
							</div>
							@endif
							{!! Form::file('image', ['class' => 'form-control-file', 'placeholder' => 'product image', 'id' => 'image', 'onchange' => 'previewImage();']) !!}
							<div class="mt-3">
								<img class="img-preview img-fluid col-sm-5" id="img-preview" style="display: block;">
							</div>
						</div>
						
						<div class="form-group">
							{!! Form::label('status', 'Status') !!}
							{!! Form::select('status', $statuses , null, ['class' => 'form-control', 'placeholder' => '-- Set Status --']) !!}
						</div>
						<div class="form-footer pt-5 border-top">
							<button type="submit" class="btn btn-primary btn-default">Save</button>
							<a href="{{ url('admin/brands') }}" class="btn btn-secondary btn-default">Back</a>
						</div>
					{!! Form::close() !!}
				</div>
			</div>  
		</div>
	</div>
</div>
@endsection

@section('scripts')
<script>
		function previewImage() {
			console.log('image preview');
			const image = document.querySelector('#image');
			const imagePreview = document.querySelector('.img-preview');

			imagePreview.style.display = 'block';

			const oFReader = new FileReader();
			oFReader.readAsDataURL(image.files[0]);

			oFReader.onload = function(oFREvent) {
				imagePreview.src = oFREvent.target.result;
			}
		}
	</script>
@endsection