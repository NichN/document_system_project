@extends('Layouts.app')

@section('title', 'Edit Document')

@section('content')
<h1>Edit Document</h1>
<form id="editDocumentForm" method="POST" action="/edit_document/{{ $document->id }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="title">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ $document->title }}" required>
    </div>
    <div class="form-group">
        <label for="description">Description</label>
        <textarea class="form-control" id="description" name="description" rows="3" required>{{ $document->description }}</textarea>
    </div>
    <div class="form-group">
        <label for="type">Type</label>
        <select class="form-control" id="type" name="type" required>
            <option value="" disabled {{ old('type', $document->type) == '' ? 'selected' : '' }}>Select a type</option>
            <option value="Questions" {{ old('type', $document->type) == 'Questions' ? 'selected' : '' }}>Questions</option>
            <option value="Knowledge" {{ old('type', $document->type) == 'Knowledge' ? 'selected' : '' }}>Knowledge</option>
            <option value="Exam Paper" {{ old('type', $document->type) == 'Exam Paper' ? 'selected' : '' }}>Exam Paper</option>
            <option value="Books" {{ old('type', $document->type) == 'Books' ? 'selected' : '' }}>Books</option>
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Save Changes</button>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        console.log(documentId); 
        const documentId = window.location.pathname.split('/').pop();
        const token = localStorage.getItem('authToken');

        if (!token) {
            alert("No authentication token found. Please log in.");
            return;
        }

        fetch(`http://localhost:8000/api/documents/${id}`, {
            method: "GET",
            headers: {
                "Authorization": `Bearer ${token}`,
                "Content-Type": "application/json"
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error("Failed to fetch document data.");
            }
            return response.json();
        })
        .then(document => {
            document.getElementById("title").value = document.title;
            document.getElementById("description").value = document.description;
            document.getElementById("type").value = document.type;
        })
        .catch(error => {
            console.error("Error fetching document data:", error);
            alert("Failed to fetch document data.");
        });

        document.getElementById("editDocumentForm").addEventListener("submit", function (event) {
            event.preventDefault();

            const title = document.getElementById("title").value;
            const description = document.getElementById("description").value;
            const type = document.getElementById("type").value;
            const fileInput = document.getElementById("document");
            const formData = new FormData();

            formData.append("title", title);
            formData.append("description", description);
            formData.append("type", type);

            fetch(`http://localhost:8000/api/documents/edit/${id}`, {
                method: "PUT",
                headers: {
                    "Authorization": `Bearer ${token}`
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Failed to update document.");
                }
                alert("Document updated successfully.");
                window.location.href = '/dashboard';
            })
            .catch(error => {
                console.error("Error updating document:", error);
                alert("Failed to update document.");
            });
        });
    });
</script>
@endsection
