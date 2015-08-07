@extends('admin.blogs.layout')

@section('title', $tag->tag)

@section('breadcrumbs')
    <li><a href="{{ route('admin.blogs.index') }}">Blogs Panel</a></li>
    <li><a href="{{ route('admin.blogs.tags.index') }}">Tags</a></li>
    <li>Tag posts</li>
@endsection

@section('blogs_content')
    <div class="box_style_1">
        <h3>Posts for {{ $tag->tag }}</h3>

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