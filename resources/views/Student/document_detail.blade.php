<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="{{ asset('css/detial.css') }}" rel="stylesheet">
</head>

<body>
  <nav class="navbar">
    <img class="img-logo" src="{{asset('image/Norton.png')}}" alt="Logo">
    <form class="navbar-form navbar-right">
      @if (Auth::check())
      <a href="{{ route('profile') }}" class="btn"
      style="margin-right:20px; color: white; font-size:160%;">{{Auth::user()->username}}</a>

    @else
      <a href="{{route('login')}}">
      <button type="button" class="btn" style="margin-right:20px">Login</button>
      </a>
    @endif

    </form>
  </nav>
  <div class="container-detail">
    <a href="{{ route('document') }}"><i class="fa-solid fa-arrow-left"></i> Back</a>

    <h1 class="text-center">Software Engineering</h1>

    <img src="{{ asset('image/doc.png') }}" alt="Image description" class="img-responsive center-block">
    <p class="text-center">
      This page provides details about the selected document. Explore the content, and feel free to leave your comments
      below.
    </p>
    <div class="comment-section">
      <form method="POST">
        @csrf
        <label for="comment">Your Comment:</label>
        <div class="form-group" style="display: flex">
          <input class="form-control" id="comment" name="comment" placeholder="Write your comment here..." required
            style="max-width: 400px;">

          <button type="submit" class="btn btn-link" style="padding: 0; background: none; border: none;">
            <i class="fas fa-paper-plane" style="font-size: 18px; color: green; margin-left:10px"></i>
          </button>
        </div>
      </form>
    </div>



    {{-- <div class="comments-display">
      <h3>Comments</h3>
      @foreach($comments as $comment)
      <div class="comment-item">
        <p><strong>User:</strong> {{ $comment->user_name ?? 'Anonymous' }}</p>
        <p>{{ $comment->content }}</p>
        <hr>
      </div>
      @endforeach
    </div> --}}
  </div>
</body>

</html>