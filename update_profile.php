<?php
session_start();

if ($_SESSION['role'] != 'User') {
    die("Oops, Sorry no permission to view this page.");
}

include_once 'db.php';
include_once 'user.php';

$database = new Database();
$db = $database->getConnection();

$user = new User($db);

$user->id = $_SESSION['user_id'];
$user->name = $_POST['name'];
$user->mobile = $_POST['mobile'];
$user->email = $_POST['email'];
$user->address = $_POST['address'];
$user->gender = $_POST['gender'];
$user->date_of_birth = $_POST['date_of_birth'];
$user->signature = $_POST['signature'];

if (! empty($_FILES['profile_picture']['name'])) {
    $profile_picture_path = $user->uploadFile($_FILES['profile_picture'], 'uploads/');
    if ($profile_picture_path) {
        $user->profile_picture = $profile_picture_path;
    } else {
        echo "Failed to upload profile picture";
        exit();
    }
}

if ($user->updateProfile()) {
    echo "Profile updated successfully";
} else {
    echo "Failed to update profile";
}
?>
