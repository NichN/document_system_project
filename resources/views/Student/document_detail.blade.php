<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Document Details</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('css/detial.css') }}" rel="stylesheet">
</head>

<body>
  <nav class="navbar">
    <img class="img-logo" src="{{ asset('image/Norton.png') }}" alt="Logo">
    <form class="navbar-form navbar-right">
      @if (Auth::check())
      <a href="{{ route('profile') }}" class="btn"
      style="margin-right:20px; color: white; font-size:160%;">{{ Auth::user()->username }}</a>
    @else
      <a href="{{ route('login') }}">
      <button type="button" class="btn" style="margin-right:20px">Login</button>
      </a>
    @endif
    </form>
  </nav>
  <div class="container-detail">
    <a href="{{ route('document') }}"><i class="fa-solid fa-arrow-left"></i> Back</a>

    <h1 class="text-center">{{ $document->title ?? 'Document Details' }}</h1>

    <img src="{{ asset('image/doc.png') }}" alt="Image description" class="img-responsive center-block">
    <p class="text-center">
      This page provides details about the selected document. Explore the content, and feel free to leave your comments
      below.
    </p>

    <div class="comment-section">
      <form id="commentForm" method="POST">
        @csrf
        <!-- Hidden field for Document ID -->
        <input type="hidden" id="documentId" name="documentId" value="{{ $document->id }}">

        <label for="comment">Your Comment:</label>
        <div class="form-group" style="display: flex;">
          <input class="form-control" id="comment" name="comment" placeholder="Write your comment here..." required
            style="max-width: 400px;">
          <button type="submit" class="btn btn-link" style="padding: 0; background: none; border: none;">
            <i class="fas fa-paper-plane" style="font-size: 18px; color: green; margin-left: 10px;"></i>
          </button>
        </div>
      </form>
      <p id="responseMessage" style="color: green; display: none;"></p>

      <div id="commentsList">
        @if($comments->isNotEmpty())
      @foreach ($comments as $comment)
      <div class="comment">
      <p>{{ $comment->content }}</p>
      <small>by {{ $comment->user->username ?? 'Unknown User' }} on
      {{ $comment->created_at->format('Y-m-d H:i') }}</small>
      </div>
    @endforeach
    @else
    <p>No comments yet. Be the first to comment!</p>
  @endif
      </div>
    </div>

    <script>
      document.getElementById("commentForm").addEventListener("submit", async function (event) {
        event.preventDefault(); // Prevent default form submission

        // Get form data
        const documentId = document.getElementById("documentId").value;
        const comment = document.getElementById("comment").value;
        const token = document.querySelector('input[name="_token"]').value;

        try {
          const response = await fetch("{{ route('comments.store') }}", {
            method: "POST",
            headers: {
              "Content-Type": "application/json",
              "X-CSRF-TOKEN": token
            },
            body: JSON.stringify({ documentId, comment })
          });

          if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || "Failed to submit comment.");
          }

          const data = await response.json();

          // Display success message
          const responseMessage = document.getElementById("responseMessage");
          responseMessage.textContent = "Comment submitted successfully!";
          responseMessage.style.display = "block";

          // Add the new comment to the comments list
          const commentsList = document.getElementById("commentsList");
          const newComment = document.createElement("div");
          newComment.classList.add("comment");
          newComment.innerHTML = `
            <p>${data.comment.content}</p>
            <small>by ${data.comment.user.username || 'Unknown User'} on ${data.comment.created_at}</small>
          `;
          commentsList.appendChild(newComment);

          // Clear the comment input field
          document.getElementById("comment").value = "";
        } catch (error) {
          alert("Failed to submit comment: " + error.message);
        }
      });
    </script>
  </div>
</body>

</html>