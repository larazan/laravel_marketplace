@extends('frontend.layout')

@section('content')
<main class="main">
            <div class="page-header breadcrumb-wrap">
                <div class="container">
                    <div class="breadcrumb">
                        <a href="index.html" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                        <span></span> Shop <span></span> Compare
                    </div>
                </div>
            </div>
            <div class="container mb-80 mt-50">
                <div class="row">
                    <div class="col-xl-10 col-lg-12 m-auto">
                        <h1 class="heading-2 mb-10">Products Compare</h1>
                        <h6 class="text-body mb-40">There are <span class="text-brand">3</span> products to compare</h6>
                        <div class="table-responsive">
                            <table class="table text-center table-compare">
                                <tbody>
                                    <tr class="pr_image">
                                        <td class="text-muted font-sm fw-600 font-heading mw-200">Preview</td>
                                        <td class="row_img"><img src="assets/imgs/shop/product-2-1.jpg" alt="compare-img" /></td>
                                        <td class="row_img"><img src="assets/imgs/shop/product-1-1.jpg" alt="compare-img" /></td>
                                        <td class="row_img"><img src="assets/imgs/shop/product-3-1.jpg" alt="compare-img" /></td>
                                    </tr>
                                    <tr class="pr_title">
                                        <td class="text-muted font-sm fw-600 font-heading">Name</td>
                                        <td class="product_name">
                                            <h6><a href="shop-product-full.html" class="text-heading">J.Crew Mercantile Women's Short</a></h6>
                                        </td>
                                        <td class="product_name">
                                            <h6><a href="shop-product-full.html" class="text-heading">Amazon Essentials Women's Tanks</a></h6>
                                        </td>
                                        <td class="product_name">
                                            <h6><a href="shop-product-full.html" class="text-heading">Amazon Brand - Daily Ritual Wom</a></h6>
                                        </td>
                                    </tr>
                                    <tr class="pr_price">
                                        <td class="text-muted font-sm fw-600 font-heading">Price</td>
                                        <td class="product_price">
                                            <h4 class="price text-brand">$12.00</h4>
                                        </td>
                                        <td class="product_price">
                                            <h4 class="price text-brand">$14.00</h4>
                                        </td>
                                        <td class="product_price">
                                            <h4 class="price text-brand">$15.00</h4>
                                        </td>
                                    </tr>
                                    <tr class="pr_rating">
                                        <td class="text-muted font-sm fw-600 font-heading">Rating</td>
                                        <td>
                                            <div class="rating_wrap">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="rating_num">(121)</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="rating_wrap">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="rating_num">(35)</span>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="rating_wrap">
                                                <div class="product-rate d-inline-block">
                                                    <div class="product-rating" style="width: 90%"></div>
                                                </div>
                                                <span class="rating_num">(125)</span>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr class="description">
                                        <td class="text-muted font-sm fw-600 font-heading">Description</td>
                                        <td class="row_text font-xs">
                                            <p class="font-sm text-muted">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and</p>
                                        </td>
                                        <td class="row_text font-xs">
                                            <p class="font-sm text-muted">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and</p>
                                        </td>
                                        <td class="row_text font-xs">
                                            <p class="font-sm text-muted">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and</p>
                                        </td>
                                    </tr>
                                    <tr class="pr_stock">
                                        <td class="text-muted font-sm fw-600 font-heading">Stock status</td>
                                        <td class="row_stock"><span class="stock-status in-stock mb-0">In Stock</span></td>
                                        <td class="row_stock"><span class="stock-status out-stock mb-0">Out of stock</span></td>
                                        <td class="row_stock"><span class="stock-status in-stock mb-0">In Stock</span></td>
                                    </tr>
                                    <tr class="pr_weight">
                                        <td class="text-muted font-sm fw-600 font-heading">Weight</td>
                                        <td class="row_weight">320 gram</td>
                                        <td class="row_weight">370 gram</td>
                                        <td class="row_weight">380 gram</td>
                                    </tr>
                                    <tr class="pr_dimensions">
                                        <td class="text-muted font-sm fw-600 font-heading">Dimensions</td>
                                        <td class="row_dimensions">N/A</td>
                                        <td class="row_dimensions">N/A</td>
                                        <td class="row_dimensions">N/A</td>
                                    </tr>
                                    <tr class="pr_add_to_cart">
                                        <td class="text-muted font-sm fw-600 font-heading">Buy now</td>
                                        <td class="row_btn">
                                            <button class="btn btn-sm"><i class="fi-rs-shopping-bag mr-5"></i>Add to cart</button>
                                        </td>
                                        <td class="row_btn">
                                            <button class="btn btn-sm btn-secondary"><i class="fi-rs-headset mr-5"></i>Contact Us</button>
                                        </td>
                                        <td class="row_btn">
                                            <button class="btn btn-sm"><i class="fi-rs-shopping-bag mr-5"></i>Add to cart</button>
                                        </td>
                                    </tr>
                                    <tr class="pr_remove text-muted">
                                        <td class="text-muted font-md fw-600"></td>
                                        <td class="row_remove">
                                            <a href="#" class="text-muted"><i class="fi-rs-trash mr-5"></i><span>Remove</span> </a>
                                        </td>
                                        <td class="row_remove">
                                            <a href="#" class="text-muted"><i class="fi-rs-trash mr-5"></i><span>Remove</span> </a>
                                        </td>
                                        <td class="row_remove">
                                            <a href="#" class="text-muted"><i class="fi-rs-trash mr-5"></i><span>Remove</span> </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        @endsection