<div id="Img_carousel" class="slider-pro">
    <div class="sp-slides">

        @foreach ($model->getImages() as $sequence => $image)
            <?php if (!is_array($image)) continue; ?>
            <div class="sp-slide">
                <img alt="" class="sp-image" src="/css/images/blank.gif"
                     data-src="{{ $image['source']['serverPath'] }}"
                {{ isset($image['medium']) ? 'data-medium='. $image['medium']['serverPath'] .'' : '' }}
                {{ isset($image['large']) ? 'data-large='. $image['large']['serverPath'] .'' : '' }}
                {{ isset($image['large']) ? 'data-retina='. $image['large']['serverPath'] .'' : '' }}">
                <h3 class="sp-layer sp-black sp-padding" data-horizontal="40" data-vertical="40" data-show-transition="left">
                    {{ $image['source']['altText'] }} </h3>
            </div>
        @endforeach

        <div class="sp-thumbnails">
            @foreach ($model->getImages() as $sequence => $image)
                <?php if (!is_array($image)) continue; ?>
                <img alt="" class="sp-thumbnail" src="{{ isset($image['medium']) ? $image['medium']['serverPath'] : '' }}">
            @endforeach
        </div>
    </div>
</div>