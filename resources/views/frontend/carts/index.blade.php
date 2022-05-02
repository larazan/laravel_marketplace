@extends('frontend.layout')

@section('content')
<main class="main" style="margin-left: 30px;margin-right: 30px; ">
        <div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                    <a href="{{ url('/') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                    <span></span> Cart
                </div>
            </div>
        </div>
        <div class="container mb-80 mt-50">
            <div class="row">
                <div class="col-lg-8 mb-40">
                    <h2 class="heading-4 mb-10"><img src="{{ asset('frontend/assets/imgs/shopping-cart.png') }}" width="50">&nbsp;Keranjang Anda</h2>
                    <!-- <div class="d-flex justify-content-between">
                        <h6 class="text-body">There are <span class="text-brand">3</span> products in your cart</h6>
                        <h6 class="text-body"><a href="#" class="text-muted"><i class="fi-rs-trash mr-5"></i>Clear Cart</a></h6>
                    </div> -->
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8">
                {!! Form::open(['url' => 'carts/update']) !!}
                    <div class="table-responsive shopping-summery">
                        <table class="table table-wishlist">
                            <thead>
                                <tr class="main-heading">
                                    <th class="custome-checkbox start pl-30">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox11" value="">
                                        <label class="form-check-label" for="exampleCheckbox11"></label>
                                    </th>
                                    <!-- <th class="">Gambar</th> -->
                                    <th scope="col" colspan="2">Product</th>
                                    <th scope="col">Unit Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Subtotal</th>
                                    <th scope="col" class="end">Remove</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($items as $item)
                                    @php
                                        $product = isset($item->associatedModel->parent) ? $item->associatedModel->parent : $item->associatedModel;
                                        $image = !empty($product->productImages->first()) ? asset('storage/'.$product->productImages->first()->path) : asset('themes/ezone/assets/img/cart/3.jpg')
                                    @endphp
                                <tr class="pt-30">
                                    <td class="custome-checkbox pl-30">
                                        <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value="">
                                        <label class="form-check-label" for="exampleCheckbox1"></label>
                                    </td>
                                    <!-- <td class="image product-thumbnail pt-40"><img src="assets/imgs/shop/product-1-1.jpg" alt="#"></td> -->
                                    <td class="image product-thumbnail pt-40">
                                        <img src="{{ $image }}" alt="{{ $product->name }}">
                                    </td>
                                    <td class="product-des product-name">
                                        <h6 class="mb-5">
                                            <a class="product-name mb-10 text-heading" href="{{ url('product/'. $product->slug) }}">{{ $item->name }}</a>
                                        </h6>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h4 class="text-body">{{ number_format($item->price) }} </h4>
                                    </td>
                                    <td class="text-center detail-info" data-title="Stock">
                                        <div class="detail-extralink mr-15">
                                            <!-- <div class="detail-qty border radius">
                                                <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                <span class="qty-val">1</span>
                                                <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                            </div> -->
                                            {!! Form::number('items['. $item->id .'][quantity]', $item->quantity, ['min' => 1, 'required' => true]) !!}
                                        </div>
                                    </td>
                                    <td class="price" data-title="Price">
                                        <h4 class="text-brand">{{ number_format($item->price * $item->quantity)}}</h4>
                                    </td>
                                    <td class="action text-center" data-title="Remove">
                                        <a href="{{ url('carts/remove/'. $item->id)}}" class="text-body"><i class="fi-rs-trash"></i></a>
                                    </td>
                                </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">The cart is empty!</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="divider-2 mb-30"></div>
                    <div class="cart-action d-flex justify-content-between">
                        <a href="{{ url('/') }}" class="btn "><i class="fi-rs-arrow-left mr-10"></i>Continue Shopping</a>
                        <a class="btn  mr-10 mb-sm-15" name="update_cart" onclick="refreshPage()"><i class="fi-rs-refresh mr-10"></i>Update Cart</a>
                    </div>
                    
                </div>
                <div class="col-lg-4">
                    <div class="border p-md-4 cart-totals ml-30">
                        <div class="table-responsive">
                            <table class="table no-border">
                                <tbody>
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Subtotal</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-brand text-end">{{ number_format(\Cart::getSubTotal()) }}</h4>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td scope="col" colspan="2">
                                            <div class="divider-2 mt-10 mb-10"></div>
                                        </td>
                                    </tr>
                                   
                                    <tr>
                                        <td class="cart_total_label">
                                            <h6 class="text-muted">Total</h6>
                                        </td>
                                        <td class="cart_total_amount">
                                            <h4 class="text-brand text-end">{{ number_format(\Cart::getTotal()) }}</h4>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <a href="{{ url('orders/checkout') }}" class="btn mb-20 w-100">Proceed To CheckOut<i class="fi-rs-sign-out ml-15"></i></a>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </main>
    @endsection

    @push('scripts')
    <script>
        function refreshPage()
        {
            window.location.reload(true)
        }
    </script>