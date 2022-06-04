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
                <div class="table-responsive shopping-summery">
                    <table class="table table-wishlist">
                        <thead>
                            <tr class="main-heading">
                                <th class="custome-checkbox start pl-30">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox11" value="">
                                    <label class="form-check-label" for="exampleCheckbox11"></label>
                                </th>
                                <th scope="col" colspan="2">Nama Barang</th>
                                <th scope="col">Harga</th>
                                <th scope="col">Jumlah</th>
                                <th scope="col">Subtotal</th>
                                <th scope="col" class="end">Hapus</th>
                            </tr>
                        </thead>
<<<<<<< HEAD
                        <tbody id="list_product">
                          
                           
=======
                        <tbody>
                            <tr class="pt-30">
                                <td class="custome-checkbox pl-30">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value="">
                                    <label class="form-check-label" for="exampleCheckbox1"></label>
                                </td>
                                <td class="image product-thumbnail pt-40"><img src="frontend/assets/imgs/shop/product-1-1.jpg" alt="#"></td>
                                <td class="product-des product-name">
                                    <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="shop-product-right.html">Field Roast Chao Cheese Creamy Original</a></h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width:90%">
                                            </div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                </td>
                                <td class="price" data-title="Price">
                                    <h4 class="text-body">$2.51 </h4>
                                </td>
                                <td class="text-center detail-info" data-title="Stock">
                                    <div class="detail-extralink mr-15">
                                        <div class="detail-qty border radius">
                                            <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                            <span class="qty-val">1</span>
                                            <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                        </div>
                                    </div>
                                </td>
                                <td class="price" data-title="Price">
                                    <h4 class="text-brand">$2.51 </h4>
                                </td>
                                <td class="action text-center" data-title="Remove"><a href="#" class="text-body"><i class="fi-rs-trash"></i></a></td>
                            </tr>
                            <tr>
                                <td class="custome-checkbox pl-30">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox2" value="">
                                    <label class="form-check-label" for="exampleCheckbox2"></label>
                                </td>
                                <td class="image product-thumbnail"><img src="frontend/assets/imgs/shop/product-2-1.jpg" alt="#"></td>
                                <td class="product-des product-name">
                                    <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="shop-product-right.html">Blue Diamond Almonds Lightly Salted</a></h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width:90%">
                                            </div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                </td>
                                <td class="price" data-title="Price">
                                    <h4 class="text-body">$3.2 </h4>
                                </td>
                                <td class="text-center detail-info" data-title="Stock">
                                    <div class="detail-extralink mr-15">
                                        <div class="detail-qty border radius">
                                            <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                            <span class="qty-val">1</span>
                                            <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                        </div>
                                    </div>
                                </td>
                                <td class="price" data-title="Price">
                                    <h4 class="text-brand">$3.2 </h4>
                                </td>
                                <td class="action text-center" data-title="Remove"><a href="#" class="text-body"><i class="fi-rs-trash"></i></a></td>
                            </tr>
                            <tr>
                                <td class="custome-checkbox pl-30">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox3" value="">
                                    <label class="form-check-label" for="exampleCheckbox3"></label>
                                </td>
                                <td class="image product-thumbnail"><img src="frontend/assets/imgs/shop/product-3-1.jpg" alt="#"></td>
                                <td class="product-des product-name">
                                    <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="shop-product-right.html">Fresh Organic Mustard Leaves Bell Pepper</a></h6>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width:90%">
                                            </div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                </td>
                                <td class="price" data-title="Price">
                                    <h4 class="text-body">$2.43 </h4>
                                </td>
                                <td class="text-center detail-info" data-title="Stock">
                                    <div class="detail-extralink mr-15">
                                        <div class="detail-qty border radius">
                                            <a href="#" class="qty-down"><i class="fi-rs-angle-small-down"></i></a>
                                            <span class="qty-val">1</span>
                                            <a href="#" class="qty-up"><i class="fi-rs-angle-small-up"></i></a>
                                        </div>
                                    </div>
                                </td>
                                <td class="price" data-title="Price">
                                    <h4 class="text-brand">$2.43 </h4>
                                </td>
                                <td class="action text-center" data-title="Remove"><a href="#" class="text-body"><i class="fi-rs-trash"></i></a></td>
                            </tr>
