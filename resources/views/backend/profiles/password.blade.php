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
                                {!! Form::model($user, ['method' => 'PUT', 'route' => ['users.update',  $user->id ] ]) !!}
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="row gx-3">
                                                    
                                                    <!-- col .// -->
                                                    <div class="col-lg-6 mb-3">
                                                        {!! Form::label('password', 'Password Lama', ['class' => 'form-label']) !!}
                                                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) !!}
                                                        @if ($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
                                                    </div>

                                                    <div class="col-lg-6 mb-3">
                                                        {!! Form::label('password', 'New Password', ['class' => 'form-label']) !!}
                                                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'New Password']) !!}
                                                        @if ($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
                                                    </div>

                                                    <div class="col-lg-6 mb-3">
                                                        {!! Form::label('password', 'Confirm Password', ['class' => 'form-label']) !!}
                                                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Confirm Password']) !!}
                                                        @if ($errors->has('password')) <p class="help-block">{{ $errors->first('password') }}</p> @endif
                                                    </div>
                                                  
                                                    
                                                </div>
                                                <!-- row.// -->
                                            </div>
                                            <!-- col.// -->
                                            <aside class="col-lg-4">
                                                <figure class="text-lg-center">
                                                    <img class="img-lg mb-3 img-avatar" src="assets/imgs/people/avatar-1.png" alt="User Photo" />
                                                    <figcaption>
                                                        <a class="btn btn-light rounded font-md" href="#"> <i class="icons material-icons md-backup font-md"></i> Upload </a>
                                                    </figcaption>
                                                </figure>
                                            </aside>
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