<?php
session_start();

require 'databaseconnection/config.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']); 

        $stmt = $pdo->prepare("SELECT id, username, role FROM users WHERE username = :username");
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: admin/home.php");
            } else {
                header("Location: home.php");
            }
            exit();
        } else {
            header("Location: login.php?error=1");
            exit();
        }
    } catch (Exception $e) {
       
        header("Location: login.php?error=1");
        exit();
    }
}
?>
