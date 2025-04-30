<?php
include 'function/postfunc.php';
include 'databaseconnection/config.php';

session_start();

// Get the counts for display
$allUsersCount = rowcount($pdo, "SELECT * FROM `users`");
$studentsCount = rowcount($pdo, "SELECT * FROM `users` WHERE `role` = 'student'");
$teachersCount = rowcount($pdo, "SELECT * FROM `users` WHERE `role` = 'teacher'");

// Include the HTML template
include 'templates/home.html.php';
?>