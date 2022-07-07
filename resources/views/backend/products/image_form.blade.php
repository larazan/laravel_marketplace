@extends('backend.layout')

@section('content')
<section class="content-main">
    <div class="row">
        <div class="col-9">
            <div class="content-header">
                <h2 class="content-title">Add New Image Product</h2>

            </div>
        </div>
        @include('backend.partials.flash', ['$errors' => $errors])
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>Media</h4>
                </div>
                {!! Form::open(['url' => ['user/products/images', $product->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
                <div class="card-body">
                    <div class="input-upload mb-3">
                    <img class="img-preview img-fluid col-sm-5 mb-3" id="img-preview" style="display: block;">
                        {!! Form::file('image', ['class' => 'form-control', 'placeholder' => 'product image', 'id' => 'image', 'onchange' => 'previewImage();']) !!}
                    </div>

                    <button class="btn btn-primary" type="submit">Save</button>
                    <a href="{{ url('user/products/'.$productID.'/images') }}" class="btn btn-secondary btn-default">Back</a>
                </div>

                
                
                {!! Form::close() !!}
            </div>
            <!-- card end// -->

            <!-- card end// -->
        </div>
    </div>
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