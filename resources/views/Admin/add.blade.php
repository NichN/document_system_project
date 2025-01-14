@extends('Layouts.app')

@section('title', 'Create Product')

@section('content')
    <h1>Create Product</h1>
    <form  method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" required></textarea>
        </div>
        <div class="form-group">
            <label for="document">Document</label>
            <input type="file" class="form-control" id="document" name="document">
        </div>
        <button type="submit" class="btn btn-success">Submit</button>
    </form>
@endsection
