@extends('blogs.layout')

@section('breadcrumbs')
    <li><a href="{{ route('blogs.index') }}">Blogs</a></li>
    <li>Tag posts</li>
@endsection

@section('blogs_content')
    <div class="box_style_1">
        @if (sizeof($posts))
            @foreach ($posts as $post)
                <div class="post">
                    @include ('admin.blogs.posts.post', ['client' => true])
                </div>
            @endforeach
        @else
            <div class="text-center">
                No posts found.
            </div>
        @endif
    </div>

    <hr>

    <div class="text-center">
        {!! $posts->appends(['q' => \Illuminate\Support\Facades\Request::input('q')])->render() !!}
    </div>
@endsection