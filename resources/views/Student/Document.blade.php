<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
    integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <link href="{{ asset('css/document.css') }}" rel="stylesheet">
  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">
  <link href="{{ asset('css/footer.css') }}" rel="stylesheet">


  <title>Document</title>

  <style>
    .navbar {
      display: flex;
      justify-content: space-around;
      padding: 10px 20px;
      background-color: #f8f9fa;
      border-bottom: 1px solid #ddd;
    }

    .img-logo {
      height: 50px;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 10px;
      /* Space between username and menu icon */
    }

    .menu-toggle {
      cursor: pointer;
    }

    #menuItems {
      position: absolute;
      top: 60px;
      background-color: #fff;
      border: 1px solid #ddd;
      padding: 10px;
      list-style: none;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    #menuItems.hidden {
      display: none;
    }

    #menuItems li {
      margin: 5px 0;
    }
  </style>
</head>

<body>
  <nav class="navbar">
    <img class="img-logo" src="{{asset('image/Norton.png')}}" alt="Logo">
    <div id="navbar_setting" class="user-info">
      <script>
        document.addEventListener("DOMContentLoaded", async function () {
          const navbarSetting = document.getElementById('navbar_setting');

          if (!navbarSetting) {
            console.error("Element with id 'navbar_setting' not found.");
            return;
          }

          const token = localStorage.getItem('authToken');

          if (token) {
            try {
              const response = await fetch("http://127.0.0.1:3000/api/auth/get-users", {
                method: "GET",
                headers: {
                  "Authorization": `Bearer ${token}`,
                  "Content-Type": "application/json"
                }
              });

              if (!response.ok) {
                throw new Error("Failed to fetch user data.");
              }

              const users = await response.json(); // Expecting an array of users
              console.log("Fetched users:", users); // Debugging API response

              // Identify the logged-in user (replace 'id' with a proper identifier, if necessary)
              const loggedInUser = users.find(user => user.role === 'Super Admin'); // Example: find user by role
              if (!loggedInUser) {
                console.error("No matching user found.");
                navbarSetting.innerHTML = `
                          <li><a href="{{ route('login') }}">Login</a></li>`;
                return;
              }

              const username = loggedInUser.username || "Unknown User";
              const role = loggedInUser.role || "Guest";

              let menuHTML = `
                      <span>${username}</span>
                      <a class="menu-toggle" onclick="toggleMenu()">
                          <i class="fa-solid fa-bars"></i>
                      </a>
                      <ul id="menuItems" class="hidden">`;
              if (role === 'Super Admin') {
                menuHTML += `
                          <li><a href="{{ route('adminlist') }}">Admin</a></li>
                          <li><a href="{{ route('teacherlist') }}">Teacher</a></li>
                          <li><a href="#" onclick="logout()">Logout</a></li>`;
              } else if (role === 'Admin') {
                menuHTML += `
                          <li><a href="{{ route('teacherlist') }}">Teacher</a></li>
                          <li><a href="#" onclick="logout()">Logout</a></li>`;
              } else if (role === 'Teacher' || role === 'Student') {
                menuHTML += `
                          <li><a href="#" onclick="logout()">Logout</a></li>`;
              }

              menuHTML += `</ul>`;
              navbarSetting.innerHTML = menuHTML;
            } catch (error) {
              console.error("Error fetching user data:", error);
            }
          } else {
            navbarSetting.innerHTML = `
                  <li><a href="{{ route('login') }}">Login</a></li>`;
          }
        });

        function toggleMenu() {
          const menu = document.getElementById('menuItems');
          menu.classList.toggle('hidden');
        }

        function logout() {
          event.preventDefault();
          localStorage.removeItem('authToken');
          window.location.href = '{{ route('logout') }}';
        }
      </script>
    </div>
  </nav>
  <div class="image-container">
    <img class="img-bg" src="{{ asset('image/norton_bg.jpg')}}" alt="Background">
    <div class="dark-overlay">
    </div>
    <h1 class="image-title">Document Feature</h1>
  </div>
  <form class="navbar-form navbar-left" role="search">
    <input type="text" id="searchBox" class="form-control" placeholder="Search documents" onkeyup="searchDocuments()">
    <a>
      <button type="button" class="btn btn-primary">Search</button>
    </a>
  </form>
  <div class="container">
    <div class="row">
      @foreach($card as $item)
      <div class="col-md-3" data-title="{{ $item['title'] }}" data-description="{{ $item['description'] }}">
      <div class="card">
        <div class="card-body mt-3">
        <h4 class="card-title text-primary text-center"><strong>{{ $item['title'] }}</strong></h4>
        <p class="card-text text-center">{{ $item['description'] }}</p>
        <div style="margin-left: 10px" class="bootom-text">
          <i class="far fa-comment" onclick="toggleCommentForm()"></i>
          <p style="color:brown"> by: {{ $item['teacher'] }}</p>
        </div>
        <div class="overlay">
          <a href="{{ route('detail') }}">
          <button type="button" class="btn-primary btn-block">View</button>
          </a>
        </div>
        </div>
      </div>
      </div>

    @endforeach
    </div>
  </div>
  <script>
    function searchDocuments() {
      // Get the search input value
      const query = document.getElementById('searchBox').value.toLowerCase();

      // Get all document cards
      const cards = document.querySelectorAll('.col-md-3');

      // Loop through each card
      cards.forEach(card => {
        const title = card.getAttribute('data-title').toLowerCase();
        const description = card.getAttribute('data-description').toLowerCase();

        // Check if the search query matches the title or description
        if (title.includes(query) || description.includes(query)) {
          card.style.display = ''; // Show the card
        } else {
          card.style.display = 'none'; // Hide the card
        }
      });
    }

  </script>
  <footer>
    <div class="info">
      <a><i class="fa-brands fa-telegram"></i></a>
      <a><i class="fa-brands fa-instagram"></i></a>
      <a><i class="fa-brands fa-facebook"></i></a>
      <a><i class="fa-brands fa-whatsapp"></i></a>
    </div>
    <p style="margin-top: 20px;">Copyright © Norton University</p>
  </footer>
</body>

</html>