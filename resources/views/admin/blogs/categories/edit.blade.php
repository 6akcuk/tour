@extends('admin.blogs.layout')

@section('breadcrumbs')
    <li><a href="{{ route('admin.blogs.index') }}">Blogs Panel</a></li>
    <li><a href="{{ route('admin.blogs.categories.index') }}">Categories</a></li>
    <li>Edit Category</li>
@endsection

@section('blogs_content')
    <div class="row box_style_1">
        <h3>Edit Category</h3>

        {!! Form::model($category, ['route' => ['admin.blogs.categories.update', $category], 'method' => 'PATCH']) !!}
        @include('admin.blogs.categories.form')

        <button class="btn_1">Save</button>
        <a href="{{ route('admin.blogs.categories.index') }}" class="btn_1 white">Cancel</a>
        {!! Form::close() !!}
    </div>
@endsection