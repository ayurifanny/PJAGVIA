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
                    <td colspan=2>Actions</td>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>Role</td>
                        <td>
                            <a href="#" class="btn btn-primary">Edit</a>
                        </td>
                        <td>
                            <form action="#" method="post">
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
