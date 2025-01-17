@extends('Layouts.app')

@section('title', 'Teacher List')

@section('content')
<h1>Teacher List</h1>
<a href="{{ route('create_teacher') }}" class="btn btn-primary">Add Teacher</a>
<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody id="teacher-list"></tbody>
</table>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const token = localStorage.getItem('authToken');

        if (!token) {
            alert("No authentication token found. Please log in.");
            return;
        }

        fetch("http://localhost:8000/api/auth/get-users", {
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
                const adminList = document.getElementById("teacher-list");

                // Filter only users with the role "Admin"
                const admins = data.filter(user => user.role === 'Teacher');

                admins.forEach(user => {
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

        fetch(`http://localhost:8000/api/auth/delete/${userId}`, {
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