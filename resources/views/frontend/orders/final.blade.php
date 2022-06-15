@extends('frontend.orders.base')

@section('content')
                    
<div class="container">
    <div class="row">
        <div class="col-lg-7 col-md-6 col-12 left">
            <div class="checkout-logo">
                <div class="container">
                    <a href="https://nest.botble.com" title="Nest - Laravel Multipurpose eCommerce Script">
                        <img src="https://nest.botble.com/storage/general/logo.png" class="img-fluid" width="150" alt="Nest - Laravel Multipurpose eCommerce Script" />
                    </a>
                </div>
            </div>
            <hr />
            <div class="thank-you">
                <!-- <i class="fa fa-check-circle" aria-hidden="true"></i> -->
                <div class="d-inline-block">
                    <h3 class="thank-you-sentence">
                        Your order is successfully placed
                    </h3>
                    <p>Thank you for purchasing our products!</p>
                </div>
            </div>
            <div class="order-customer-info">
                <h3>Customer information</h3>
                <p>
                    <span class="d-inline-block">Nama Lengkap:</span>
                    <span class="order-customer-info-meta">{{ $order->customer_first_name }} {{ $order->customer_last_name }}</span>
                </p>
                <p>
                    <span class="d-inline-block">Telpon:</span>
                    <span class="order-customer-info-meta">{{ $order->customer_phone }}</span>
                </p>
                <p>
                    <span class="d-inline-block">Email:</span>
                    <span class="order-customer-info-meta">
                        <a href="/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="9ae8ffe8ffeedafdf7fbf3f6b4f9f5f7">
                            {{ $order->customer_email }}
                        </a>
                    </span>
                </p>
                <p>
                    <span class="d-inline-block">Alamat:</span>
                    <span class="order-customer-info-meta">{{ $order->customer_address1 }}</span>
                </p>
                <p>
                    <span class="d-inline-block">kodepos:</span>
                    <span class="order-customer-info-meta">{{ $order->customer_postcode }}</span>
                </p>
                <p>
                    <span class="d-inline-block">Ongkos kirim:</span>
                    <span class="order-customer-info-meta">{{ $order->shipping_service_name }} - $0.00</span>
                </p>
                <p>
                    <span class="d-inline-block">Metode pembayaran:</span>
                    <span class="order-customer-info-meta">Cash on delivery (COD)</span>
                </p>
                <p>
                    <span class="d-inline-block">Status Pembayaran:</span>
                    <span class="order-customer-info-meta" style="text-transform: uppercase;"><span class="label-warning status-label">{{ $order->payment_status }}</span></span>
                </p>
            </div>
            <a href="https://nest.botble.com" class="btn payment-checkout-btn"> Continue shopping </a>
        </div>

        <div class="col-lg-5 col-md-6 right">
            <div class="pt-3 mb-4">
                <div class="align-items-center">
                    <h6 class="d-inline-block">Order number: #{{ $order->code }}</h6>
                    <p>{{ \General::datetimeFormat($order->order_date) }}</p>
                </div>
                @forelse ($order->orderItems as $item)
                <div class="checkout-success-products">
                    <div class="row show-cart-row d-md-none p-2">
                        <div class="col-9">
                            <a class="show-cart-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#cart-item-52">
                                Order information #10000052 <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="col-3">
                            <p class="text-end mobile-total">$44.98</p>
                        </div>
                    </div>
                    <div id="cart-item-52" class="collapse collapse-products">
                        <div class="row cart-item">
                            <div class="col-lg-3 col-md-3">
                                <div class="checkout-product-img-wrapper">
                                    <img class="item-thumb img-thumbnail img-rounded" src="https://nest.botble.com/storage/products/4-150x150.jpg" alt="Foster Farms Takeout Crispy Classic(HS-150-A0)" />
                                    <span class="checkout-quantity">{{ $item->qty }}</span>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5">
                                <p class="mb-0">{{ $item->name }}</p>
                                <p class="mb-0">
                                    <small>(SKU: {{ $item->sku }}, Berat: 4KG)</small>
                                </p>
                            </div>
                            <div class="col-lg-4 col-md-4 col-4 float-end text-end">
                                <p>{{ \General::priceFormat($item->base_price) }}</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p>Subtotal:</p>
                            </div>
                            <div class="col-6 float-end">
                                <p class="price-text text-end">{{ \General::priceFormat($item->sub_total) }}</p>
                            </div>
                        </div>
                      
                    </div>
                </div>
                @empty
                <div>
                    <p>Order item not found!</p>
                </div>
                @endforelse

                <div class="checkout-success-products">
                    <div class="row show-cart-row d-md-none p-2">
                        <div class="col-9">
                            <a class="show-cart-link" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#cart-item-52">
                                Order information #10000052 <i class="fa fa-angle-down" aria-hidden="true"></i>
                            </a>
                        </div>
                        <div class="col-3">
                            <p class="text-end mobile-total">$44.98</p>
                        </div>
                    </div>
                    <div id="cart-item-52" class="collapse collapse-products">
                        <div class="row cart-item">
                            <div class="col-lg-3 col-md-3">
                                <div class="checkout-product-img-wrapper">
                                    <img class="item-thumb img-thumbnail img-rounded" src="https://nest.botble.com/storage/products/4-150x150.jpg" alt="Foster Farms Takeout Crispy Classic(HS-150-A0)" />
                                    <span class="checkout-quantity">2</span>
                                </div>
                            </div>
                            <div class="col-lg-5 col-md-5">
                                <p class="mb-0">Foster Farms Takeout Crispy Classic</p>
                                <p class="mb-0">
                                    <small>(Boxes: 3 Boxes, Weight: 4KG)</small>
                                </p>
                            </div>
                            <div class="col-lg-4 col-md-4 col-4 float-end text-end">
                                <p>$40.89</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <p>Subtotal:</p>
                            </div>
                            <div class="col-6 float-end">
                                <p class="price-text text-end">$40.89</p>
                            </div>
                        </div>
                      
                    </div>
                </div>
            </div>
            <hr />
          

            <div class="bg-light p-3">
                <div class="row total-price">
                    <div class="col-6" style="font-weight: 600;">
                        <p style="font-size: medium;">Sub amount:</p>
                    </div>
                    <div class="col-6">
                        <p class="text-end">{{ \General::priceFormat($order->base_total_price) }}</p>
                    </div>
                </div>
                <div class="row total-price">
                    <div class="col-6" style="font-weight: 600;">
                        <p style="font-size: medium;">Shipping fee:</p>
                    </div>
                    <div class="col-6">
                        <p class="text-end">{{ \General::priceFormat($order->shipping_cost) }}</p>
                    </div>
                </div>
                <div class="row total-price">
                    <div class="col-6" style="font-weight: 600;">
                        <p style="font-size: medium;">Tax:</p>
                    </div>
                    <div class="col-6">
                        <p class="text-end">{{ \General::priceFormat($order->tax_amount) }}</p>
                    </div>
                </div>
                <div class="row total-price">
                    <div class="col-6" style="font-weight: 600;">
                        <p style="font-size: larger;">Total amount:</p>
                    </div>
                    <div class="col-6">
                        <p class="total-text raw-total-text text-end">{{ \General::priceFormat($order->grand_total) }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                    
@endsection               