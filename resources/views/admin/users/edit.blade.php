@extends('layouts.admin')

@section('breadcrumbs')
    <li><a href="{{ route('admin.users.index') }}">Users list</a></li>
    <li>Edit User</li>
@endsection

@section('content')
    <div class="row box_style_1">
        <h3>Edit User</h3>

        {!! Form::model($user, ['route' => ['admin.users.update', $user], 'method' => 'PATCH']) !!}
        @include('admin.users.form')

        <button class="btn_1">Save</button>
        <a href="{{ route('admin.users.index') }}" class="btn_1 white">Cancel</a>
        {!! Form::close() !!}
    </div>
@endsection