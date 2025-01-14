<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="{{ asset('css/detial.css') }}" rel="stylesheet">
</head>
<body>
    <nav class="navbar">
      <img class="img-logo" src="{{asset('image/Norton.png')}}" alt="Logo">
      <form class="navbar-form navbar-right">
        <a href="{{route('login')}}">
          <button type="button" class="btn" style="margin-right:20px">Login</button>
        </a>
      </form>
  </nav>
</body>
</html>