>>>>>>> 91712fd608f8f4d68cb26fc9014da2928418a1fc
                        </tbody>
                    </table>
                </div>
                <div class="divider-2 mb-30"></div>
                <div class="cart-action d-flex justify-content-between">
                    <a class="btn "><i class="fi-rs-arrow-left mr-10"></i>Continue Shopping</a>
                    <a class="btn  mr-10 mb-sm-15"><i class="fi-rs-refresh mr-10"></i>Update Cart</a>
                </div>
              
            </div>
            <div class="col-lg-4">
                <div class="border p-md-4 cart-totals ml-30">
<<<<<<< HEAD
                    <img src="{{ asset('frontend/assets/imgs/sorgumku.svg') }}" width="200">
                    <br>
=======
>>>>>>> 91712fd608f8f4d68cb26fc9014da2928418a1fc
                    <div class="table-responsive">
                        <table class="table no-border">
                            <tbody>
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Subtotal</h6>
                                    </td>
                                    <td class="cart_total_amount">
<<<<<<< HEAD
                                        <h4 class="text-brand text-end" id="subtotal"></h4>
=======
                                        <h4 class="text-brand text-end">$12.31</h4>
>>>>>>> 91712fd608f8f4d68cb26fc9014da2928418a1fc
                                    </td>
                                </tr>
                                <tr>
                                    <td scope="col" colspan="2">
                                        <div class="divider-2 mt-10 mb-10" style="background-color: #3bb77e;!important"></div>
                                    </td>
                                </tr>
                               
                                <tr>
                                    <td class="cart_total_label">
                                        <h6 class="text-muted">Total</h6>
                                    </td>
                                    <td class="cart_total_amount">
<<<<<<< HEAD
                                        <h4 class="text-brand text-end" id="total"></h4>
=======
                                        <h4 class="text-brand text-end">$12.31</h4>
>>>>>>> 91712fd608f8f4d68cb26fc9014da2928418a1fc
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
<<<<<<< HEAD
                    <a href="{{ url('orders') }}" class="btn mb-20 w-100" id="btn_checkout">Checkout<i class="fi-rs-sign-out ml-15"></i></a>
=======
                    <a href="#" class="btn mb-20 w-100">Checkout<i class="fi-rs-sign-out ml-15"></i></a>
