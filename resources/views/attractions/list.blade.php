@extends('attractions.search_layout')

@section('breadcrumbs')
    <li>Attractions</li>
@endsection

@section('search_content')
    <div id="tools">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="styled-select-filters">
                    <form action="{{ route('attractions.index', Request::all()) }}" method="get">
                    @include('layouts.partials.form_params', ['exclude' => ['sort_price']])
                    {!! Form::select('sort_price', [
                        '' => 'Sort by price',
                        'lower' => 'Lowest price',
                        'higher' => 'Highest price'
                    ], Request::input('sort_price'), ['id' => 'sort_price']) !!}
                    </form>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="styled-select-filters">
                    <form action="{{ route('attractions.index', Request::all()) }}" method="get">
                    @include('layouts.partials.form_params', ['exclude' => ['sort_rating']])
                    {!! Form::select('sort_rating', [
                        '' => 'Sort by ranking',
                        'lower' => 'Lowest ranking',
                        'higher' => 'Highest ranking'
                    ], Request::input('sort_rating'), ['id' => 'sort_rating']) !!}
                    </form>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 hidden-xs text-right">
                <a class="bt_filters" href="{{ route('attractions.index', array_merge(Request::all(), ['grid' => 1])) }}">
                    <i class="icon-th"></i></a>
                <a class="bt_filters" href="{{ route('attractions.index', array_merge(Request::all(), ['grid' => 0])) }}">
                    <i class="icon-list"></i>
                </a>
            </div>
        </div>
    </div>

    @foreach ($attractions['products'] as $idx => $attraction)
        @if (Request::input('grid'))
            @if ($idx % 2 == 0) <div class="row"> @endif
            @include('attractions.partials.grid_element', ['columns' => 2])
            @if ($idx % 2 != 0) </div> @endif
        @else
            @include('attractions.partials.list_element')
        @endif
    @endforeach

    <hr>

    <div class="text-center">
        {!! $paginator->render() !!}
    </div>
@endsection

@section('footer_javascript')
    <script src="js/sort_product.js"></script>
    <script src="http://maps.googleapis.com/maps/api/js"></script>
    <script src="js/infobox.js"></script>
    <script src="js/map.js"></script>
    <script>
        var markersData = {
            'Walking': [
                @foreach ($attractions['products'] as $attraction)
                @if (!stristr($attraction['boundary'], 'MULTIPOINT'))
                <?php $coord = explode(',', $attraction['boundary']) ?>
                    {
                    name: '{{ $attraction['productName'] }}',
                    location_latitude: {{ $coord[0] }},
                    location_longitude: {{ $coord[1] }},
                    map_image_url: '{{ $attraction['productImage'] }}',
                    name_point: '{{ $attraction['productName'] }}',
                    description_point: '{!! rtrim(str_replace("\n", '\\', nl2br(addslashes(substr($attraction['productDescription'], 0, 50)))), '\\') !!}',
                    url_point: '{{ route('attractions.show', explode('$', $attraction['productId'])[0]) }}'
                },
                @endif
                @endforeach
                ]
        };

        <?php $coord = explode(',', $attractions['products'][0]['boundary']) ?>

        var mapZoom = 6;
        var latitude = {{ $coord[0] }};
        var longitude = {{ $coord[1] }};
    </script>
@endsection