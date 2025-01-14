<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
        <img class="img-logo" src="{{ asset('image/Norton.png') }}" alt="Logo">
        <div id="navbar_setting">
                <li><a href="#">Teacher</a></li>
                <li><a href="#">Admin</a></li>
                <li><a href="#">Setting</a></li>
                <li><a href="#">Logout</a></li>
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
        <p class="text-center">© 2025 Norton University</p>
    </footer>
    <script src="{{ asset('js/navigation.js') }}"></script>
</body>
</html>
