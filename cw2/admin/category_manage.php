<?php
session_start();
require '../databaseconnection/config.php';
require '../function/postfunc.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        if (isset($_POST['add_category'])) {
            addCategory($pdo, $_POST['cat_id'], $_POST['cat_name']);
            $_SESSION['success'] = "Category added successfully!";
        } elseif (isset($_POST['update_category'])) {
            updateCategory($pdo, $_POST['cat_id'], $_POST['new_name']);
            $_SESSION['success'] = "Category updated successfully!";
        } elseif (isset($_POST['delete_category'])) {
            deleteCategory($pdo, $_POST['cat_id']);
            $_SESSION['success'] = "Category deleted successfully!";
        }
    } catch (Exception $e) {
        $_SESSION['error'] = $e->getMessage();
    }
    header("Location: category_manage.php");
    exit();
}

// Fetch all categories for display
$categories = getAllCategories($pdo);

ob_start();
include '../templates/category_manage.html.php';
$output = ob_get_clean();

echo $output;
