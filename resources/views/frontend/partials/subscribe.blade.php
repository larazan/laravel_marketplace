<section class="newsletter mb-15">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="position-relative newsletter-inner">
                    <div class="newsletter-content">
                        <h2 class="mb-20">
                            Stay home & get your daily <br />
                            needs from our shop
                        </h2>
                        <p class="mb-45">Start You'r Daily Shopping with <span class="text-brand">Nest Mart</span></p>
                        <div id="statusSubscribe" style="display: none;"></div>
                        <form action="javascript:void(0)" class="form-subcriber d-flex">
                            <input onfocus="enableSubscriber();" onfocusout="enableSubscriber();" type="email" class="email subscriber_email" placeholder="Your emaill address" />
                            <button onclick="checkSubscriber(); addSubscriber();" value="Subscribe" name="subscribe" class="btn" type="submit">Subscribe</button>
                        </form>
                    </div>
                    <img src="{{ asset('frontend/assets/imgs/banner/banner-9.png') }}" alt="newsletter" />
                </div>
            </div>
        </div>
    </div>
</section>



@section('scripts')
<script>
    function checkSubscriber() {
        var subscriber_email = $(".subscriber_email").val();
        console.log(subscriber_email);
        $.ajax({
            type: 'post',
            url: '/check-subscriber-email',
            data: {
                subscriber_email: subscriber_email
            },
            success: function(resp) {
                if (resp == "exists") {
                    // alert("Subscriber email already exist");
                    $("#statusSubscribe").show();
                    $("#btnSubmit").hide();
                    $("#statusSubscribe").html("<span style='margin-top: 10px;'>&nbsp;</span><font color='red'>Error: Subscriber email already exists!</font>");
                }
            },
            error: function() {
                alert("Error");
            }
        })
    }

    function addSubscriber() {
        var subscriber_email = $(".subscriber_email").val();
        $.ajax({
            type: 'post',
            url: '/add-subscriber-email',
            data: {
                subscriber_email: subscriber_email
            },
            success: function(resp) {
                if (resp == "exists") {
                    // alert("Subscriber email already exist");
                    $("#statusSubscribe").show();
                    $("#statusSubscribe").html("<span style='margin-top: 10px;'>&nbsp;</span><font color='red'>Error: Subscriber email already exists!</font>");
                } else if (resp == "saved") {
                    $("#statusSubscribe").show();
                    $("#statusSubscribe").html("<span style='margin-top: 10px;''>&nbsp;</span><font color='red'>Success: Thanks for subscribing!</font>");
                }
            },
            error: function() {
                alert("Error");
            }
        })
    }

    function enableSubscriber() {
        $("#statusSubscribe").hide();
        $("#btnSubmit").show();
    }
</script>
@endsection