@extends('frontend.layout')

@section('content')

<main class="main">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
                <a href="{{ url('/') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                @foreach ($breadcrumbs_data['breadcrumbs_array'] as $key => $value)
                <span></span> <a href="{{ $key }}"> {{ $value }} </a>
                @endforeach
                <span></span> {{ $breadcrumbs_data['current_page_title'] }}
                <!-- <li><a href="{{ $key }}">{{ $value }}</a></li> -->
            </div>
        </div>
    </div>
    <div class="container mb-30">
        <div class="archive-header-3 mt-30 mb-80" style="background-image: url({{ asset('frontend/assets/imgs/vendor/vendor-header-bg.png') }})">
            <div class="archive-header-3-inner">

                <div class="vendor-logo mr-50">
                    @if ($shop->medium)
                    <img src="{{ asset('storage/'.$shop->small) }}" alt="{{ $shop->name }}" />
                    @else
                    <img src="{{ asset('frontend/assets/imgs/vendor/vendor-17.png') }}" alt="{{ $shop->name }}" />
                    @endif
                </div>

                <div class="vendor-content">
                    <div class="product-category">
                        <span class="text-muted">Since {{ $shop->created_at->format('Y') }}</span>
                    </div>
                    <h3 class="mb-5 text-white"><a href="vendor-details-1.html" class="text-white">{{ $shop->name }}</a></h3>
                    <div class="product-rate-cover mb-15">
                        <div class="product-rate d-inline-block">
                            <div class="product-rating" style="width: 90%"></div>
                        </div>
                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                    </div>

                    <div class="row">
                        <div class="col-lg-4">
                            <div class="vendor-des mb-15">
                                <p class="font-sm text-white">{{ $shop->description }}</p>
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="vendor-info text-white mb-15">
                                <ul class="font-sm">
                                    <li><img class="mr-5" src="{{ asset('frontend/assets/imgs/theme/icons/icon-location.svg') }}" alt="" /><strong>Alamat: </strong> <span>{{ $shop->user->address1 }}</span></li>
                                    <li><img class="mr-5" src="{{ asset('frontend/assets/imgs/theme/icons/icon-contact.svg') }}" alt="" /><strong>Telpon:</strong><span>{{ $shop->user->phone }}</span></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="follow-social">
                                <h6 class="mb-15 text-white">Follow Us</h6>
                                <ul class="social-network">
                                    <li class="hover-up">
                                        <a href="#">
                                            <img src="{{ asset('frontend/assets/imgs/theme/icons/social-tw.svg') }}" alt="" />
                                        </a>
                                    </li>
                                    <li class="hover-up">
                                        <a href="#">
                                            <img src="{{ asset('frontend/assets/imgs/theme/icons/social-fb.svg') }}" alt="" />
                                        </a>
                                    </li>
                                    <li class="hover-up">
                                        <a href="#">
                                            <img src="{{ asset('frontend/assets/imgs/theme/icons/social-insta.svg') }}" alt="" />
                                        </a>
                                    </li>
                                    <li class="hover-up">
                                        <a href="#">
                                            <img src="{{ asset('frontend/assets/imgs/theme/icons/social-pin.svg') }}" alt="" />
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row flex-row-reverse">
            <div class="col-lg-4-5">
                <div class="shop-product-fillter">
                    <div class="totall-product">
                        <p>We found <strong class="text-brand">{{ $shop->products->count() }}</strong> items for you!</p>
                    </div>
                    <div class="sort-by-product-area">
                        <div class="sort-by-cover mr-10">
                            <div class="sort-by-product-wrap">
                                <div class="sort-by">
                                    <span><i class="fi-rs-apps"></i>Show:</span>
                                </div>
                                <div class="sort-by-dropdown-wrap">
                                    <span> 50 <i class="fi-rs-angle-small-down"></i></span>
                                </div>
                            </div>
                            <div class="sort-by-dropdown">
                                <ul>
                                    <li><a class="active" href="#">50</a></li>
                                    <li><a href="#">100</a></li>
                                    <li><a href="#">150</a></li>
                                    <li><a href="#">200</a></li>
                                    <li><a href="#">All</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="sort-by-cover">
                            <div class="sort-by-product-wrap">
                                <div class="sort-by">
                                    <span><i class="fi-rs-apps-sort"></i>Sort by:</span>
                                </div>
                                <div class="sort-by-dropdown-wrap">
                                    <span> Featured <i class="fi-rs-angle-small-down"></i></span>
                                </div>
                            </div>
                            <div class="sort-by-dropdown">
                                <ul>
                                    <li><a class="active" href="#">Featured</a></li>
                                    <li><a href="#">Price: Low to High</a></li>
                                    <li><a href="#">Price: High to Low</a></li>
                                    <li><a href="#">Release Date</a></li>
                                    <li><a href="#">Avg. Rating</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row product-grid" id="isi_produk">
                   
                </div>
                <!--product grid-->
                <div class="pagination-area mt-20 mb-20">
                    <nav aria-label="Page navigation example" id="paging_produk">
                        
                    </nav>
                </div>

                <!--End Deals-->
            </div>
            <!-- sidebar -->
        </div>
    </div>
