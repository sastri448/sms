<?php
session_start();

include_once 'Database.php';
include_once 'User.php';
$msg = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);

    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM users WHERE username = :username";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    if ($stmt->rowCount() > 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (password_verify($password, $row['password'])) {
            if ($row['approved'] == 1) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role_id'];
                $redirectUrl = "admin_dashboard.php";
                if ($row['role_id'] == 1) {
                    $_SESSION['role_name'] = 'Super Admin';
                } elseif ($row['role_id'] == 2) {
                    $_SESSION['role_name'] = 'Admin';
                } else {
                    $_SESSION['role_name'] = 'User';
                    $redirectUrl = "edit_profile.php?id={$row['id']}";
                }
                header("Location: {$redirectUrl}");
                exit();
            } else {
                $msg = "Your account is not approved yet.";
            }
        } else {
            $msg = "Invalid password.";
        }
    } else {
        $msg = "Invalid username.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login</title>
<link rel="stylesheet"
	href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
<style>
body {
	background-color: #f8f9fa;
	display: flex;
	justify-content: center;
	align-items: center;
	height: 100vh;
}

.login-container {
	background: white;
	padding: 2rem;
	border-radius: 5px;
	box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
	width: 360px;
}

.login-container h2 {
	margin-bottom: 1.5rem;
}

.login-container .form-group {
	margin-bottom: 1rem;
}

.login-container button {
	width: 100%;
}

.register-link {
	display: block;
	text-align: center;
	margin-top: 1rem;
}
</style>
</head>
<body>

	<div class="login-container">
		<p style="color: red;"><?php echo $msg;?></p>
		<h2>Login</h2>
		<form action="login.php" method="POST">
			<div class="form-group">
				<label for="username">Username</label> <input type="text"
					class="form-control" id="username" name="username" required>
			</div>
			<div class="form-group">
				<label for="password">Password</label> <input type="password"
					class="form-control" id="password" name="password" required>
			</div>
			<button type="submit" class="btn btn-primary">Login</button>
		</form>
		<a href="add_userform.php" class="register-link">Register</a>
		<div>Login Credentials<br/>
		Super Admin: superadmin/superadmin<br/>
		Admin: admin/admin<br/>
		User: user/user</div>
	</div>
</body>
</html>