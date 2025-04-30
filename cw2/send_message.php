<?php
session_start();
require 'databaseconnection/config.php'; 
require 'function/postfunc.php'; 

if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    $homeLink = "admin/home.php";  
} else {
    $homeLink = "home.php"; 
}
if (!isset($_SESSION['user_id'])) {
    $_SESSION['error'] = 'You must be logged in to send a message';
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];  
$role = $_SESSION['role'];  


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $message = trim($_POST['message']);

        if (empty($message)) {
            throw new Exception('Message cannot be empty');
        }

        sendMessage($pdo, $role, $user_id, $message);

        $_SESSION['success'] = 'Message sent successfully!';
        header('Location: send_message.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
        header('Location:send_message.php');
        exit();
    }
}


$messages = getMessages($pdo); 


$output = [
    'messages' => $messages
];


include 'templates/send_message.html.php';
?>
