@extends('frontend.layout')

@section('content')
    @include('frontend.products.index')
@endsection

@push('scripts')
<script>
    var dataPagination, pageNumber=1, lastPageNumber, lastPageSize, lastPageKeyword, lastPageKategori, lastPageJenis, lastPageKecamatan, lastPageSort, lastProductType, lastPriceMin=0, lastPriceMax=0, delayTime=400,urlParam='',isBackPage = false,fireCounter=0;
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
       
        // var ajaxUrl = baseUrl+'/produk/',
        $('#pagekeyword').on("keyup", function(event) {
            event.preventDefault();
            if (event.keyCode === 13) {
                $("#btn_search").click();
            }

            if(this.value == ''){
                setTimeout(() => {
                    $("#btn_search").click();
                }, 200);
            }
        });

        $('#pmin').inputmask("numeric", {
            radixPoint: ".",
            groupSeparator: ",",
            /* digits: 2, */
            autoGroup: true,
            /* prefix: '$', *No Space, this will truncate the first character */
            rightAlign: false,
            oncleared: function () {
                // self.Value('');
            }
        });

        $('#pmax').inputmask("numeric", {
            radixPoint: ".",
            groupSeparator: ",",
            /* digits: 2, */
            autoGroup: true,
            /* prefix: '$', *No Space, this will truncate the first character */
            rightAlign: false,
            oncleared: function () {
                // self.Value('');
            }
        });

        $('#pmin').keyup(helpDelay(function (e) {
            checkPriceRange();
        }, delayTime));

        $('#pmax').keyup(helpDelay(function (e) {
            checkPriceRange();
        }, delayTime));

        $('#btn_reset').click(function (e) {
            $('#pmin').val('');
            $('#pmax').val('');

            checkPriceRange();
        });


        cekUrl();
    });

    function cekUrl(action='reload') {
        let param = window.location.href;

        let tempUrl = param.split('?');

        if(tempUrl.length > 1){
            tempUrl = getJsonFromUrl('?'+tempUrl[1]);
            let pricemin = ((tempUrl['pricemin'] == 0)? '' : tempUrl['pricemin']);
            let pricemax = ((tempUrl['pricemax'] == 0)? '' : tempUrl['pricemax']);
            pricemin = isNaN(pricemin)? 0 : pricemin;
            pricemax = isNaN(pricemax)? 0 : pricemax;
            console.log(pricemin)
            $('#pagesort').val(tempUrl['sort']);
            $('#cmb_product_type').val(tempUrl['product-type']);
            $('#pagekeyword').val(tempUrl['keyword']);
            $('#pagesize').val(tempUrl['size']);
            $('#pmin').val(pricemin);
            $('#pmax').val(pricemax);

            pageNumber = tempUrl['page'];
            lastPageSize = tempUrl['size'];

            let kategori = tempUrl['id_kategori'].split('.');
            let jenis = tempUrl['id_jenis'].split('.');

            $('.kategori').prop('checked', false);
            $('.jenis').prop('checked', false);

            for (var i = 0; i < kategori.length; i++) {
                $('#kategori-'+kategori[i]).prop('checked', true);
            }

            for (var j = 0; j < jenis.length; j++) {
                $('#jenis-'+jenis[j]).prop('checked', true);
            }

            if (tempUrl['pricemin'] == 0 && tempUrl['pricemax'] == 0) {
                document.getElementById("text_warning").style.display = "none";
                document.getElementById("btn_reset").style.display = "none";
            }else{
                if (tempUrl['pricemin'] > tempUrl['pricemax'] && (tempUrl['pricemax'] != 0)) {
                    document.getElementById("btn_reset").style.display = "none";
                    document.getElementById("text_warning").style.display = "block";
                } else {
                    document.getElementById("text_warning").style.display = "none";
                    document.getElementById("btn_reset").style.display = "block";
                }
            }
            
            // console.log('reload');
        }else{
            resetParam();
            // console.log('reset');
        }

        cekParam();
    }

    function checkPriceRange() {
        var pmin = $("#pmin").val();
        var pmax = $("#pmax").val();
        pmin = pmin.replace(/\,/g, '');
        pmax = pmax.replace(/\,/g, '');
        pmin = parseInt(pmin);
        pmax = parseInt(pmax);

        pmin = isNaN(pmin)? 0 : pmin;
        pmax = isNaN(pmax)? 0 : pmax;
        console.log(pmax)

        if (pmin != lastPriceMin || pmax != lastPriceMax) {
            if (pmin == 0 && pmax == 0) {
                document.getElementById("text_warning").style.display = "none";
                document.getElementById("btn_reset").style.display = "none";
                resetPage();
            }else{
                if (pmin > pmax && pmax != 0) {
                    document.getElementById("btn_reset").style.display = "none";
                    document.getElementById("text_warning").style.display = "block";
                } else {
                    document.getElementById("text_warning").style.display = "none";
                    document.getElementById("btn_reset").style.display = "block";
                    resetPage();
                }
            }
        }
    }

    function resetPage() {
        pageNumber = 1;
        cekParam();
    }

    function setPage(value) {
        pageNumber = value;
        cekParam();
    }

    function resetParam() {
        // $('#pagesort').find('option').eq(0).prop('selected', true);
        // $('#cmb_product_type').find('option').eq(0).prop('selected', true);
        $('#pagesize').find('option').eq(0).prop('selected', true);
        $('#kategori').prop('checked', false);
        $('.jenis').prop('checked', false);
        $('#pmin').val('');
        $('#pmax').val('');
    }

    function cekParam() {
        let load_data = false;
        let pagekeyword = $('#pagekeyword').val();
        let pagekategori = '';
        let filter_kategori = $('#form_kategori').serializeArray();
        let pricemin = parseInt($("#pmin").val().replace(/\,/g, ''));
        let pricemax = parseInt($("#pmax").val().replace(/\,/g, ''));
        pricemin = isNaN(pricemin)? 0 : pricemin;
        pricemax = isNaN(pricemax)? 0 : pricemax;

        for (var i = 0; i < filter_kategori.length; i++) {
            pagekategori += filter_kategori[i]['value'];

            if((i + 1) < filter_kategori.length){
                pagekategori +='.';
            }
        }


        if(pagekeyword != lastPageKeyword){
            lastPageKeyword = pagekeyword;
            load_data = true;
            pageNumber = 1;
        }

        if(pageNumber != lastPageNumber){
            lastPageNumber = pageNumber;
            load_data = true;
        }

        if(pricemin != lastPriceMin){
            lastPriceMin = pricemin;
            load_data = true;
        }

        if(pricemax != lastPriceMax){
            lastPriceMax = pricemax;
            load_data = true;
        }

        if(pagekategori != lastPageKategori){
            lastPageKategori = pagekategori;
            console.log(lastPageKategori)
            load_data = true;
        }

        if(load_data == true){
            urlParam = base_url+'produk?keyword='+lastPageKeyword+'&sort='+lastPageSort+'&id_kategori='+lastPageKategori+'&id_kecamatan='+lastPageKecamatan+'&pricemin='+lastPriceMin+'&pricemax='+lastPriceMax+'&id_jenis='+lastPageJenis+'&product-type='+lastProductType ;
            // console.log(urlParam);
            loadBarang();
        }
        // loadBarang();
    }

    function loadBarang()
    {
        var rows = 0, total_rows = 0, start = 0, end = 0;
        let keyword = $('#pagekeyword').val();
        let product_type = null;
        let filter_kategori = $('#form_kategori').serializeArray();
        let kategori = '';
        lastPageSize = 15;
        let size = 15;

        for (var i = 0; i < filter_kategori.length; i++) {
            kategori += '&id_kategori[]='+filter_kategori[i]['value'];
        }

        var ajaxSource = '{{ route("json_grid") }}';
        let dataSource = ajaxSource+'?keyword='+keyword+'&sort='+kategori+'&page='+pageNumber+'&size='+lastPageSize+'&pricemin='+lastPriceMin+'&pricemax='+lastPriceMax+'&product-type='+product_type;
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:"GET",
            url: dataSource+'?utm_source=product',
            beforeSend: function() {
                // preventLeaving();
                $('#preloader-active').show();
            },
            success:function(response){
                $('#preloader-active').hide();
                let obj = response;

                urlParam = urlParam.replace('&page='+lastPageNumber+'&size='+lastPageSize, '');
                pageNumber = obj.data.meta.pagination.page;
                lastPageNumber = obj.data.meta.pagination.page;
                fireCounter++;
                
                urlParam += '&page='+pageNumber+'&size='+lastPageSize;
                var hitung = obj.data.barang.length;
                
                console.log(base_url)
                var template = "";
                renderPagination(obj.data.meta.pagination);

                if(isBackPage == false){
                setPageHistory();
                    // console.log('forward');
                }else{
                    // console.log('back');
                    isBackPage = false;
                }    

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

    function setPageHistory() {
        /* Add an item to the history log */
        // history.pushState({url:urlParam}, null, urlParam);

        var currentUrl = "{{url()->current().'/'}}";
        // console.log(lastPageKeyword);
        if(lastPageSize == 15 && lastPageKeyword == '' && lastPriceMin == 0 && lastPriceMax == 0 && lastPageKategori == ''){
            history.pushState({url:currentUrl}, null, currentUrl);
            console.log('sama');
        }else{
            history.pushState({url:urlParam}, null, urlParam);
            console.log('beda');
        }
    }

    // window.addEventListener('popstate', function(event) {
    //     // console.log('popstate fired!');

    //     isBackPage = true;
    //     cekUrl();
    // });

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
            beforeSend: function() {
                $('#preloader-active').show();
            },
            success:function(response){
                console.log(response)
                $('#preloader-active').hide();
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

    function addWishlist(id)
    {
        Swal.fire({
        title: 'Tambahkan ke Wishlist?',
        text: "Ayo tambahkan produk kesayanganu sekarang..",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya'
        }).then((result) => {
        if (result.isConfirmed) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type:"POST",
                url: '{{ url("wishlist/add-product") }}',
                data: {id:id},
                dataType: "json",
                beforeSend: function() {
                    $('#preloader-active').show();
                },
                success:function(response){
                    $('#preloader-active').hide();
                    if(response.code == 200){
                        Swal.fire(
                            'Berhasil',
                            response.data.message,
                            'success'
                        )
                    }else{
                        Swal.fire(
                            'Gagal',
                            response.data.message,
                            'error'
                        )
                    }
                    

                },
                error: function(response) {
                
                }
            });
        }
        })

       
    }
    
</script>
@endpush