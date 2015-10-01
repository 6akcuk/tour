@extends('layouts.product')

@section('title', $model->getName())

@if ($model->getParallaxImage())
    @section('main_bg', $model->getParallaxImage())
@else
    @section('main_bg', 'img/backgrounds/Events-min-blur.jpg')
@endif

@section('parallax_content')
    <div class="row">
        <div class="col-md-8 col-sm-8">
            <h1>{{ $model->getName() }}</h1>
            <span>{{ $model->getAddress() }}</span>
        </div>
        <div class="col-md-4 col-sm-4">
            <div id="price_single_main" class="hotel">
                @if ($model->isFree())
                    <span>FREE</span>
                @else
                    from/per person <span><sup>$</sup>{{ $model->getRateFrom() }}</span>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('breadcrumbs')
    <li><a href="{{ route('events.index') }}">Events</a></li>
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
                    <h3>Schedule</h3>
                </div>
                <div class="col-md-9">
                    @if (in_array($model->getFrequencyId(), ['ONCE ONLY', 'ANNUAL', 'DAILY']))
                        <?php
                            $start = \Carbon\Carbon::parse($model->getFrequencyStart());
                            $end = \Carbon\Carbon::parse($model->getFrequencyEnd());
                            $step = clone $start;
                            $openTimes = $model->getOpenTimes();
                        ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th colspan="2">
                                    {{ ucfirst(strtolower($model->getFrequencyId())) }}
                                    {{ $start->formatLocalized('%d %B %Y') }}
                                    to
                                    {{ $end->formatLocalized('%d %B %Y') }}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @for($i = 1; $i <= min(7, $end->diffInDays($start)) + 1; $i++)
                                <tr>
                                    <td>{{ $step->formatLocalized('%A') }}</td>
                                    <td>{{ isset($openTimes[0]) && isset($openTimes[0]['openTimeText']) ? $openTimes[0]['openTimeText'] : '' }}</td>
                                </tr>
                                <?php $step->addDay(); ?>
                            @endfor
                            </tbody>
                        </table>
                    </div>
                    @elseif (in_array($model->getFrequencyId(), ['MONTHLY', 'WEEKLY']))
                        <?php
                        $start = \Carbon\Carbon::parse($model->getFrequencyStart());
                        $end = \Carbon\Carbon::parse($model->getFrequencyEnd());
                        $step = $start;
                        $openTimes = $model->getOpenTimes();
                        ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th colspan="2">
                                        {{ ucfirst(strtolower($model->getFrequencyId())) }}
                                        {{ $start->formatLocalized('%d %B %Y') }}
                                        to
                                        {{ $end->formatLocalized('%d %B %Y') }}
                                    </th>
                                </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $step->formatLocalized('%A') }}</td>
                                        <td>{{ isset($openTimes[0]) && isset($openTimes[0]['openTimeText']) ? $openTimes[0]['openTimeText'] : '' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                @if ($model->getServices())
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
                @endif
            </div><!-- End row  -->
        </div>

        <aside class="col-md-4">
            <p class="hidden-sm hidden-xs">
                <a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap">View on map</a>
            </p>

            @include('layouts.partials.book_form', ['type' => 'events'])

            @include('layouts.partials.book_phone')

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
        'route' => 'events.show'
    ])
@endsection