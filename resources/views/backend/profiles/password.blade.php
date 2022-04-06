@extends('backend.layout')

@section('content')

<section class="content-main">
                <div class="content-header">
                    <h2 class="content-title">Change password</h2>
                </div>
                <div class="card">
                    <div class="card-body">
                        <div class="row gx-5">
                            
                            <div class="col-lg-9">
                                <section class="content-body p-xl-4">
                                    <form class="form-horizontal" method="POST" action="{{ route('changePasswordPost') }}">
                                    {{ csrf_field() }}
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="row gx-3">
                                                    
                                                    <!-- col .// -->
                                                    <div class="col-lg-6 mb-3">
                                                        {!! Form::label('current-password', 'Password Lama', ['class' => 'form-label']) !!}
                                                        {!! Form::password('current-password', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Password']) !!}
                                                        @if ($errors->has('current-password')) <p class="help-block">{{ $errors->first('current-password') }}</p> @endif
                                                    </div>

                                                    <div class="col-lg-6 mb-3">
                                                        {!! Form::label('new-password', 'New Password', ['class' => 'form-label']) !!}
                                                        {!! Form::password('new-password', ['class' => 'form-control', 'required' => true, 'placeholder' => 'New Password']) !!}
                                                        @if ($errors->has('new-password')) <p class="help-block">{{ $errors->first('new-password') }}</p> @endif
                                                    </div>

                                                    <div class="col-lg-6 mb-3">
                                                        {!! Form::label('new-password-confirm', 'Confirm Password', ['class' => 'form-label']) !!}
                                                        {!! Form::password('new-password_confirmation', ['class' => 'form-control', 'required' => true, 'placeholder' => 'Confirm Password']) !!}
                                                    </div>
                                                  
                                                    
                                                </div>
                                                <!-- row.// -->
                                            </div>
                                            <!-- col.// -->
                                            
                                        </div>
                                        <!-- row.// -->
                                        <br />
                                        <!-- <button class="btn btn-primary" type="submit">Save changes</button> -->
                                        {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
                                    {!! Form::close() !!}
                                    
                                    <!-- row.// -->
                                </section>
                                <!-- content-body .// -->
                            </div>
                            <!-- col.// -->
                        </div>
                        <!-- row.// -->
                    </div>
                    <!-- card body end// -->
                </div>
                <!-- card end// -->
            </section>

@endsection