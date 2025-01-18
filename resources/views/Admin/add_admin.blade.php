@extends('Layouts.app')

@section('title', 'Add Admin')

@section('content')
<h1>Add Admin</h1>
<form id="addAdminForm" method="POST" action="{{ route('create_admin') }}">
    @csrf
    <div class="form-group">
        <label for="username">Name</label>
        <input type="text" class="form-control" id="username" name="username" placeholder="Enter teacher's name"
            required autocomplete="off">
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Enter teacher's email" required>
    </div>
    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" placeholder="Enter teacher's password"
            required autocomplete="off">

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
    <button type="submit" class="btn btn-primary">Add Admin</button>
</form>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("addAdminForm").addEventListener("submit", async function (event) {
            event.preventDefault();

            const username = document.getElementById("username").value;
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;
            const role = document.querySelector('input[name="role"]:checked').value;

            // Get token from localStorage
            const token = localStorage.getItem('authToken');

            if (!token) {
                alert("No authentication token found. Please log in.");
                return;
            }

            try {
                // Send a POST request to the API
                const response = await fetch("http://localhost:8000/api/auth/add-user", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json", // Set content type
                        "Authorization": `Bearer ${token}`, // Include the token
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value // Laravel CSRF token
                    },
                    body: JSON.stringify({ username, email, password, role }), // Send JSON body
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    console.error("Error response:", errorData);
                    throw new Error(errorData.message || "Failed to add admin.");
                }

                const data = await response.json();
                console.log("Admin added successfully:", data);

                // Display success message and reset the form
                alert("Admin added successfully!");
                document.getElementById("addAdminForm").reset();
                window.location.href = '/adminlist'; // Redirect to admin list
            } catch (error) {
                console.error("Error while adding admin:", error);
                alert("Failed to add admin: " + error.message);
            }
        });
    });
</script>
@endsection