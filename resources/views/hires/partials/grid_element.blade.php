<div class="col-md-{{ $columns == 2 ? 6 : 4 }} col-sm-6 wow zoomIn" data-wow-delay="0.1s">
    <div class="hotel_container">
        <div class="img_container">
            <a href="{{ route('hires.show', explode('$', $hire['productId'])[0]) }}">
                <img src="{{ $hire['productImage'] }}" class="img-responsive" alt="">
                @if ($hire['starRating'] > 4.5)<div class="ribbon top_rated"></div>@endif
                <div class="short_info">
                    {{ $hire['productClassifications'][0] }}<span class="price"><sup>AUD $</sup>{{ (int)$hire['rateFrom'] }}</span>
                </div>
            </a>
        </div>
        <div class="hotel_title">
            <h3><strong>{{ $hire['productName'] }}</strong></h3>
            <div class="rating">
                @include('layouts.partials.rating', ['rating' => $hire['starRating']])
            </div><!-- end rating -->
        </div>
    </div><!-- End box hire -->
</div><!-- End col-md-4 -->