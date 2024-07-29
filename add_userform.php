<?php
ob_start(); // Warning: Cannot modify header information - headers already sent by (output started)
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add User</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">User Management</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
		
        <div class="collapse navbar-collapse" id="navbarNav">
		<?php if (isset($_SESSION['role_name'])){ ?>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="admin_dashboard.php">Users</a>
                </li>
            </ul>
		
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
		<?php }?>
        </div>
    </nav>
<div class="container">
    <h2>Add User</h2>
    <form id="add-user-form" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="mobile">Mobile</label>
            <input type="text" class="form-control" id="mobile" name="mobile">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email">
        </div>
        <div class="form-group">
            <label for="address">Address (Location)</label>
            <input type="text" name="address" id="address" class="form-control">
            <button type="button" id="getLocation" class="btn btn-primary mt-2">Get My Location</button>
        </div>
        <div class="form-group">
            <label for="gender">Gender</label>
            <select class="form-control" id="gender" name="gender">
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </div>
        <div class="form-group">
            <label for="date_of_birth">Date of Birth</label>
            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
        </div>
        <div class="form-group">
            <label for="profile_picture">Profile Picture</label>
            <input type="file" class="form-control" id="profile_picture" name="profile_picture">
        </div>
        <div class="form-group">
            <label for="signature">Signature</label>
            <input type="text" class="form-control" id="signature" name="signature">
        </div>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary">Create User</button>
		<a href="admin_dashboard.php"><button type="button" class="btn btn-primary">Back</button></a>
    </form>
</div>

<script>
	document.getElementById('getLocation').addEventListener('click', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(showPosition);
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    });
	
	function showPosition(position) {
        const lat = position.coords.latitude;
        const lng = position.coords.longitude;
		const apikey = '037b472cfa734bf6afa32955580f5924';
		// my google key having issues.
		var apiURL =  'https://api.opencagedata.com/geocode/v1/json?key='+apikey+'&q='+lat+'%2C+'+lng;
        // Use OpenCage Geocoding API to convert coordinates to address
        fetch(apiURL)
            .then(response => response.json())
            .then(data => {
                if (data.results && data.results.length > 0) {
                    const address = data.results[0].formatted;
                    document.getElementById('address').value = address;
                } else {
                    alert("Unable to retrieve address.");
                }
            })
            .catch(error => console.error('Error:', error));
    }
	
    $(document).ready(function () {
        $('#add-user-form').on('submit', function (e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                url: 'add_user.php',
                method: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    alert(response);
                    if (response.trim() === "User added successfully") {
                        window.location.href = "admin_dashboard.php";
                    }
                }
            });
        });
    });
</script>

</body>
</html>
