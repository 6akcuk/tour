@extends('blogs.layout')

@section('title', $post->title)

@section('breadcrumbs')
    <li><a href="{{ route('blogs.index') }}">Blogs</a></li>
    <li>{{ $post->title }}</li>
@endsection

@section('blogs_content')
    <div class="box_style_1">
        <div class="post nopadding">
            @include ('admin.blogs.posts.post', ['single' => true, 'client' => true])
        </div>
    </div>
@endsection