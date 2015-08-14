<div class="col-md-{{ $columns == 2 ? 6 : 4 }} col-sm-6 wow zoomIn" data-wow-delay="0.1s">
    <div class="hotel_container">
        <div class="img_container">
            <a href="{{ route('events.show', explode('$', $event['productId'])[0]) }}">
                <img src="{{ $event['productImage'] }}" class="img-responsive" alt="">
                @if ($event['starRating'] > 4.5)<div class="ribbon top_rated"></div>@endif
                <div class="short_info">
                    {{ $event['productClassifications'][0] }}<span class="price"><sup>AUD $</sup>{{ (int)$event['rateFrom'] }}</span>
                </div>
            </a>
        </div>
        <div class="hotel_title">
            <h3><strong>{{ $event['productName'] }}</strong></h3>
        </div>
    </div><!-- End box event -->
</div><!-- End col-md-4 -->