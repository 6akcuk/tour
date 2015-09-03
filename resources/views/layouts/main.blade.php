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

@if (!isset($booking))
<section class="parallax-window" data-parallax="scroll" data-image-src="@yield('main_bg', 'img/bg.jpg')" data-natural-width="855" data-natural-height="584">
    <div class="parallax-content-1">
        <div class="animated">
            <h1>@yield('header')</h1>
        </div>
    </div>
</section>
@else
<section id="hero_2">
    <div class="intro_title animated fadeInDown">
        <h1>Place Your Order</h1>
        <div class="bs-wizard">
            <div class="col-xs-6 bs-wizard-step {{ (Request::is('booking/*') && !Request::is('booking/make')) ? 'active' : 'complete' }}">
                <div class="text-center bs-wizard-stepnum">Order Details</div>
                <div class="progress"><div class="progress-bar"></div></div>
                <a href="#" class="bs-wizard-dot"></a>
            </div>

            <div class="col-xs-6 bs-wizard-step {{ (Request::is('booking/*') && !Request::is('booking/make')) ? 'disabled' : 'active' }}">
                <div class="text-center bs-wizard-stepnum">Finish!</div>
                <div class="progress"><div class="progress-bar"></div></div>
                <a href="confirmation_hotel.html" class="bs-wizard-dot"></a>
            </div>
        </div>
    </div>
</section>
@endif

<div id="position">
    <div class="container">
        <ul>
            <li><a href="/">Home</a></li>
            @yield('breadcrumbs')
        </ul>
    </div>
</div>

<div class="collapse" id="collapseMap">
    <div id="map" class="map"></div>
</div>

<div class="container margin_60">

    @yield('content')

</div><!-- End container -->

@include('layouts.partials.footer_nav')

<div id="toTop"></div><!-- Back to top button -->

@include('layouts.partials.footer')