@if ($slides)
<section class="home-slider position-relative mb-30">
    <div class="container">
        <div class="home-slide-cover mt-30">
            <div class="hero-slider-1 style-4 dot-style-1 dot-style-1-position-1">
                @foreach ($slides as $slide)
                <div class="single-hero-slider single-animation-wrap" style="background-image: url({{ asset('storage/'. $slide->extra_large) }})">
                    <div class="slider-content">
                        <h1 class="display-2 mb-40">
                        {!! $slide->title !!}
                        </h1>
                        <p class="mb-65">{{ $slide->body }}</p>
                        @if($slide->url)
                        <form class="form-subcriber d-flex">
                            <input type="email" placeholder="Your emaill address" />
                            <button class="btn" type="submit">Subscribe</button>
                        </form>
                        @endif
                    </div>
                </div>
                @endforeach
                <div class="single-hero-slider single-animation-wrap" style="background-image: url({{ asset('frontend/assets/imgs/slider/slider-8.png') }})">
                    <div class="slider-content">
                        <h1 class="display-2 mb-40">
                            Fresh Vegetables<br />
                            Big discount
                        </h1>
                        <p class="mb-65">Save up to 50% off on your first order</p>
                        <form class="form-subcriber d-flex">
                            <input type="email" placeholder="Your emaill address" />
                            <button class="btn" type="submit">Subscribe</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="slider-arrow hero-slider-1-arrow"></div>
        </div>
    </div>
</section>
@endif