@extends('Layouts.app')

@section('title', 'Create Document')

@section('content')
    <h1>Create Document</h1>
    <form id="documentForm" enctype="multipart/form-data">
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
        document.getElementById('submitBtn').addEventListener('click', async function () {
            const form = document.getElementById('documentForm');
            const formData = new FormData(form);

            try {
                const apiUrl = "{{ route('store_document') }}";

                const response = await fetch('http://localhost:3000/api/documents/upload', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                });

                if (response.ok) {
                    const result = await response.json();
                    console.log('Document uploaded successfully:', result);
                    alert('Document uploaded successfully');
            
                } else {
                    const error = await response.json();
                    console.error('Error uploading document:', error);
                    alert('Failed to upload document: ' + (error.message || 'Unknown error'));
                }
            } catch (err) {
                console.error('Error:', err);
                alert('Error uploading document');
            }
        });
    </script>
@endsection
