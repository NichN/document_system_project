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


  <title>Document</title>
  <style>
    .navbar {
      background-color: #3498db;
      /* Light background */
      border: none;
      padding: 20px 30px;
    }

    .image-container {
      position: relative;
      width: 100%;
      height: 300px;
      overflow: hidden;
    }

    .img-bg {
      width: 100%;
      height: 100%;
      object-fit: cover;
      display: block;
      position: absolute;
      top: 0;
      left: 0;
      z-index: 1;
    }

    .img-logo {
      max-height: 40px;
      /* Restrict the logo height */
    }

    .user-info {
      display: flex;
      align-items: center;
    }

    .user-info .menu-toggle {
      margin-left: 10px;
      cursor: pointer;
    }

    .hidden {
      display: none;
    }

    .menu-toggle {
      font-size: 1.5rem;
      margin-left: 10px;
      cursor: pointer;
    }

    .image-container h1 {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      z-index: 3;
      color: #fff;
      font-size: 2.5rem;
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
    }

    .card {
      width: 270px;
      margin-top: 30px;
      border: none;
      border-radius: 8px;
      overflow: hidden;
      background: #fff;
      box-shadow: 4px 4px 10px rgba(0, 0, 0, 0.25);
    }

    .container {
      margin-top: 50px;
    }

    .hidden {
      display: none;
      /* Initially hidden */
    }

    .dropdown-menu {
      min-width: 200px;
      /* Adjust width */
      padding: 10px 0;
      /* Spacing inside the dropdown */
      background-color: #ffffff;
      /* White background */
      border-radius: 8px;
      /* Rounded corners */
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
      /* Subtle shadow */
      position: absolute;
      /* Position dropdown */
      top: 50px;
      /* Adjust positioning relative to icon */
      right: 0;
      /* Align dropdown to the right */
      z-index: 1000;
      /* Ensure it appears above other elements */
      list-style: none;
      /* Remove bullet points */
    }

    .dropdown-menu li a {
      color: #333333;
      /* Neutral text color */
      padding: 10px 20px;
      /* Add padding around links */
      display: block;
      /* Full width clickable */
      text-decoration: none;
      /* Remove underlines */
      font-size: 14px;
      /* Slightly larger font */
      transition: background-color 0.3s, color 0.3s;
      /* Smooth hover effects */
    }

    .dropdown-menu li a:hover {
      background-color: #f1f1f1;
      /* Light background on hover */
      color: #007bff;
      /* Accent color */
    }




    .dropdown-menu li {
      list-style: none;
      /* Remove bullet points */
    }



    .menu-toggle {
      font-size: 1.5rem;
      cursor: pointer;
      color: #ffffff;
      /* White color for the icon */
    }

    .hidden {
      display: none;
      /* Initially hide the dropdown */
    }

    .dropdown-menu-right {
      right: 0;
      left: auto;
      /* Align menu to the right */
    }

    footer {
      width: 100%;
      height: 120px;
      background-color: #3498db;
      margin-top: 50px;
      padding: 20px 0;
      text-align: center;
      color: white;
    }

    footer .info {
      display: flex;
      justify-content: center;
      gap: 20px;
    }

    footer .info a {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 40px;
      height: 40px;
      border-radius: 50%;
      background-color: black;
      text-decoration: none;
    }

    .bootom-text {
      justify-content: space-between;
      display: flex;
    }
  </style>

</head>

<body>
  <nav class="navbar">
    <img class="img-logo" src="{{asset('image/Norton.png')}}" alt="Logo">
    <div class="navbar-right user-info" id="navbar_setting">
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

        document.addEventListener('click', (event) => {
          const menu = document.getElementById('menuItems');
          const toggleButton = document.querySelector('.menu-toggle');

          // Close dropdown if clicked outside
          if (menu && !menu.contains(event.target) && !toggleButton.contains(event.target)) {
            menu.classList.add('hidden');
          }
        });

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