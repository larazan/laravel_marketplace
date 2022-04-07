<div class="row">
    @forelse ($vendors as $vendor)
        @include('frontend.vendors.grid_box')
    @empty
        No product found!
    @endforelse
</div>