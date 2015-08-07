<div class="widget">
    <form method="get">
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

@inject('blogMetrics', 'App\Jobs\BlogMetricsService')

<div class="widget" id="cat_blog">
    <h4>Menu</h4>

    <ul>
        <li><a href="{{ route('admin.blogs.index') }}">Posts ({{ $blogMetrics->posts() }})</a></li>
        <li><a href="{{ route('admin.blogs.categories.index') }}">Categories ({{ $blogMetrics->categories() }})</a></li>
        <li><a href="{{ route('admin.blogs.tags.index') }}">Tags ({{ $blogMetrics->tags() }})</a></li>
    </ul>
</div>