<div class="col-md-{{ $columns == 2 ? 6 : 4 }} col-sm-6 zoomIn" data-wow-delay="0.1s">
    <div class="hotel_container">
        <div class="img_container">
            <a href="{{ route('tours.show', explode('$', $tour['productId'])[0]) }}">
                <img src="{{ $tour['productImage'] }}" class="img-responsive" alt="">
                @if ($tour['starRating'] > 4.5)<div class="ribbon top_rated"></div>@endif
                <div class="short_info">
                    {{ $tour['productClassifications'][0] }}<span class="price"><sup>AUD $</sup>{{ (int)$tour['rateFrom'] }}</span>
                </div>
            </a>
        </div>
        <div class="hotel_title">
            <h3><strong>{{ $tour['productName'] }}</strong></h3>
            <div class="rating clearfix">
                @if ($tour['optin'])
                    <div class="pull-left">
                    <span class="booking-available">
                        Available <small>for booking</small>
                    </span>
                    </div>
                @endif
            </div><!-- end rating -->
        </div>
    </div><!-- End box tour -->
</div><!-- End col-md-4 -->