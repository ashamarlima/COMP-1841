<?php
session_start();
require_once '../databaseconnection/config.php'; 
require_once '../function/postfunc.php';

if (!isset($_GET['id'])) {
    $_SESSION['error'] = 'User ID not provided';
    header('Location: users.php');
    exit();
}

$user = getUserById($pdo, $_GET['id']);
if (!$user) {
    $_SESSION['error'] = 'User not found';
    header('Location: users.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id = $_GET['id'];
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        validateUserInput($username, $email, $password ?: null, $password ? $confirm_password : null);

        if ($password) {
            updateUser($pdo, $id, $username, $email, $password);
        } else {
            updateUser($pdo, $id, $username, $email);
        }

        $_SESSION['success'] = 'User updated successfully';
        header('Location: users.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header("Location: edit_user.php?id=" . $_GET['id']);
        exit();
    }
}


ob_start();
include '../templates/edit_user.html.php'; 
$output = ob_get_clean();

echo $output;
