<!-- Name Form Input -->
<div class="form-group @if ($errors->has('first_name')) has-error @endif">
    {!! Form::label('first_name', 'First Name') !!}
    {!! Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'First Name']) !!}
    @if ($errors->has('first_name')) <p class="help-block">{{ $errors->first('first_name') }}</p> @endif
</div>

<div class="form-group @if ($errors->has('last_name')) has-error @endif">
    {!! Form::label('last_name', 'Last Name') !!}
    {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Last Name']) !!}
    @if ($errors->has('last_name')) <p class="help-block">{{ $errors->first('last_name') }}</p> @endif
</div>

<!-- email Form Input -->
<div class="form-group @if ($errors->has('email')) has-error @endif">
    {!! Form::label('email', 'Email') !!}
    {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
    @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
</div>
@if (!empty($user))
<div class="form-group @if ($errors->has('phone')) has-error @endif">
    {!! Form::label('phone', 'Phone') !!}
    {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Phone']) !!}
    @if ($errors->has('phone')) <p class="help-block">{{ $errors->first('phone') }}</p> @endif
</div>

<div class="form-group @if ($errors->has('address1')) has-error @endif">
    {!! Form::label('address1', 'Address1') !!}
    {!! Form::textarea('address1', null, ['class' => 'form-control', 'placeholder' => 'Address1']) !!}
    @if ($errors->has('address1')) <p class="help-block">{{ $errors->first('address1') }}</p> @endif
</div>

<div class="form-group @if ($errors->has('address2')) has-error @endif">
    {!! Form::label('address2', 'Address2') !!}
    {!! Form::textarea('address2', null, ['class' => 'form-control', 'placeholder' => 'Address2']) !!}
    @if ($errors->has('address2')) <p class="help-block">{{ $errors->first('address2') }}</p> @endif
</div>

<div class="form-group @if ($errors->has('postcode')) has-error @endif">
    {!! Form::label('postcode', 'PosCode') !!}
    {!! Form::text('postcode', null, ['class' => 'form-control', 'placeholder' => 'PostCode']) !!}
    @if ($errors->has('postcode')) <p class="help-block">{{ $errors->first('postcode') }}</p> @endif
</div>

<div class="form-group @if ($errors->has('province_id')) has-error @endif">
    {!! Form::label('province_id', 'Provinsi') !!}
    {!! Form::select('province_id', App\Http\Controllers\Admin\UserController::getProvinces(), $user->province_id, ['class' => 'form-control', 'id' => 'user-province-id', 'placeholder' => '- Please Select - ', 'required' => true]) !!}
    @if ($errors->has('province_id')) <p class="help-block">{{ $errors->first('province_id') }}</p> @endif
</div>

<div class="form-group @if ($errors->has('city_id')) has-error @endif">
    {!! Form::label('city_id', 'city') !!}
    {!! Form::select('city_id', App\Http\Controllers\Admin\UserController::getCities($user->province_id), null, ['class' => 'form-control', 'id' => 'user-city-id', 'placeholder' => '- Please Select -', 'required' => true])!!}
    @if ($errors->has('city_id')) <p class="help-block">{{ $errors->first('city_id') }}</p> @endif
</div>

@endif
<!-- password Form Input -->
<div class="form-group @if ($errors->has('password')) has-error @endif">
    {!! Form::label('password', 'Password') !!}
    {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
    @if ($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
</div>

<!-- Roles Form Input -->
<div class="form-group @if ($errors->has('isAdmin')) has-error @endif">
    {!! Form::label('isAdmin', 'Role') !!}
    {!! Form::select('isAdmin', ['user', 'admin'],  0,  ['class' => 'form-control']) !!}
    @if ($errors->has('isAdmin')) <p class="help-block">{{ $errors->first('isAdmin') }}</p> @endif
</div>
