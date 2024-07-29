<?php
ob_start(); // Warning: Cannot modify header information - headers already sent by (output started)
session_start();
include_once 'Database.php';
include_once 'User.php';

// Redirect to login if not logged in
if (! isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$row = [];
// Fetch user details
if (isset($_GET['id']) && ! empty($_GET['id'])) {
    $row = $user->fetchProfile($_GET['id']);
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user->id = $_POST['id'];
    $user->name = $_POST['name'];
    $user->mobile = $_POST['mobile'];
    $user->email = $_POST['email'];
    $user->address = $_POST['address'];
    $user->gender = $_POST['gender'];
    $user->date_of_birth = $_POST['date_of_birth'];
    $user->signature = $_POST['signature'];

    if (! empty($_FILES['profile_picture']['name'])) {
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["profile_picture"]["name"]);
        if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $target_file)) {
            $user->profile_picture = $target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
            exit();
        }
    } else {
        $user->profile_picture = $_POST['hidden_profile_picture'] ?? '';
    }

    if ($user->updateProfile()) {
        echo "Profile updated successfully";
        $redirectUrl = "admin_dashboard.php";
        if ($_SESSION['role_name'] == 'User') {
            $redirectUrl = "edit_profile.php?id={$_POST['id']}";
        }
        header("location:{$redirectUrl}");
    } else {
        echo "Profile could not be updated";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Profile</title>
<link rel="stylesheet"
	href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-light bg-light">
		<a class="navbar-brand" href="#">User Management</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse"
			data-target="#navbarNav" aria-controls="navbarNav"
			aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarNav">
			<?php if ($_SESSION['role_name'] != 'User'){ ?>
            <ul class="navbar-nav">
				<li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Dashboard</a>
				</li>
				<li class="nav-item"><a class="nav-link" href="add_userform.php">Add
						User</a></li>
			</ul>
			<?php } ?>
			<ul class="navbar-nav">
				<li class="nav-item"><a class="nav-link" href="file_upload.php">File
						Management System</a></li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a>
				</li>
			</ul>
		</div>
	</nav>
	<div class="container">
		<h2>Edit Profile</h2>
		<form id="edit-profile-form" enctype="multipart/form-data"
			method="POST" action="edit_profile.php">
			<div class="form-group">
				<label for="name">Name</label> <input type="text"
					class="form-control" id="name" name="name"
					value="<?php echo $row['name']; ?>" required>
			</div>
			<div class="form-group">
				<label for="mobile">Mobile</label> <input type="text"
					class="form-control" id="mobile" name="mobile"
					value="<?php echo $row['mobile']; ?>">
			</div>
			<div class="form-group">
				<label for="email">Email</label> <input type="email"
					class="form-control" id="email" name="email"
					value="<?php echo $row['email']; ?>">
			</div>
			<div class="form-group">
				<label for="address">Address (Location)</label>
				<input type="text" name="address" id="address" class="form-control" value="<?php echo $row['address']; ?>">
				<button type="button" id="getLocation" class="btn btn-primary mt-2">Get My Location</button>
			</div>
			<div class="form-group">
				<label for="gender">Gender</label> <select class="form-control"
					id="gender" name="gender">
					<option value="Male"
						<?php if ($row['gender'] == 'Male') echo 'selected'; ?>>Male</option>
					<option value="Female"
						<?php if ($row['gender'] == 'Female') echo 'selected'; ?>>Female</option>
					<option value="Other"
						<?php if ($row['gender'] == 'Other') echo 'selected'; ?>>Other</option>
				</select>
			</div>
			<div class="form-group">
				<label for="date_of_birth">Date of Birth</label> <input type="date"
					class="form-control" id="date_of_birth" name="date_of_birth"
					value="<?php echo $row['date_of_birth']; ?>"
					pattern="\d{4}-\d{2}-\d{2}" required>
			</div>
			<div class="form-group">
				<label for="profile_picture">Profile Picture (optional)</label> <input
					type="file" class="form-control" id="profile_picture"
					name="profile_picture">
            <?php if (!empty($row['profile_picture'])): ?>
                <img src="<?php echo $row['profile_picture']; ?>"
					alt="Profile Picture" style="max-width: 100px;">
            <?php endif; ?>
			<input type="hidden" class="form-control" id="hidden_profile_picture"
					name="hidden_profile_picture"
					value="<?php echo $row['profile_picture']; ?>">
			</div>
			<div class="form-group">
				<label for="signature">Signature</label> <input type="text"
					class="form-control" id="signature" name="signature"
					value="<?php echo $row['signature']; ?>">
			</div>
			<input type="hidden" class="form-control" id="id" name="id"
				value="<?php echo $row['id']; ?>">
			<button type="submit" class="btn btn-primary">Update Profile</button>
		</form>
	</div>
</body>
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
</html>