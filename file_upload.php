<?php
session_start();
include_once 'Database.php';
include_once 'User.php';
require_once 'FileManager.php';
if (! isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
$db = new Database();
$user_id = $_SESSION['user_id'];
if (isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $fileManager = new FileManager($db->getConnection());

    if ($fileManager->uploadFile($user_id, $file)) {
        echo "File uploaded successfully";
        header("location: file_upload.php");
    } else {
        echo "File upload failed";
    }
}
$fileManager = new FileManager($db->getConnection());
$files = $fileManager->getFilesByUser($user_id);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Upload File</title>
<link rel="stylesheet"
	href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
#preview {
	display: none;
	margin-top: 10px;
	max-width: 200px;
	max-height: 200px;
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
		<?php if ($_SESSION['role_name'] == 'Super Admin' || $_SESSION['role_name'] == 'Admin'){ ?>
		<ul class="navbar-nav">
			<li class="nav-item"><a class="nav-link" href="admin_dashboard.php">Users</a>
			</li>
			<li class="nav-item"><a class="nav-link" href="add_userform.php">Add
					User</a></li>
			<li class="nav-item"><a class="nav-link" href="employees.php">Employees</a>
			</li>
		</ul>
		<?php }?>
		<ul class="navbar-nav">
			<li class="nav-item"><a class="nav-link" href="file_upload.php">File
					Management System</a></li>
		</ul>
		<div class="collapse navbar-collapse" id="navbarNav">
			<ul class="navbar-nav ml-auto">
				<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a>
				</li>
			</ul>
		</div>
	</nav>
	<div class="container">
		<h2>Upload File</h2>
		<form action="file_upload.php" method="post"
			enctype="multipart/form-data">
			<div class="form-group">
				<label for="file">Choose file</label> <input type="file" name="file"
					id="file" class="form-control" >
			</div>
			<img id="preview" src="" alt="Image Preview">
			<button type="submit" class="btn btn-primary">Upload</button>
		</form>
	</div>

	<div class="container">
		<h2>Your Files</h2>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>File Name</th>
					<th>Uploaded At</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
			<?php
            if (count($files) > 0) {
                foreach ($files as $file) {
            ?>
            <tr>
					<td><?php echo $file['file_name']; ?></td>
					<td><?php echo $file['uploaded_at']; ?></td>
					<td><a href="<?php echo $file['file_path']; ?>" target="_blank">View</a></td>
				</tr>
            <?php } ?>
			<?php } else {?>
			<tr>
					<td colspan="9">No record found</td>
				</tr>
             <?php } ?>
        </tbody>
		</table>
	</div>

	<script>
    document.getElementById('file').addEventListener('change', function(event) {
        const [file] = event.target.files;
        if (file) {
            const preview = document.getElementById('preview');
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        }
    });
</script>
</body>
</html>
