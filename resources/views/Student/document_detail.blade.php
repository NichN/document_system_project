<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link href="{{ asset('css/detial.css') }}" rel="stylesheet">
</head>
<body>
  <nav class="navbar">
    <img class="img-logo" src="{{asset('image/Norton.png')}}" alt="Logo">
    <form class="navbar-form navbar-right">
      @if (Auth::check())
        <a href="{{ route('profile') }}" class="btn" style="margin-right:20px; color: white; font-size:160%;">{{Auth::user()->username}}</a>
      @else
        <a href="{{route('login')}}">
          <button type="button" class="btn" style="margin-right:20px">Login</button>
        </a>
      @endif
    </form>
  </nav>

  <div class="container-detail">
    <a href="{{ route('document') }}" class="back-link"><i class="fa-solid fa-arrow-left"></i> Back</a>
    <h1 class="text-center">{{ $document->title }}</h1>

    <img src="{{ asset('image/doc.png') }}" alt="Image description" class="img-responsive center-block">
    <p class="text-center">{{ $document->description }}</p>
    <p class="text-center">Upload by: {{ $document->uploader->username }}</p>

    <div class="text-center">
        <button class="btn btn-primary mt-3" onclick="downloadDocument({{ $document->id }})">Download</button>
    </div>
    <div class="comment-section">
        <h3>Leave a Comment:</h3>
        <form id="commentForm">
            <div class="form-group" style="display: flex; justify-content: space-between;">
                <input class="form-control" id="comment" placeholder="Write your comment here..." required style="max-width: 75%; font-size: 1em;">
                <button type="submit" class="btn">Submit</button>
            </div>
        </form>

        <div id="commentsList" class="comments-list">
            <p>Loading comments...</p>
        </div>
    </div>
  </div>
  <script>
    async function loadComments() {
      const documentId = {{ $document->id }};
      const apiUrl = `http://localhost:8000/api/comments/${documentId}`;
      const authToken = localStorage.getItem('authToken');

      if (!authToken) {
        console.error("No token found. Please log in.");
        document.getElementById('commentsList').innerHTML = '<p>You need to be logged in to see comments.</p>';
        return;
      }

      try {
        const response = await fetch(apiUrl, {
          method: 'GET',
          headers: {
            'Authorization': `Bearer ${authToken}`,
          },
        });

        const data = await response.json();
        const commentsList = document.getElementById('commentsList');
        commentsList.innerHTML = '';

        if (data.length === 0) {
          commentsList.innerHTML = '<p>No comments yet. Be the first to comment!</p>';
        } else {
          data.forEach(comment => {
            const commentElement = document.createElement('div');
            commentElement.classList.add('comment');

            const decodedToken = JSON.parse(atob(authToken.split('.')[1]));
            const loggedInUserId = decodedToken.user_id; 

            commentElement.innerHTML = `
              <p>${comment.comment}</p>
              <small>by ${comment.username} on ${new Date(comment.created_at).toLocaleString()}</small>
            `;

            if (comment.user_id === loggedInUserId) {
              const editButton = document.createElement('button');
              editButton.classList.add('btn', 'btn-primary');
              editButton.textContent = 'Edit';
              editButton.onclick = () => editComment(comment.id);
              commentElement.appendChild(editButton);
              const deleteButton = document.createElement('button');
              deleteButton.classList.add('btn', 'btn-danger');
              deleteButton.textContent = 'Delete';
              deleteButton.onclick = () => deleteComment(comment.id);
              commentElement.appendChild(deleteButton);
            }

            commentsList.appendChild(commentElement);
          });
        }
      } catch (error) {
        console.error('Error loading comments:', error);
        document.getElementById('commentsList').innerHTML = '<p>Failed to load comments.</p>';
      }
    }

    loadComments();

    document.getElementById('commentForm').addEventListener('submit', async (e) => {
      e.preventDefault();

      const commentInput = document.getElementById('comment');
      const comment = commentInput.value.trim();

      if (!comment) {
        alert('Please enter a comment.');
        return;
      }

      const documentId = {{ $document->id }};
      const apiUrl = 'http://localhost:8000/api/comments';
      const token = localStorage.getItem('authToken'); 

      if (!token) {
        alert('You need to be logged in to submit a comment.');
        return;
      }

      try {
        const response = await fetch(apiUrl, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${token}`
          },
          body: JSON.stringify({ documentId, comment }),
        });

        if (!response.ok) {
          throw new Error('Failed to submit comment');
        }

        commentInput.value = '';
        loadComments();
      } catch (error) {
        console.error('Error submitting comment:', error);
        alert('Error submitting comment. Please try again.');
      }
    });

    function viewDocument(filePath) {
      const fileExtension = filePath.split('.').pop().toLowerCase();
      const previewContainer = document.getElementById('documentPreviewContainer');

      if (fileExtension === 'jpg' || fileExtension === 'jpeg' || fileExtension === 'png' || fileExtension === 'gif') {
        previewContainer.innerHTML = `<img src="${filePath}" alt="Document Image" class="img-responsive center-block" />`;
      } else if (fileExtension === 'pdf') {
        previewContainer.innerHTML = `<iframe src="${filePath}" width="100%" height="600px" frameborder="0"></iframe>`;
      } else {
        previewContainer.innerHTML = `<a href="${filePath}" target="_blank" class="btn btn-info">View Document</a>`;
      }
    }

    async function downloadDocument(documentId) {
      const apiUrl = `http://localhost:8000/api/documents/${documentId}/download`;

      try {
        const response = await fetch(apiUrl, {
          method: 'GET',
          headers: {
            'Authorization': `Bearer ${localStorage.getItem("authToken")}` 
          }
        });

        if (response.ok) {
          const blob = await response.blob();
          const link = document.createElement('a');
          link.href = window.URL.createObjectURL(blob);
          link.download = 'document.pdf'; 
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
        } else {
          throw new Error('Failed to download document');
        }
      } catch (error) {
        console.error('Error downloading document:', error);
        alert('Failed to download the document.');
      }
    }
  </script>
</body>
</html>
