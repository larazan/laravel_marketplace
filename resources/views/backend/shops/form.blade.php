@extends('backend.layout')

@section('content')

<section class="content-main">
    <div class="content-header">
        <h2 class="content-title">Edit Shop Information</h2>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row gx-5">
                
                <div class="col-lg-9">
                    <section class="content-body p-xl-4">
                        
                        @if (!empty($shop))
                            {!! Form::model($shop, ['url' => ['user/shop/update', $shop->id], 'method' => 'PUT', 'enctype' => 'multipart/form-data']) !!}
                            {!! Form::hidden('id') !!}
                        @else
                            {!! Form::open(['url' => 'user/shop/store', 'enctype' => 'multipart/form-data']) !!}
                        @endif

                            <div class="row border-bottom mb-4 pb-4">
                                <div class="col-md-5">
                                    <h5>Shop name</h5>
                                </div>
                                <!-- col.// -->
                                <div class="col-md-7">
                                    <div class="mb-3">
                                        {!! Form::text('name', null, ['class' => 'form-control']) !!}
                                    </div>
                                    
                                </div>
                                <!-- col.// -->
                            </div>
                            <!-- row.// -->
                            
                            <!-- row.// -->
                            <div class="row border-bottom mb-4 pb-4">
                                <div class="col-md-5">
                                    <h5>Description</h5>
                                </div>
                                <div class="col-md-7">
                                    
                                    <div class="mb-3">
                                        {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                                        @if ($errors->has('description')) <p class="help-block">{{ $errors->first('description') }}</p> @endif
                                    </div>
                                </div>
                                <!-- col.// -->
                            </div>
                            <!-- row.// -->
                            <div class="row border-bottom mb-4 pb-4">
                                <div class="col-md-5">
                                    <h5>Image</h5>
                                </div>
                                <div class="col-md-7">
                                    
                                    <div class="mb-3">
                                    <img class="img-preview img-fluid col-sm-5 mb-3" id="img-preview" style="display: block;">
                                    {!! Form::file('featured_image', ['class' => 'form-control', 'placeholder' => 'post image', 'id' => 'image', 'onchange' => 'previewImage();']) !!}
                                    </div>
                                </div>
                                <!-- col.// -->
                            </div>
                            <!-- row.// -->
                            <!-- <div class="row border-bottom mb-4 pb-4">
                                <div class="col-md-5">
                                    <h5>Status</h5>
                                </div>
                                
                                <div class="col-md-7">
                                    <div class="mb-3" style="max-width: 200px">
                                        <select class="form-select">
                                            <option>US Dollar</option>
                                            <option>EU Euro</option>
                                            <option>RU Ruble</option>
                                            <option>UZ Som</option>
                                        </select>
                                    </div>
                                    
                                </div>
                                
                            </div> -->
                            <!-- row.// -->
                            <button class="btn btn-primary" type="submit">Save</button> &nbsp;
                            <a href="{{ url('user/shop') }}" class="btn btn-light rounded font-md">Reset</a>
                        {!! Form::close() !!}
                    </section>
                    <!-- content-body .// -->
                </div>
                <!-- col.// -->
            </div>
            <!-- row.// -->
        </div>
        <!-- card-body .//end -->
    </div>
    <!-- card .//end -->
</section>

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