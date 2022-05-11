@extends('admin.layout')

@section('content')
	
@php
	$formTitle = !empty($setting) ? 'Update' : 'New'    
@endphp

<div class="content">
	<div class="row">
		<div class="col-lg-8">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom">
						<h2>{{ $formTitle }} Setting</h2>
				</div>
				<div class="card-body">
					@include('admin.partials.flash', ['$errors' => $errors])

					@if (!empty($setting))
						{!! Form::model($setting, ['method' => 'PUT', 'route' => ['updateSetting'], 'enctype' => 'multipart/form-data' ]) !!}
					@else
						{!! Form::open(['url' => 'admin/setting/store', 'enctype' => 'multipart/form-data']) !!}
					@endif
						<div class="form-group">
							{!! Form::label('title', 'Title') !!}
							{!! Form::text('title', null, ['class' => 'form-control']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('address', 'Address') !!}
							{!! Form::text('address', null, ['class' => 'form-control']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('phone', 'Phone') !!}
							{!! Form::text('phone', null, ['class' => 'form-control']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('email', 'Email') !!}
							{!! Form::text('email', null, ['class' => 'form-control']) !!}
						</div>
					
						<div class="form-group">
							{!! Form::label('image', 'Slide Image (1920x643 pixel)') !!}
							@if (!empty($slide))
							<div style="width:fit-content; border: 1px solid grey; padding: 5px; margin: 10px 10px 10px 0;">
								<img src="{{ asset('storage/'. $slide->small) }}" />
							</div>
							@endif
							{!! Form::file('image', ['class' => 'form-control-file', 'placeholder' => 'product image', 'id' => 'image', 'onchange' => 'previewImage();']) !!}
							<div class="mt-3">
								<img class="img-preview img-fluid col-sm-5" id="img-preview" style="display: block;">
							</div>
						</div>
					
						<div class="form-group">
							{!! Form::label('description', 'Description') !!}
							{!! Form::textarea('description', null, ['class' => 'form-control', 'rows' => 3]) !!}
						</div>

						<div class="form-group">
							{!! Form::label('short_des', 'Short Description') !!}
							{!! Form::textarea('short_des', null, ['class' => 'form-control', 'rows' => 3]) !!}
						</div>

						<div class="form-group">
							{!! Form::label('twitter', 'twitter') !!}
							{!! Form::text('twitter', null, ['class' => 'form-control']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('facebook', 'facebook') !!}
							{!! Form::text('facebook', null, ['class' => 'form-control']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('instagram', 'instagram') !!}
							{!! Form::text('instagram', null, ['class' => 'form-control']) !!}
						</div>
						
						<div class="form-footer pt-5 border-top">
							<button type="submit" class="btn btn-primary btn-default">Save</button>
							<a href="{{ url('admin/setting') }}" class="btn btn-secondary btn-default">Back</a>
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