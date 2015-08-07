@extends('admin.blogs.layout')

@section('breadcrumbs')
    <li><a href="{{ route('admin.blogs.index') }}">Blogs Panel</a></li>
    <li>Categories</li>
@endsection

@section('blogs_content')
    <div class="box_style_1">
        <h3>
            Blog Categories
            <div class="pull-right">
                <a class="btn_1" href="{{ route('admin.blogs.categories.create') }}">Add New Category</a>
            </div>
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
            @if ($categories->count())
            @foreach ($categories as $category)
                <tr>
                    <td>{{ $category->id }}</td>
                    <td>{{ $category->name }}</td>
                    <td>{{ $category->posts->count() }}</td>
                    <td>
                        @include('admin.partials.default_actions', [
                            'updateRoute' => 'admin.blogs.categories.edit',
                            'destroyRoute' => 'admin.blogs.categories.destroy',
                            'model' => $category
                        ])
                    </td>
                </tr>
            @endforeach
            @else
                <tr>
                    <td class="text-center" colspan="4">No categories found.</td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>

    <hr>

    <div class="text-center">
        {!! $categories->appends(['q' => Illuminate\Support\Facades\Request::input('q')])->render() !!}
    </div>
@endsection