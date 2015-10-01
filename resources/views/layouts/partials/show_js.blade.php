<script src="js/sort_product.js"></script>

<script src="js/icheck.js"></script>
<script>
    $('input').iCheck({
        checkboxClass: 'icheckbox_square-grey',
        radioClass: 'iradio_square-grey'
    });
</script>

<!-- Slider -->
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

<!-- Carousel -->
<script src="js/owl.carousel.min.js"></script>
<script>
    $(document).ready(function(){
        $(".carousel").owlCarousel({
            items : 4,
            itemsDesktop : [1199,3],
            itemsDesktopSmall : [979,3]
        });
    });
</script>

<!-- Map View -->
<script src="//maps.googleapis.com/maps/api/js"></script>
<script src="js/infobox.js"></script>
<script src="js/map.js"></script>
<script>
    var markersData = {
        '{{ $marker }}': [
            @foreach ($products as $nst)
                <?php if (stristr($nst['boundary'], 'MULTI')) continue; ?>
                <?php $coord = explode(',', $nst['boundary']) ?>
                    {
                name: '{{ $nst['productName'] }}',
                location_latitude: {{ $coord[0] }},
                location_longitude: {{ $coord[1] }},
                map_image_url: '{{ $nst['productImage'] }}',
                name_point: '{{ $nst['productName'] }}',
                description_point: '{!! rtrim(str_replace("\n", '\\', nl2br(addslashes(substr($nst['productDescription'], 0, 50)))), '\\') !!}',
                url_point: '{{ route($route, explode('$', $nst['productId'])[0]) }}'
            },
            @endforeach
            ]
    };

    var mapZoom = {{ $zoom }};
    var latitude = {{ $lat }};
    var longitude = {{ $long }};
</script>