@include('layouts.partials.header')

<body>

<!--[if lte IE 8]>
<p class="chromeframe">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a>.</p>
<![endif]-->

<div id="preloader">
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
            <li class="active"><a href="#accommodation" data-toggle="tab">Accommodation</a></li>
            <li class=""><a href="#tours" data-toggle="tab">Tours</a></li>
            <li class=""><a href="#attractions" data-toggle="tab">Attractions</a></li>
            <li class=""><a href="#events" data-toggle="tab">Events</a></li>
            <li class=""><a href="#hires" data-toggle="tab">Hires</a></li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane active" id="accommodation">
                <form>
                    <h3>Search Accomodation in Australia</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Search terms</label>
                                <input type="text" class="form-control" id="accommodation_name" name="terms" placeholder="Optionally type accommodation name or town">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Region</label>
                                {!! Form::select('region', config('tours.regions'), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
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
                                <input class="date-pick form-control" data-date-format="M d, D" type="text" name="check_in">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label><i class="icon-calendar-7"></i> Check out</label>
                                <input class="date-pick form-control" data-date-format="M d, D" type="text" name="check_out">
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
                    <hr>
                    <button class="btn_1 green"><i class="icon-search"></i>Search now</button>
                </form>
            </div>

            <div class="tab-pane" id="tours">
                <form>
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
                    <hr>
                    <button class="btn_1 green"><i class="icon-search"></i>Search now</button>
                </form>
            </div><!-- End rab -->

            <div class="tab-pane" id="attractions">
                <form>
                    <h3>Search Attractions in Australia</h3>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Search terms</label>
                                <input type="text" class="form-control" id="attractions_name" name="terms" placeholder="Optionally type attraction name or town">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Region</label>
                                {!! Form::select('region', config('tours.regions'), null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-md-4">
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
                    <hr>
                    <button class="btn_1 green"><i class="icon-search"></i>Search now</button>
                </form>
            </div>

            <div class="tab-pane" id="events">
                <h3>Search Events in Australia</h3>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Search terms</label>
                            <input type="text" class="form-control" id="events_name" name="terms" placeholder="Optionally type event name or town">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Region</label>
                            {!! Form::select('region', config('tours.regions'), null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
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
                <hr>
                <button class="btn_1 green"><i class="icon-search"></i>Search now</button>
            </div>

            <div class="tab-pane" id="hires">
                <h3>Search Hires in Australia</h3>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Search terms</label>
                            <input type="text" class="form-control" id="hires_name" name="terms" placeholder="Optionally type business name">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Region</label>
                            {!! Form::select('region', config('tours.regions'), null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Hire type</label>
                            {!! Form::select('type', config('tours.hires_types'), null, ['class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- End hero -->

<div class="container margin_60">

    <div class="main_title">
        <h2>Paris <span>Top</span> Tours</h2>
        <p>Quisque at tortor a libero posuere laoreet vitae sed arcu. Curabitur consequat.</p>
    </div>

    <div class="row">

        <div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.1s">
            <div class="tour_container">
                <div class="img_container">
                    <a href="single_tour.html">
                        <img src="img/tour_box_1.jpg" class="img-responsive" alt="">
                        <div class="ribbon top_rated"></div>
                        <div class="short_info">
                            <i class="icon_set_1_icon-44"></i>Historic Buildings<span class="price"><sup>$</sup>39</span>
                        </div>
                    </a>
                </div>
                <div class="tour_title">
                    <h3><strong>Arc Triomphe</strong> tour</h3>
                    <div class="rating">
                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                    </div><!-- end rating -->
                    <div class="wishlist">
                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                    </div><!-- End wish list-->
                </div>
            </div><!-- End box tour -->
        </div><!-- End col-md-4 -->

        <div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.2s">
            <div class="tour_container">
                <div class="img_container">
                    <a href="single_tour.html">
                        <img src="img/tour_box_2.jpg" width="800" height="533" class="img-responsive" alt="">
                        <div class="ribbon top_rated"></div>
                        <div class="badge_save">Save<strong>30%</strong></div>
                        <div class="short_info">
                            <i class="icon_set_1_icon-43"></i>Churches<span class="price"><sup>$</sup>45</span>
                        </div>
                    </a>
                </div>
                <div class="tour_title">
                    <h3><strong>Notredame</strong> tour</h3>
                    <div class="rating">
                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                    </div><!-- end rating -->
                    <div class="wishlist">
                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                    </div><!-- End wish list-->
                </div>
            </div><!-- End box tour -->
        </div><!-- End col-md-4 -->

        <div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.3s">
            <div class="tour_container">
                <div class="img_container">
                    <a href="single_tour.html">
                        <img src="img/tour_box_3.jpg" width="800" height="533" class="img-responsive" alt="">
                        <div class="ribbon popular"></div>
                        <div class="badge_save">Save<strong>30%</strong></div>
                        <div class="short_info">
                            <i class="icon_set_1_icon-44"></i>Historic Buildings<span class="price"><sup>$</sup>48</span>
                        </div>
                    </a>
                </div>
                <div class="tour_title">
                    <h3><strong>Versailles</strong> tour</h3>
                    <div class="rating">
                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                    </div><!-- end rating -->
                    <div class="wishlist">
                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                    </div><!-- End wish list-->
                </div>
            </div><!-- End box tour -->
        </div><!-- End col-md-4 -->

        <div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.4s">
            <div class="tour_container">
                <div class="img_container">
                    <a href="single_tour.html">
                        <img src="img/tour_box_4.jpg" width="800" height="533" class="img-responsive" alt="">
                        <div class="ribbon popular"></div>
                        <div class="short_info">
                            <i class="icon_set_1_icon-30"></i>Walking tour<span class="price"><sup>$</sup>36</span>
                        </div>
                    </a>
                </div>
                <div class="tour_title">
                    <h3><strong>Pompidue</strong> tour</h3>
                    <div class="rating">
                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                    </div><!-- end rating -->
                    <div class="wishlist">
                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                    </div><!-- End wish list-->
                </div>
            </div><!-- End box tour -->
        </div><!-- End col-md-4 -->

        <div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.5s">
            <div class="tour_container">
                <div class="img_container">
                    <a href="single_tour.html">
                        <img src="img/tour_box_14.jpg" width="800" height="533" class="img-responsive" alt="">
                        <div class="ribbon popular"></div>
                        <div class="short_info">
                            <i class="icon_set_1_icon-28"></i>Skyline tours<span class="price"><sup>$</sup>42</span>
                        </div>
                    </a>
                </div>
                <div class="tour_title">
                    <h3><strong>Tour Eiffel</strong> tour</h3>
                    <div class="rating">
                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                    </div><!-- end rating -->
                    <div class="wishlist">
                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                    </div><!-- End wish list-->
                </div>
            </div><!-- End box tour -->
        </div><!-- End col-md-4 -->

        <div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.6s">
            <div class="tour_container">
                <div class="img_container">
                    <a href="single_tour.html">
                        <img src="img/tour_box_5.jpg" width="800" height="533" class="img-responsive" alt="">
                        <div class="ribbon top_rated"></div>
                        <div class="short_info">
                            <i class="icon_set_1_icon-44"></i>Historic Buildings<span class="price"><sup>$</sup>40</span>
                        </div>
                    </a>
                </div>
                <div class="tour_title">
                    <h3><strong>Pantheon</strong> tour</h3>
                    <div class="rating">
                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                    </div><!-- end rating -->
                    <div class="wishlist">
                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                    </div><!-- End wish list-->
                </div>
            </div><!-- End box tour -->
        </div><!-- End col-md-4 -->

        <div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.7s">
            <div class="tour_container">
                <div class="img_container">
                    <a href="single_tour.html">
                        <img src="img/tour_box_8.jpg" width="800" height="533" class="img-responsive" alt="">
                        <div class="ribbon top_rated"></div>
                        <div class="short_info">
                            <i class="icon_set_1_icon-3"></i>City sightseeing<span class="price"><sup>$</sup>35</span>
                        </div>
                    </a>
                </div>
                <div class="tour_title">
                    <h3><strong>Open Bus</strong> tour</h3>
                    <div class="rating">
                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                    </div><!-- end rating -->
                    <div class="wishlist">
                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                    </div><!-- End wish list-->
                </div>
            </div><!-- End box tour -->
        </div><!-- End col-md-4 -->

        <div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.8s">
            <div class="tour_container">
                <div class="img_container">
                    <a href="single_tour.html">
                        <img src="img/tour_box_9.jpg" width="800" height="533" class="img-responsive" alt="">
                        <div class="ribbon top_rated"></div>
                        <div class="short_info">
                            <i class="icon_set_1_icon-4"></i>Museums<span class="price"><sup>$</sup>38</span>
                        </div>
                    </a>
                </div>
                <div class="tour_title">
                    <h3><strong>Louvre museum</strong> tour</h3>
                    <div class="rating">
                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                    </div><!-- end rating -->
                    <div class="wishlist">
                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                    </div><!-- End wish list-->
                </div>
            </div><!-- End box tour -->
        </div><!-- End col-md-4 -->

        <div class="col-md-4 col-sm-6 wow zoomIn" data-wow-delay="0.9s">
            <div class="tour_container">
                <div class="img_container">
                    <a href="single_tour.html">
                        <img src="img/tour_box_12.jpg" width="800" height="533" class="img-responsive" alt="">
                        <div class="ribbon top_rated"></div>
                        <div class="short_info">
                            <i class="icon_set_1_icon-14"></i>Eat &amp; drink<span class="price"><sup>$</sup>25</span>
                        </div>
                    </a>
                </div>
                <div class="tour_title">
                    <h3><strong>Boulangerie</strong> tour</h3>
                    <div class="rating">
                        <i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile voted"></i><i class="icon-smile"></i><small>(75)</small>
                    </div><!-- end rating -->
                    <div class="wishlist">
                        <a class="tooltip_flip tooltip-effect-1" href="javascript:void(0);">+<span class="tooltip-content-flip"><span class="tooltip-back">Add to wishlist</span></span></a>
                    </div><!-- End wish list-->
                </div>
            </div><!-- End box tour -->
        </div><!-- End col-md-4 -->

    </div><!-- End row -->
    <p class="text-center nopadding">
        <a href="#" class="btn_1 medium"><i class="icon-eye-7"></i>View all tours (144) </a>
    </p>
</div><!-- End container -->

@include('layouts.partials.footer_nav')

<div id="toTop"></div><!-- Back to top button -->

@include('layouts.partials.footer')