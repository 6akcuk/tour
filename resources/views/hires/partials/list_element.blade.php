<div class="strip_all_tour_list fadeIn animated" data-wow-delay="0.1s">
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-4">
            <div class="img_list">
                <a href="{{ route('hires.show', explode('$', $hire['productId'])[0]) }}">
                    <img src="{{ $hire['productImage'] }}">
                    <div class="short_info"></div>
                </a>
            </div>
        </div>
        <div class="clearfix visible-xs-block"></div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="tour_list_desc">
                <h3>{{ $hire['productName'] }}</h3>
                <p>
                    {{ substr($hire['productDescription'], 0, 100) .'...' }}
                </p>
            </div>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2">
            <div class="price_list">
                <div>
                    <sup>$</sup>
                    {{ (int)$hire['rateFrom'] }}*
                    <span class="normal_price_list"></span>
                    <small>*From/Per night</small>
                    <p>
                        <a href="{{ route('hires.show', explode('$', $hire['productId'])[0]) }}" class="btn_1">Details</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>