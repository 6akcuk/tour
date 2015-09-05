@extends('layouts.admin')

@section('breadcrumbs')
    <li><a href="{{ route('admin.pages.index') }}">Pages List</a></li>
    <li>Add New Page</li>
@endsection

@section('content')
    <div class="row box_style_1">
        <h3>Add New Page</h3>

        {!! Form::open(['route' => 'admin.pages.index', 'enctype' => 'multipart/form-data']) !!}
        @include('admin.pages.form')

        <button class="btn_1">Add Page</button>
        <a href="{{ route('admin.pages.index') }}" class="btn_1 white">Cancel</a>
        {!! Form::close() !!}
    </div>
@endsection