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
    <style>
        .hidden {
            display: none;
        }

        .menu-toggle {
            cursor: pointer;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        ul li {
            margin: 5px 0;
        }
    </style>
</head>

<body>
    <nav class="navbar">
        <img class="img-logo" src="{{ asset('image/Norton.png') }}" alt="Logo">
        <div id="navbar_setting">


        </div>
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