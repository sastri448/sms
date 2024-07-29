<?php
session_start();
include_once 'Database.php';
include_once 'User.php';
if (! isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$search = '';
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}
$limit = 10;
if (isset($_GET["page"])) {
    $page = $_GET["page"];
} else {
    $page = 1;
}
;
$offset = ($page - 1) * $limit;
$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$employees = $user->fetchEmployees($search, $offset, $limit);
$total_records = $user->countEmployees($search);
$total_pages = ceil($total_records / $limit);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Employees</title>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
.container {
	margin-top: 20px;
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
	<div class="container">
		<h2>Employees</h2>
		<form method="get" action="employees.php">
			<div class="form-group">
				<input type="text" class="form-control" name="search"
					placeholder="Search employees..."
					value="<?php echo htmlspecialchars($search); ?>">
			</div>
			<button type="submit" class="btn btn-primary">Search</button>
			<button type="button"
				onClick="window.location.href = 'employees.php';"
				class="btn btn-primary">Clear</button>
		</form>
		<table class="table table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th>Name</th>
					<th>Designation</th>
					<th>Date of Birth</th>
					<th>Date of Joining</th>
					<th>Blood Group</th>
					<th>Mobile</th>
					<th>Email</th>
					<th>Address</th>
				</tr>
			</thead>
			<tbody>
                <?php if (count($employees) > 0) { ?>
                    <?php foreach ($employees as $employee) { ?>
                        <tr>
					<td><?php echo $employee['id']; ?></td>
					<td><?php echo $employee['employee_name']; ?></td>
					<td><?php echo $employee['designation']; ?></td>
					<td><?php echo $employee['date_of_birth']; ?></td>
					<td><?php echo $employee['date_of_joining']; ?></td>
					<td><?php echo $employee['blood_group']; ?></td>
					<td><?php echo $employee['mobile']; ?></td>
					<td><?php echo $employee['email']; ?></td>
					<td><?php echo $employee['address']; ?></td>
				</tr>
                    <?php } ?>
                <?php } else {?>
                    <tr>
					<td colspan="9">No employees found</td>
				</tr>
                <?php } ?>
            </tbody>
		</table>
		<nav aria-label="Page navigation example">
			<ul class="pagination">
                <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                    <li
					class="page-item <?php if ($i == $page) echo 'active'; ?>"><a
					class="page-link"
					href="employees.php?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
				</li>
                <?php } ?>
            </ul>
		</nav>
	</div>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>