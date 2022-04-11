<aside class="col-lg-3 border-end">
    <nav class="nav nav-pills flex-lg-column mb-4">
        <a class="nav-link {{ ($currentForm == 'detail') ? 'active' : ''}}" aria-current="page" href="{{ url('user/products/'. $productID .'/edit') }}">Detail</a>
        <a class="nav-link {{ ($currentForm == 'image') ? 'active' : ''}}" href="{{ url('user/products/'. $productID .'/images') }}">Image</a>
    </nav>
</aside>