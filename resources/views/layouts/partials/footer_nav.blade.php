<footer>
    <div class="container">
        <div class="row">
            <div class="col-md-5 col-sm-4">
                <h3>About</h3>
                <ul>
                    <li><a href="{{ url('/about-us') }}">About us</a></li>
                    <li><a href="{{ route('blogs.index') }}">Blogs</a></li>
                    <li><a href="{{ url('/admin/auth/login') }}">Login</a></li>
                    <li><a href="{{ url('/terms-and-condition') }}">Terms and condition</a></li>
                    <li><a href="{{ url('/contact-us') }}">Contact us</a></li>
                </ul>
            </div>
            <div class="col-md-3 col-sm-4">
                <h3>Discover</h3>
                <ul>
                    <li><a href="{{ route('accommodation.index') }}">Accommodation</a></li>
                    <li><a href="{{ route('tours.index') }}">Tours</a></li>
                    <li><a href="{{ route('attractions.index') }}">Attractions</a></li>
                    <li><a href="{{ route('events.index') }}">Events</a></li>
                    <li><a href="{{ route('hires.index') }}">Hire</a></li>
                </ul>
            </div>
            <div class="col-md-4 col-sm-4">
                <div id="logo" class="text-right hidden-xs">
                    <a href="/"><img src="img/logo_sticky.png" height="34" alt="City tours" data-retina="true" class="logo_sticky"></a>
                </div>
                <div id="logo" class="visible-xs">
                    <a href="/"><img src="img/logo_sticky.png" height="34" alt="City tours" data-retina="true" class="logo_sticky"></a>
                </div>
            </div>
        </div><!-- End row -->
        <div class="row">
            <div class="col-md-12">
                <div id="social_footer">
                    <ul>
                        <li><a href="http://www.facebook.com/backpackers.com.au"><i class="icon-facebook"></i></a></li>
                        <li><a href="http://www.twitter.com/backpackersau"><i class="icon-twitter"></i></a></li>
                        <!--<li><a href="#"><i class="icon-google"></i></a></li>
                        <li><a href="#"><i class="icon-instagram"></i></a></li>
                        <li><a href="#"><i class="icon-pinterest"></i></a></li>
                        <li><a href="#"><i class="icon-vimeo"></i></a></li>
                        <li><a href="#"><i class="icon-youtube-play"></i></a></li>
                        <li><a href="#"><i class="icon-linkedin"></i></a></li>-->
                    </ul>
                    <p>&copy; Backpackers 2015</p>
                </div>
            </div>
        </div><!-- End row -->
    </div><!-- End container -->
</footer><!-- End footer -->