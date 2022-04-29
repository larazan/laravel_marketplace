<div class="row">
    @forelse ($products as $product)
        @include('frontend.products.grid_box')
    @empty
        No product found!
    @endforelse
</div>