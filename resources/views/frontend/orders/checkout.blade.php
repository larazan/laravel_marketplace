@extends('frontend.orders.base')

@section('content')

<!-- <link rel="stylesheet" href="https://nest.botble.com/vendor/core/plugins/payment/css/payment.css?v=1.0.6">
<script src="https://nest.botble.com/vendor/core/plugins/payment/js/payment.js?v=1.0.6" type="2354b4d8179df5447e9cee2f-text/javascript"></script> -->

@include('admin.partials.flash', ['$errors' => $errors])
{!! Form::model($user, ['url' => 'orders/checkout', 'class' => 'checkout-form payment-checkout-form', 'id' => 'checkout-form']) !!}

    <div class="container" id="main-checkout-product-info">
        <div class="row">
            <div class="order-1 order-md-2 col-lg-5 col-md-6 right">
                <div class="d-block d-sm-none">
                    <div class="checkout-logo">
                        <div class="container">
                            <a href="https://nest.botble.com" title="Nest - Laravel Multipurpose eCommerce Script">
                                <img src="https://nest.botble.com/storage/general/logo.png" class="img-fluid" width="150" alt="Nest - Laravel Multipurpose eCommerce Script" />
                            </a>
                        </div>
                    </div>
                    <hr>
                </div>
                <div id="cart-item" class="position-relative">
                    <div class="payment-info-loading" style="display: none;">
                        <div class="payment-info-loading-content">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </div>
                    <div class="bg-light p-2">
                        <p class="font-weight-bold mb-0">Informasi Belanja :</p>
                    </div>
                    <div class="checkout-products-marketplace" id="shipping-method-wrapper">
                        <div class="mt-3 bg-light mb-3">
                            <div class="p-2" style="background: antiquewhite;">
                                <img src="https://nest.botble.com/storage/stores/3.png" alt="Young Shop" class="img-fluid rounded" width="30">
                                <span class="font-weight-bold">{{ $orders[0]->nama_toko }}</span>
                                <div class="rating_wrap">
                                    <div class="rating">
                                        <div class="product_rate" style="width: 80%"></div>
                                    </div>
                                </div>
                            </div>
                            @php
                                $subtotal = 0;
                                $total_per_produ = 0;
                                $ongkir = 0;
                                $pajak = 0;
                            @endphp
                            @foreach ($orders as $item)
                            @php
                                $total_per_produk = $item->price * $item->qty;
                            @endphp
                            
                            <div class="p-3">
                                <div class="row cart-item">
                                    <div class="col-3">
                                        <div class="checkout-product-img-wrapper">
                                            <img class="item-thumb img-thumbnail img-rounded" src="{{ url('/storage/'.$item->gambar) }}" alt="All Natural Italian-Style Chicken Meatballs">
                                            <span class="checkout-quantity">{{ $item->qty }}</span>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <p class="mb-0">{{ $item->name }}</p>
                                        <p class="mb-0">
                                            <small>(Boxes: 1 Box, Weight: 4KG)</small>
                                        </p>
                                    </div>
                                    <div class="col-4 text-end">
                                        <p>{{ \General::priceFormat($total_per_produk, 'Rp') }}</p>
                                    </div>
                                </div>
                            </div>
                            @php
                            $subtotal += $total_per_produk;
                            @endphp
                            @endforeach
                            <hr>
                            <div class="p-3">
                                <div class="row">
                                    <div class="col-6">
                                        <p>Subtotal:</p>
                                    </div>
                                    <div class="col-6 text-end">
                                        <p class="price-text sub-total-text text-end"> {{ \General::priceFormat($subtotal, 'Rp') }} </p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <p>Ongkos Kirim ({{ $totalWeight }} kg):</p>
                                        <p class="price-text">
                                            <select id="shipping-cost-option" class="form-control" required name="shipping_service"></select>
                                        </p>
                                    </div>
                                    <!-- <div class="col-12 text-end">
                                        
                                    </div> -->
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p>Pajak:</p>
                                    </div>
                                    <div class="col-6 text-end">
                                        <p class="price-text tax-price-text">{{ \General::priceFormat($tax, 'Rp') }}</p>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <p>Total:</p>
                                    </div>
                                    <div class="col-6 float-end">
                                        <p class="total-text raw-total-text mb-0 total-amount" data-price=""> {{ \General::priceFormat(Keranjang::getTotalChecked(), 'Rp') }} </p>
                                    </div>
                                </div>
                            </div>
                            <div class="shipping-method-wrapper p-3">
                                <div class="payment-checkout-form">
                                    <div class="mx-0">
                                        <h6>Shipping method:</h6>
                                    </div>
                                    <input type="hidden" name="shipping_option[3]" value="1">
                                    <div id="shipping-method-3">
                                        <ul class="list-group list_payment_method">
                                            <li class="list-group-item">
                                                <input class="magic-radio shipping_method_input" type="radio" name="shipping_method[3]" id="shipping-method-3-default-1" checked value="default" data-option="1" data-id="3">
                                                <label for="shipping-method-3-default-1"> Free shipping - <strong>Free shipping</strong>
                                                </label>
                                            </li>
                                            <li class="list-group-item">
                                                <input class="magic-radio shipping_method_input" type="radio" name="shipping_method[3]" id="shipping-method-3-default-2" value="default" data-option="2" data-id="3">
                                                <label for="shipping-method-3-default-2"> Local Pickup - $20.00 </label>
                                            </li>
                                            <li class="list-group-item">
                                                <input class="magic-radio shipping_method_input" type="radio" name="shipping_method[3]" id="shipping-method-3-default-3" value="default" data-option="3" data-id="3">
                                                <label for="shipping-method-3-default-3"> Flat Rate - $25.00 </label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="mt-3 mb-5">
                    <div class="checkout-discount-section">
                        <a href="#" class="btn-open-coupon-form">Kamu memiliki kupon diskon ?</a>
                    </div>
                    <div class="coupon-wrapper" style="display: none;">
                        <div class="row promo coupon coupon-section">
                            <div class="col-lg-8 col-md-8 col-8">
                                <input type="text" name="coupon_code" class="form-control coupon-code input-md checkout-input" value="" placeholder="Enter coupon code...">
                                <div class="coupon-error-msg">
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-4 text-end">
                                <button class="btn btn-md btn-gray btn-info apply-coupon-code float-end" data-url="https://nest.botble.com/coupon/apply" type="button" style="margin-top: 0;padding: 10px 20px;">
																																									
                                    <i class="fa fa-gift"></i> Apply </button>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <div class="col-lg-7 col-md-6 left">
                <div class="d-none d-sm-block">
                    <div class="checkout-logo">
                        <div class="container">
                            <a href="https://nest.botble.com" title="Nest - Laravel Multipurpose eCommerce Script">
                                <img src="{{ asset('frontend/assets/imgs/sorgumku.svg') }}" class="img-fluid" width="200" alt="Sorgumku" />
                            </a>
                        </div>
                    </div>
                    <hr>
                </div>
                <div class="form-checkout">
                   
                        <div>
                            <h5 class="checkout-payment-title">Informasi Pengiriman</h5>
                            <input type="hidden" value="https://nest.botble.com/checkout/e6bdba4290b7429a533e2016a234d8f6/information" id="save-shipping-information-url">
                            <div class="customer-address-payment-form">
                                
                                <div class="address-form-wrapper">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group  ">
                                                {!! Form::text('first_name', null, ['required' => true, 'class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group  ">
                                                {!! Form::text('last_name', null, ['required' => true, 'class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="row">
                                        <div class="col-lg-8 col-12">
                                            <div class="form-group  ">
                                                {!! Form::text('email', null, ['placeholder' => 'Email', 'readonly' => true, 'class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-12">
                                            <div class="form-group  ">
                                                {!! Form::text('phone', null, ['required' => true, 'placeholder' => 'Phone', 'class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group mb-3 ">
                                            {!! Form::select('province_id', $provinces, Auth::user()->province_id, ['id' => 'province-id', 'placeholder' => '- Please Select - ', 'required' => true, 'class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group  ">
                                            {{ Form::hidden('city_origin', $item->city_id, ['id' => 'city-origin']) }}
									        {!! Form::select('city_id', $cities, null, ['id' => 'city-id', 'placeholder' => '- Please Select -', 'required' => true, 'class' => 'form-control'])!!}
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-3 ">
                                            {!! Form::text('address1', null, ['required' => true, 'placeholder' => 'Home number and street name', 'class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-3 ">
                                            {!! Form::number('postcode', null, ['required' => true, 'placeholder' => 'Postcode', 'class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-3">
                                            <input id="ship-box" type="checkbox" name="ship_to"/>
                                            <label for="create_account" class="control-label" style="padding-left: 5px">Ship to a different address?</label>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                        <br>
                        <div id="ship-box-info">
                            <div class="customer-address-payment-form">
                                
                                <div class="address-form-wrapper">
                                    <div class="row">
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group  ">
                                            {!! Form::text('shipping_first_name', null, ['class' => 'form-control', 'placeholder' => 'Firstname']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-6 col-12">
                                            <div class="form-group  ">
                                            {!! Form::text('shipping_last_name', null, ['class' => 'form-control', 'placeholder' => 'Lastname']) !!}
                                            </div>
                                        </div>
                                    </div>
                                   
                                    <div class="row">
                                        <div class="col-lg-8 col-12">
                                            <div class="form-group  ">
                                            {!! Form::text('shipping_email', null, ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-12">
                                            <div class="form-group  ">
                                            {!! Form::text('shipping_phone', null, ['placeholder' => 'Phone', 'class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group mb-3 ">
                                            {!! Form::select('shipping_province_id', $provinces, null, ['id' => 'shipping-province', 'placeholder' => '- Please Select - ', 'class' => 'form-control' ]) !!}
                                            </div>
                                        </div>
                                        <div class="col-sm-6 col-12">
                                            <div class="form-group  ">
									        {!! Form::select('shipping_city_id', [], null, ['id' => 'shipping-city','placeholder' => '- Please Select -', 'class' => 'form-control'])!!}
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-3 ">
                                            {!! Form::text('shipping_address1', null, ['placeholder' => 'Home number and street name', 'class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group mb-3 ">
                                            {!! Form::number('shipping_postcode', null, ['placeholder' => 'Postcode', 'class' => 'form-control']) !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                    
                            </div>
                        </div>
                        <!-- <div class="position-relative">
                            <div class="payment-info-loading" style="display: none;">
                                <div class="payment-info-loading-content">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </div>
                            </div>
                            <h5 class="checkout-payment-title">Payment method</h5>
                            <input type="hidden" name="amount" value="341.044">
                            <input type="hidden" name="currency" value="USD">
                            <input type="hidden" name="callback_url" value="https://nest.botble.com/payment/status">
                            <input type="hidden" name="return_url" value="https://nest.botble.com/checkout/e6bdba4290b7429a533e2016a234d8f6/success">
                            <ul class="list-group list_payment_method">
                                <li class="list-group-item">
                                    <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_stripe" value="stripe" checked data-bs-toggle="collapse" data-bs-target=".payment_stripe_wrap" data-parent=".list_payment_method">
                                    <label for="payment_stripe" class="text-start"> Pay online via Stripe </label>
                                    <div class="payment_stripe_wrap payment_collapse_wrap collapse  show ">
                                        <div class="card-checkout" style="max-width: 350px">
                                            <div class="form-group mt-3 mb-3">
                                                <div class="stripe-card-wrapper"></div>
                                            </div>
                                            <div class="form-group mb-3 ">
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <input placeholder="Card number" class="form-control" type="text" id="stripe-number" data-stripe="number" autocomplete="off">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input placeholder="MM/YY" class="form-control" type="text" id="stripe-exp" data-stripe="exp" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group mb-3 ">
                                                <div class="row">
                                                    <div class="col-sm-8">
                                                        <input placeholder="Full name" class="form-control" id="stripe-name" type="text" data-stripe="name" autocomplete="off">
                                                    </div>
                                                    <div class="col-sm-4">
                                                        <input placeholder="CVC" class="form-control" type="text" id="stripe-cvc" data-stripe="cvc" autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="payment-stripe-key" data-value="pk_test_7XJekDehXaxssmHNfkQMG4aG"></div>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_paypal" value="paypal" data-bs-toggle="collapse" data-bs-target=".payment_paypal_wrap" data-parent=".list_payment_method">
                                    <label for="payment_paypal" class="text-start">Pay online via PayPal</label>
                                    <div class="payment_paypal_wrap payment_collapse_wrap collapse " style="padding: 15px 0;"> Payment with PayPal </div>
                                </li>
                                <li class="list-group-item">
                                    <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_razorpay" value="razorpay" data-bs-toggle="collapse" data-bs-target=".payment_razorpay_wrap" data-parent=".list_payment_method">
                                    <label for="payment_razorpay">Online payment via Razorpay</label>
                                    <div class="payment_razorpay_wrap payment_collapse_wrap collapse ">
                                        <p>Payment with Razorpay</p>
                                    </div>
                                    <input type="hidden" id="rzp_order_id" value="order_Jc4ZK13qBGilH0">
                                </li>

                                <li class="list-group-item">
                                    <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_paystack" value="paystack" data-bs-toggle="collapse" data-bs-target=".payment_paystack_wrap" data-parent=".list_payment_method">
                                    <label for="payment_paystack">Online payment via Paystack</label>
                                    <div class="payment_paystack_wrap payment_collapse_wrap collapse ">
                                        <p>Payment with Paystack</p>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_mollie" value="mollie" data-bs-toggle="collapse" data-bs-target=".payment_mollie_wrap" data-parent=".list_payment_method">
                                    <label for="payment_mollie">Online payment via Mollie</label>
                                    <div class="payment_mollie_wrap payment_collapse_wrap collapse ">
                                        <p>Payment with Mollie</p>
                                    </div>
                                </li>
                                <li class="list-group-item">
                                    <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_cod" value="cod" data-bs-toggle="collapse" data-bs-target=".payment_cod_wrap" data-parent=".list_payment_method">
                                    <label for="payment_cod" class="text-start">Cash on delivery (COD)</label>
                                    <div class="payment_cod_wrap payment_collapse_wrap collapse " style="padding: 15px 0;"> Please pay money directly to the postman, if you choose cash on delivery method (COD). </div>
                                </li>
                                <li class="list-group-item">
                                    <input class="magic-radio js_payment_method" type="radio" name="payment_method" id="payment_bank_transfer" value="bank_transfer" data-bs-toggle="collapse" data-bs-target=".payment_bank_transfer_wrap" data-parent=".list_payment_method">
                                    <label for="payment_bank_transfer" class="text-start">Bank transfer</label>
                                    <div class="payment_bank_transfer_wrap payment_collapse_wrap collapse " style="padding: 15px 0;"> Please send money to our bank account: ACB - 1990 404 19. </div>
                                </li>
                            </ul>
                        </div> -->
                        <br>
                        <div class="form-group mb-3 ">
                            <label for="description" class="control-label">Catatan Pesanan</label>
                            <br>
                            {!! Form::textarea('note', null, ['class' => 'form-control', 'cols' => 30, 'rows' => 5,'placeholder' => 'Notes about your order, e.g. special notes for delivery.']) !!}
                        </div>
                        <div class="form-group mb-3">
                            <div class="row">
                                <div class="col-md-6 d-none d-md-block" style="line-height: 53px">
                                    <a class="text-info" href="{{ url('carts') }}">
                                        <i class="fas fa-long-arrow-alt-left"></i>
                                        <span class="d-inline-block back-to-cart">Kembali ke keranjang</span>
                                    </a>
                                </div>
                                <div class="col-md-6 checkout-button-group">
                                    <button type="submit" class="btn payment-checkout-btn payment-checkout-btn-step float-end" data-processing-text="Processing. Please wait..." data-error-header="Error"> Checkout </button>
                                </div>
                            </div>
                            <div class="d-block d-md-none back-to-cart-button-group">
                                <a class="text-info" href="{{ url('carts') }}">
                                    <i class="fas fa-long-arrow-alt-left"></i>
                                    <span class="d-inline-block">Kembali ke keranjang</span>
                                </a>
                            </div>
                        </div>
                        
                </div>
            </div>
        </div>
    </div>
   
    {!! Form::close() !!}

    @endsection

    @push('style')
        <style>
            #ship-box-info {
              display: none;
            }
        </style>
    @endpush

    @push('scripts')
            <script>
                $('#ship-box').on('click', function() {
                    $('#ship-box-info').slideToggle(1000);
                });
            </script>
    @endpush