@extends('Layouts.app')

@section('title', 'Teacher List')

@section('content')
<h1>AdminList</h1>
<a href="{{ route('create_admin') }}" class="btn btn-primary">Add Admin</a>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Role</th>
            <th>Created At</th>
            <th>Updated At</th>
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
            .then(response => response.json())
            .then(data => {
                const adminList = document.getElementById("admin-list");
                data.forEach(user => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${user.id}</td>
                        <td>${user.username}</td>
                        <td>${user.email}</td>
                        <td>${user.role}</td>
                       
                        <td>
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

    function deleteUser(userId) {
        const token = localStorage.getItem('authToken');

        if (!token) {
            alert("No authentication token found. Please log in.");
            return;
        }

        fetch(`http://127.0.0.1:3000/api/auth/delete-user/${userId}`, {
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