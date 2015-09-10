@include('layouts.partials.header')

<body>

<!--[if lte IE 8]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</p>
<![endif]-->

<!--<div id="preloader">
    <div class="sk-spinner sk-spinner-wave">
        <div class="sk-rect1"></div>
        <div class="sk-rect2"></div>
        <div class="sk-rect3"></div>
        <div class="sk-rect4"></div>
        <div class="sk-rect5"></div>
    </div>
</div>
<!-- End Preload -->

@include('layouts.partials.nav')

<section id="search_container">
    <div id="search">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#accommodations" data-toggle="tab">Accommodation</a></li>
            <li class=""><a href="#tours" data-toggle="tab">Tours</a></li>
            <li class=""><a href="#attractions" data-toggle="tab">Attractions</a></li>
            <li class=""><a href="#events" data-toggle="tab">Events</a></li>
            <li class=""><a href="#hires" data-toggle="tab">Hires</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="accommodations">
                <form action="{{ route('accommodation.index') }}" method="get">
                    <h3>Search Accommodation in Australia</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Search terms</label>
                                <input type="text" class="form-control" id="accommodation_name" name="terms" placeholder="Optionally type accommodation name or town">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Accommodation type</label>
                                {!! Form::select('type', config('tours.accommodations_types'), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><i class="icon-calendar-7"></i> Check in</label>
                                <input class="date-pick form-control" data-date-format="M d, D" type="text" name="from">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><i class="icon-calendar-7"></i> Check out</label>
                                <input class="date-pick form-control" data-date-format="M d, D" type="text" name="to">
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-3 col-xs-5">
                            <div class="form-group">
                                <label>Adults</label>
                                <div class="numbers-row">
                                    <input type="text" value="1" id="adults" class="qty2 form-control" name="adults">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-3 col-xs-5">
                            <div class="form-group">
                                <label>Kids</label>
                                <div class="numbers-row">
                                    <input type="text" value="0" id="children" class="qty2 form-control" name="kids">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row geo_search"></div>
                    <hr>
                    <button class="btn_1 green"><i class="icon-search"></i>Search now</button>
                </form>
            </div>

            <div class="tab-pane" id="tours">
                <form action="{{ route('tours.index') }}" method="get">
                    <h3>Search Tours in Australia</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Search terms</label>
                                <input type="text" class="form-control" id="firstname_booking" name="terms" placeholder="Type your search terms">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tour type</label>
                                {!! Form::select('type', config('tours.tours_types'), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div><!-- End row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="icon-calendar-7"></i> From</label>
                                <input class="date-pick form-control" data-date-format="M d, D" type="text" name="from">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="icon-calendar-7"></i> To</label>
                                <input class="date-pick form-control" data-date-format="M d, D" type="text" name="to">
                            </div>
                        </div>
                    </div><!-- End row -->
                    <div class="row geo_search"></div>
                    <hr>
                    <button class="btn_1 green"><i class="icon-search"></i>Search now</button>
                </form>
            </div><!-- End rab -->

            <div class="tab-pane" id="attractions">
                <form action="{{ route('attractions.index') }}" method="get">
                    <h3>Search Attractions in Australia</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Search terms</label>
                                <input type="text" class="form-control" id="attractions_name" name="terms" placeholder="Optionally type attraction name or town">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Attraction type</label>
                                {!! Form::select('type', config('tours.attractions_types'), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div><!-- End row -->
                    <div class="row">
                        @foreach (config('tours.attractions_filters') as $value => $label)
                        <div class="col-md-4 col-sm-4 col-xs-6">
                            <label>
                                <input type="checkbox" name="filter[]" value="{{ $value }}"> {{ $label }}
                            </label>
                        </div>
                        @endforeach
                    </div> <!-- End row -->
                    <div class="row geo_search"></div>
                    <hr>
                    <button class="btn_1 green"><i class="icon-search"></i>Search now</button>
                </form>
            </div>

            <div class="tab-pane" id="events">
                <form action="{{ route('events.index') }}" method="get">
                    <h3>Search Events in Australia</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Search terms</label>
                                <input type="text" class="form-control" id="events_name" name="terms" placeholder="Optionally type event name or town">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Event type</label>
                                {!! Form::select('type', config('tours.events_types'), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div><!-- End row -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="icon-calendar-7"></i> From</label>
                                <input class="date-pick form-control" data-date-format="M d, D" type="text" name="from">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label><i class="icon-calendar-7"></i> To</label>
                                <input class="date-pick form-control" data-date-format="M d, D" type="text" name="to">
                            </div>
                        </div>
                    </div><!-- End row -->
                    <div class="row">
                        @foreach (config('tours.events_filters') as $value => $label)
                            <div class="col-md-4 col-sm-4 col-xs-6">
                                <label>
                                    <input type="checkbox" name="filter[]" value="{{ $value }}"> {{ $label }}
                                </label>
                            </div>
                        @endforeach
                    </div> <!-- End row -->
                    <div class="row geo_search"></div>
                    <hr>
                    <button class="btn_1 green"><i class="icon-search"></i>Search now</button>
                </form>
            </div>

            <div class="tab-pane" id="hires">
                <form action="{{ route('hires.index') }}" method="get">
                    <h3>Search Hires in Australia</h3>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Search terms</label>
                                <input type="text" class="form-control" id="hires_name" name="terms" placeholder="Optionally type business name">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Hire type</label>
                                {!! Form::select('type', config('tours.hires_types'), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row geo_search"></div>
                    <hr>
                    <button class="btn_1 green"><i class="icon-search"></i>Search now</button>
                </form>
            </div>
        </div>
    </div>
</section><!-- End hero -->

<div id="accommodations_top" class="container margin_60">

    <div class="main_title">
        <h2><span>Top Rated</span> Accommodation</h2>
    </div>

    <div class="row">

        @foreach ($accommodations['products'] as $acc)
            @include('accommodations.partials.grid_element', ['columns' => 3])
        @endforeach

    </div><!-- End row -->
    <p class="text-center nopadding">
        <a href="{{ route('accommodation.index') }}" class="btn_1 medium"><i class="icon-eye-7"></i>View all accommodation ({{ $accommodations['numberOfResults'] }}) </a>
    </p>
</div><!-- End container -->

<div id="tours_top" class="container margin_60" style="display: none">

    <div class="main_title">
        <h2><span>Top Rated</span> Tours</h2>
    </div>

    <div class="row" style="position: relative; min-height: 100px">
        <div class="sk-spinner sk-spinner-wave">
            <div class="sk-rect1"></div>
            <div class="sk-rect2"></div>
            <div class="sk-rect3"></div>
            <div class="sk-rect4"></div>
            <div class="sk-rect5"></div>
        </div>
    </div><!-- End row -->
    <p class="text-center nopadding">
        <a href="{{ route('tours.index') }}" class="btn_1 medium"><i class="icon-eye-7"></i>View all tours (<span id="tours_num"></span>) </a>
    </p>
</div><!-- End container -->

<div id="attractions_top" class="container margin_60" style="display: none">

    <div class="main_title">
        <h2><span>Top Rated</span> Attractions</h2>
    </div>

    <div class="row" style="position: relative; min-height: 100px">
        <div class="sk-spinner sk-spinner-wave">
            <div class="sk-rect1"></div>
            <div class="sk-rect2"></div>
            <div class="sk-rect3"></div>
            <div class="sk-rect4"></div>
            <div class="sk-rect5"></div>
        </div>
    </div><!-- End row -->
    <p class="text-center nopadding">
        <a href="{{ route('attractions.index') }}" class="btn_1 medium"><i class="icon-eye-7"></i>View all attractions (<span id="attractions_num"></span>) </a>
    </p>
</div><!-- End container -->

<div id="events_top" class="container margin_60" style="display: none">

    <div class="main_title">
        <h2><span>Top Rated</span> Events</h2>
    </div>

    <div class="row" style="position: relative; min-height: 100px">
        <div class="sk-spinner sk-spinner-wave">
            <div class="sk-rect1"></div>
            <div class="sk-rect2"></div>
            <div class="sk-rect3"></div>
            <div class="sk-rect4"></div>
            <div class="sk-rect5"></div>
        </div>
    </div><!-- End row -->
    <p class="text-center nopadding">
        <a href="{{ route('events.index') }}" class="btn_1 medium"><i class="icon-eye-7"></i>View all events (<span id="events_num"></span>) </a>
    </p>
</div><!-- End container -->

<div id="hires_top" class="container margin_60" style="display: none">

    <div class="main_title">
        <h2><span>Top Rated</span> Hires</h2>
    </div>

    <div class="row" style="position: relative; min-height: 100px">
        <div class="sk-spinner sk-spinner-wave">
            <div class="sk-rect1"></div>
            <div class="sk-rect2"></div>
            <div class="sk-rect3"></div>
            <div class="sk-rect4"></div>
            <div class="sk-rect5"></div>
        </div>
    </div><!-- End row -->
    <p class="text-center nopadding">
        <a href="{{ route('hires.index') }}" class="btn_1 medium"><i class="icon-eye-7"></i>View all hires (<span id="hires_num"></span>) </a>
    </p>
</div><!-- End container -->

@include('layouts.partials.footer_nav')

<div id="toTop"></div><!-- Back to top button -->

@include('layouts.partials.footer')
