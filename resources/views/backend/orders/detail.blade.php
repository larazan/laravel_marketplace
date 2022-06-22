@extends('backend.layout')

@section('content')

<section class="content-main">
    <div class="content-header">
        <div>
            <h2 class="content-title card-title">Order detail</h2>
            <p>Details for Order ID: #{{ $order->code }}</p>
        </div>
    </div>
    <div class="card">
        <header class="card-header">
            <div class="row align-items-center">
                <div class="col-lg-6 col-md-6 mb-lg-0 mb-15">
                    <span> <i class="material-icons md-calendar_today"></i> <b>Wed, Aug 13, 2020, 4:34PM</b> </span> <br />
                    <small class="text-muted">Order ID: #{{ $order->code }}</small>
                </div>
                <div class="col-lg-6 col-md-6 ms-auto text-md-end">
                    <select class="form-select d-inline-block mb-lg-0 mr-5 mw-200">
                        <option>Change status</option>
                        <option>Awaiting payment</option>
                        <option>Confirmed</option>
                        <option>Shipped</option>
                        <option>Delivered</option>
                    </select>
                    <a class="btn btn-primary" href="#">Save</a>
                    <a class="btn btn-secondary print ms-2" href="#"><i class="icon material-icons md-print"></i></a>
                </div>
            </div>
        </header>
        <!-- card-header end// -->
        <div class="card-body">
            <div class="row mb-50 mt-20 order-info-wrap">
                <div class="col-md-4">
                    <article class="icontext align-items-start">
                        <span class="icon icon-sm rounded-circle bg-primary-light">
                            <i class="text-primary material-icons md-person"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1">Customer</h6>
                            <p class="mb-1">
                                {{ $order->customer_first_name }} {{ $order->customer_last_name }} <br />
                                Email: {{ $order->customer_email }} <br />
                                Phone: {{ $order->customer_phone }} <br />
                                Postcode: {{ $order->customer_postcode }}
                            </p>
                        </div>
                    </article>
                </div>
                <!-- col// -->
                @if ($order->shipment)
                <div class="col-md-4">
                    <article class="icontext align-items-start">
                        <span class="icon icon-sm rounded-circle bg-primary-light">
                            <i class="text-primary material-icons md-local_shipping"></i>
                        </span>
                        <div class="text">
                            <h6 class="mb-1">Shipment Address</h6>
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
                <div class="col-md-4">
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
                                    <th>Description</th>
                                    <th>Quantity</th>
                                    <th>Unit Cost</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($order->orderItems as $item)
                                <tr>
                                    <td>{{ $item->sku }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{!! \General::showAttributes($item->attributes) !!}</td>
                                    <td>{{ $item->qty }}</td>
                                    <td>{{ \General::priceFormat($item->base_price) }}</td>
                                    <td>{{ \General::priceFormat($item->sub_total) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6">Order item not found!</td>
                                </tr>
                                @endforelse

                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4"></td>
                                    <td>
                                        <h6 class="">Subtotal</h6>
                                    </td>
                                    <td>
                                        <h6 class="">{{ \General::priceFormat($order->base_total_price) }}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"></td>
                                    <td>
                                        <h6>Pajak</h6>
                                    </td>
                                    <td>
                                        <h6>{{ \General::priceFormat($order->tax_amount) }}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"></td>
                                    <td>
                                        <h6>Ongkos Kirim</h6>
                                    </td>
                                    <td>
                                        <h6>{{ \General::priceFormat($order->shipping_cost) }}</h6>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="4"></td>
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

                    <!-- table-responsive// -->
                    <div class="row ">
                        <div class="col-lg-5 col-xl-4 col-xl-3 ml-sm-auto">

                            @if (!$order->trashed())
                            @if ($order->isPaid() && $order->isConfirmed())
                            <a href="{{ url('user/shipments/'. $order->shipment->id .'/edit')}}" class="btn btn-block mt-2 btn-lg btn-primary btn-pill"> Procced to Shipment</a>
                            @endif

                            @if (in_array($order->status, [\App\Models\Order::CREATED, \App\Models\Order::CONFIRMED]))
                            <a href="{{ url('user/orders/'. $order->id .'/cancel')}}" class="btn btn-block mt-2 btn-lg btn-secondary btn-pill delete"> Cancel</a>
                            @endif

                            @if ($order->isDelivered())
                            <a href="#" class="btn btn-block mt-2 btn-lg btn-primary btn-pill" onclick="event.preventDefault();
						document.getElementById('complete-form-{{ $order->id }}').submit();"> Mark as Completed</a>

                            {!! Form::open(['url' => 'user/orders/complete/'. $order->id, 'id' => 'complete-form-'. $order->id, 'style' => 'display:none']) !!}
                            {!! Form::close() !!}
                            @endif

                            @if (!in_array($order->status, [\App\Models\Order::DELIVERED, \App\Models\Order::COMPLETED]))
                            <a href="#" class="btn btn-block mt-2 btn-lg btn-secondary btn-pill delete" order-id="{{ $order->id }}"> Remove</a>

                            {!! Form::open(['url' => 'user/orders/'. $order->id, 'class' => 'delete', 'id' => 'delete-form-'. $order->id, 'style' => 'display:none']) !!}
                            {!! Form::hidden('_method', 'DELETE') !!}
                            {!! Form::close() !!}
                            @endif
                            @else
                            <a href="{{ url('user/orders/restore/'. $order->id)}}" class="btn btn-block mt-2 btn-lg btn-primary btn-pill restore"> Restore</a>
                            <a href="#" class="btn btn-block mt-2 btn-lg btn-secondary btn-pill delete" order-id="{{ $order->id }}"> Remove Permanently</a>

                            {!! Form::open(['url' => 'user/orders/'. $order->id, 'class' => 'delete', 'id' => 'delete-form-'. $order->id, 'style' => 'display:none']) !!}
                            {!! Form::hidden('_method', 'DELETE') !!}
                            {!! Form::close() !!}
                            @endif
                        </div>
                    </div>
                </div>
                <!-- col// -->
                <div class="col-lg-1"></div>
                <!-- <div class="col-lg-4">
                    <div class="box shadow-sm bg-light">
                        <h6 class="mb-15">Payment info</h6>
                        <p>
                            <img src="{{ URL::asset('dashboard/assets/imgs/card-brands/2.png') }}" class="border" height="20" /> Master Card **** **** 4768 <br />
                            Business name: Grand Market LLC <br />
                            Phone: +1 (800) 555-154-52
                        </p>
                    </div>
                    <div class="h-25 pt-4">
                        <div class="mb-3">
                            <label>Notes</label>
                            <textarea class="form-control" name="notes" id="notes" placeholder="Type some note"></textarea>
                        </div>
                        <button class="btn btn-primary">Save note</button>
                    </div>
                </div> -->
                <!-- col// -->
            </div>
        </div>
        <!-- card-body end// -->
    </div>
    <!-- card end// -->
</section>

@endsection