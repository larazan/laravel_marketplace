@extends('backend.layout')

@section('content')

<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Konfirmasi Pembayaran</h2>
            <p>for Order ID: #{{ $order->code }}</p>
        </div>
    </div>

    <div class="card">
        <div class="col-lg-6">
            @include('backend.partials.flash', ['$errors' => $errors])
            {!! Form::model($order, ['url' => ['user/orderout/confim_paid', $order->id], 'method' => 'POST',  'enctype' => 'multipart/form-data']) !!}
           
            {!! Form::hidden('id') !!}
            
                <div class="card-body">
                    <div class="row gx-3">
                   
                        <div class="col-6 mb-3">
                            {!! Form::label('nominal', 'Nominal') !!}
                            {!! Form::text('nominal', \General::priceFormat($order->grand_total), ['class' => 'form-control', 'readonly' => true]) !!}
                        </div>

                        <div class="col-6 mb-3">
                            {!! Form::label('bank', 'Bank') !!}
                            {!! Form::select('bank', $banks , null, ['class' => 'form-select', 'placeholder' => '-- Pilih Bank --']) !!}
                        </div>

                        <div class="col-6 mb-3">
                            {!! Form::label('rekening', 'Nomer Rekening') !!}
                            {!! Form::text('rekening', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-6 mb-3">
                            {!! Form::label('atasnama', 'atasnama') !!}
                            {!! Form::text('atasnama', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="mb-4">
                            {!! Form::label('file', 'Gambar') !!}
                            <img class="img-preview img-fluid col-sm-5 mb-3" id="img-preview" style="display: block;">
                                    {!! Form::file('image', ['class' => 'form-control', 'placeholder' => 'post image', 'id' => 'image', 'onchange' => 'previewImage();']) !!}
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit">Submit</button>
                    <a href="{{ url('user/orderout/detail/'. $order->id) }}" class="btn btn-secondary btn-default">Kembali</a>
                </div>
                {!! Form::close() !!}
        </div>
    </div>

    <div class="card">

        <header class="card-header">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 mb-lg-0">
                    <h4 class="text-muted">Order Detail</h4>
                </div>
            </div>
        </header>
        <div class="card-body">
            <div class="row mb-50 mt-20 order-info-wrap">
                <div class="col-md-6">
                    <article class="icontext align-items-start">
                        <span class="icon icon-sm rounded-circle bg-primary-light">
                            <i class="text-primary material-icons md-person"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1">Billing Address</h6>
                            <p class="mb-1">
                                {{ $order->customer_first_name }} {{ $order->customer_last_name }} <br />
                                Email: {{ $order->customer_email }} <br />
                                Phone: {{ $order->customer_phone }} <br />
                                Alamat: {{ $order->customer_address1 }} <br />
                                Postcode: {{ $order->customer_postcode }}
                            </p>
                        </div>
                    </article>
                </div>

                <div class="col-md-6">
                    <article class="icontext align-items-start">
                        <span class="icon icon-sm rounded-circle bg-primary-light">
                            <i class="text-primary material-icons md-place"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1">Details</h6>
                            <address>
                                #{{ $order->code }}
                                <br> {{ \General::datetimeFormat($order->order_date) }}
                                <br> Status: {{ $order->status }}

                                <br> Payment Status: {{ $order->payment_status }}
                                <br> Shipped by: {{ $order->shipping_service_name }}
                            </address>
                        </div>
                    </article>
                </div>

            </div>


            <div class="col-lg-7">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Unit Cost</th>
                                <th class="text-end2">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($order->orderItems as $item)
                            <tr>
                                <td>{{ $item->sku }}</td>
                                <td>{{ $item->name }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>{{ \General::priceFormat($item->base_price) }}</td>
                                <td>{{ \General::priceFormat($item->sub_total) }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5">Order item not found!</td>
                            </tr>
                            @endforelse

                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3"></td>
                                <td>
                                    <h6 class="">Subtotal</h6>
                                </td>
                                <td>
                                    <h6 class="">{{ \General::priceFormat($order->base_total_price) }}</h6>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td>
                                    <h6>Pajak</h6>
                                </td>
                                <td>
                                    <h6>{{ \General::priceFormat($order->tax_amount) }}</h6>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td>
                                    <h6>Ongkos Kirim</h6>
                                </td>
                                <td>
                                    <h6>{{ \General::priceFormat($order->shipping_cost) }}</h6>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td>
                                    <h6>Total</h6>
                                </td>
                                <td>
                                    <h6>{{ \General::priceFormat($order->grand_total) }}</h6>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
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