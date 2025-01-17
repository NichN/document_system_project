<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
    <link href="{{ asset('css/footer.css') }}" rel="stylesheet">
</head>

<body>
    <nav class="navbar">
        <img class="img-logo" src="{{ asset('image/Norton.png') }}" alt="Logo">
        <div id="navbar_setting">
             <script>
                document.addEventListener("DOMContentLoaded", function () {
                    const token = localStorage.getItem('authToken');

                    if (token) {
                        fetch("http://localhost:8000/api/auth/get-users", {
                            method: "GET",
                            headers: {
                                "Authorization": `Bearer ${token}`,
                                "Content-Type": "application/json"
                            }
                        })
                            .then(response => response.json())
                            .then(user => {
                                if (user.role === 'Admin' || user.role === 'Super Admin') {
                                    document.getElementById('navbar_setting').innerHTML += `
                                                <li><a href="{{ route('teacherlist') }}"><i class="fas fa-chalkboard-teacher"></i> Teacher</a></li>
                                                <li><a href="{{ route('adminlist') }}"><i class="fas fa-user-shield"></i> Admin</a></li>
                                            `;
                                }
                                document.getElementById('navbar_setting').innerHTML += `
                                            <li><a href="{{ route('profile') }}"><i class="fas fa-user"></i> Profile</a></li>
                                            <li><a href="#" class="logout" onclick="logout()"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                                        `;
                            })
                            .catch(error => {
                                console.error("Error fetching user data:", error);
                            });
                    } else {
                        document.getElementById('navbar_setting').innerHTML += `
                                        <li><a href="{{ route('login') }}"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                                    `;
                    }
                });

                function logout() {
                    event.preventDefault();
                    localStorage.removeItem('authToken');
                    window.location.href = '{{ route('logout') }}';
                }
            </script>

        </div>
        <form class="navbar-form navbar-right">
            <a class="st-button" onclick="Navigation()">
                <i class="fa-solid fa-bars"></i>
            </a>
        </form>
    </nav>

    <div class="container">
        @yield('content')
    </div>
    <footer>
        <div class="info">
            <a><i class="fa-brands fa-telegram"></i></a>
            <a><i class="fa-brands fa-instagram"></i></a>
            <a><i class="fa-brands fa-facebook"></i></a>
            <a><i class="fa-brands fa-whatsapp"></i></a>
        </div>
        <p style="margin-top: 20px;">Copyright © Norton University</p>
    </footer>
    <script src="{{ asset('js/navigation.js') }}"></script>
</body>

</html>