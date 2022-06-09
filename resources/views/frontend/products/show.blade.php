@extends('frontend.layout')

@section('content')
<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <!-- <a href="#" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a> -->
                @foreach ($breadcrumbs_data['breadcrumbs_array'] as $key => $value)
                <a href="{{ $key }}"><i class="fi-rs-home mr-5"></i>{{ $value }}</a>
                @endforeach
                <span></span> {{ $breadcrumbs_data['current_page_title'] }}
            </div>
        </div>
    </div>
    <div class="container mb-30">
        <div class="row">
            <div class="col-xl-10 col-lg-12 m-auto">
                <div class="product-detail accordion-detail">
                
                    <div class="row mb-50 mt-30">
                    @include('frontend.partials.flash')
                        <div class="col-md-6 col-sm-12 col-xs-12 mb-md-0 mb-sm-5">
                        <div class="detail-gallery">
                                        <span class="zoom-icon"><i class="fi-rs-search"></i></span>
                                        <!-- MAIN SLIDES -->
                                        <div class="product-image-slider">
                                            @php
                                            $i = 1
                                            @endphp
                                            @forelse ($product->productImages as $image)
                                            @if ($image->large && $image->extra_large)
                                            <figure class="border-radius-10">
                                                <img src="{{ asset('storage/'.$image->large) }}" alt="{{ $product->name }}" />
                                            </figure>
                                            @else
                                            <figure class="border-radius-10">
                                                <img src="assets/imgs/shop/product-16-2.jpg" alt="product image" />
                                            </figure>
                                            @endif

                                            @php
                                            $i++
                                            @endphp
                                            @empty
                                            No image found!
                                            @endforelse
                                        </div>
                                        <!-- THUMBNAILS -->
                                        <div class="slider-nav-thumbnails">
                                            @php
                                            $i = 1
                                            @endphp
                                            @forelse ($product->productImages as $image)
                                            <div>
                                                @if ($image->small)
                                                <img src="{{ asset('storage/'.$image->small) }}" alt="{{ $product->name }}" />
                                                @else
                                                <img src="assets/imgs/shop/thumbnail-3.jpg" alt="product image" />
                                                @endif
                                            </div>
                                            @php
                                            $i++
                                            @endphp
                                            @empty
                                            No image found!
                                            @endforelse
                                        </div>
                                    </div>
                                    <!-- End Gallery -->
                        </div>
                        <div class="col-md-6 col-sm-12 col-xs-12">
                            <div class="detail-info pr-30 pl-30">
                                <span class="stock-status out-stock"> Sale Off </span>
                                <h2 class="title-detail">{{ $product->name }}</h2>
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
                                        <span class="current-price text-brand">{{ \General::priceFormat($product->price, 'Rp') }}</span>
                                        {{-- <span>
                                            <span class="save-price font-md color3 ml-15">26% Off</span>
                                            <span class="old-price font-md ml-15">$52</span>
                                        </span> --}}
                                    </div>
                                </div>
                                <div class="short-desc mb-30">
                                    <p class="font-lg">{{ \Illuminate\Support\Str::words($product->description, '25') }}.</p>
                                </div>
                                <form id="shopForm">
					                    {{ Form::hidden('product_id', $product->id) }}
					                    {{ Form::hidden('price', $product->price) }}

                                        @if ($product->type == 'configurable')
                                        <div class="attr-detail attr-size mb-30">
                                            <strong class="mr-10">Size: </strong>
                                            {!! Form::select('size', $sizes , null, ['class' => 'select', 'placeholder' => '- Please Select -', 'required' => true]) !!}
                                            <!-- <ul class="list-filter size-filter font-small">
                                                <li><a href="#">50g</a></li>
                                                <li class="active"><a href="#">60g</a></li>
                                                <li><a href="#">80g</a></li>
                                                <li><a href="#">100g</a></li>
                                                <li><a href="#">150g</a></li>
                                            </ul> -->
                                        </div>
                                        <div class="attr-detail attr-size mb-30">
                                            <strong class="mr-10">Color: </strong>
                                            {!! Form::select('color', $colors , null, ['class' => 'select', 'placeholder' => '- Please Select -', 'required' => true]) !!}
                                            <!-- <ul class="list-filter size-filter font-small">
                                                <li><a href="#">50g</a></li>
                                                <li class="active"><a href="#">60g</a></li>
                                                <li><a href="#">80g</a></li>
                                                <li><a href="#">100g</a></li>
                                                <li><a href="#">150g</a></li>
                                            </ul> -->
                                        </div>
                                        @endif
                                       
                                        <div class="detail-extralink mb-50">
                                            <div class="">
                                            {!! Form::number('qty', 1, ['class' => 'form-control cart-plus-minus-box qty-val qty-input', 'id' => 'product-quantity', 'placeholder' => 'qty', 'min' => 1]) !!}
                                                <!-- <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                                <span class="qty-val">1</span>
                                                <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a> -->
                                            </div>
                                            <div class="product-extra-link2">
                                                <button type="button" class="button button-add-to-cart" onclick="save()"><i class="fi-rs-shopping-cart"></i>Beli</button>
                                                <a aria-label="Add To Wishlist" class="action-btn hover-up" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn hover-up" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                            </div>
                                        </div>
                                </form>
                                        <div class="font-xs">
                                            <ul class="mr-50 float-start">
                                                <!-- <li class="mb-5">Type: <span class="text-brand"></span></li> -->
                                                <!-- <li class="mb-5">MFG:<span class="text-brand"> Jun 4.2021</span></li> -->
                                                <!-- <li>LIFE: <span class="text-brand">70 days</span></li> -->
                                            </ul>
                                            <ul class="float-start">
                                                <li class="mb-5">SKU: <a href="#">{{ $product->sku }}</a></li>
                                                <li class="mb-5">Kategori: 
                                                    @foreach ($product->categories as $category)
                                                    <a href="{{ url('products?category='. $category->slug ) }}" rel="tag">{{ $category->name }}</a>, 
                                                    @endforeach
                                                </li>
                                                <li>Stok:<span class="in-stock text-brand ml-5">{{ $product->productInventory->qty ?? '' }} Barang Tersedia</span></li>
                                            </ul>
                                        </div>
                            </div>
                            <!-- Detail Info -->
                        </div>
                    </div>
                    <div class="product-info">
                        <div class="tab-style3">
                            <ul class="nav nav-tabs text-uppercase">
                                <li class="nav-item">
                                    <a class="nav-link active" id="Description-tab" data-bs-toggle="tab" href="#Description">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Additional-info-tab" data-bs-toggle="tab" href="#Additional-info">Additional info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Vendor-info-tab" data-bs-toggle="tab" href="#Vendor-info">Vendor</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="Reviews-tab" data-bs-toggle="tab" href="#Reviews">Reviews (3)</a>
                                </li>
                            </ul>
                            <div class="tab-content shop_info_tab entry-main-content">
                                <div class="tab-pane fade show active" id="Description">
                                    <div class="">
                                    {{ $product->description }}
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="Additional-info">
                                    <table class="font-md">
                                        <tbody>
                                            <tr class="stand-up">
                                                <th>Stand Up</th>
                                                <td>
                                                    <p>35″L x 24″W x 37-45″H(front to back wheel)</p>
                                                </td>
                                            </tr>
                                            <tr class="folded-wo-wheels">
                                                <th>Folded (w/o wheels)</th>
                                                <td>
                                                    <p>32.5″L x 18.5″W x 16.5″H</p>
                                                </td>
                                            </tr>
                                            <tr class="folded-w-wheels">
                                                <th>Folded (w/ wheels)</th>
                                                <td>
                                                    <p>32.5″L x 24″W x 18.5″H</p>
                                                </td>
                                            </tr>
                                            <tr class="door-pass-through">
                                                <th>Door Pass Through</th>
                                                <td>
                                                    <p>24</p>
                                                </td>
                                            </tr>
                                            <tr class="frame">
                                                <th>Frame</th>
                                                <td>
                                                    <p>Aluminum</p>
                                                </td>
                                            </tr>
                                            <tr class="weight-wo-wheels">
                                                <th>Weight (w/o wheels)</th>
                                                <td>
                                                    <p>20 LBS</p>
                                                </td>
                                            </tr>
                                            <tr class="weight-capacity">
                                                <th>Weight Capacity</th>
                                                <td>
                                                    <p>60 LBS</p>
                                                </td>
                                            </tr>
                                            <tr class="width">
                                                <th>Width</th>
                                                <td>
                                                    <p>24″</p>
                                                </td>
                                            </tr>
                                            <tr class="handle-height-ground-to-handle">
                                                <th>Handle height (ground to handle)</th>
                                                <td>
                                                    <p>37-45″</p>
                                                </td>
                                            </tr>
                                            <tr class="wheels">
                                                <th>Wheels</th>
                                                <td>
                                                    <p>12″ air / wide track slick tread</p>
                                                </td>
                                            </tr>
                                            <tr class="seat-back-height">
                                                <th>Seat back height</th>
                                                <td>
                                                    <p>21.5″</p>
                                                </td>
                                            </tr>
                                            <tr class="head-room-inside-canopy">
                                                <th>Head room (inside canopy)</th>
                                                <td>
                                                    <p>25″</p>
                                                </td>
                                            </tr>
                                            <tr class="pa_color">
                                                <th>Color</th>
                                                <td>
                                                    <p>Black, Blue, Red, White</p>
                                                </td>
                                            </tr>
                                            <tr class="pa_size">
                                                <th>Size</th>
                                                <td>
                                                    <p>M, S</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade" id="Vendor-info">
                                    <div class="vendor-logo d-flex mb-30">
                                        <img src="assets/imgs/vendor/vendor-18.svg" alt="" />
                                        <div class="vendor-name ml-15">
                                            <h6>
                                                <a href="vendor-details-2.html">Noodles Co.</a>
                                            </h6>
                                            <div class="product-rate-cover text-end">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (32 reviews)</span>
                                            </div>
                                        </div>
                                    </div>
                                    <ul class="contact-infor mb-50">
                                        <li><img src="assets/imgs/theme/icons/icon-location.svg" alt="" /><strong>Address: </strong> <span>5171 W Campbell Ave undefined Kent, Utah 53127 United States</span></li>
                                        <li><img src="assets/imgs/theme/icons/icon-contact.svg" alt="" /><strong>Contact Seller:</strong><span>(+91) - 540-025-553</span></li>
                                    </ul>
                                    <div class="d-flex mb-55">
                                        <div class="mr-30">
                                            <p class="text-brand font-xs">Rating</p>
                                            <h4 class="mb-0">92%</h4>
                                        </div>
                                        <div class="mr-30">
                                            <p class="text-brand font-xs">Ship on time</p>
                                            <h4 class="mb-0">100%</h4>
                                        </div>
                                        <div>
                                            <p class="text-brand font-xs">Chat response</p>
                                            <h4 class="mb-0">89%</h4>
                                        </div>
                                    </div>
                                    <p>Noodles & Company is an American fast-casual restaurant that offers international and American noodle dishes and pasta in addition to soups and salads. Noodles & Company was founded in 1995 by Aaron Kennedy and is headquartered in Broomfield, Colorado. The company went public in 2013 and recorded a $457 million revenue in 2017.In late 2018, there were 460 Noodles & Company locations across 29 states and Washington, D.C.</p>
                                </div>
                                <div class="tab-pane fade" id="Reviews">
                                    @include('frontend.products.review')
                                </div>
                            </div>
                        </div>
                    </div>
                   <!-- related produk -->

                    <!-- end related produk -->
                </div>
            </div>
        </div>
    </div>
