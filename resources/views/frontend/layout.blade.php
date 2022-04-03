<!DOCTYPE html>
<html class="no-js" lang="en">
    <head>
        <meta charset="utf-8" />
        <title>Sorgum - Marketplace</title>
        <meta http-equiv="x-ua-compatible" content="ie=edge" />
        <meta name="description" content="" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta property="og:title" content="" />
        <meta property="og:type" content="" />
        <meta property="og:url" content="" />
        <meta property="og:image" content="" />
        <!-- Favicon -->
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/imgs/theme/favicon.svg') }}" />
        <!-- Template CSS -->
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/plugins/slider-range.css') }}" />
        <link rel="stylesheet" href="{{ asset('frontend/assets/css/main.css?v=4.0') }}" />
    </head>

    <body>
    @include('frontend.partials.modal')
    @include('frontend.partials.header')

    @yield('content')

    @include('frontend.partials.footer')
    

    <!-- Preloader Start -->
    <div id="preloader-active">
            <div class="preloader d-flex align-items-center justify-content-center">
                <div class="preloader-inner position-relative">
                    <div class="text-center">
                        <img src="{{ asset('frontend/assets/imgs/theme/loading.gif') }}" alt="" />
                    </div>
                </div>
            </div>
        </div>
     <!-- Vendor JS-->
    
     <script src="{{ asset('frontend/assets/js/vendor/modernizr-3.6.0.min.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/vendor/jquery-3.6.0.min.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/vendor/jquery-migrate-3.3.0.min.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/vendor/bootstrap.bundle.min.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/slick.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/jquery.syotimer.min.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/wow.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/slider-range.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/perfect-scrollbar.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/magnific-popup.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/select2.min.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/waypoints.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/counterup.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/jquery.countdown.min.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/images-loaded.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/isotope.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/scrollup.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/jquery.vticker-min.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/jquery.theia.sticky.js') }}"></script>
     <script src="{{ asset('frontend/assets/js/plugins/jquery.elevatezoom.js') }}"></script>
     <!-- Template  JS -->
     <script src="{{ asset('frontend/assets/js/main.js?v=4.0') }}"></script>
     <script src="{{ asset('frontend/assets/js/shop.js?v=4.0') }}"></script>
     <script src="{{ asset('frontend/assets/extends/js/energeek.js') }}"></script>
     <script>
        var dataPagination, pageNumber=1, lastPageNumber, lastPageSize, lastPageKeyword, lastPageKategori, lastPageJenis, lastPageKecamatan, lastPageSort, lastProductType, lastPriceMin, lastPriceMax, delayTime=400;
        $(document).ready(function(){
           
            // var ajaxUrl = baseUrl+'/produk/',
            loadBarang();
        });

        function loadBarang()
        {
            let keyword = null;
            let product_type = null;
            let lastPageSize = 15;
            let size = 15;

            var ajaxSource = '{{ route("json_grid") }}';
            let dataSource = ajaxSource+'?keyword='+keyword+'&page='+pageNumber+'&size='+lastPageSize+'&pricemin='+lastPriceMin+'&pricemax='+lastPriceMax+'&product-type='+product_type;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:"GET",
                url: dataSource+'?utm_source=product',
                // beforeSend: function() {
                //     preventLeaving();
                //     $('.se-pre-con').show();
                // },
                success:function(response){
                    let obj = response;
                    var base_url = {!! json_encode(url('/')) !!}
                    var template = "";

                    renderPagination(obj.data.meta.pagination);

                    if(obj.data.barang.length > 0){
                        for (var i = 0; i < obj.data.barang.length; i++) {
                            let rowData = obj.data.barang[i];
                            var img =  base_url+'/storage/'+rowData['gambar'];
                            template += `
                            <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                                <div class="product-cart-wrap mb-30">
                                    <div class="product-img-action-wrap">
                                        <div class="product-img product-img-zoom">
                                            <a href="shop-product-right.html">
                                                <img class="default-img" src="${img}" alt="" />
                                                        <img class="hover-img" src="{{ asset('frontend/assets/imgs/shop/product-1-2.jpg') }}" alt="" />
                                                    </a>
                                                </div>
                                                <div class="product-action-1">
                                                    <a aria-label="Add To Wishlist" class="action-btn" href="shop-wishlist.html"><i class="fi-rs-heart"></i></a>
                                                    <a aria-label="Compare" class="action-btn" href="shop-compare.html"><i class="fi-rs-shuffle"></i></a>
                                                    <a aria-label="Quick view" class="action-btn" data-bs-toggle="modal" data-bs-target="#quickViewModal"><i class="fi-rs-eye"></i></a>
                                                </div>
                                                <div class="product-badges product-badges-position product-badges-mrg">
                                                    <span class="hot">Hot</span>
                                                </div>
                                            </div>
                                            <div class="product-content-wrap">
                                                <div class="product-category">
                                                    <a href="shop-grid-right.html">${rowData['nama_kategori']}</a>
                                                </div>
                                                <h2><a href="shop-product-right.html">${rowData['nama_produk']}</a></h2>
                                                <div class="product-rate-cover">
                                                    <div class="product-rate d-inline-block">
                                                        <div class="product-rating" style="width: 90%"></div>
                                                    </div>
                                                    <span class="font-small ml-5 text-muted"> (4.0)</span>
                                                </div>
                                                <div>
                                                    <span class="font-small text-muted">By <a href="vendor-details-1.html">NestFood</a></span>
                                                </div>
                                                <div class="product-card-bottom">
                                                    <div class="product-price">
                                                        <span>${helpCurrency(rowData['price'], 'Rp ', '.')}</span>
                                                        <span class="old-price">$32.8</span>
                                                    </div>
                                                    <div class="add-cart">
                                                        <a class="add" href="shop-cart.html"><i class="fi-rs-shopping-cart mr-5"></i>Add </a>
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
                template +=  '<li class="page-item">\
                                <a class="page-link" href="#"><i class="fi-rs-arrow-small-left" data-num="'+(page - 1)+'" onclick="setPage('+(page - 1)+')"></i></a>\
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
    </script>

    </body>
</html>
