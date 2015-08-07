@extends('admin.blogs.layout')

@section('breadcrumbs')
    <li><a href="{{ route('admin.blogs.index') }}">Blogs Panel</a></li>
    <li>Tags</li>
@endsection

@section('blogs_content')
    <div class="box_style_1">
        <h3>
            Tags
        </h3>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Posts Num</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            @if ($tags->count())
                @foreach ($tags as $tag)
                    <tr>
                        <td>{{ $tag->id }}</td>
                        <td>{{ $tag->tag }}</td>
                        <td>{{ $tag->posts->count() }}</td>
                        <td>
                            @include('admin.partials.default_actions', [
                                'updateRoute' => 'admin.blogs.tags.edit',
                                'destroyRoute' => 'admin.blogs.tags.destroy',
                                'model' => $tag
                            ])
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="4">No tags found.</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

    <hr>

    <div class="text-center">
        {!! $tags->appends(['q' => Illuminate\Support\Facades\Request::input('q')])->render() !!}
    </div>
@endsection