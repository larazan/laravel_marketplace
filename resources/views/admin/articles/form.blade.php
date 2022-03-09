@extends('admin.layout')

@section('content')
	
@php
	$formTitle = !empty($article) ? 'Update' : 'New'    
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
					@if (!empty($article))
						{!! Form::model($article, ['url' => ['admin/articles', $article->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
						{!! Form::hidden('id') !!}
					@else
						{!! Form::open(['url' => 'admin/articles', 'enctype' => 'multipart/form-data']) !!}
					@endif
						<div class="form-group">
							{!! Form::label('title', 'Title') !!}
							{!! Form::text('title', null, ['class' => 'form-control']) !!}
						</div>
						<div class="form-group">
                            {!! Form::label('category_ids', 'Category') !!}
							{!! General::selectMultiLevel('category_ids[]', $categories, ['class' => 'form-control', 'multiple' => true, 'selected' => !empty(old('category_ids')) ? old('category_ids') : $categoryIDs]) !!}
                        </div>
					
						<div class="form-group">
							{!! Form::label('image', 'Post Image (1920x643 pixel)') !!}
							@if (!empty($article))
							<div style="width:fit-content; border: 1px solid grey; padding: 5px; margin: 10px 10px 10px 0;">
								<img src="{{ asset('storage/'. $articleImage->first()->small) }}" />
							</div>
							@endif
							{!! Form::file('featured_image', ['class' => 'form-control-file', 'placeholder' => 'post image', 'id' => 'image', 'onchange' => 'previewImage();']) !!}
							<div class="mt-3">
								<img class="img-preview img-fluid col-sm-5" id="img-preview" style="display: block;">
							</div>
						</div>
					
						<div class="form-group">
							{!! Form::label('editor1', 'Body') !!}
							{!! Form::textarea('editor1', null, ['class' => 'form-control editor1', 'rows' => 3, 'id' => 'editor']) !!}
						</div>
						
						<div class="form-group">
							{!! Form::label('tags', 'Tags') !!}
							{!! Form::text('tags_input', null, ['class' => 'form-control']) !!}
						</div>
                        <div class="form-group">
                            {!! Form::label('published_at', 'Published At') !!}
                            {!! Form::text('published_at', null, ['class' => 'form-control', 'id' => 'published_at']) !!}
                        </div>
						<div class="form-group">
							{!! Form::label('status', 'Status') !!}
							{!! Form::select('status', $statuses , null, ['class' => 'form-control', 'placeholder' => '-- Set Status --']) !!}
						</div>
						 
						<div class="form-footer pt-5 border-top">
							<button type="submit" class="btn btn-primary btn-default">Save</button>
							<a href="{{ url('admin/articles') }}" class="btn btn-secondary btn-default">Back</a>
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
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr('#published_at', {
            enableTime: true
        })
    </script>

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

@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endsection