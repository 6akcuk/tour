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
            <div id="single_tour_feat">
                <ul>
                    @if ($model->hasAttribute('BAR'))
                        <li>
                            <i class="icon_set_1_icon-20"></i>
                            Bar
                        </li>
                    @endif
                    @if ($model->hasAttribute('TVLOUNGE'))
                        <li>
                            <i class="icon_set_2_icon-116"></i>
                            TV/Lounge
                        </li>
                    @endif
                    @if ($model->hasAttribute('FREEWIFI'))
                        <li>
                            <i class="icon_set_1_icon-86"></i>
                            Free Wifi
                        </li>
                    @endif
                    @if ($model->hasAttribute('POOL'))
                        <li>
                            <i class="icon_set_2_icon-110"></i>
                            Pool
                        </li>
                    @endif
                    @if ($model->hasAttribute('PETALLOW'))
                        <li>
                            <i class="icon_set_1_icon-22"></i>
                            Pet allowed
                        </li>
                    @endif
                    @if ($model->hasAttribute('DISNOASST'))
                        <li>
                            <i class="icon_set_1_icon-13"></i>
                            Accessibility
                        </li>
                    @endif
                    @if ($model->hasAttribute('CARPARK'))
                    <li>
                        <i class="icon_set_1_icon-27"></i>
                        Parking
                    </li>
                    @endif
                </ul>
            </div>
            <p class="visible-sm visible-xs"><a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap">View on map</a></p><!-- Map button for tablets/mobiles -->
            @if (sizeof($model->getImages()))
            <div id="Img_carousel" class="slider-pro">
                <div class="sp-slides">
                    @foreach ($model->getImages() as $label => $image)
                        <?php if (!is_array($image) || isset($image['YOUTUBE'])) continue; ?>
                    <div class="sp-slide">
                        <img alt="" class="sp-image" src="/css/images/blank.gif"
                             data-src="{{ isset($image['large']) ? $image['large'] : isset($image['medium']) ? $image['medium'] : '' }}"
                             {{ isset($image['medium']) ? 'data-medium='. $image['medium'] .'' : '' }}
                             {{ isset($image['large']) ? 'data-large='. $image['large'] .'' : '' }}
                             {{ isset($image['large']) ? 'data-retina='. $image['large'] .'' : '' }}">
                        <h3 class="sp-layer sp-black sp-padding" data-horizontal="40" data-vertical="40" data-show-transition="left">
                            {{ $label }} </h3>
                    </div>
                    @endforeach

                    <div class="sp-thumbnails">
                        @foreach ($model->getImages() as $label => $image)
                            <?php if (!is_array($image) || isset($image['YOUTUBE'])) continue; ?>
                        <img alt="" class="sp-thumbnail" src="{{ $image['medium'] or '' }}">
                        @endforeach
                    </div>
                </div>
            </div>
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

                    <div class="row">
                        <?php
                            $facilities = $model->getServiceFacilities();
                        ?>
                        <div class="col-md-6 col-sm-6">
                            <ul class="list_ok">
                            @for ($i = 0; $i < sizeof($facilities) / 2; $i++)
                                <li>{{ $facilities[$i]['name'] }}</li>
                            @endfor
                            </ul>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <ul class="list_ok">
                                @for ($i = sizeof($facilities) / 2; $i < sizeof($facilities); $i++)
                                    <li>{{ $facilities[$i]['name'] }}</li>
                                @endfor
                            </ul>
                        </div>
                    </div>
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
                    @endforeach

                    <!--<div class="row">
                        <div class="col-md-6 col-sm-6">
                            <ul class="list_icons">
                                <li><i class="icon_set_1_icon-86"></i> Free wifi</li>
                                <li><i class="icon_set_2_icon-116"></i> Plasma Tv</li>
                                <li><i class="icon_set_2_icon-106"></i> Safety  box</li>
                            </ul>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <ul class="list_ok">
                                <li>Lorem ipsum dolor sit amet</li>
                                <li>No scripta electram necessitatibus sit</li>
                                <li>Quidam percipitur instructior an eum</li>
                            </ul>
                        </div>
                    </div><!-- End row  -->
                    <!--<div class="carousel magnific-gallery">
                        <div class="item">
                            <a href="img/carousel/1.jpg"><img src="img/carousel/1.jpg" alt="Image"></a>
                        </div>
                        <div class="item">
                            <a href="img/carousel/2.jpg"><img src="img/carousel/2.jpg" alt="Image"></a>
                        </div>
                        <div class="item">
                            <a href="img/carousel/3.jpg"><img src="img/carousel/3.jpg" alt="Image"></a>
                        </div>
                        <div class="item">
                            <a href="img/carousel/4.jpg"><img src="img/carousel/4.jpg" alt="Image"></a>
                        </div>
                    </div><!-- End photo carousel  -->
                </div><!-- End col-md-9  -->
            </div><!-- End row  -->

            {{--<hr>

            <div class="row">
                <div class="col-md-3">
                    <h3>Reviews</h3>
                </div>
                <div class="col-md-9">
                    <div id="score_detail"><span>7.5</span>Good <small>(Based on 34 reviews)</small></div><!-- End general_rating -->
                    <div class="row" id="rating_summary">
                        <div class="col-md-6">
                            <ul>
                                <li>Position
                                    <div class="rating">
                                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><i class="icon-smile"></i>
                                    </div>
                                </li>
                                <li>Comfort
                                    <div class="rating">
                                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul>
                                <li>Price
                                    <div class="rating">
                                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><i class="icon-smile"></i>
                                    </div>
                                </li>
                                <li>Quality
                                    <div class="rating">
                                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div><!-- End row -->
                    <hr>
                    <div class="review_strip_single">
                        <img src="img/avatar1.jpg" alt="" class="img-circle">
                        <small> - 10 March 2015 -</small>
                        <h4>Jhon Doe</h4>
                        <p>
                            "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a lorem quis neque interdum consequat ut sed sem. Duis quis tempor nunc. Interdum et malesuada fames ac ante ipsum primis in faucibus."
                        </p>
                        <div class="rating">
                            <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><i class="icon-smile"></i>
                        </div>
                    </div><!-- End review strip -->

                    <div class="review_strip_single">
                        <img src="img/avatar2.jpg" alt="" class="img-circle">
                        <small> - 10 March 2015 -</small>
                        <h4>Jhon Doe</h4>
                        <p>
                            "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a lorem quis neque interdum consequat ut sed sem. Duis quis tempor nunc. Interdum et malesuada fames ac ante ipsum primis in faucibus."
                        </p>
                        <div class="rating">
                            <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><i class="icon-smile"></i>
                        </div>
                    </div><!-- End review strip -->

                    <div class="review_strip_single last">
                        <img src="img/avatar3.jpg" alt="" class="img-circle">
                        <small> - 10 March 2015 -</small>
                        <h4>Jhon Doe</h4>
                        <p>
                            "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed a lorem quis neque interdum consequat ut sed sem. Duis quis tempor nunc. Interdum et malesuada fames ac ante ipsum primis in faucibus."
                        </p>
                        <div class="rating">
                            <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><i class="icon-smile"></i>
                        </div>
                    </div><!-- End review strip -->
                </div>
            </div> --}}
        </div>

        <aside class="col-md-4">
            <p class="hidden-sm hidden-xs">
                <a class="btn_map" data-toggle="collapse" href="#collapseMap" aria-expanded="false" aria-controls="collapseMap">View on map</a>
            </p>
            <div class="box_style_1 expose">
                <h3 class="inner">Check Availability</h3>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label><i class="icon-calendar-7"></i> Check in</label>
                            <input class="date-pick form-control" data-date-format="M d, D" type="text">
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label><i class="icon-calendar-7"></i> Check out</label>
                            <input class="date-pick form-control" data-date-format="M d, D" type="text">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Adults</label>
                            <div class="numbers-row">
                                <input type="text" value="1" id="adults" class="qty2 form-control" name="quantity">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <label>Children</label>
                            <div class="numbers-row">
                                <input type="text" value="0" id="children" class="qty2 form-control" name="quantity">
                            </div>
                        </div>
                    </div>
                </div>
                <br>

                <a class="btn_full" href="cart_hotel.html">Check now</a>
            </div><!--/box_style_1 -->

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
    <script src="js/jquery.sliderPro.min.js"></script>
    <script type="text/javascript">
        $( document ).ready(function( $ ) {
            $( '#Img_carousel' ).sliderPro({
                width: 960,
                height: 500,
                fade: true,
                arrows: true,
                buttons: false,
                fullScreen: false,
                startSlide: 0,
                mediumSize: 600,
                largeSize: 1000,
                thumbnailArrows: true,
                autoplay: false
            });
        });
    </script>

    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script src="js/infobox.js"></script>
    <script src="js/map.js"></script>
    <script>
        var markersData = {
            'Walking': [
            @foreach ($nearest['products'] as $nst)
            <?php if (stristr($nst['boundary'], 'MULTIPOINT')) continue; ?>
            <?php $coord = explode(',', $nst['boundary']) ?>
                {
                    name: '{{ $nst['productName'] }}',
                    location_latitude: {{ $coord[0] }},
                    location_longitude: {{ $coord[1] }},
                    map_image_url: '{{ $nst['productImage'] }}',
                    name_point: '{{ $nst['productName'] }}',
                    description_point: '{!! rtrim(str_replace("\n", '\\', nl2br(addslashes(substr($nst['productDescription'], 0, 50)))), '\\') !!}',
                    url_point: '{{ route('hires.show', explode('$', $nst['productId'])[0]) }}'
                },
            @endforeach
            ]
        };

        <?php $coord = $model->getCoordinates() ?>

        var mapZoom = 12;
        var latitude = {{ $coord['lat'] }};
        var longitude = {{ $coord['long'] }};
    </script>
@endsection