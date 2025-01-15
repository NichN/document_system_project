@extends('Layouts.app')

@section('title', 'Teacher List')

@section('content')
    <h1>AdminList</h1>
    <a href="{{ route('create_admin') }}" class="btn btn-primary">Add Admin</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Password</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
    </table>
@endsection
