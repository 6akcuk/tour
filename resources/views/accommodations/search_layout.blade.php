@extends('layouts.main')

@section('header', 'Accommodations')

@section('content')
    <div class="row">
        <aside class="col-lg-3 col-md-3">
            <p>
                <a class="btn_map" data-toggle="collapse" href="#collapseMap">View on map</a>
            </p>
            <div class="box_style_cat">
                <ul id="cat_nav">
                    @foreach (config('tours.accommodations_types') as $type => $name)
                    <li>
                        <a href="{{ route('accommodations.index', array_merge(Request::all(), ['type' => $type])) }}" id="{{ Request::input('type') == $type || ($type == '' && !Request::input('type')) ? 'active' : '' }}">
                            {{ $name }} ({{ $type == '' ? $total['numberOfResults'] : $accommodations['facetGroups'][0]['facets'][array_search($type, array_column($accommodations['facetGroups'][0]['facets'], 'name'))]['count'] }})
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </aside>
        <div class="col-lg-9 col-md-9">
            @yield('search_content')
        </div>
    </div>
@endsection