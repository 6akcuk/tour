@extends('accommodations.search_layout')

@section('breadcrumbs')
    <li>Accommodations</li>
@endsection

@section('search_content')
    <div id="tools">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="styled-select-filters">
                    <form action="{{ route('accommodation.index', Request::all()) }}" method="get">
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
                    <form action="{{ route('accommodation.index', Request::all()) }}" method="get">
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
                <a class="bt_filters" href="{{ route('accommodation.index', array_merge(Request::all(), ['grid' => 1])) }}">
                    <i class="icon-th"></i></a>
                <a class="bt_filters" href="{{ route('accommodation.index', array_merge(Request::all(), ['grid' => 0])) }}">
                    <i class="icon-list"></i>
                </a>
            </div>
        </div>
    </div>

    @forelse ($accommodations['products'] as $idx => $acc)
        @if (Request::input('grid'))
            @if ($idx % 2 == 0) <div class="row"> @endif
            @include('accommodations.partials.grid_element', ['columns' => 2])
            @if ($idx % 2 != 0) </div> @endif
        @else
            @include('accommodations.partials.list_element')
        @endif
    @empty
        <div class="text-center">No accommodations founded.</div>
    @endforelse

    <hr>

    <div class="text-center">
        {!! $paginator->render() !!}
    </div>
@endsection

@section('footer_javascript')
    @if (sizeof($accommodations['products']))
    <?php $coord = explode(',', $accommodations['products'][0]['boundary']) ?>

    @include('layouts.partials.show_js', [
            'zoom' => 6,
            'lat' => $coord[0],
            'long' => $coord[1],
            'marker' => 'Single_hotel',
            'products' => $accommodations['products'],
            'route' => 'accommodation.show'
        ])
    @endif
@endsection