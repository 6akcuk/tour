@extends('layouts.main')

@section('header', 'Tours')

@section('content')
    <div class="row">
        <aside class="col-lg-3 col-md-3">
            <p>
                <a class="btn_map" data-toggle="collapse" href="#collapseMap">View on map</a>
            </p>
            <div class="box_style_cat">
                <ul id="cat_nav">
                    @foreach (config('tours.tours_types') as $type => $name)
                        <li>
                            <a href="{{ route('tours.index', array_merge(Request::all(), ['type' => $type])) }}" id="{{ Request::input('type') == $type || ($type == '' && !Request::input('type')) ? 'active' : '' }}">
                                {{ $name }} ({{ $type == '' || $tours['numberOfResults'] == 0 ? $total['numberOfResults'] : $tours['facetGroups'][0]['facets'][array_search($type, array_column($tours['facetGroups'][0]['facets'], 'name'))]['count'] }})
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div id="filters_col">
                <a data-toggle="collapse" href="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters" id="filters_col_bt"><i class="icon_set_1_icon-65"></i>Filters <i class="icon-plus-1 pull-right"></i></a>
                <div class="collapse" id="collapseFilters">
                    <form action="{{ route('tours.index') }}" method="get">
                    @include('layouts.partials.form_params', ['exclude' => ['rateRange', 'rating']])
                    <div class="filter_type">
                        <h6>Price</h6>
                        <ul>
                            @foreach (['10-50', '50-150', '150-300', '300-30000'] as $rr)
                                <li>
                                    <label>
                                        <input type="checkbox" name="rateRange[]" value="{{ $rr }}" {{ Request::input('rateRange') && in_array($rr, Request::input('rateRange')) ? 'checked' : '' }}>
                                        <?php $rra = explode('-', $rr) ?>
                                        From ${{ min($rra) }} @if (max($rra) < 30000) to ${{ max($rra) }} @endif
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