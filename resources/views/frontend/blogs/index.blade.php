@extends('frontend.layout')

@section('content')
<main class="main">
<div class="page-header breadcrumb-wrap">
            <div class="container">
                <div class="breadcrumb">
                @if ($breadcrumbs_data['current_page_title'] != '')
                    @foreach ($breadcrumbs_data['breadcrumbs_array'] as $key => $value)
                    <!-- <li><a href="{{ $key }}">{{ $value }}</a></li> -->
                    <a href="{{ $key }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>{{ $value }}</a>
                    <span></span> {{ $value }}
                    @endforeach
                    <span></span> {{ $breadcrumbs_data['current_page_title'] }}
                @else 
                    @foreach ($breadcrumbs_data['breadcrumbs_array'] as $key => $value)
                        @if ($value == 'Home')
                        <a href="{{ $key }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>{{ $value }}</a>
                        @else
                        <span></span> {{ $value }}
                        @endif
                    @endforeach
                @endif
                   
                </div>
            </div>
        </div>
            <div class="page-content mb-50">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9">
                           
                            <div class="loop-grid pr-30">
                                <div class="row">
                                @foreach ($articles as $post)
                                    <article class="col-xl-4 col-lg-6 col-md-6 text-center hover-up mb-30 animated">
                                        <div class="post-thumb">
                                            <a href="{{ url('blog/'. $post->slug) }}">
                                                <img class="border-radius-15" src="{{ asset('storage/'.$post->featured_img) }}" alt="" />
                                            </a>
                                            <div class="entry-meta">
                                                <a class="entry-meta meta-2" href="blog-category-grid.html"><i class="fi-rs-heart"></i></a>
                                            </div>
                                        </div>
                                        <div class="entry-content-2">
                                            
                                            <h4 class="post-title mb-15">
                                                <a href="{{ url('blog/'. $post->slug) }}">{{ $post->title }}</a>
                                            </h4>
                                            <h6 class="mb-10 font-sm"><a class="entry-meta text-muted" href="blog-category-grid.html">{{ substr($post->body, 0, 120) }}...</a></h6>
                                            <div class="entry-meta font-xs color-grey mt-10 pb-10">
                                                <div>
                                                    <span class="post-on mr-10">{{ date('M j, Y', strtotime($post->created_at)) }}</span>
                                                    
                                                    <span class="hit-count has-dot">4 mins read</span>
                                                    <span class="hit-count has-dot mr-10">Admin</span>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                    @endforeach
                                </div>
                            </div>
                            <div class="pagination-area mt-15 mb-sm-5 mb-lg-0">
                                <nav aria-label="Page navigation example">
                                {{ $articles->links() }}
                                    <!-- <ul class="pagination justify-content-start">
                                        <li class="page-item">
                                            <a class="page-link" href="#"><i class="fi-rs-arrow-small-left"></i></a>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item active"><a class="page-link" href="#">2</a></li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item"><a class="page-link dot" href="#">...</a></li>
                                        <li class="page-item"><a class="page-link" href="#">6</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#"><i class="fi-rs-arrow-small-right"></i></a>
                                        </li>
                                    </ul> -->
                                </nav>
                            </div>
                        </div>
                        @include('frontend.blogs.sidebar')
                    </div>
                </div>
            </div>
        </main>
        @endsection