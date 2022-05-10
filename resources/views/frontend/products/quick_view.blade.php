<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
<div class="modal-body">
    <div class="row">
    <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
        <div class="detail-gallery">
            <span class="zoom-icon"><i class="fi-rs-search"></i></span>
            <!-- MAIN SLIDES -->
            <div class="product-image-slider">
                @foreach ($image as $item)
                    <figure class="border-radius-10" style="display: flex;justify-content: center;">
                        <img src="{{url('/storage/'.$item->medium) }}" alt="product image" />
                    </figure>
                @endforeach
                
            
            </div>
            <!-- THUMBNAILS -->
            <div class="slider-nav-thumbnails">
                @foreach ($image as $item)
                    <div><img src="{{url('/storage/'.$item->small) }}" alt="product image" /></div>
                @endforeach
                
            </div>
        </div>
        <!-- End Gallery -->
    </div>
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="detail-info pr-30 pl-30">
            <span class="stock-status out-stock"> Sale Off </span>
            <h3 class="title-detail"><a href="shop-product-right.html" class="text-heading">{{ $product->name }}</a></h3>
            <div class="product-detail-rating">
                <div class="product-rate-cover text-end">
                    <div class="product-rate d-inline-block">
                        <div class="product-rating" style="width: 90%"></div>
                    </div>
                    <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                </div>
            </div>
            <div class="clearfix product-price-cover">
                <div class="product-price primary-color float-left">
                    <span class="current-price text-brand" style="font-size: 40px!important;">{{ \General::priceFormat($product->price, 'Rp') }}</span>
                    {{-- <span>
                        <span class="save-price font-md color3 ml-15">26% Off</span>
                        <span class="old-price font-md ml-15">$52</span>
                    </span> --}}
                </div>
            </div>
            <div class="detail-extralink mb-30">
                <div class="detail-qty border radius">
                    <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                    <span class="qty-val">1</span>
                    <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                </div>
                <div class="product-extra-link2">
                    <button type="submit" class="button button-add-to-cart"><i class="fi-rs-shopping-cart"></i>Add to cart</button>
                </div>
            </div>
            <div class="font-xs">
                <ul>
                    <li class="mb-5">Vendor: <span class="text-brand">Nest</span></li>
                    <li class="mb-5">MFG:<span class="text-brand"> Jun 4.2021</span></li>
                </ul>
            </div>
        </div>
        <!-- Detail Info -->
    </div>
</div>
</div>