>>>>>>> 91712fd608f8f4d68cb26fc9014da2928418a1fc
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
<<<<<<< HEAD
    const hostName = window.location.origin,
    pecah = window.location.pathname.split("/");
    var base_url;
    base_url = "http://localhost" == hostName ? hostName + "/" + pecah[1] + "/" : hostName + "/";
    $(document).ready(function() {
        listProduk();
    });

    function listProduk()
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:"POST",
            url: '{{ route("list-produk") }}',
            data: {id:1},
            // beforeSend: function() {
            //     // preventLeaving();
            //     // $('#preloader-active').show();
            // },
            success:function(response){
                // $('#preloader-active').hide();
                var template = '';
                let obj = response;
                var total = 0;
                var subtotal = 0;

                var total2 = 0;
                var subtotal2 = 0;
                console.log(obj)
                if(obj.data.produk.length > 0){
                    for (var i = 0; i < obj.data.produk.length; i++) {
                        let rowData = obj.data.produk[i];
                        var harga = helpCurrency2(rowData['price'], 'Rp ');
                        subtotal = rowData['price'] * rowData['qty'];
                        total += subtotal;
                        if (rowData['is_checked'] == 1) {
                            subtotal2 = rowData['price'] * rowData['qty'];
                            total2 += subtotal2;
                        }
                        
                        var total_amount = helpCurrency2(total, 'Rp ');
                        var total_amount2 = helpCurrency2(total2, 'Rp ');
                        subtotal = helpCurrency2(subtotal, 'Rp ');
                        var checkbox = "checkbox_"+i;
                        var no = i + 1;
                        var id_checkbox = "exampleCheckbox"+rowData['id_basket'];

                        var img =  base_url+'storage/'+rowData['gambar'];
                        var imgZonk = base_url+'frontend/assets/imgs/shop/product-1-2.jpg';
                        var name_qty = 'qty_'+rowData['id_basket'];

                        var is_checked = '';
                        if (rowData['is_checked'] == 1) {
                            is_checked = 'checked';
                        }else{
                            is_checked = '';
                        }
                        template += `
                            <tr class="pt-30">
                                <td class="custome-checkbox pl-30">
                                    <input class="form-check-input cek_shop" type="checkbox" name="${checkbox}" data-id="${rowData['id_basket']}" data-produk="${rowData['product_id']}" id="${id_checkbox}" value="" ${is_checked} }}>
                                    <label class="form-check-label" for="${id_checkbox}"></label>
                                </td>
                                <td class="image product-thumbnail pt-40"><img src="${rowData['gambar'] ? img : imgZonk}" alt="#"></td>
                                <td class="product-des product-name">
                                    <h6 class="mb-5"><a class="product-name mb-10 text-heading" href="shop-product-right.html">${rowData['name']}</a></h6>
                                    <p class="d-block mb-0 sold-by">
                                        <small>
                                            <span>Toko :</span> <a href="https://nest.botble.com/stores/young-shop">${rowData['nama_toko']}</a>
                                        </small>
                                    </p>
                                    <div class="product-rate-cover">
                                        <div class="product-rate d-inline-block">
                                            <div class="product-rating" style="width:90%">
                                            </div>
                                        </div>
                                        <span class="font-small ml-5 text-muted"> (4.0)</span>
                                    </div>
                                </td>
                                <td class="price" data-title="Price">
                                    <h4 class="text-body">${harga}</h4>
                                </td>
                                <td class="text-center detail-info" data-title="Stock">
                                    <div class="detail-extralink">
                                      
                                            <input type="number" name="${name_qty}" data-id="${rowData['id_basket']}" class="form-control cart-plus-minus-box qty-val qty-input" id="product-quantity" min="1" value="${rowData['qty']}">
                                      
                                    </div>
                                </td>
                                <td class="price" data-title="Price">
                                    <h4 class="text-brand">${subtotal}</h4>
                                </td>
                                <td class="action text-center" data-title="Remove"><a href="#" onclick='hapus("${rowData['id_basket']}")' class=" btn-icon btn-sm btn-danger"><i class="fi-rs-trash"></i></a></td>
                            </tr>
                        `;
                        
                    }
                }else{
                    template = `<tr class="pt-30">
                                    <td class="custome-checkbox pl-30" colspan="6" align="center">
                                        <h4>Keranjangmu masih kosong</h4> 
                                    </td>
                                </tr>`;
                }
                $('#list_product').html(template);
                if (total == 0) {
                    total_amount = '';
                    $("#btn_checkout").addClass("disabled");
                }else{
                    $("#btn_checkout").removeClass("disabled");
                }
                $('#subtotal').html(total_amount2);
                $('#total').html(total_amount2);
            },
            error: function(response) {
            
            }
        });
    }

    function hapus(id)
    {
        Swal.fire({
            title: 'Hapus barang ?',
            text: "Barang akan dikeluarkan dari keranjangmu..",
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
                url: '{{ url("carts/delete-list-cart") }}',
                data: {id:id},
                dataType: "json",
                beforeSend: function() {
                    // $('#preloader-active').show();
                },
                success:function(response){
                    // $('#preloader-active').hide();
                    if (response.code == 200) {
                        listProduk();
                        toastr.success(response.data.message)
                    }else{
                        listProduk();
                        toastr.error(response.data.message)
                    }
                    

                },
                error: function(response) {
                
                }
            });
        }
        })
    }

    $(document).on('change', '#product-quantity', function(){
        var value = $(this).val();
        var id = $(this).data("id");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:"POST",
            url: '{{ url("carts/edit-qty-cart") }}',
            data: {
                    id:id, 
                    qty:value
                },
            dataType: "json",
            beforeSend: function() {
                $('#preloader-active').show();
            },
            success:function(response){
                $('#preloader-active').hide();
                if (response.code == 200) {
                    listProduk();
                    toastr.success(response.data.message)
                }else{
                    listProduk();
                    toastr.error(response.data.message)
                }
                

            },
            error: function(response) {
            
            }
        });

    });

    $(document).on('change', '.cek_shop', function(){
        var id = $(this).data("id");
        var produk = $(this).data("produk");
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            type:"POST",
            url: '{{ url("carts/cek-shop") }}',
            data: {
                    id:id,
                    id_produk: produk
                },
            dataType: "json",
            beforeSend: function() {
                $('#preloader-active').show();
            },
            success:function(response){
                $('#preloader-active').hide();
                if (response.code == 200) {
                    listProduk();
                    toastr.success(response.data.message)
                }else{
                    listProduk();
                    toastr.error(response.data.message)
                }
                

            },
            error: function(response) {
            
            }
        });

    });

</script>
@endpush
=======
    $(document).ready(function() {
        console.log( "ready!" );
    });
</script>
>>>>>>> 91712fd608f8f4d68cb26fc9014da2928418a1fc