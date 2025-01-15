<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        .profile-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            border-radius: 8px;
            background-color: #f8f9fa;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-img-container {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #ddd;
            margin-bottom: 10px;
        }
        .upload-btn {
            font-size: 16px;
            color: #007bff;
            cursor: pointer;
        }
        .form-group input, .form-group select, .form-group textarea {
            border-radius: 5px;
        }
        .form-group label {
            font-weight: bold;
        }
        .submit-btn {
            background-color: #28a745;
            color: white;
            font-size: 16px;
            padding: 10px 20px;
            border-radius: 5px;
            border: none;
            width: 100%;
        }
    </style>
</head>
<body>

    <div class="container profile-container">
        <div class="profile-header">
            <h2>User Profile</h2>
            <p>Edit your details</p>
        </div>

        <div class="profile-img-container">
            <img src="https://via.placeholder.com/120" alt="Profile Picture" class="profile-img" id="profileImg">
            <div>
                <input type="file" id="fileInput" style="display: none;" accept="image/*" onchange="previewImage(event)">
                <label for="fileInput" class="upload-btn">Upload Profile Picture</label>
            </div>
        </div>

        <form action="#" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Full Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Enter your phone number">
            </div>

            <div class="form-group">
                <label for="gender">Gender</label>
                <select class="form-control" id="gender" name="gender">
                    <option value="">Select Gender</option>
                    <option value="male">Male</option>
                    <option value="female">Female</option>
                    <option value="other">Other</option>
                </select>
            </div>

            <div class="form-group">
                <label for="bio">Biography</label>
                <textarea class="form-control" id="bio" name="bio" rows="3" placeholder="Tell us something about yourself"></textarea>
            </div>

            <button type="submit" class="submit-btn">Save Changes</button>
        </form>
    </div>

    <script>
        function previewImage(event) {
            const output = document.getElementById('profileImg');
            output.src = URL.createObjectURL(event.target.files[0]);
        }
    </script>

</body>
</html>
