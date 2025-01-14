@extends('Layouts.app')

@section('title', 'Document List')

@section('content')
    <h1>Document List</h1>
    <a href="{{ route('create_document') }}" class="btn btn-primary">Create Product</a>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Document</th>
                <th>Upload By</th>
                <th>Created At</th>
                <th>Updated At</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@endsection
