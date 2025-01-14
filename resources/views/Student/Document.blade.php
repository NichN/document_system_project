
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="{{ asset('css/document.css') }}" rel="stylesheet">
    <title>Document</title>
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
    <div class="image-container">
        <img class="img-bg" src="{{ asset('image/norton_bg.jpg')}}" alt="Background">
        <div class="dark-overlay">
        </div>
        <h1 class="image-title">Document Feature</h1>
    </div>
    <form class="navbar-form navbar-left" role="search">
      <div class="form-group">
        <input type="text" class="form-control" placeholder="Search">
      </div>
      <a>
        <button type="button" class="btn btn-primary">Search</button>
      </a>
    </form>
    <div class="container">
      <div class="row">
          @foreach($card as $item)
          <div class="col-md-3">
              <div class="card">
                  <div class="card-body mt-3">
                      <h4 class="card-title text-primary text-center"><strong>{{ $item['title'] }}</strong></h4>
                      <p class="card-text text-center">{{ $item['description'] }}</p>
                      <div style="margin-left: 10px" class="bootom-text">
                        <i class="far fa-comment" onclick="toggleCommentForm()"></i>
                        <p style="color:brown"> by:{{$item['teacher']}}</p>
                    </div>
                    <div id="commentForm" style="display:none">
                      <form action="Document.blade.php" method="POST">
                          <input name="comment" placeholder="Write your comment here..." required></input><br>
                          <input type="submit" value="done"></input>
                      </form>
                  </div>
                  <?php
                    if(isset($_POST['submit'])){
                      $comment=$_POST('comment');
                    }
                 ?>
                  <div class="overlay">
                    <a href="{{route('detail')}}">
                      <button type="button" class="btn-primary btn-block">View</button>
                    </a>    
                      </div>
                  </div>
              </div>
          </div>
          @endforeach
      </div>
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
<script src={{ asset('js/cmtform.js')}}></script>
</body>
</html>


