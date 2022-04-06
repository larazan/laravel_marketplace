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
                                    <!-- {!! Form::model($user, ['url' => ['profile']]) !!} -->
                                    {!! Form::model($user, ['method' => 'PUT', 'route' => ['updateProfile'] ]) !!}
                                    @csrf    
                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="row gx-3">
                                                    <div class="col-6 mb-3">
                                                        {!! Form::label('first_name', 'First Name', ['class' => 'form-label']) !!}
                                                        {!! Form::text('first_name', null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'First Name']) !!}
                                                        @if ($errors->has('first_name')) <p class="help-block">{{ $errors->first('first_name') }}</p> @endif
                                                    </div>
                                                    <!-- col .// -->
                                                    <div class="col-6 mb-3">
                                                        {!! Form::label('last_name', 'Last Name', ['class' => 'form-label']) !!}
                                                        {!! Form::text('last_name', null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Last Name']) !!}
                                                        @if ($errors->has('last_name')) <p class="help-block">{{ $errors->first('last_name') }}</p> @endif
                                                    </div>
                                                    <!-- col .// -->
                                                    <div class="col-lg-6 mb-3">
                                                        {!! Form::label('company', 'Company', ['class' => 'form-label']) !!}
                                                        {!! Form::text('company', null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Company']) !!}
                                                        @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
                                                        
                                                    </div>
                                                    <!-- col .// -->
                                                    <div class="col-lg-6 mb-3">
                                                        {!! Form::label('email', 'Email', ['class' => 'form-label']) !!}
                                                        {!! Form::text('email', null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Email']) !!}
                                                        @if ($errors->has('email')) <p class="help-block">{{ $errors->first('email') }}</p> @endif
                                                        
                                                    </div>
                                                    <!-- col .// -->
                                                    <div class="col-lg-6 mb-3">
                                                        {!! Form::label('phone', 'Phone', ['class' => 'form-label']) !!}
                                                        {!! Form::text('phone', null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Phone']) !!}
                                                        @if ($errors->has('phone')) <p class="help-block">{{ $errors->first('phone') }}</p> @endif
                                                    </div>
                                                    <!-- col .// -->
                                                    <div class="col-lg-12 mb-3">
                                                        {!! Form::label('address', 'Address1', ['class' => 'form-label']) !!}
                                                        {!! Form::textarea('address1', null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Address']) !!}
                                                        @if ($errors->has('address1')) <p class="help-block">{{ $errors->first('address1') }}</p> @endif
                                                    </div>
                                                    <!-- col .// -->
                                                    <div class="col-lg-12 mb-3">
                                                        {!! Form::label('address', 'Address2 (optional)', ['class' => 'form-label']) !!}
                                                        {!! Form::textarea('address2', null, ['class' => 'form-control', 'placeholder' => 'Address']) !!}
                                                        @if ($errors->has('address2')) <p class="help-block">{{ $errors->first('address2') }}</p> @endif
                                                    </div>

                                                     <!-- col .// -->
                                                     <div class="col-lg-12 mb-3">
                                                        {!! Form::label('province', 'Provinsi', ['class' => 'form-label']) !!}
                                                        {!! Form::select('province_id', $provinces, Auth::user()->province_id, ['class' => 'form-select', 'id' => 'user-province-id', 'placeholder' => '- Please Select - ', 'required' => true]) !!}
                                                        @error('province_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <!-- col .// -->
                                                    <div class="col-lg-12 mb-3">
                                                        {!! Form::label('city', 'Kota', ['class' => 'form-label']) !!}
                                                        {!! Form::select('city_id', $cities, null, ['class' => 'form-select', 'id' => 'user-city-id', 'placeholder' => '- Please Select -', 'required' => true])!!}
											            @error('city_id')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>

                                                    <!-- col .// -->
                                                    <div class="col-lg-12 mb-3">
                                                        {!! Form::label('postcode', 'Address', ['class' => 'form-label']) !!}
                                                        {!! Form::number('postcode', null, ['class' => 'form-control', 'required' => true, 'placeholder' => 'Postcode']) !!}
                                                        @if ($errors->has('postcode')) <p class="help-block">{{ $errors->first('postcode') }}</p> @endif
                                                    </div>

                                                    <!-- col .// -->
                                                    <div class="col-lg-12 mb-3">
                                                        {!! Form::label('gambar', 'Foto', ['class' => 'form-label']) !!}
                                                        <img class="img-preview img-fluid col-sm-5 mb-3" id="img-preview" style="display: block;">
                                                        {!! Form::file('featured_image', ['class' => 'form-control', 'placeholder' => 'post image', 'id' => 'image', 'onchange' => 'previewImage();']) !!}
                                                    </div>

                                                </div>
                                                <!-- row.// -->
                                            </div>
                                            <!-- col.// -->
                                           
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