@extends('Layouts.app')

@section('title', 'Edit User')

@section('content')
<h1>Edit User</h1>
<form id="editUserForm" method="POST" action="{{ route('update_user', $user->id) }}">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="username">Name</label>
        <input type="text" class="form-control" id="username" name="username" value="{{ $user->username }}" required>
    </div>
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" required>
    </div>
    <div class="form-group">
        <label>Access Role</label>
        <div>
            <input type="radio" id="role-teacher" name="role" value="Teacher" {{ $user->role == 'Teacher' ? 'checked' : '' }}>
            <label for="role-teacher">Teacher</label>
        </div>
        <div>
            <input type="radio" id="role-admin" name="role" value="Admin" {{ $user->role == 'Admin' ? 'checked' : '' }}>
            <label for="role-admin">Admin</label>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Save Changes</button>
</form>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const userId = window.location.pathname.split('/').pop();
        const token = localStorage.getItem('authToken');

        if (!token) {
            alert("No authentication token found. Please log in.");
            return;
        }
        fetch(`http://localhost:8000/api/auth/get-user/${userId}`, {
            method: "GET",
            headers: {
                "Authorization": `Bearer ${token}`,
                "Content-Type": "application/json"
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Failed to fetch user data.");
                }
                return response.json();
            })
            .then(user => {
                document.getElementById("username").value = user.username;
                document.getElementById("email").value = user.email;
                document.querySelector(`input[name="role"][value="${user.role}"]`).checked = true;
            })
            .catch(error => {
                console.error("Error fetching user data:", error);
                alert("Failed to fetch user data.");
            });

        document.getElementById("editUserForm").addEventListener("submit", function (event) {
            event.preventDefault(); 

            const username = document.getElementById("username").value;
            const email = document.getElementById("email").value;
            const role = document.querySelector('input[name="role"]:checked').value;

            fetch(`http://127.0.0.1:3000/api/auth/edit/${userId}`, {
                method: "PUT",
                headers: {
                    "Authorization": `Bearer ${token}`,
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ username, email, role })
            })
                .then(response => {
                    if (!response.ok) {
                        throw new Error("Failed to update user.");
                    }
                    alert("User updated successfully.");
                    window.location.href = '/adminlist'; 
                })
                .catch(error => {
                    console.error("Error updating user:", error);
                    alert("Failed to update user.");
                });
        });
    });
</script>
@endsection