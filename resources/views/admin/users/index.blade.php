@extends('layouts.admin')

@section('breadcrumbs')
    <li>Users list</li>
@endsection

@section('content')
    <div class="row">
        <div class="box_style_1">
            <h3>
                Users list

                <div class="pull-right">
                    <a href="{{ route('admin.users.create') }}" class="btn_1">Add New User</a>
                </div>
            </h3>

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Username</th>
                    <th>Name</th>
                    <th>E-Mail</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->username }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <div class="pull-left"><a href="{{ route('admin.users.edit', $user) }}" class="btn_1">Edit</a></div>
                            @if ($user->id != 1)
                            <div class="pull-left btn_delete">
                                {!! Form::open(['route' => ['admin.users.destroy', $user], 'method' => 'DELETE', 'onsubmit' => 'return confirm("Do you want to delete?")']) !!}
                                <button class="btn_1">Delete</button>
                                {!! Form::close() !!}
                            </div>
                            @endif
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {!! $users->render() !!}
        </div>
    </div>
@endsection