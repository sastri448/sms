<?php
session_start();
include_once 'Database.php';
include_once 'User.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();

    $user = new User($db);

    $user->name = $_POST['name'];
    $user->role_id = 3;
    $user->mobile = $_POST['mobile'];
    $user->email = $_POST['email'];
    $user->address = $_POST['address'];
    $user->gender = $_POST['gender'];
    $user->date_of_birth = $_POST['date_of_birth'];
    $user->signature = $_POST['signature'];
    $user->username = $_POST['username'];
    $user->password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $user->approved = ($user->role_id == 3) ? 0 : 1;
    if (isset($_SESSION['role_name']) && ($_SESSION['role_name'] == 'Super Admin' || $_SESSION['role_name'] == 'Admin')) {
        $user->approved = 1;
    }
    // Check for duplicate username
    $cnt = $user->getUserByUsername($user->username);
    if ($cnt > 0) {
        echo 'Username already exists. Please choose another one.';
        exit();
    }

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
        $user->profile_picture = null;
    }
    if ($user->createUser()) {
        echo "User added successfully";
        if (! isset($_SESSION['user_id'])) {
            echo "\r\nSuper Admin needs to approve you registration";
            exit();
        }
    } else {
        echo "User could not be added";
    }
}
?>
