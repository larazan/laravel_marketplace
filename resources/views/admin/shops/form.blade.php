@extends('admin.layout')

@section('content')

@php
$formTitle = !empty($shop) ? 'Update' : 'New';
$capi = !empty($capitalID) ? ($capitalID->count() > 0) ? (int)$capitalID[0] : 0 : null;
@endphp

<div class="content">
	<div class="row">
		<div class="col-lg-6">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom">
					<h2>{{ $formTitle }} shop </h2>
					@isset($capitalID) 
					<!-- {{ gettype($capitalID) }} 
					{{ $capitalID->count() }}  -->
					@endisset
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
					{!! Form::label('logo', 'Logo') !!}
					<div style="width:fit-content; border: 1px solid #ccc; padding: 8px; margin: 10px 10px 10px 0;">
						@if (!empty($shop))
                        <img src="{{ asset('storage/'.$shop->small) }}" class="center-xy img-fluid" alt="Logo Brand" />
                        @else
                        <img src="{{ URL::asset('dashboard/assets/imgs/brands/vendor-2.png') }}" class="center-xy img-fluid" alt="Logo Brand" />
                        @endif
					</div>
					</div>
						<div class="form-group">
							{!! Form::label('rekening', 'Rekening') !!}
							{!! Form::text('rekening', null, ['class' => 'form-control']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('atasnama', 'Atasnama') !!}
							{!! Form::text('atasnama', null, ['class' => 'form-control']) !!}
						</div>
						<div class="form-group">
							{!! Form::label('bank', 'Bank') !!}
							{!! Form::select('bank', $banks , null, ['class' => 'form-control', 'placeholder' => '-- Pilih Bank --']) !!}
						</div>
					<div class="form-group">
						{!! Form::label('capital', 'Capital') !!} 
						<select class="form-control" name="capital_id">
							<option selected="selected" value="">-- Choose Capital --</option>
							@foreach ($capitals as $capital)
								<option value="{{ $capital->id }}" {{ $capital->id == $capi ? 'selected' : null }}>{{ \General::priceFormat($capital->mini) }} - {{ \General::priceFormat($capital->maxi) }}</option>
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