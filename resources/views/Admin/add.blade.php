@extends('Layouts.app')

@section('title', 'Create Document')

@section('content')
<h1>Create Document</h1>
<form id="documentForm" action="/upload" enctype="multipart/form-data" method="POST">
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
            <option value="Newspaper">Newspaper</option>
            <option value="Project">Project</option>
        </select>
    </div>
    <div class="form-group">
        <label for="file_path">Document</label>
        <input type="file" class="form-control" id="file_path" name="file_path" required>
        <div id="filePreview"></div>
    </div>
    <button type="submit" id="submitBtn" class="btn btn-success">Submit</button>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("file_path").addEventListener("change", function () {
            const file = this.files[0];
            const previewContainer = document.getElementById("filePreview");

            previewContainer.innerHTML = ""; // Clear previous preview

            if (file) {
                const reader = new FileReader();

                reader.onload = function (event) {
                    const fileType = file.type;

                    if (fileType.startsWith("image/")) {
                        const img = document.createElement("img");
                        img.src = event.target.result;
                        img.alt = "Document Preview";
                        img.style.maxWidth = "300px";
                        previewContainer.appendChild(img);
                    } else {
                        const fileName = document.createElement("p");
                        fileName.textContent = `File Selected: ${file.name}`;
                        previewContainer.appendChild(fileName);
                    }
                };

                reader.readAsDataURL(file);
            }
        });
        document.getElementById("documentForm").addEventListener("submit", async function (event) {
            event.preventDefault();

            const title = document.getElementById("title").value;
            const description = document.getElementById("description").value;
            const type = document.getElementById("type").value;
            const documentFile = document.getElementById("file_path").files[0];
            const token = localStorage.getItem('authToken');
            if (!token) {
                alert("No authentication token found. Please log in.");
                return;
            }
            if (!documentFile) {
                alert("Please select a document to upload.");
                return;
            }

            const formData = new FormData();
            formData.append("title", title);
            formData.append("description", description);
            formData.append("type", type);
            formData.append("file_path", documentFile);

            try {
                const response = await fetch("http://localhost:8000/api/documents/upload", {
                    method: "POST",
                    headers: {
                        "Authorization": `Bearer ${token}`, 
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value 
                    },
                    body: formData, 
                });

                const responseText = await response.text();
                if (!response.ok) {
                    console.error("Error response:", responseText);
                    alert("Failed to add document. Please check the server logs.");
                    return;
                }
                const data = JSON.parse(responseText);
                alert("Document uploaded successfully!");
                document.getElementById("documentForm").reset();
                window.location.href = '/dashboard';
            } catch (error) {
                console.error("Error while adding document:", error);
                alert("Failed to add document: " + error.message);
            }
        });
    });
</script>

@endsection
