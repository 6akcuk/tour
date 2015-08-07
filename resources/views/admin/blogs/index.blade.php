@extends('admin.blogs.layout')

@section('breadcrumbs')
    <li>Blogs Panel</li>
@endsection

@section('blogs_content')
    <div class="box_style_1">
        <h3>
            Posts
            <div class="pull-right">
                <a class="btn_1" href="{{ route('admin.blogs.posts.create') }}">Add New Post</a>
            </div>
        </h3>

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