</main>

@endsection

@push('scripts')
<script>
    var dataPagination, 
        pageNumber=1, 
        lastPageNumber, 
        lastPageSize, 
        lastPageKeyword, 
        lastPageKategori, 
        lastPageJenis, 
        lastPageKecamatan, 
        lastPageSort, 
        lastProductType, 
        lastPriceMin, 
        lastPriceMax, 
        delayTime=400;
    const hostName = window.location.origin,
    pecah = window.location.pathname.split("/");
    var base_url;
    base_url = "http://localhost" == hostName ? hostName + "/" + pecah[1] + "/" : hostName + "/";
    var KTAppOptions = {
        colors: {
            state: { brand: "#5d78ff", dark: "#282a3c", light: "#ffffff", primary: "#5867dd", success: "#34bfa3", info: "#36a3f7", warning: "#ffb822", danger: "#fd3995" },
            base: { label: ["#c5cbe3", "#a1a8c3", "#3d4465", "#3e4466"], shape: ["#f0f3ff", "#d9dffa", "#afb4d4", "#646c9a"] },
        },
    };
    $(document).ready(function(){       
        loadBarang();
    });
    function loadBarang()
    {
        let keyword = null;
        let product_type = null;
        let lastPageSize = 15;
        let size = 15;
        var ajaxSource = '{{ route("produk_grid") }}';
        let dataSource = ajaxSource+'?keyword='+keyword+'&page='+pageNumber+'&size='+lastPageSize;
        console.log(dataSource);
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        
        $.ajax({
            type:"GET",
            url: dataSource,
            beforeSend: function() {
                // preventLeaving();
                $('#preloader-active').show();
            },
            success:function(response){
                $('#preloader-active').hide();
                let obj = response;
                
                console.log(base_url)
                var template = "";
                renderPagination(obj.data.meta.pagination);

                if(obj.data.barang.length > 0){
                    for (var i = 0; i < obj.data.barang.length; i++) {
                        let rowData = obj.data.barang[i];
                        var img =  base_url+'storage/'+rowData['gambar'];
                        var imgZonk = base_url+'frontend/assets/imgs/shop/product-1-2.jpg';
                        var slugUrl = base_url+'product/'+rowData['slug'];
                        var harga = helpCurrency2(rowData['price'], 'Rp');
                        template += `
                        <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                            <div class="product-cart-wrap mb-30">
                                <div class="product-img-action-wrap">
                                    <div class="product-img product-img-zoom">
                                        <a href="${slugUrl}">
                                            <img class="default-img" src="${rowData['gambar'] ? img : imgZonk}" alt="" />
                                        </a>
                                            </div>
                                            <div class="product-action-1">
                                                <a aria-label="Tambahkan ke wishlist" class="action-btn" onclick='addWishlist("${rowData['id_produk']}")'><i class="fi-rs-heart"></i></a>
                                                <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                                <a aria-label="Lihat Detail" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal" onclick='quickViewModal("${rowData['slug']}")'><i class="fi-rs-eye"></i></a>
                                            </div>
                                            
                                        </div>
                                        <div class="product-content-wrap">
                                            <div class="product-category">
                                                <a href="shop-grid-right.html">${rowData['nama_kategori']}</a>
                                            </div>
                                            <h2><a href="${slugUrl}">${rowData['nama_produk']}</a></h2>
                                            <div class="product-rate-cover">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="font-small ml-5 text-muted"> (4.0)</span>
                                            </div>
                                            <div>
                                                <span class="font-small text-muted">${rowData['sku']} - <a href="vendor-details-1.html">${rowData['nama_toko']}</a></span>
                                            </div>
                                            <div class="product-card-bottom">
                                                <div class="product-price">
                                                    <span>${harga}</span>
                                                    <span class="old-price">$32.8</span>
                                                </div>
                                                <div class="add-cart">
                                                    <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i>Beli </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        `;
                        
                    }
                }else{
                    template = '<h3>Data tidak tersedia</h3>';
                }
                $('#isi_produk').html(template);
            },
            error: function(response) {
            
            }
        });
    }
    function renderPagination(pagination)
    {
        let maxPage = 6;
        let page = parseInt(pagination.page);
        let total_page = parseInt(pagination.total_page);
        let template = '<ul class="pagination justify-content-start">';
                       
                    //     <li class="page-item"><a class="page-link" href="#">1</a></li>\
                    //     <li class="page-item active"><a class="page-link" href="#">2</a></li>\
                    //     <li class="page-item"><a class="page-link" href="#">3</a></li>\
                    //     <li class="page-item"><a class="page-link dot" href="#">...</a></li>\
                    //     <li class="page-item"><a class="page-link" href="#">6</a></li>\
                    //     <li class="page-item">\
                    //         <a class="page-link" href="#"><i class="fi-rs-arrow-small-right"></i></a>\
                    //     </li>\
                    // </ul>';
        if(page > 1){
            template +=  '<li class="page-item" data-num="'+(page - 1)+'" onclick="setPage('+(page - 1)+')">\
                            <a class="page-link" href="#"><i class="fi-rs-arrow-small-left" ></i></a>\
                        </li>';
        }
        let half_total_links =  Math.ceil(total_page / 2);
        let from = (page - Math.ceil(maxPage / 2));
        let to = (from + maxPage);
        if(from < 1){
            from = 1;
            to = (from + maxPage);
        }else if(to > total_page){
            to = total_page;
            from = (to - maxPage);
        }
        from = (from > 1)? from : 1;
        to = (to > total_page)? total_page : to;
        for (var i = from; i < to; i++) {
            let active = ( (i == page)? 'active' : '' );
            
            // template += '<li class="paginationjs-page J-paginationjs-page '+active+'" data-num="'+i+'" onclick="setPage('+i+')" ><span>'+i+'</span></li>';
            template += '<li class="page-item '+active+' data-num="'+i+'" onclick="setPage('+i+')"" ><a class="page-link" href="#">'+i+'</a></li>';
        }
        if(page < total_page){
            // template += '<li class="paginationjs-next J-paginationjs-next" title="Next Page" data-num="'+(page + 1)+'" onclick="setPage('+(page + 1)+')"><span>»</span></li>';
            template += '<li class="page-item">\
                            <a class="page-link" href="#"><i class="fi-rs-arrow-small-right" data-num="'+(page + 1)+'" onclick="setPage('+(page + 1)+')"></i></a>\
                        </li>';
        }
        template += '</ul>';
        $('#paging_produk').html(template);
    }
    function setPage(value) {
        pageNumber = value;
        loadBarang();
    }
    function quickViewModal(slug)
    {
        
        var modal = $("#quickViewModal");
        // modal.find('.modal-content').empty();
        // $('.slider-nav-thumbnails .slick-slide').removeClass('slick-active');
        var urlRoute = "{{ route('quick-view', ":slug") }}";
        console.log(slug)
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:"GET",
            url: urlRoute.replace(":slug", slug),
            dataType: "json",
            // beforeSend: function() {
            //     modal.find('.modal-content').html('Tunggu sebentar...');
            // },
            success:function(response){
                console.log(response)
                // var tes = '';
                modal.find('.modal-content').html(response);
                // $('#quickViewModal').modal('show');
                // $('.text-heading').html(response.product.name);
                // $('.text-brand').html(helpCurrency(response.product.price, 'Rp ', '.'));
                // var images = response.image;
                // for(i=0;i<images.length;i++){
                //     var imges =  base_url+'/public/storage/'+images[i]['small'];
                //     var img = "<div><img src='"+imges+"' alt='product image tes' /></div>";
                //     tes += img;
                // }
                // $('#gambar_kecil').html(tes);
               
                productDetails();
                $('#quickViewModal').modal('show');
                
            },
            error: function(response) {
            
            }
        });
    }
     var productDetails = function () {
        $('.product-image-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: false,
            asNavFor: '.slider-nav-thumbnails',
        });
        $('.slider-nav-thumbnails').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: '.product-image-slider',
            dots: false,
            focusOnSelect: true,
            
            prevArrow: '<button type="button" class="slick-prev"><i class="fi-rs-arrow-small-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="fi-rs-arrow-small-right"></i></button>'
        });
        // Remove active class from all thumbnail slides
        $('.slider-nav-thumbnails .slick-slide').removeClass('slick-active');
        // Set active class to first thumbnail slides
        $('.slider-nav-thumbnails .slick-slide').eq(0).addClass('slick-active');
        // On before slide change match active thumbnail to current slide
        $('.product-image-slider').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            var mySlideNumber = nextSlide;
            $('.slider-nav-thumbnails .slick-slide').removeClass('slick-active');
            $('.slider-nav-thumbnails .slick-slide').eq(mySlideNumber).addClass('slick-active');
        });
        $('.product-image-slider').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            var img = $(slick.$slides[nextSlide]).find("img");
            $('.zoomWindowContainer,.zoomContainer').remove();
            $(img).elevateZoom({
                zoomType: "inner",
                cursor: "crosshair",
                zoomWindowFadeIn: 500,
                zoomWindowFadeOut: 750
            });
        });
        //Elevate Zoom
        if ( $(".product-image-slider").length ) {
            $('.product-image-slider .slick-active img').elevateZoom({
                zoomType: "inner",
                cursor: "crosshair",
                zoomWindowFadeIn: 500,
                zoomWindowFadeOut: 750
            });
        }
        //Filter color/Size
        $('.list-filter').each(function () {
            $(this).find('a').on('click', function (event) {
                event.preventDefault();
                $(this).parent().siblings().removeClass('active');
                $(this).parent().toggleClass('active');
                $(this).parents('.attr-detail').find('.current-size').text($(this).text());
                $(this).parents('.attr-detail').find('.current-color').text($(this).attr('data-color'));
            });
        });
        //Qty Up-Down
        $('.detail-qty').each(function () {
            var qtyval = parseInt($(this).find('.qty-val').text(), 10);
            $('.qty-up').on('click', function (event) {
                event.preventDefault();
                qtyval = qtyval + 1;
                $(this).prev().text(qtyval);
            });
            $('.qty-down').on('click', function (event) {
                event.preventDefault();
                qtyval = qtyval - 1;
                if (qtyval > 1) {
                    $(this).next().text(qtyval);
                } else {
                    qtyval = 1;
                    $(this).next().text(qtyval);
                }
            });
        });
        $('.dropdown-menu .cart_list').on('click', function (event) {
            event.stopPropagation();
        });
    };
    
</script>
@endpush