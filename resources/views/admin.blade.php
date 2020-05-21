@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-sm-12">
        <h1 class="display-3">Users</h1>
        @if(Route::has('register'))
            <a href="{{ route('register') }}">Register</a>
        @endif
        <table class="table table-striped">
            <thead>
                <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Email</td>
                    <td>Role</td>
                    <td>Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @if($user->getRoleNames()[0] == 'admin')                             
                            Admin
                            @else
                                <form action="/update_role" method="post">
                                    @csrf
                                    <input name="user_id" id='hidden_data' type="hidden" value='{{$user->id}}' />
                                    <select id="role" name="role" onchange="this.form.submit()">

                                        @if ($user->getRoleNames()[0] == 'customer'):
                                        <option value="customer" selected="selected">Customer </option>
                                        @else
                                        <option value="customer">Customer </option>
                                        @endif

                                        @if ($user->getRoleNames()[0] == 'inspector'):
                                        <option value="inspector" selected="selected">Inspector </option>
                                        @else
                                        <option value="inspector">Inspector </option>
                                        @endif
                                    @endif
                                </select>
                            </form>
                        </td>
                        <td>
                            <form action="/users/{{$user->id}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div>
        </div>
        @endsection