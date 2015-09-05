@extends('layouts.admin')

@section('breadcrumbs')
    <li><a href="{{ route('admin.pages.index') }}">Pages List</a></li>
    <li>Edit Page</li>
@endsection

@section('content')
    <div class="row box_style_1">
        <h3>Edit Page</h3>

        {!! Form::model($page, ['route' => ['admin.pages.update', $page], 'method' => 'PATCH', 'enctype' => 'multipart/form-data']) !!}
        @include('admin.pages.form')

        <button class="btn_1">Save</button>
        <a href="{{ route('admin.pages.index') }}" class="btn_1 white">Cancel</a>
        {!! Form::close() !!}
    </div>
@endsection