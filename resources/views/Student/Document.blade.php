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
  <link rel="stylesheet" href="{{ asset('css/document.css') }}">
  <title>Document</title>
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
              const response = await fetch("http://localhost:8000/api/auth/get-users", {
                method: "GET",
                headers: {
                  "Authorization": `Bearer ${token}`,
                  "Content-Type": "application/json"
                }
              });

              if (!response.ok) {
                throw new Error("Failed to fetch user data.");
              }

              const users = await response.json();
              console.log("Fetched users:", users);

              const loggedInUser = users.find(user => user.role === 'Super Admin');
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
  <div class="container mt-5">
    <h1 class="text-center">Document Viewer</h1>
    <div id="documentContainer" class="row">
    </div>
  </div>
  <script>
    document.addEventListener("DOMContentLoaded", function () {
      fetchDocuments();
    });

    function fetchDocuments() {
      const token = localStorage.getItem('authToken');
      fetch("http://localhost:8000/api/documents", {
        method: "GET",
        headers: {
          "Authorization": `Bearer ${token}`,
          "Content-Type": "application/json"
        }
      })
        .then(response => {
          if (!response.ok) {
            throw new Error("Failed to fetch documents");
          }
          return response.json();
        })
        .then(data => {
          const container = document.querySelector('#documentContainer');
          if (!data || data.length === 0) {
            container.innerHTML = `<p class="text-center">No documents available at the moment.</p>`;
            return;
          }
          renderDocuments(data, container);
        })
        .catch(error => {
          console.error("Error fetching documents:", error);
          document.querySelector('#documentContainer').innerHTML = `
        <p class="text-center text-danger">Failed to load documents. Please try again later.</p>`;
        });
    }

    function renderDocuments(documents, container) {
      container.innerHTML = "";
      documents.forEach(doc => {
        container.innerHTML += `
      <div class="col-md-3" data-title="${doc.title.toLowerCase()}" data-description="${doc.description.toLowerCase()}">
        <div class="card">
          <div class="card-body mt-3">
            <h4 class="card-title text-primary text-center"><strong>${doc.title}</strong></h4>
            <p class="card-title text-primary text-center truncated-description" id="description" style="color:black"> ${doc.description}</p>
            <button id="toggleDescription" class="btn btn-link" style="display: none;">Read More</button>
            <p class="card-text text-center"></p>
            <p class="text-center" style="color:brown">upload by: ${doc.uploaded_by}</p>
            <a href="/document/detail/${doc.id}" target="_self">
               <button type="button" class="btn btn-primary btn-block" onclick="viewDocument(${doc.id})">View</button>
            </a>
          </div>
        </div>
      </div>`;
      });
    }
    document.addEventListener('DOMContentLoaded', function () {
      const descriptionElement = document.getElementById('description');
      const toggleButton = document.getElementById('toggleDescription');
      if (descriptionElement) {
        const fullDescription = descriptionElement.textContent.trim();
        const maxLength = 100;
        if (fullDescription.length > maxLength) {
          const truncatedDescription = fullDescription.slice(0, maxLength) + '...';
          descriptionElement.textContent = truncatedDescription;
          toggleButton.style.display = 'inline';
        }

        toggleButton.addEventListener('click', () => {
          const isTruncated = descriptionElement.textContent.endsWith('...');
          descriptionElement.textContent = isTruncated ? fullDescription : fullDescription.slice(0, maxLength) + '...';
          toggleButton.textContent = isTruncated ? 'Show Less' : 'Read More';
        });
      }
    });

    function searchDocuments() {
      const query = document.getElementById('searchBox').value.toLowerCase();
      const cards = document.querySelectorAll('.col-md-3');

      cards.forEach(card => {
        const title = card.getAttribute('data-title').toLowerCase();
        const description = card.getAttribute('data-description').toLowerCase();

        if (title.includes(query) || description.includes(query)) {
          card.style.display = '';
        } else {
          card.style.display = 'none';
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