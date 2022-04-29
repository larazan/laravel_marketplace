<div class="row">
	@forelse ($products as $product)
		@include('frontend.products.list_box')
	@empty
		No product found!
	@endforelse
</div>