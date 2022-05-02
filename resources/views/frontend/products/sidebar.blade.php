<div class="col-lg-1-5 primary-sidebar sticky-sidebar">
    @if ($categories)
        <div class="sidebar-widget widget-category-2 mb-30">
            <h5 class="section-title style-1 mb-30">Kategori</h5>
            <ul id="list-kategori">
                <form onsubmit="return false" class="" id="form_kategori">
                    @foreach ($categories as $category)
                        <input class="form-check-input" type="checkbox" name="kategori[]"
                        id="kategori-{{ $category->id }}"
                        value="{{ $category->id }}" onchange="resetPage()" />
                        <label class="form-check-label" for="kategori-{{ $category->id }}"><span>{{ $category->name }}</span></label>
                        <br />
                    @endforeach
                </form>
            </ul>
        </div>
    @endif
    <!-- Fillter By Price -->
    <div class="sidebar-widget price_range range mb-30">
        <h5 class="section-title style-1 mb-30">Batasi Harga</h5>
        <div class="list-group">
            <div class="list-group-item mb-10 mt-10">
               <form>
                   <div class="col-md-12">
                        <label>Minimal</label>
                        <input id="pmin" name="min" class="form-control" placeholder="Rp xx.xxx" type="text" value="">
                   </div>
                   <div class="col-md-12">
                        <label>Maximal</label>
                        <input id="pmax" name="max" class="form-control" placeholder="Rp xx.xxx" type="text" value="">
                    </div>
                    <small id="text_warning" style="color:red; display:none;">Harga maksimum harus lebih
                        besar dari harga minimum </small>
               </form>
            </div>
        </div>
        <button id="btn_reset" type="button" style="display: none;margin-top: 5px;" class="btn btn-sm btn-default"><i class="fi-rs-filter mr-5"></i> Hapus Filter</button>
    </div>

</div>