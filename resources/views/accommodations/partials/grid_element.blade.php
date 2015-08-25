<div class="col-md-{{ $columns == 2 ? 6 : 4 }} col-sm-6 wow zoomIn" data-wow-delay="0.1s">
    <div class="hotel_container">
        <div class="img_container">
            <a href="{{ route('accommodation.show', explode('$', $acc['productId'])[0]) }}">
                <img src="{{ $acc['productImage'] }}" class="img-responsive" alt="">
                @if ($acc['starRating'] > 4.5)<div class="ribbon top_rated"></div>@endif
                <div class="short_info">
                    <i class="icon_set_1_icon-23"></i>{{ $acc['productClassifications'][0] }}<span class="price"><sup>AUD $</sup>{{ (int)$acc['rateFrom'] }}</span>
                </div>
            </a>
        </div>
        <div class="hotel_title">
            <h3><strong>{{ $acc['productName'] }}</strong></h3>
            <div class="rating">
                @include('layouts.partials.rating', ['rating' => $acc['starRating']])
            </div><!-- end rating -->
        </div>
    </div><!-- End box tour -->
</div><!-- End col-md-4 -->