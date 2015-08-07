<div class="widget">
    <form @if (\Illuminate\Support\Facades\Request::is('blogs/*') && !\Illuminate\Support\Facades\Request::is('blogs/*/*')) action="{{ route('blogs.index') }}" @endif method="get">
        <div class="input-group">
            <input type="text" class="form-control" name="q" value="{{ Illuminate\Support\Facades\Request::input('q') }}" placeholder="Search...">
            <span class="input-group-btn">
                <button class="btn btn-default">
                    <i class="icon-search"></i>
                </button>
            </span>
        </div>
    </form>
</div>

<hr>

@inject('blogService', 'App\Jobs\BlogService')

<div class="widget" id="cat_blog">
    <h4>Categories</h4>

    <ul>
        <?php $categories = $blogService->getCategories(); ?>
        @foreach ($categories as $category)
        <li>
            <a href="{{ route('blogs.category', ['category_name' => $category->name]) }}">{{ $category->name }}</a>
        </li>
        @endforeach
    </ul>
</div>

<hr>

<div class="widget">
    <h4>Recent post</h4>

    <ul class="recent_post">
        <?php $posts = $blogService->getRecentPosts(); ?>
        @foreach ($posts as $post)
        <li>
            <i class="icon-calendar-empty"></i>
            {{ Carbon\Carbon::parse($post->created_at)->formatLocalized('%d %B, %Y') }}
            <div>
                <a href="{{ route('blogs.show', ['slug' => $post->slug]) }}">{{ $post->title }}</a>
            </div>
        </li>
        @endforeach
    </ul>
</div>

<hr>

<div class="widget tags">
    <h4>Tags</h4>

    <?php $tags = $blogService->getTags(); ?>
    @foreach ($tags as $tag)
    <a href="{{ route('blogs.tag', $tag->tag) }}">{{ $tag->tag }}</a>
    @endforeach
</div>