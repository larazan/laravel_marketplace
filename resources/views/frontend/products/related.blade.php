
@if ($products)
<div class="row mt-60">
    <div class="col-12">
        <h2 class="section-title style-1 mb-30">Related products</h2>
    </div>
    <div class="col-12">
        <div class="row related-products">
        @foreach ($products as $product)
            @php
            $product = $product->parent ?: $product;
            @endphp
            <div class="col-lg-3 col-md-4 col-12 col-sm-6">
                <div class="product-cart-wrap hover-up">
                    <div class="product-img-action-wrap">
                        <div class="product-img product-img-zoom">
                            <a href="{{ url('product/'. $product->slug) }}" tabindex="0">
                            @if ($product->productImages->first())
                                <img class="default-img" src="{{ asset('storage/'.$product->productImages->first()->medium) }}" alt="{{ $product->name }}" />
                                @else
                                <img class="hover-img" src="{{ asset('frontend/assets/imgs/shop/product-2-2.jpg') }}" alt="{{ $product->name }}" />
                                @endif
                            </a>
                        </div>
                        <div class="product-action-1">
                            <a aria-label="Quick view" class="action-btn small hover-up" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-search"></i></a>
                            <a aria-label="Add To Wishlist" class="action-btn small hover-up" href="shop-wishlist.html" tabindex="0"><i class="fi-rs-heart"></i></a>
                            <a aria-label="Compare" class="action-btn small hover-up" href="shop-compare.html" tabindex="0"><i class="fi-rs-shuffle"></i></a>
                        </div>
                        <div class="product-badges product-badges-position product-badges-mrg">
                            <span class="hot">Hot</span>
                        </div>
                    </div>
                    <div class="product-content-wrap">
                        <h2><a href="{{ url('product/'. $product->slug) }}" tabindex="0">{{ $product->name }}</a></h2>
                        <div class="rating-result" title="90%">
                            <span> </span>
                        </div>
                        <div class="product-price">
                            <span>{{ number_format($product->priceLabel()) }} </span>
                            <span class="old-price">$245.8</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>