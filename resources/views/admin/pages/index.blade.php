@extends('layouts.admin')

@section('breadcrumbs')
    <li>Pages list</li>
@endsection

@section('content')
    <div class="row">
        <div class="box_style_1">
            <h3>
                Pages list

                <div class="pull-right">
                    <a href="{{ route('admin.pages.create') }}" class="btn_1">Add New Page</a>
                </div>
            </h3>

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($pages as $page)
                    <tr>
                        <td>{{ $page->id }}</td>
                        <td>{{ $page->title }}</td>
                        <td>{{ $page->slug }}</td>
                        <td>
                            @include('admin.partials.default_actions', [
                                'updateRoute' => 'admin.pages.edit',
                                'destroyRoute' => 'admin.pages.destroy',
                                'model' => $page
                            ])
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">Pages not founded.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>

            {!! $pages->render() !!}
        </div>
    </div>
@endsection