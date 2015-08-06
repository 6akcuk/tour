@extends('layouts.admin')

@section('breadcrumbs')
    <li>Blogs Panel</li>
@endsection

@section('content')
    <div class="row">
        <aside class="col-md-3 add_bottom_30">
            <div class="widget">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button class="btn btn-default">
                            <i class="icon-search"></i>
                        </button>
                    </span>
                </div>
            </div>

            <hr>

            <div class="widget" id="cat_blog">
                <h4>Menu</h4>

                <ul>
                    <li><a href="{{ route('admin.blogs.index') }}">Blogs</a></li>
                    <li><a href="">Categories</a></li>
                    <li><a href="">Tags</a></li>
                </ul>
            </div>
        </aside>
        <div class="col-md-9">
            <div class="box_style_1">
                @foreach ($blogs as $blog)
                    <div class="post">

                    </div>
                @endforeach
            </div>

            <hr>
        </div>
    </div>
@endsection