    @php
        $rating = 3;
    @endphp
    
    <!--Comments-->
    <div class="">
        <button class="btn btn-xs" id="review-button">Tambah Review</button>
    </div>

     <!--comment form-->
     <div class="comment-form" id="review-box">
        <h4 class="mb-15">Add a review</h4>
        

        
        
        <div class="row">
            <div class="col-lg-8 col-md-12">
                <form class="form-contact comment_form" id="commentForm">
                    {{ Form::hidden('product_id', $product->id) }}
                    <div class="row">
                        <div class="col-12">
                        <div class="rate">
                    <input type="radio" id="star5" class="rate" name="rating" value="5"/>
                    <label for="star5" title="text">5 stars</label>
                    <input type="radio" checked id="star4" class="rate" name="rating" value="4"/>
                    <label for="star4" title="text">4 stars</label>
                    <input type="radio" id="star3" class="rate" name="rating" value="3"/>
                    <label for="star3" title="text">3 stars</label>
                    <input type="radio" id="star2" class="rate" name="rating" value="2">
                    <label for="star2" title="text">2 stars</label>
                    <input type="radio" id="star1" class="rate" name="rating" value="1"/>
                    <label for="star1" title="text">1 star</label>
                    </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <textarea class="form-control w-100" name="review" id="review" cols="30" rows="9" placeholder="Write Comment"></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="button" class="button button-contactForm" onclick="createReview()">Submit Review</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="comments-area">
        <div class="row">
            <div class="col-lg-8">
                <h4 class="mb-30">Customer questions &amp; answers</h4>
                <div class="comment-list">
                    @forelse ($reviews as $review)
                    @php
                        $rate = $review->rate / 5 * 100
                    @endphp
                    <div class="single-comment justify-content-between d-flex mb-30">
                        <div class="user justify-content-between d-flex">
                            <div class="thumb text-center">
                                <img src="{{ Avatar::create($review->user_info->first_name.' '.$review->user_info->last_name)->toBase64() }}" alt="">
                                <a href="#" class="font-heading text-brand">{{ $review->user_info->first_name }}</a>
                            </div>
                            <div class="desc">
                                <div class="d-flex justify-content-between mb-10">
                                    <div class="d-flex align-items-center">
                                        <span class="font-xs text-muted">{{ $review->created_at }} </span>
                                    </div>
                                    <div class="product-rate d-inline-block">
                                        <div class="product-rating" style="width: {{{ $rate }}}%"></div>
                                    </div>
                                </div>
                                <p class="mb-10">
                                    {{ $review->review }}
                                    <a href="#" class="reply">Reply</a>
                                </p>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div>
                        <p>no review yet</p>
                    </div>
                    @endforelse
                    
                </div>
            </div>
            <!-- <div class="col-lg-4">
                <h4 class="mb-30">Customer reviews</h4>
                <div class="d-flex mb-30">
                    <div class="product-rate d-inline-block mr-15">
                        <div class="product-rating" style="width: 90%"></div>
                    </div>
                    <h6>4.8 out of 5</h6>
                </div>
                <div class="progress">
                    <span>5 star</span>
                    <div class="progress-bar" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                </div>
                <div class="progress">
                    <span>4 star</span>
                    <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">25%</div>
                </div>
                <div class="progress">
                    <span>3 star</span>
                    <div class="progress-bar" role="progressbar" style="width: 45%" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100">45%</div>
                </div>
                <div class="progress">
                    <span>2 star</span>
                    <div class="progress-bar" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100">65%</div>
                </div>
                <div class="progress mb-30">
                    <span>1 star</span>
                    <div class="progress-bar" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100">85%</div>
                </div>
                <a href="#" class="font-xs text-muted">How are ratings calculated?</a>
            </div> -->
        </div>
    </div>
   

@push('style')
<style>
.rate {
         float: left;
         height: 46px;
         padding: 0 10px;
         }
         .rate:not(:checked) > input {
         position:absolute;
         display: none;
         }
         .rate:not(:checked) > label {
         float:right;
         width:1em;
         overflow:hidden;
         white-space:nowrap;
         cursor:pointer;
         font-size:30px;
         color:#ccc;
         }
         .rate:not(:checked) > label:before {
         content: '★ ';
         }
         .rate > input:checked ~ label {
         color: #ffc700;
         }
         .rate:not(:checked) > label:hover,
         .rate:not(:checked) > label:hover ~ label {
         color: #deb217;
         }
         .rate > input:checked + label:hover,
         .rate > input:checked + label:hover ~ label,
         .rate > input:checked ~ label:hover,
         .rate > input:checked ~ label:hover ~ label,
         .rate > label:hover ~ input:checked ~ label {
         color: #c59b08;
         }
</style>
@endpush