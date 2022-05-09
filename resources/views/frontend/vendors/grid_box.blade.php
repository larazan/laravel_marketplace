<div class="col-lg-3 col-md-6 col-12 col-sm-6">
    <div class="vendor-wrap mb-40">
        <div class="vendor-img-action-wrap">
            <div class="vendor-img">
                <a href="{{ url('vendor/'. $shop->slug) }}">
                    @if ($shop->medium)
                    <img src="{{ asset('storage/'.$shop->small) }}" alt="{{ $shop->name }}" />
                    @else
                    <img class="default-img" src="{{ asset('frontend/assets/imgs/vendor/vendor-1.png') }}" alt="" />
                    @endif
                </a>
            </div>
            <!-- <div class="product-badges product-badges-position product-badges-mrg">
                <span class="hot">Mall</span>
            </div> -->
        </div>
        <div class="vendor-content-wrap">
            <div class="d-flex justify-content-between align-items-end mb-30">
                <div>
                    <div class="product-category">
                        <span class="text-muted">{{ $shop->created_at->format('Y') }}</span>
                    </div>
                    <h4 class="mb-5"><a href="{{ url('vendor/'. $shop->slug) }}">{{ $shop->name }}</a></h4>

                    <div class="product-rate-cover">
                        <div class="product-rate d-inline-block">
                            <div class="product-rating" style="width: 90%"></div>
                        </div>
                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                    </div>
                </div>

                <div class="mb-10">
                    <span class="font-small total-product">{{ $shop->products->count() }} produk</span>
                </div>
            </div>

            <div class="vendor-info mb-30">
                <ul class="contact-infor text-muted">
                    <li><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-location.svg') }}" alt="" /><strong>Alamat: </strong> <span>{{ $shop->user->address1 }} </span></li>
                    <li><img src="{{ asset('frontend/assets/imgs/theme/icons/icon-contact.svg') }}" alt="" /><strong>Telpon:</strong><span>{{ $shop->user->phone }} </span></li>
                </ul>
            </div>
            <a href="{{ url('vendor/'. $shop->slug) }}" class="btn btn-xs">Visit Store <i class="fi-rs-arrow-small-right"></i></a>
        </div>
    </div>
</div>