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

<section class="parallax-window" data-parallax="scroll" data-image-src="img/bg.jpg" data-natural-width="855" data-natural-height="584">
    <div class="parallax-content-1">
        <div class="animated">
            <h1>Backpackers Blog</h1>
        </div>
    </div>
</section>

<div id="position">
    <div class="container">
        <ul>
            <li><a href="/">Home</a></li>
            @yield('breadcrumbs')
        </ul>
    </div>
</div>

<div class="container margin_60">

    @yield('content')

</div><!-- End container -->

@include('layouts.partials.footer_nav')

<div id="toTop"></div><!-- Back to top button -->

@include('layouts.partials.footer')