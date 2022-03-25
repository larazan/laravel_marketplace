@extends('backend.layout')

@section('content')

<section class="content-main">
    <div class="row">
        <div class="col-9">
            <div class="content-header">
                <h2 class="content-title">Add New Product</h2>
                <div>
                    <button class="btn btn-light rounded font-sm mr-5 text-body hover-up">Save to draft</button>
                    <button class="btn btn-md rounded font-sm hover-up">Publich</button>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-4">
                        <label for="product_title" class="form-label">Product title</label>
                        <input type="text" placeholder="Type here" class="form-control" id="product_title" />
                    </div>
                    <div class="row gx-3">
                        <div class="col-md-4 mb-3">
                            <label for="product_sku" class="form-label">SKU</label>
                            <input type="text" placeholder="Type here" class="form-control" id="product_sku" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="product_color" class="form-label">Color</label>
                            <input type="text" placeholder="Type here" class="form-control" id="product_color" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="product_size" class="form-label">Size</label>
                            <input type="text" placeholder="Type here" class="form-control" id="product_size" />
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="product_brand" class="form-label">Brand</label>
                        <input type="text" placeholder="Type here" class="form-control" id="product_brand" />
                    </div>
                </div>
            </div>
            <!-- card end// -->
            <div class="card mb-4">
                <div class="card-body">
                    <div>
                        <label class="form-label">Description</label>
                        <textarea placeholder="Type here" class="form-control" rows="4"></textarea>
                    </div>
                </div>
            </div>
            <!-- card end// -->
            <div class="card mb-4">
                <div class="card-body">
                    <div>
                        <label class="form-label">Images</label>
                        <input class="form-control" type="file" />
                    </div>
                </div>
            </div>
            <!-- card end// -->
        </div>
        <div class="col-lg-3">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="mb-4">
                        <label class="form-label">Price</label>
                        <input type="text" placeholder="Type here" class="form-control" />
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Status</label>
                        <select class="form-select">
                            <option>Published</option>
                            <option>Draft</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Tags</label>
                        <input type="text" placeholder="Type here" class="form-control" />
                    </div>
                    <a href="#" class="font-xs hover-up mr-15"><i class="font-xs material-icons md-close text-body"></i> Tech</a>
                    <a href="#" class="font-xs hover-up mr-15"><i class="font-xs material-icons md-close text-body"></i> Mobile</a>
                    <a href="#" class="font-xs hover-up mr-15"><i class="font-xs material-icons md-close text-body"></i> Apple</a>
                    <hr />
                    <h5 class="mb-3">Categories</h5>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="product-cat" />
                        <label class="form-check-label" for="product-cat"> Shirt </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="product-cat-1" />
                        <label class="form-check-label" for="product-cat-1"> T-Shirt </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="product-cat-2" />
                        <label class="form-check-label" for="product-cat-2"> Sneakers </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="product-cat-3" />
                        <label class="form-check-label" for="product-cat-3"> Joggers </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="product-cat-4" />
                        <label class="form-check-label" for="product-cat-4"> Vests </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="product-cat-5" />
                        <label class="form-check-label" for="product-cat-5"> Knitwear </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="" id="product-cat-8" />
                        <label class="form-check-label" for="product-cat-8"> Shorts </label>
                    </div>
                </div>
            </div>
            <!-- card end// -->
        </div>
    </div>
</section>

@endsection