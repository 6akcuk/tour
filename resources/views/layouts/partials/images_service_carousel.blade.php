<div class="carousel magnific-gallery">
    @foreach ($helper->getImages() as $image)
        <div class="item">
            <a href="{{ $image['source']['serverPath'] }}"><img src="{{ $image['medium']['serverPath'] }}" alt="{{ $image['source']['altText'] }}"></a>
        </div>
    @endforeach
</div><!-- End photo carousel  -->