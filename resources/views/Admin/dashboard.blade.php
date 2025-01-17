@extends('Layouts.app')

@section('title', 'Document List')

@section('content')
    <h1>Document List</h1>
    <a href="{{route('new_document')}}" class="btn btn-primary">Create Document</a>
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
        <tbody id="documentTableBody"></tbody>
    </table>    
    <script>
    document.addEventListener("DOMContentLoaded", function () {
    const token = localStorage.getItem('authToken');
    if (!token) {
        alert("No authentication token found. Please log in.");
        return;
    }

    fetch("http://localhost:8000/api/documents", {
        method: "GET",
        headers: {
            "Authorization": `Bearer ${token}`,
            "Content-Type": "application/json"
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Failed to fetch documents.");
        }
        const contentType = response.headers.get("Content-Type");
        if (contentType && contentType.includes("application/json")) {
            return response.json();  
        } else {
            return response.text(); 
        }
    })
    .then(data => {
        if (typeof data === "string") {
            console.error("Expected JSON but got text:", data);
            alert("Received unexpected data. Please check the console for details.");
            return;
        }

        console.log(data);

        if (!Array.isArray(data)) {
            throw new Error("Unexpected response format");
        }

        const documentList = document.getElementById("documentTableBody");
        data.forEach(doc => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td>${doc.id}</td>
                <td>${doc.title}</td>
                <td>${doc.description}</td>
                <td>${doc.type}</td>
                <td><a href="/storage/${doc.file_path}" target="_blank">View Document</a></td>
                <td>${doc.uploaded_by}</td>
                <td>${new Date(doc.created_at).toLocaleString()}</td>
                <td>${new Date(doc.updated_at).toLocaleString()}</td>
                <td>
                    <button class="btn btn-sm btn-warning" onclick="editDocument(${doc.id})">Edit</button>
                    <button class="btn btn-sm btn-danger" onclick="deleteDocument(${doc.id})">Delete</button>
                </td>
            `;
            documentList.appendChild(row);
        });
    })
    .catch(error => {
        console.error("Error fetching documents:", error);
        alert("Failed to fetch documents.");
    });
});
function editDocument(id) {
    window.location.href = `/edit_document/${id}`;
}
function deleteDocument(id) {
    const token = localStorage.getItem('authToken');

    if (!token) {
        alert("No authentication token found. Please log in.");
        return;
    }
    fetch(`http://localhost:8000/api/documents/${id}`, {
        method: "DELETE",
        headers: {
            "Authorization": `Bearer ${token}`,
            "Content-Type": "application/json"
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error("Failed to delete document.");
        }
        alert("Document deleted successfully.");
        location.reload();
    })
    .catch(error => {
        console.error("Error deleting document:", error);
        alert("Failed to delete document.");
    });
}


</script>
@endsection
