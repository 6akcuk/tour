@extends('admin.blogs.layout')

@section('title', $category->name)

@section('breadcrumbs')
    <li><a href="{{ route('admin.blogs.index') }}">Blogs Panel</a></li>
    <li><a href="{{ route('admin.blogs.categories.index') }}">Categories list</a></li>
    <li>Category posts list</li>
@endsection

@section('blogs_content')
    <div class="box_style_1">
        <h3>Posts in {{ $category->name }}</h3>

        @foreach ($posts as $post)
            <div class="post">
                @include ('admin.blogs.posts.post')
            </div>
        @endforeach
    </div>

    <hr>

    <div class="text-center">
        {!! $posts->appends(['q' => \Illuminate\Support\Facades\Request::input('q')])->render() !!}
    </div>
@endsection