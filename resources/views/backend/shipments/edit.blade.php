@extends('backend.layout')

@section('content')

<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Order Shipment</h2>
            <p>for Order ID: #{{ $shipment->order->code }}</p>
        </div>
    </div>

    <div class="card">
        <div class="col-lg-6">
            @include('backend.partials.flash', ['$errors' => $errors])
            {!! Form::model($shipment, ['url' => ['user/shipments', $shipment->id], 'method' => 'PUT']) !!}
            {!! Form::hidden('id') !!}
            
                <div class="card-body">
                    <div class="row gx-3">
                        <div class="col-6 mb-3">
                            {!! Form::label('first_name', 'First name') !!}
                            {!! Form::text('first_name', null, ['class' => 'form-control', 'readonly' => true]) !!}
                        </div>
                        <div class="col-6 mb-3">
                            {!! Form::label('last_name', 'Last name') !!}
                            {!! Form::text('last_name', null, ['class' => 'form-control', 'readonly' => true]) !!}
                        </div>

                        <div class="mb-4">
                            {!! Form::label('address1', 'Home number and street name') !!}
                            {!! Form::text('address1', null, ['class' => 'form-control', 'readonly' => true]) !!}
                        </div>

                        <div class="mb-4">
                            {!! Form::label('address2', 'Apartment, suite, unit etc. (optional)') !!}
                            {!! Form::text('address2', null, ['class' => 'form-control', 'readonly' => true]) !!}
                        </div>

                        <div class="col-6 mb-3">
                            {!! Form::label('province_id', 'Province') !!}
                            {!! Form::select('province_id', $provinces, $shipment->province_id, ['id' => 'province-id', 'class' => 'form-control', 'disabled' => true]) !!}
                        </div>

                        <div class="col-6 mb-3">
                            {!! Form::label('city_id', 'City') !!}
                            {!! Form::select('city_id', $cities, $shipment->city_id, ['id' => 'city-id', 'class' => 'form-control', 'disabled' => true])!!}
                        </div>

                        <div class="col-4 mb-3">
                            {!! Form::label('postcode', 'Postcode / zip') !!}
                            {!! Form::text('postcode', null, ['class' => 'form-control', 'readonly' => true]) !!}
                        </div>
                        <div class="col-4 mb-3">
                            {!! Form::label('phone', 'Phone') !!}
                            {!! Form::text('phone', null, ['class' => 'form-control', 'readonly' => true]) !!}
                        </div>

                        <div class="col-4 mb-3">
                            {!! Form::label('email', 'Email') !!}
                            {!! Form::text('email', null, ['class' => 'form-control', 'readonly' => true]) !!}
                        </div>

                        <div class="col-6 mb-3">
                            {!! Form::label('total_qty', 'Quantity') !!}
                            {!! Form::text('total_qty', null, ['class' => 'form-control', 'readonly' => true]) !!}
                        </div>

                        <div class="col-6 mb-3">
                            {!! Form::label('total_weight', 'Total Weight (gram)') !!}
                            {!! Form::text('total_weight', null, ['class' => 'form-control', 'readonly' => true]) !!}
                        </div>

                        <div class="mb-4">
                        <label for="track_number" class="required">Track Number <span>*</span></label>
                            {!! Form::text('track_number', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>

                    <button class="btn btn-primary" type="submit">Submit</button>
                    <a href="{{ url('user/orders/detail/'. $shipment->order->id) }}" class="btn btn-secondary btn-default">Kembali</a>
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
                                {{ $shipment->order->customer_first_name }} {{ $shipment->order->customer_last_name }} <br />
                                Email: {{ $shipment->order->customer_email }} <br />
                                Phone: {{ $shipment->order->customer_phone }} <br />
                                Alamat: {{ $shipment->order->customer_address1 }} <br />
                                Postcode: {{ $shipment->order->customer_postcode }}
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
                                #{{ $shipment->order->code }}
                                <br> {{ \General::datetimeFormat($shipment->order->order_date) }}
                                <br> Status: {{ $shipment->order->status }}

                                <br> Payment Status: {{ $shipment->order->payment_status }}
                                <br> Shipped by: {{ $shipment->order->shipping_service_name }}
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
                            @forelse ($shipment->order->orderItems as $item)
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
                                    <h6 class="">{{ \General::priceFormat($shipment->order->base_total_price) }}</h6>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td>
                                    <h6>Pajak</h6>
                                </td>
                                <td>
                                    <h6>{{ \General::priceFormat($shipment->order->tax_amount) }}</h6>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td>
                                    <h6>Ongkos Kirim</h6>
                                </td>
                                <td>
                                    <h6>{{ \General::priceFormat($shipment->order->shipping_cost) }}</h6>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="3"></td>
                                <td>
                                    <h6>Total</h6>
                                </td>
                                <td>
                                    <h6>{{ \General::priceFormat($shipment->order->grand_total) }}</h6>
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

@section('style')
<style>
.required span{
    color: red;
    text-transform: italic;
}
</style>
@endsection