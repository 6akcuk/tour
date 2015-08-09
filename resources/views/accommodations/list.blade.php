@extends('accommodations.search_layout')

@section('breadcrumbs')
    <li>Accommodations</li>
@endsection

@section('search_content')
    @foreach ($accommodations['products'] as $acc)
    <div class="strip_all_tour_list wow fadeIn animated" data-wow-delay="0.1s">
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4">
                <div class="img_list">
                    <img src="{{ $acc['productImage'] }}">
                    <div class="short_info"></div>
                </div>
            </div>
            <div class="clearfix visible-xs-block"></div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="tour_list_desc">
                    <div class="rating">
                        @include('layouts.partials.rating', ['rating' => $acc['starRating']])
                    </div>
                    <h3>{{ $acc['productName'] }}</h3>
                    <p>
                        {{ substr($acc['productDescription'], 0, 100) .'...' }}
                    </p>
                </div>
            </div>
            <div class="col-lg-2 col-md-2 col-sm-2">
                <div class="price_list">
                    <div>
                        <sup>$</sup>
                        {{ (int)$acc['rateFrom'] }}*
                        <span class="normal_price_list"></span>
                        <small>*From/Per night</small>
                        <p>
                            <a class="btn_1">Details</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <hr>

    <div class="text-center">
        {!! $paginator->render() !!}
    </div>
@endsection