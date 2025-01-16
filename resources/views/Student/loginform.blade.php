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
            event.preventDefault(); 

            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;

            try {
                const response = await fetch("http://localhost:8000/api/auth/login", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json", 
                        "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value
                    },
                    body: JSON.stringify({ email, password })
                });

                const loginData = await response.json();

                if (!response.ok) {
                    throw new Error(loginData.message || "Failed to login.");
                }

                console.log("Login successful:", loginData);
                localStorage.setItem('authToken', loginData.token);

                alert("Login successful!");
                window.location.href = '/';
            } catch (error) {
                console.error("Error during login:", error);
                alert("Login failed: " + error.message);
            }
        });
    </script>
</body>
</html>