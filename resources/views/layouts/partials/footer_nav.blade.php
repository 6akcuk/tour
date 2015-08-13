<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-3">
                <h3>Need help?</h3>
                <!--<a href="tel://004542344599" id="phone">+45 423 445 99</a>-->
                <a href="mailto:help@backpackers.com.au" id="email_footer">help@backpackers.com.au</a>
            </div>
            <div class="col-md-3 col-sm-3">
                <h3>About</h3>
                <ul>
                    <li><a href="{{ url('/blogs/about-us') }}">About us</a></li>
                    <li><a href="{{ route('blogs.index') }}">Blogs</a></li>
                    <li><a href="{{ url('/admin/auth/login') }}">Login</a></li>
                    <li><a href="{{ url('/blogs/terms-and-condition') }}">Terms and condition</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-3">
                <h3>Discover</h3>
                <ul>
                    <li><a href="{{ route('accommodations.index') }}">Accommodation</a></li>
                    <li><a href="{{ route('tours.index') }}">Tours</a></li>
                    <li><a href="{{ route('attractions.index') }}">Attractions</a></li>
                    <li><a href="{{ route('events.index') }}">Events</a></li>
                    <li><a href="{{ route('hires.index') }}">Hire</a></li>
                </ul>
            </div>
            <div class="col-md-2 col-sm-3">
                <div id="logo">
                    <a href="/"><img src="img/logo_sticky.png" width="160" height="34" alt="City tours" data-retina="true" class="logo_sticky"></a>
                </div>
            </div>
        </div><!-- End row -->
        <div class="row">
            <div class="col-md-12">
                <div id="social_footer">
                    <ul>
                        <li><a href="#"><i class="icon-facebook"></i></a></li>
                        <li><a href="#"><i class="icon-twitter"></i></a></li>
                        <li><a href="#"><i class="icon-google"></i></a></li>
                        <li><a href="#"><i class="icon-instagram"></i></a></li>
                        <li><a href="#"><i class="icon-pinterest"></i></a></li>
                        <li><a href="#"><i class="icon-vimeo"></i></a></li>
                        <li><a href="#"><i class="icon-youtube-play"></i></a></li>
                        <li><a href="#"><i class="icon-linkedin"></i></a></li>
                    </ul>
                    <p>� Backpackers 2015</p>
                </div>
            </div>
        </div><!-- End row -->
    </div><!-- End container -->
</footer><!-- End footer -->