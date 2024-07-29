<?php
session_start();
if (! isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
if (isset($_SESSION['role_name']) && $_SESSION['role_name'] != 'Super Admin' && $_SESSION['role_name'] != 'Admin') {
    die("Oops, Sorry no permission to view this page.");
}
include_once 'Database.php';
include_once 'User.php';
$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$users = $user->fetchAllUsers();
echo json_encode($users);
?>
