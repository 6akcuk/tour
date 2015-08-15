@extends('hires.search_layout')

@section('breadcrumbs')
    <li>Hires</li>
@endsection

@section('search_content')
    <div id="tools">
        <div class="row">
            <div class="col-md-3 col-sm-3 col-xs-6">
                <div class="styled-select-filters">
                    <form action="{{ route('hires.index', Request::all()) }}" method="get">
                    @include('layouts.partials.form_params', ['exclude' => ['sort_name']])
                    {!! Form::select('sort_name', [
                        '' => 'Sort by name',
                        'asc' => 'Name (A-Z)',
                        'desc' => 'Name (Z-A)'
                    ], Request::input('sort_name'), ['id' => 'sort_name']) !!}
                    </form>
                </div>
            </div>
            <div class="col-md-9 col-sm-9 hidden-xs text-right">
                <a class="bt_filters" href="{{ route('hires.index', array_merge(Request::all(), ['grid' => 1])) }}">
                    <i class="icon-th"></i></a>
                <a class="bt_filters" href="{{ route('hires.index', array_merge(Request::all(), ['grid' => 0])) }}">
                    <i class="icon-list"></i>
                </a>
            </div>
        </div>
    </div>

    @forelse ($hires['products'] as $idx => $hire)
        @if (Request::input('grid'))
            @if ($idx % 2 == 0) <div class="row"> @endif
            @include('hires.partials.grid_element', ['columns' => 2])
            @if ($idx % 2 != 0) </div> @endif
        @else
            @include('hires.partials.list_element')
        @endif
    @empty
        <div class="text-center">No hires founded.</div>
    @endforelse

    <hr>

    <div class="text-center">
        {!! $paginator->render() !!}
    </div>
@endsection

@section('footer_javascript')
    @if (sizeof($hires['products']))
    <?php $coord = explode(',', $hires['products'][0]['boundary']) ?>

    @include('layouts.partials.show_js', [
        'zoom' => 6,
        'lat' => $coord[0],
        'long' => $coord[1],
        'marker' => 'Walking',
        'products' => $hires['products'],
        'route' => 'hires.show'
    ])
    @endif
@endsection