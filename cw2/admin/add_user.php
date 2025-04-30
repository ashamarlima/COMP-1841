<?php
session_start();
require '../databaseconnection/config.php'; // ✅ This line fixes the $pdo issue
require '../function/postfunc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];
        $role = $_POST['role']; 
        
        // Validate and add user
        validateUserInput($username, $email, $password, $confirm_password);
        addUser($pdo, $username, $email, $password, $role);
        
        $_SESSION['success'] = 'User added successfully.';
        header('Location: users.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location: add_user.php');
        exit();
    }
}

// Load view if GET request
ob_start();
include '../templates/add_user.html.php';
$output = ob_get_clean();

echo $output;
