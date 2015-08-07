@extends('admin.blogs.layout')

@section('breadcrumbs')
    <li><a href="{{ route('admin.blogs.index') }}">Blogs Panel</a></li>
    <li>Edit Post</li>
@endsection

@section('blogs_content')
    <div class="row box_style_1">
        <h3>Edit Post</h3>

        {!! Form::model($post, ['route' => ['admin.blogs.posts.update', $post], 'method' => 'PATCH', 'enctype' => 'multipart/form-data']) !!}
        @include('admin.blogs.posts.form')

        <button class="btn_1">Save</button>
        <a href="{{ route('admin.blogs.index') }}" class="btn_1 white">Cancel</a>
        {!! Form::close() !!}
    </div>
@endsection