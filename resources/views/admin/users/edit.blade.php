@extends('admin.layout')

@section('title', 'Edit User ' . $user->first_name)

@section('content')
<div class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-default">
                <div class="card-header card-header-border-bottom">
                        <h2>Edit -  {{ $user->first_name.' '.$user->last_name }}</h2>
                </div>
                <div class="card-body">
                    {!! Form::model($user, ['method' => 'PUT', 'route' => ['users.update',  $user->id ] ]) !!}
                        @include('admin.users.form')
                        <!-- Submit Form Button -->
                        <div class="form-footer pt-5 border-top">
                        {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
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
   
    $('#user-province-id').on('change', function (e) {
        var province_id = e.target.value;
        console.log('pilih');
        $.get('/orders/cities?province_id=' + province_id, function(data){
            $('#user-city-id').empty();
            $('#user-city-id').append('<option value>- Please Select -</option>');

            $.each(data.cities, function(city_id, city){
            
            $('#user-city-id').append('<option value="'+city_id+'">'+ city + '</option>');

        });
        });
    });

</script>