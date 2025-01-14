
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="{{ asset('css/document.css') }}" rel="stylesheet">
    <title>Document</title>
</head>
<body>
    <nav class="navbar">
        <img class="img-logo" src="{{ asset('image/Norton.png') }}" alt="Logo">
        <div class="btn-group">
            <button onclick="window.location.href='{{ route('login') }}'" class="btn-lan">Login</button>
        </div>
    </nav>

    <div class="image-container">
        <img class="img-bg" src="{{ asset('image/norton_bg.jpg')}}" alt="Background">
        <div class="dark-overlay"></div>
        <h1 class="image-title">Document Feature</h1>
    </div>

    <div class="container">
        <div class="card-list">
            @foreach($card as $item)
            <div class="card">
                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}">
                <div class="image-label">{{ $item['title'] }}</div>
                <div class="overlay">
                    <button>Read</button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</body>
</html>

