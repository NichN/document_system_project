@extends('Layouts.app')

@section('title', 'Document List')

@section('content')
    <h1>Document List</h1>
    <a href="{{ route('create_document') }}" class="btn btn-primary">Create Document</a>

    <table class="table table-striped" id="documentTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Description</th>
                <th>Type</th>
                <th>Document</th>
                <th>Uploaded By</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
@endsection

@section('scripts')
    <script>
        async function loadDocuments() {
            localStorage.getItem('authToken');

    const apiUrl = 'http://localhost:8000/api/documents';

    try {
        const response = await fetch(apiUrl, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`
            }
        });

        if (!response.ok) {
            throw new Error('Failed to fetch documents');
        }

        const documents = await response.json();
        const tableBody = document.querySelector('#documentTable tbody');
        tableBody.innerHTML = ''; // Clear the table before appending rows

        documents.forEach(doc => {
            const row = document.createElement('tr');

            row.innerHTML = `
                <td>${doc.id}</td>
                <td>${doc.title}</td>
                <td>${doc.description}</td>
                <td>${doc.type}</td>
                <td><a href="/${doc.file_path}" target="_blank">View Document</a></td>
                <td>${doc.uploaded_by}</td>
                <td>${new Date(doc.created_at).toLocaleString()}</td>
                <td>${new Date(doc.updated_at).toLocaleString()}</td>
                <td>
                    <button class="btn btn-info">Edit</button>
                    <button class="btn btn-danger">Delete</button>
                </td>
            `;

            tableBody.appendChild(row);
        });

    } catch (error) {
        console.error('Error fetching documents:', error);
        alert('Error fetching documents. Please check the console for details.');
    }
}

    </script>
@endsection
