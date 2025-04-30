<?php
session_start();
require '../databaseconnection/config.php';
require '../function/postfunc.php';



if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: templates/index.php");
    exit();
}

$allUsersCount = rowcount($pdo, "SELECT * FROM `users`");
$studentsCount = rowcount($pdo, "SELECT * FROM `users` WHERE `role` = 'student'");
$teachersCount = rowcount($pdo, "SELECT * FROM `users` WHERE `role` = 'teacher'");


$output = 'admin/home.html.php';


include '../templates/admin_home.html.php';