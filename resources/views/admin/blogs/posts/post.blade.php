<?php
    if (!isset($single)) $single = false;
    if (!isset($client)) $client = false;

    $showLink = $client ? route('blogs.show', ['slug' => $post->slug]) : route('admin.blogs.posts.show', ['id' => $post->id]);
    $categoryLink = $client
            ? route('blogs.category', ['category_name' => $post->category->name])
            : route('admin.blogs.categories.show', $post->category);
?>

@if (!$single)<a href="{{ $showLink }}">@endif
    <img src="uploads/blogs/{{ $post->photo }}" class="img-responsive">
@if (!$single)</a>@endif
<div class="post_info clearfix">
    <div class="post-left">
        <ul>
            <li>
                <i class="icon-calendar-empty"></i>
                On
                <span>{{ \Carbon\Carbon::parse($post->created_at)->formatLocalized('%d %B %Y') }}</span>
            </li>
            <li>
                <i class="icon-inbox-alt"></i>
                In
                <a href="{{ $categoryLink }}">{{ $post->category->name }}</a>
            </li>
            @if ($post->tags()->count() > 0)
            <li>
                <i class="icon-tags"></i>
                Tags
                <?php
                    $tags = array_map(function($tag) use ($client) {
                        return '<a href="'. ($client ? route('blogs.tag', $tag['tag']) : route('admin.blogs.tags.show', $tag['id'])) .'">'. $tag['tag'] .'</a>';
                    }, $post->tags->toArray());

                    echo implode(', ', $tags);
                ?>
            </li>
            @endif
        </ul>
    </div>
    <!--
    <div class="post-right">
        <i class="icon-comment"></i>
        <a href="#">0</a>
        @if ($single) Comments @endif
    </div>
    -->
</div>
<h2>{{ $post->title }}</h2>
@if ($single)
    {!! $post->body !!}
@else
    <?php
        $body = explode('<p>', str_replace('</p>', '', $post->body));
    ?>
    @for ($i = 0; $i < min(2, sizeof($body)); $i++)
        <p>{!! $body[$i] !!}</p>
    @endfor
@endif

@if (!$single)
    <a href="{{ $showLink }}" class="btn_1">Read More</a>
@endif

@if (Auth::check())
    <a href="{{ route('admin.blogs.posts.edit', $post) }}" class="btn_1">Edit Post</a>
    {!! Form::open([
        'route' => ['admin.blogs.posts.destroy', $post],
        'method' => 'DELETE',
        'style' => 'display: inline-block',
        'onsubmit' => 'return confirm("Do you want to delete post?")'
    ]) !!}
    <button class="btn_1">Delete Post</button>
    {!! Form::close() !!}
@endif