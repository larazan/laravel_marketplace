<div class="row">
    @forelse ($shops as $shop)
        @include('frontend.vendors.grid_box')
    @empty
        No vendor found!
    @endforelse
</div>