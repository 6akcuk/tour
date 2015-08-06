@extends('layouts.admin')

@section('breadcrumbs')
    <li><a href="{{ route('admin.users.index') }}">Users list</a></li>
    <li>Add New User</li>
@endsection

@section('content')
    <div class="row box_style_1">
        <h3>Add New User</h3>

        {!! Form::open(['route' => 'admin.users.index']) !!}
            @include('admin.users.form')

            <button class="btn_1">Add User</button>
            <a href="{{ route('admin.users.index') }}" class="btn_1 white">Cancel</a>
        {!! Form::close() !!}
    </div>
@endsection