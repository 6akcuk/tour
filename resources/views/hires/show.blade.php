@extends('layouts.product')

@section('title', $model->getName())

@if ($model->getParallaxImage())
    @section('main_bg', $model->getParallaxImage())
@endif

@section('parallax_content')
    <div class="row">
        <div class="col-md-8 col-sm-8">
            <span class="rating">
                @include('layouts.partials.rating', ['rating' => $model->getRating()])
            </span>
            <h1>{{ $model->getName() }}</h1>
            <span>{{ $model->getAddress() }}</span>
        </div>
        <div class="col-md-4 col-sm-4">
            <div id="price_single_main" class="hotel">
                from/per person <span><sup>$</sup>{{ $model->getRateFrom() }}</span>
            </div>
        </div>
    </div>
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('hires.index') }}">Hires</a></li>
    <li>{{ $model->getName() }}</li>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8" id="single_tour_desc">
            @include('layouts.partials.product_features')

            <p class="visible-sm visible-xs"><a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap">View on map</a></p><!-- Map button for tablets/mobiles -->
            @if (sizeof($model->getImages()))
                @include('layouts.partials.images_carousel')
            @endif

            <hr>

            <div class="row">
                <div class="col-md-3">
                    <h3>Description</h3>
                </div>
                <div class="col-md-9">
                    {!! nl2br($model->getDescription()) !!}

                    @if ($model->getServiceFacilities())
                        <h4>Facilities</h4>
                        @include('layouts.partials.facilities', ['facilities' => $model->getServiceFacilities()])
                    @endif
                </div><!-- End col-md-9  -->
            </div><!-- End row  -->

            <hr>

            <div class="row">
                <div class="col-md-3">
                    <h3>Services</h3>
                </div>
                <div class="col-md-9">
                    @foreach ($model->getServices() as $service)
                        <h4>{{ $service['serviceName'] }}</h4>
                        <p>
                            {!! nl2br($service['serviceDescription']) !!}
                        </p>

                        <hr>

                        <?php $helper = new \App\Jobs\ProductService(new \App\Jobs\ATLASService(), $service) ?>
                        @if ($helper->getServiceFacilities())
                            @include('layouts.partials.facilities', ['facilities' => $helper->getServiceFacilities()])
                        @endif

                        @if ($helper->getImages())
                            @include('layouts.partials.images_service_carousel')
                        @endif
                    @endforeach
                </div><!-- End col-md-9  -->
            </div><!-- End row  -->
        </div>

        <aside class="col-md-4">
            <p class="hidden-sm hidden-xs">
                <a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap">View on map</a>
            </p>

            <div class="box_style_4">
                <i class="icon_set_1_icon-90"></i>
                <h4><span>Book</span> by phone</h4>
                <a href="tel://{{ str_replace(' ', '', $model->getTelephone()) }}" class="phone">
                    +{{ $model->getTelephone() }}
                </a>
                <small>Monday to Friday 9.00am - 7.30pm</small>
            </div>

        </aside>
    </div>
@endsection

@section('header_css')
    <link href="css/slider-pro.min.css" rel="stylesheet">
    <link href="css/owl.carousel.css" rel="stylesheet">
    <link href="css/owl.theme.css" rel="stylesheet">
@endsection

@section('footer_javascript')
    <?php $coord = $model->getCoordinates() ?>

    @include('layouts.partials.show_js', [
        'zoom' => 12,
        'lat' => $coord['lat'],
        'long' => $coord['long'],
        'marker' => 'Walking',
        'products' => $nearest['products'],
        'route' => 'hires.show'
    ])
@endsection