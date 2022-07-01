@extends('admin.layout')

@section('content')
	
@php
	$formTitle = !empty($region) ? 'Update' : 'New'    
@endphp

<div class="content">
	<div class="row">
		<div class="col-lg-6">
			<div class="card card-default">
				<div class="card-header card-header-border-bottom">
						<h2>{{ $formTitle }} region</h2>
				</div>
				<div class="card-body">
					@include('admin.partials.flash', ['$errors' => $errors])
					@if (!empty($region))
						{!! Form::model($region, ['url' => ['admin/regions', $region->id], 'method' => 'PUT']) !!}
						{!! Form::hidden('id') !!}
					@else
						{!! Form::open(['url' => 'admin/regions']) !!}
					@endif
						<div class="form-group">
                            {!! Form::label('province', 'Provinsi', ['class' => 'form-label']) !!}
                            {!! Form::select('province_id', $provinces, null, ['class' => 'form-control', 'id' => 'user-province-id', 'placeholder' => '- Please Select - ', 'required' => true]) !!}
                            @error('province_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            {!! Form::hidden('province_name', null, ['id' => 'pro_name']) !!}
						</div>

                        <div class="form-group">
                            {!! Form::label('city', 'Kota / Kabupaten', ['class' => 'form-label']) !!}
                            {!! Form::select('city_id', $cities, null, ['class' => 'form-control', 'id' => 'user-city-id', 'placeholder' => '- Please Select -', 'required' => true])!!}
                            @error('city_id')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                            {!! Form::hidden('city_name', null, ['id' => 'ci_name']) !!}
						</div>

                        <div class="form-group">
							{!! Form::label('number', 'Number') !!}
							{!! Form::number('number', null, ['class' => 'form-control']) !!}
						</div>
						
						<div class="form-group">
							{!! Form::label('status', 'Status') !!}
							{!! Form::select('status', $statuses , null, ['class' => 'form-control', 'placeholder' => '-- Set Status --']) !!}
						</div>
						<div class="form-footer pt-5 border-top">
							<button type="submit" class="btn btn-primary btn-default">Save</button>
							<a href="{{ url('admin/regions') }}" class="btn btn-secondary btn-default">Back</a>
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
    $('#user-province-id').on('change', function(e) {
        var province_id = e.target.value;
        console.log('pilih');
        $('#pro_name').val($('#user-province-id option:selected').text());
        $.get('/orders/cities?province_id=' + province_id, function(data) {
            $('#user-city-id').empty();
            $('#user-city-id').append('<option value>- Please Select -</option>');

            $.each(data.cities, function(city_id, city) {

                $('#user-city-id').append('<option value="' + city_id + '">' + city + '</option>');
                
            });
        });
    });

    $('#user-city-id').on('change', function(e) {
        $('#ci_name').val($('#user-city-id option:selected').text());
    })
</script>
@endsection