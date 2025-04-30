<?php
session_start();
require_once '../databaseconnection/config.php'; // ✅ Include this to define $pdo
require_once '../function/postfunc.php';

if (!isset($_GET['id'])) {
    $_SESSION['error'] = 'User ID not provided';
    header('Location: users.php');
    exit();
}

try {
    deleteUser($pdo, $_GET['id']);
    $_SESSION['success'] = 'User deleted successfully';
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
}

header('Location: users.php');
exit();
