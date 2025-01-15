@extends('Layouts.app')

@section('title', 'Add Admin')

@section('content')
    <h1>Add Admin</h1>
    <form  method="POST">
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
            <label for="department">Password</label>
            <input type="text" class="form-control" id="department" name="department" placeholder="Enter teacher's department" required>
        </div>
        <button type="submit" class="btn btn-primary">Add Admin</button>
    </form>
@endsection
