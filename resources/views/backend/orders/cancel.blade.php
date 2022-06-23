@extends('backend.layout')

@section('content')

<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Cancel Order</h2>
            <p>Details for Order ID: #{{ $order->code }}</p>
        </div>
    </div>

    <div class="card">
        <header class="card-header">
            <div class="row align-items-center">
                <div class="mb-lg-0">
                    <h4 class="text-muted">Cancel Order ID: #{{ $order->code }}</h4>
                </div>

            </div>
        </header>
        <div class="col-lg-6">
            @include('admin.partials.flash', ['$errors' => $errors])
            {!! Form::model($order, ['url' => ['user/orders/cancel', $order->id], 'method' => 'PUT']) !!}
            {!! Form::hidden('id') !!}

            <div class="card-body">
                <div class="row gx-3">
                    <div class="mb-4">
                        {!! Form::label('cancellation_note', 'Cancellation Note') !!}
                        {!! Form::textarea('cancellation_note', null, ['class' => 'form-control']) !!}
                    </div>
                </div>

                <button class="btn btn-primary" type="submit">Cancel the Order</button>
                <a href="{{ url('user/orders') }}" class="btn btn-secondary btn-default">Kembali</a>
            </div>
            {!! Form::close() !!}
        </div>
    </div>

    <div class="card">
        <header class="card-header">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 mb-lg-0">
                    <h4 class="text-muted">Detail Order</h4>
                </div>

            </div>
        </header>
        <!-- card-header end// -->
        <div class="card-body">
            <div class="row mb-50 mt-20 order-info-wrap">
                @if ($order->shipment)
                <div class="col-md-6">
                    <article class="icontext align-items-start">
                        <span class="icon icon-sm rounded-circle bg-primary-light">
                            <i class="text-primary material-icons md-local_shipping"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1">Billing Address</h6>
                            <address>
                                {{ $order->shipment->first_name }} {{ $order->shipment->last_name }}
                                <br> {{ $order->shipment->address1 }}
                                <br> {{ $order->shipment->address2 }}
                                <br> Email: {{ $order->shipment->email }}
                                <br> Phone: {{ $order->shipment->phone }}
                                <br> Postcode: {{ $order->shipment->postcode }}
                            </address>
                        </div>
                    </article>
                </div>
                @endif
                <!-- col// -->
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
                                <br> Status: {{ $order->status }} {{ $order->isCancelled() ? '('. \General::datetimeFormat($order->cancelled_at) .')' : null}}
                                @if ($order->isCancelled())
                                <br> Cancellation Note : {{ $order->cancellation_note}}
                                @endif
                                <br> Payment Status: {{ $order->payment_status }}
                                <br> Shipped by: {{ $order->shipping_service_name }}
                            </address>
                        </div>
                    </article>
                </div>
                <!-- col// -->
            </div>
            <!-- row // -->
            <div class="row">
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
        <!-- card-body end// -->
    </div>
    <!-- card end// -->
</section>

@endsection