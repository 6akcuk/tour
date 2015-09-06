<div class="col-md-{{ $columns == 2 ? 6 : 4 }} col-sm-6 zoomIn" data-wow-delay="0.1s">
    <div class="hotel_container">
        <div class="img_container">
            <a href="{{ route('attractions.show', explode('$', $attraction['productId'])[0]) }}">
                <img src="{{ $attraction['productImage'] }}" class="img-responsive" alt="">
                @if ($attraction['starRating'] > 4.5)<div class="ribbon top_rated"></div>@endif
            </a>
        </div>
        <div class="hotel_title">
            <h3><strong>{{ $attraction['productName'] }}</strong></h3>
            <div class="rating clearfix">
                @if ($attraction['optin'])
                <div class="pull-left">
                    <span class="booking-available">
                        Available <small>for booking</small>
                    </span>
                </div>
                @endif
            </div><!-- end rating -->
        </div>
    </div><!-- End box attraction -->
</div><!-- End col-md-4 -->