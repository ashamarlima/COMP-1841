<?php
session_start();

require_once 'databaseconnection/config.php';
require_once 'function/postfunc.php';

// Check if the user is an admin
if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin') {
    $homeLink = "admin/home.php";  // Admin home
} else {
    $homeLink = "home.php";  // Regular home
}

$cards = getAllCards($pdo);
$categories = getAllCategories($pdo);

// Pass the home link to the view
include 'templates/index.html.php';
