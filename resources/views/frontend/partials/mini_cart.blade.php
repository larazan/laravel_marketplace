<div class="cart-dropdown-wrap cart-dropdown-hm2">
    @if (!\Cart::isEmpty())
    <ul>
        @foreach (\Cart::getContent() as $item)
        @php
        $product = isset($item->associatedModel->parent) ? $item->associatedModel->parent : $item->associatedModel;
        $image = !empty($product->productImages->first()) ? asset('storage/'.$product->productImages->first()->path) : asset('themes/ezone/assets/img/cart/3.jpg')
        @endphp
        <li>
            <div class="shopping-cart-img">
                <a href="{{ url('product/'. $product->slug) }}"><img alt="{{ $product->name }}" src="{{ $image }}" /></a>
            </div>
            <div class="shopping-cart-title">
                <h4><a href="{{ url('product/'. $product->slug) }}">{{ $item->name }}</a></h4>
                <h4><span>{{ $item->quantity }} × </span>{{ number_format($item->price) }}</h4>
            </div>
            <div class="shopping-cart-delete">
                <a href="#"><i class="fi-rs-cross-small"></i></a>
            </div>
        </li>
        @endforeach

    </ul>
    <div class="shopping-cart-footer">
        <div class="shopping-cart-total">
            <h4>Total <span>{{ number_format(\Cart::getSubTotal()) }}</span></h4>
        </div>
        <div class="shopping-cart-button">
            <a href="{{ url('carts') }}" class="outline">View cart</a>
            <a href="{{ url('orders/checkout') }}">Checkout</a>
        </div>
    </div>
    @endif
</div>