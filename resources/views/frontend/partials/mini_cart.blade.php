<div class="cart-dropdown-wrap cart-dropdown-hm2">
    @if (!Keranjang::isEmpty())
    <ul>
        @foreach (Keranjang::getItems() as $item)
            
            <li>
                <div class="shopping-cart-img">
                    <a href="{{ url('product/'. $item->slug) }}">
                        <img alt="{{ $item->name }}" src="{{ url('/storage/'.$item->gambar) }}" />
                    </a>
                </div>
                <div class="shopping-cart-title">
                    <h4><a href="{{ url('product/'. $item->slug) }}">{{ $item->name }}</a></h4>
                    <h4><span>{{ $item->qty }} × </span>{{ number_format($item->price) }}</h4>
                </div>
                <div class="shopping-cart-delete">
                    <a href="#"><i class="fi-rs-cross-small"></i></a>
                </div>
            </li>
        @endforeach

    </ul>
    <div class="shopping-cart-footer">
        <div class="shopping-cart-total">
            <h4>Total <span>{{ number_format(Keranjang::subTotal()) }}</span></h4>
        </div>
        <div class="shopping-cart-button">
            <a href="{{ url('carts') }}" class="outline">View cart</a>
            <a href="{{ url('orders/checkout') }}">Checkout</a>
        </div>
    </div>
    @else
        <p>keranjang masih kosong</p>
    @endif
</div>