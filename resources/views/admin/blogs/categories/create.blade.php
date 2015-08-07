@extends('admin.blogs.layout')

@section('breadcrumbs')
    <li><a href="{{ route('admin.blogs.index') }}">Blogs Panel</a></li>
    <li><a href="{{ route('admin.blogs.categories.index') }}">Categories</a></li>
    <li>Add New Category</li>
@endsection

@section('blogs_content')
    <div class="row box_style_1">
        <h3>Add New Category</h3>

        {!! Form::open(['route' => 'admin.blogs.categories.index']) !!}
        @include('admin.blogs.categories.form')

        <button class="btn_1">Add Category</button>
        <a href="{{ route('admin.blogs.categories.index') }}" class="btn_1 white">Cancel</a>
        {!! Form::close() !!}
    </div>
@endsection