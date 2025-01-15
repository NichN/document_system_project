<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>

<body>
    <form id="loginForm" action="{{ route('login.post') }}" method="POST">
        @csrf
        <div class="login-container">
            <img src="/Image/norton.png" alt="Logo">
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn">Login</button>
        </div>
    </form>

    <script>
        document.getElementById("loginForm").addEventListener("submit", async function (event) {
            event.preventDefault(); // Prevent default form submission

            // Get form data
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;

            try {
                // Send a POST request to the external API
                const response = await fetch("http://127.0.0.1:3000/api/auth/login", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json", // Set content type
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value // Laravel CSRF token
                    },
                    body: JSON.stringify({ email, password }) // Send JSON body
                });

                const loginData = await response.json(); // Read response body once

                // Check if the response is successful
                if (!response.ok) {
                    throw new Error(loginData.message || "Failed to login.");
                }

                // Store the authentication token

                console.log("Login successful:", loginData);
                localStorage.setItem('authToken', loginData.token);

                alert("Login successful!");
                window.location.href = '/'; // Redirect after successful login
            } catch (error) {
                console.error("Error during login:", error);
                alert("Login failed: " + error.message);
            }
        });
    </script>


</body>

</html>