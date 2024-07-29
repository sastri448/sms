<?php
session_start();

if ($_SESSION['role_name'] != 'Super Admin' && $_SESSION['role_name'] != 'Admin') {
    die("Oops, Sorry no permission to view this page.");
}

include_once 'Database.php';
include_once 'User.php';

$database = new Database();
$db = $database->getConnection();
$user = new User($db);
$user->id = $_POST['id'];
if ($user->deleteUser()) {
    echo "User deleted successfully";
} else {
    echo "Failed to delete user";
}
?>