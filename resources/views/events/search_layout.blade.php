@extends('layouts.main')

@section('header', 'Events')

@section('content')
    <div class="row">
        <aside class="col-lg-3 col-md-3">
            <p>
                <a class="btn_map" data-toggle="collapse" href="#collapseMap">View on map</a>
            </p>
            <div class="box_style_cat">
                <ul id="cat_nav">
                    @foreach (config('tours.events_types') as $type => $name)
                        <li>
                            <a href="{{ route('events.index', array_merge(Request::all(), ['type' => $type])) }}" id="{{ Request::input('type') == $type || ($type == '' && !Request::input('type')) ? 'active' : '' }}">
                                {{ $name }} ({{ $type == '' || $events['numberOfResults'] == 0 ? $total['numberOfResults'] : $events['facetGroups'][0]['facets'][array_search($type, array_column($events['facetGroups'][0]['facets'], 'name'))]['count'] }})
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div id="filters_col">
                <a data-toggle="collapse" href="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters" id="filters_col_bt"><i class="icon_set_1_icon-65"></i>Filters <i class="icon-plus-1 pull-right"></i></a>
                <div class="collapse" id="collapseFilters">
                    <form action="{{ route('events.index') }}" method="get">
                    @include('layouts.partials.form_params', ['exclude' => ['rateRange', 'rating', 'filter']])
                    <div class="filter_type">
                        <h6>Experience</h6>
                        <ul>
                            @foreach (config('tours.events_filters') as $value => $label)
                                <li>
                                    <label>
                                        <input type="checkbox" name="filter[]" value="{{ $value }}" {{ Request::input('filter') && in_array($value, Request::input('filter')) ? 'checked' : '' }}>
                                        {{ $label }}
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="filter_type">
                        <button class="btn_1 btn-block">Search</button>
                    </div>
                    </form>
                </div>
            </div>
        </aside>
        <div class="col-lg-9 col-md-9">
            @yield('search_content')
        </div>
    </div>
@endsection