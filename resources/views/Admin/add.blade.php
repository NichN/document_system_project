@extends('Layouts.app')

@section('title', 'Create Document')

@section('content')
    <h1>Create Document</h1>
    <form id="documentForm" enctype="multipart/form-data" action="{{route('document_list')}}" method="POST">
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
            <label for="type">Type</label>
            <select class="form-control" id="type" name="type" required>
                <option value="" disabled selected>Select a type</option>
                <option value="Questions">Questions</option>
                <option value="Knowledge">Knowledge</option>
                <option value="Exam Paper">Exam Paper</option>
                <option value="Books">Books</option>
            </select>
        </div>
        <div class="form-group">
            <label for="document">Document</label>
            <input type="file" class="form-control" id="document" name="document" required>
        </div>
        <button type="button" id="submitBtn" class="btn btn-success">Submit</button>
    </form>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.getElementById("submitBtn").addEventListener("submit", async function (event) {
                event.preventDefault(); 
    
                // Get form data
                const title = document.getElementById("title").value;
                const description = document.getElementById("description").value;
                const type = document.getElementById("type").value;
                const documentFile = document.getElementById("document").files[0];
    
                // Get token from localStorage
                const token = localStorage.getItem('authToken');
    
                if (!token) {
                    alert("No authentication token found. Please log in.");
                    return;
                }
    
                // Form validation to ensure a file is selected
                if (!documentFile) {
                    alert("Please select a document to upload.");
                    return;
                }
    
                // Prepare the form data to be sent with the request
                const formData = new FormData();
                formData.append("title", title);
                formData.append("description", description);
                formData.append("type", type);
                formData.append("document", documentFile);
    
                try {
                    const response = await fetch("http://localhost:8000/api/documents/upload", {
                        method: "POST",
                        headers: {
                            "Authorization": `Bearer ${token}`, 
                            "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value // Laravel CSRF token
                        },
                        body: formData, 
                    });
    
                    if (!response.ok) {
                        const errorData = await response.json();
                        console.error("Error response:", errorData);
                        throw new Error(errorData.message || "Failed to add document.");
                    }
    
                    const data = await response.json();
                    console.log("Document added successfully:", data);
    
                    // Display success message and reset the form
                    alert("Document uploaded successfully!");
                    document.getElementById("documentForm").reset();
                    window.location.href = '/documentlist'; // Redirect to document list page
                } catch (error) {
                    console.error("Error while adding document:", error);
                    alert("Failed to add document: " + error.message);
                }
            });
        });
    </script>
    
@endsection
