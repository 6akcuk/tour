@extends('tours.search_layout')

@section('breadcrumbs')
    <li>Tours</li>
@endsection

@section('search_content')
    <div id="tools">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="styled-select-filters">
                    <form action="{{ route('tours.index', Request::all()) }}" method="get">
                    @include('layouts.partials.form_params', ['exclude' => ['sort_price']])
                    {!! Form::select('sort_price', [
                        '' => 'Sort by price',
                        'lower' => 'Lowest price',
                        'higher' => 'Highest price'
                    ], Request::input('sort_price'), ['id' => 'sort_price']) !!}
                    </form>
                </div>
            </div>
            <div class="col-md-9 col-sm-9 hidden-xs text-right">
                <a class="bt_filters" href="{{ route('tours.index', array_merge(Request::all(), ['grid' => 1])) }}">
                    <i class="icon-th"></i></a>
                <a class="bt_filters" href="{{ route('tours.index', array_merge(Request::all(), ['grid' => 0])) }}">
                    <i class="icon-list"></i>
                </a>
            </div>
        </div>
    </div>

    @forelse ($tours['products'] as $idx => $tour)
        @if (Request::input('grid'))
            @if ($idx % 2 == 0) <div class="row"> @endif
            @include('tours.partials.grid_element', ['columns' => 2])
            @if ($idx % 2 != 0) </div> @endif
        @else
            @include('tours.partials.list_element')
        @endif
    @empty
        <div class="text-center">No tours found.</div>
    @endforelse

    <hr>

    <div class="text-center">
        {!! $paginator->render() !!}
    </div>
@endsection

@section('footer_javascript')
    @if (sizeof($tours['products']))
    <?php
        if (stristr($tours['products'][0]['boundary'], 'multi')) {
            $coord = explode(" ", preg_replace('/MULTIPOINT\(([\-0-9\.]*)[ ]{1}([\-0-9\.]*).*/', "$2 $1", $tours['products'][0]['boundary']));
        } else {
            $coord = explode(',', $tours['products'][0]['boundary']);
        }
    ?>

    @include('layouts.partials.show_js', [
        'zoom' => 6,
        'lat' => $coord[0],
        'long' => $coord[1],
        'marker' => 'Walking',
        'products' => $tours['products'],
        'route' => 'tours.show'
    ])
    @endif
@endsection