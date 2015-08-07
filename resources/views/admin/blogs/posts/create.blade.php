@extends('admin.blogs.layout')

@section('breadcrumbs')
    <li><a href="{{ route('admin.blogs.index') }}">Blogs Panel</a></li>
    <li>Add New Post</li>
@endsection

@section('blogs_content')
    <div class="row box_style_1">
        <h3>Add New Post</h3>

        {!! Form::open(['route' => 'admin.blogs.posts.index', 'enctype' => 'multipart/form-data']) !!}
        @include('admin.blogs.posts.form')

        <button class="btn_1">Add Post</button>
        <a href="{{ route('admin.blogs.index') }}" class="btn_1 white">Cancel</a>
        {!! Form::close() !!}
    </div>
@endsection