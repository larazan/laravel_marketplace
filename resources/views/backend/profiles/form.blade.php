@extends('backend.layout')

@section('content')

<section class="content-main">
                <div class="content-header">
                    <h2 class="content-title">Profile setting</h2>
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
                                                    <div class="col-6 mb-3">
                                                        {!! Form::label('first_name', 'First Name', ['class' => 'form-label']) !!}
                                                        {!! Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'First Name']) !!}
                                                        @if ($errors->has('first_name')) <p class="help-block">{{ $errors->first('first_name') }}</p> @endif
                                                    </div>
                                                    <!-- col .// -->
                                                    <div class="col-6 mb-3">
                                                        {!! Form::label('last_name', 'Last Name', ['class' => 'form-label']) !!}
                                                        {!! Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Last Name']) !!}
                                                        @if ($errors->has('last_name')) <p class="help-block">{{ $errors->first('last_name') }}</p> @endif
                                                    </div>
                                                    <!-- col .// -->
                                                    <div class="col-lg-6 mb-3">
                                                        {!! Form::label('email', 'Email', ['class' => 'form-label']) !!}
                                                        {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) !!}
                                                        @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
                                                        
                                                    </div>
                                                    <!-- col .// -->
                                                    <div class="col-lg-6 mb-3">
                                                        {!! Form::label('phone', 'Phone', ['class' => 'form-label']) !!}
                                                        {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Phone']) !!}
                                                        @if ($errors->has('phone')) <p class="help-block">{{ $errors->first('phone') }}</p> @endif
                                                    </div>
                                                    <!-- col .// -->
                                                    <div class="col-lg-12 mb-3">
                                                    {!! Form::label('address', 'Address', ['class' => 'form-label']) !!}
                                                        {!! Form::textarea('address', null, ['class' => 'form-control', 'placeholder' => 'Address']) !!}
                                                        @if ($errors->has('address')) <p class="help-block">{{ $errors->first('address') }}</p> @endif
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
                                    <hr class="my-5" />
                                    <div class="row" style="max-width: 920px">
                                        <div class="col-md">
                                            <article class="box mb-3 bg-light">
                                                <a class="btn float-end btn-light btn-sm rounded font-md" href="#">Change</a>
                                                <h6>Password</h6>
                                                <small class="text-muted d-block" style="width: 70%">You can reset or change your password by clicking here</small>
                                            </article>
                                        </div>
                                        <!-- col.// -->
                                        <div class="col-md">
                                            <article class="box mb-3 bg-light">
                                                <a class="btn float-end btn-light rounded btn-sm font-md" href="#">Deactivate</a>
                                                <h6>Remove account</h6>
                                                <small class="text-muted d-block" style="width: 70%">Once you delete your account, there is no going back.</small>
                                            </article>
                                        </div>
                                        <!-- col.// -->
                                    </div>
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