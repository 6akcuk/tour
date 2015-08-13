<div class="col-md-{{ $columns == 2 ? 6 : 4 }} col-sm-6 wow zoomIn" data-wow-delay="0.1s">
    <div class="hotel_container">
        <div class="img_container">
            <a href="{{ route('attractions.show', explode('$', $attraction['productId'])[0]) }}">
                <img src="{{ $attraction['productImage'] }}" class="img-responsive" alt="">
                @if ($attraction['starRating'] > 4.5)<div class="ribbon top_rated"></div>@endif
                <div class="short_info">
                    {{ $attraction['productClassifications'][0] }}<span class="price"><sup>AUD $</sup>{{ (int)$attraction['rateFrom'] }}</span>
                </div>
            </a>
        </div>
        <div class="hotel_title">
            <h3><strong>{{ $attraction['productName'] }}</strong></h3>
            <div class="rating">
                @include('layouts.partials.rating', ['rating' => $attraction['starRating']])
            </div><!-- end rating -->
        </div>
    </div><!-- End box attraction -->
</div><!-- End col-md-4 -->