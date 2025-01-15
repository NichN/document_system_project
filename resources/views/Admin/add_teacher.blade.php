@extends('Layouts.app')

@section('title', 'Add Teacher')

@section('content')
    <h1>Add Teacher</h1>
    <form method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Enter teacher's name" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter teacher's email" required>
        </div>
        <div class="form-group">
            <label for="department">Department</label>
            <input type="text" class="form-control" id="department" name="department" placeholder="Enter teacher's department" required>
        </div>
        <div class="form-group">
            <label>Access Role</label>
            <div>
                <input type="radio" id="role-teacher" name="role" value="teacher" checked>
                <label for="role-teacher">Teacher</label>
            </div>
            <div>
                <input type="radio" id="role-admin" name="role" value="admin">
                <label for="role-admin">Admin</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Add Teacher</button>
    </form>
@endsection
