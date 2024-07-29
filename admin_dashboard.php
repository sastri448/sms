<?php
session_start();
include_once 'Database.php';
include_once 'User.php';
if (! isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if (isset($_SESSION['role_name']) && $_SESSION['role_name'] != 'Super Admin' && $_SESSION['role_name'] != 'Admin') {
    header('Location: edit_profile.php');
    exit();
}
$editControl = false;
$deleteControl = false;
if ($_SESSION['role_name'] == 'Super Admin') {
    $editControl = true;
}
if ($_SESSION['role_name'] == 'Admin' || $_SESSION['role_name'] == 'Super Admin') {
    $deleteControl = true;
}
$database = new Database();
$db = $database->getConnection();

$user = new User($db);
$row = [];
// Fetch user details
if (isset($_GET['id']) && ! empty($_GET['id']) && isset($_GET['approve']) && ! empty($_GET['approve'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $user->id = $_GET['id'];
        $user->approved = 1;
        if ($user->updateApprove()) {
            echo "Profile updated successfully";
            $url = "admin_dashboard.php";
            header("location:{$url}");
        } else {
            echo "Profile could not be updated";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>User Management</title>
<link rel="stylesheet"
	href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<link rel="stylesheet"
	href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<style>
.container {
	margin-top: 20px;
}

.blink_me {
	animation: blinker 1s linear infinite;
}

@keyframes blinker { 50% {
	opacity: 0;
}
}
</style>
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
			<ul class="navbar-nav">
				<li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Users</a>
				</li>
				<li class="nav-item"><a class="nav-link" href="add_userform.php">Add
						User</a></li>
				<li class="nav-item"><a class="nav-link" href="employees.php">Employees</a>
				</li>
				<li class="nav-item"><a class="nav-link" href="file_upload.php">File
						Management System</a></li>
			</ul>
			<ul class="navbar-nav ml-auto">
				<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a>
				</li>
			</ul>
		</div>
	</nav>
	<div class="container" style="max-width: 99%;">
		<h2>Welcome, <?php echo $_SESSION['role_name'];?></h2>
		<!-- Your dashboard content here -->
		<div id="user-table"></div>
	</div>
	<script
		src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
	<script>
    $(document).ready(function () {
        $.ajax({
            url: 'fetch_users.php',
            method: 'GET',
            success: function (response) {
                var users = JSON.parse(response); //js object
				var editControl = "<?php echo $editControl;?>";
				var deleteControl = "<?php echo $deleteControl;?>";
				var approved =  '';
                var table = '<table class="table table-bordered"><thead><tr><th>ID</th><th>Name</th><th>Role</th><th>Mobile</th><th>Email</th><th>Address</th><th>Gender</th><th>Date of Birth</th><th>Profile Picture</th><th>Signature</th><th>Approved</th><th>Actions</th></tr></thead><tbody>';
                users.forEach(function (user) {
					var profile_picture = user.profile_picture ?? '';
                    table += '<tr>';
                    table += '<td>' + user.id + '</td>';
                    table += '<td>' + user.name + '</td>';
                    table += '<td>' + user.role_name + '</td>';
                    table += '<td>' + user.mobile  ?? '' + '</td>';
                    table += '<td>' + user.email ?? '' + '</td>';
                    table += '<td>' + user.address ?? '' + '</td>';
                    table += '<td>' + user.gender + '</td>';
                    table += '<td>' + user.date_of_birth + '</td>';
					table += '<td>';
					if (profile_picture) {
						table += '<img src="' + profile_picture + '" width="50">';
					}
					 table += '</td>';
                    table += '<td>' + user.signature + '</td>';
					table += '<td>';
					if (user.approved  == 1) { 
					 table += 'Yes';
					} else {
						table += 'No';
					}
					table += '</td>';
                    table += '<td style="font-size:18px;">';
					if (editControl && user.role_name!= 'Super Admin') {
						table += '<a href="edit_profile.php?id=' + user.id + '"><i class="fas fa-edit" data-id="' + user.id + '"></i></a>';
					}
					if (deleteControl && (user.role_name!= 'Super Admin' || user.role_name == 'Admin')) {
						table += '&nbsp;<i class="fas fa-trash delete-user" data-id="' + user.id + '"></i>';
					}
					if (user.role_name == 'User' && user.approved == 0) {
						table += '&nbsp;<a title="Aprrove" href="admin_dashboard.php?id=' + user.id + '&approve=yes"><i class="fas fa-check blink_me" data-id="' + user.id + '"></i></a>';
					}
                    table += '</td>';
                    table += '</tr>';
                });
                table += '</tbody></table>';
                $('#user-table').html(table);
            }
        });

        $(document).on('click', '.delete-user', function () {
            var id = $(this).data('id');
			if (confirm('Are you sure want to delete?')) {
				$.ajax({
                url: 'delete_user.php',
                method: 'POST',
                data: { id: id },
                success: function (response) {
                    alert(response);
                    location.reload();
                }
            });
			}
        });
    });
</script>
</body>
</html>
