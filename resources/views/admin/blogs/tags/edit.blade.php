@extends('admin.blogs.layout')

@section('breadcrumbs')
    <li><a href="{{ route('admin.blogs.index') }}">Blogs Panel</a></li>
    <li><a href="{{ route('admin.blogs.tags.index') }}">Tags</a></li>
    <li>Edit Tag</li>
@endsection

@section('blogs_content')
    <div class="row box_style_1">
        <h3>Edit Tag</h3>

        {!! Form::model($tag, ['route' => ['admin.blogs.tags.update', $tag], 'method' => 'PATCH']) !!}
        @include('admin.blogs.tags.form')

        <button class="btn_1">Save</button>
        <a href="{{ route('admin.blogs.tags.index') }}" class="btn_1 white">Cancel</a>
        {!! Form::close() !!}
    </div>
@endsection