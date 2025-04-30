<?php
require 'databaseconnection/config.php';
include 'function/postfunc.php';
session_start();

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['Id'] ?? null;
        $name = $_POST['name'] ?? '';
        $description = $_POST['description'] ?? '';
        $category = $_POST['category'] ?? '';

        if (!$id || !$name || !$description || !$category) {
            throw new Exception('All fields are required');
        }

        $imagePath = null;

        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $filename = validateImage($_FILES['image']);
            $imagePath = moveUploadedImage($_FILES['image'], 'uploads/', $filename);
        }

        updateCard($pdo, $id, $name, $description, $category, $imagePath);

        $_SESSION['success'] = 'Card updated successfully';
        header('Location: index.php');
        exit;
    } else {
        throw new Exception('Invalid request method');
    }
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header('Location: index.php');
    exit;
}
?>