</main>
@endsection


@push('scripts')
<script src="{{ asset('frontend/assets/js/shop2.js?v=4.0') }}"></script>
<script>
    $(document).ready(function() {
        // Swal.fire('Any fool can use a computer')
        // $('#preloader-active').hide();
        // productDetails();
        // $(".product-image-slider").slick("setPosition");
        // $(".slider-nav-thumbnails").slick("setPosition");
        
        console.log('kesini dong');
    });

    function addCart(id)
    {
        var qty = $('.qty-val').text();
        Swal.fire(
        'Tambahkan produk?',
        'Ayo tambahkan produk kesayanganmu sekarang..',
        'question'
        )
    }

    function save()
    {        
        var form = $('#shopForm')[0];
        var data = new FormData(form);
        var id = $('[name="product_id"]').val();

        Swal.fire({
        title: 'Tambahkan ke keranjag?',
        text: "Ayo tambahkan produk kesayanganmu sekarang..",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Iya '
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                enctype: 'multipart/form-data',
                url: "{{ url('carts/add-cart') }}",
                data: data,
                dataType: "JSON",
                processData: false, // false, it prevent jQuery form transforming the data into a query string
                contentType: false, 
                cache: false,
                timeout: 600000,
                success: function (response) {
                    if (response.code == 200) {
                        toastr.success(response.data.message)
                    }else{
                        toastr.error(response.data.message)
                    }

                },
                error: function (e) {

                }
            });
        }
        })

    }

    
</script>
@endpush