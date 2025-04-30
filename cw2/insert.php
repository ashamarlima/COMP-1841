<?php
session_start();
require 'databaseconnection/config.php';
include 'function/postfunc.php';

if (isset($_POST['upload'])) {
    try {
        if (!isset($_SESSION['user_id'])) {
            throw new Exception('You must be logged in to create posts');
        }

        if (empty($_POST['name']) || empty($_POST['description']) || 
            empty($_POST['category']) || $_FILES['image']['error'] != 0) {
            throw new Exception('Please fill all fields and upload a valid image');
        }

        $name = $_POST['name'];
        $description = $_POST['description'];
        $category = $_POST['category'];
        $image = $_FILES['image'];
        $userId = $_SESSION['user_id'];

        $filename = validateImage($image);
        $imagePath = moveUploadedImage($image, 'images/', $filename);

        $sql = "INSERT INTO tblcard (Name, Description, Image, Category, user_id) 
                VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$name, $description, $imagePath, $category, $userId]);

        header("Location: index.php?success=Item uploaded successfully");
        exit();
    } catch (Exception $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
