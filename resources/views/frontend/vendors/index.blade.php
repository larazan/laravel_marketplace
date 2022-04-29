@extends('frontend.layout')

@section('content')

<main class="main pages mb-80">
    <div class="page-header breadcrumb-wrap">
        <div class="container">
            <div class="breadcrumb">
            <a href="{{ url('/') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
                @foreach ($breadcrumbs_data['breadcrumbs_array'] as $key => $value)
                <span></span>  {{ $value }} 
                @endforeach
            </div>
        </div>
    </div>
    <div class="page-content pt-50">
        <div class="container">
            <div class="archive-header-2 text-center">
                <h1 class="display-2 mb-50">Vendors List</h1>
                <div class="row">
                    <div class="col-lg-5 mx-auto">
                        <div class="sidebar-widget-2 widget_search mb-50">
                            <div class="search-form">

                                <form action="{{ url('vendors') }}" method="GET">
                                    <input placeholder="I am Searching for . . ." type="text" name="q" value="{{ isset($q) ? $q : null }}">
                                    <button type="submit"><i class="fi-rs-search"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mb-50">
                <div class="col-12 col-lg-8 mx-auto">
                    <div class="shop-product-fillter">
                        <div class="totall-product">
                            <p>We have <strong class="text-brand">{{ $shops->total() }}</strong> vendors now</p>
                        </div>

                    </div>
                </div>
            </div>

            <div class="row vendor-grid">
                @include('frontend.vendors.grid_view')
            </div>

            {{ $shops->links('frontend.partials.paginator') }}

        </div>
    </div>
</main>

@endsection