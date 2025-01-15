<!-- filepath: /Users/sunnasy/Desktop/Co4_ES1/Software Engineering/document_system_project/resources/views/Admin/adminlist.blade.php -->
@extends('Layouts.app')

@section('title', 'Admin List')

@section('content')
<h1>Admin List</h1>
<a href="{{ route('create_admin') }}" class="btn btn-primary">Add Admin</a>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="admin-list"></tbody>
</table>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const token = localStorage.getItem('authToken');

        if (!token) {
            alert("No authentication token found. Please log in.");
            return;
        }

        fetch("http://127.0.0.1:3000/api/auth/get-users", {
            method: "GET",
            headers: {
                "Authorization": `Bearer ${token}`,
                "Content-Type": "application/json"
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Failed to fetch admin list.");
                }
                return response.json();
            })
            .then(data => {
                console.log(data); // Log the response data to inspect its structure
                if (!Array.isArray(data)) {
                    throw new Error("Unexpected response format");
                }
                const adminList = document.getElementById("admin-list");
                data.forEach(user => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                    <td>${user.id}</td>
                    <td>${user.username}</td>
                    <td>${user.email}</td>
                    <td>${user.role}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" onclick="editUser(${user.id})">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteUser(${user.id})">Delete</button>
                    </td>
                `;
                    adminList.appendChild(row);
                });
            })
            .catch(error => {
                console.error("Error fetching admin list:", error);
                alert("Failed to fetch admin list.");
            });
    });



    function editUser(userId) {
        window.location.href = `/edit_user/${userId}`;
    }

    function deleteUser(userId) {
        const token = localStorage.getItem('authToken');

        if (!token) {
            alert("No authentication token found. Please log in.");
            return;
        }

        fetch(`http://127.0.0.1:3000/api/auth/delete/${userId}`, {
            method: "DELETE",
            headers: {
                "Authorization": `Bearer ${token}`,
                "Content-Type": "application/json"
            }
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error("Failed to delete user.");
                }
                alert("User deleted successfully.");
                location.reload(); // Reload the page to update the list
            })
            .catch(error => {
                console.error("Error deleting user:", error);
                alert("Failed to delete user.");
            });
    }
</script>
@endsection