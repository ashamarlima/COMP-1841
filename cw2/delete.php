<?php
include 'databaseconnection/config.php';
include 'function/postfunc.php';

if (isset($_GET['Id'])) {
    try {
        $stmt = $pdo->prepare("DELETE FROM tblcard WHERE Id = :id");
        $stmt->bindParam(':id', $_GET['Id'], PDO::PARAM_INT);
        
        if ($stmt->execute()) {
            header('Location: index.php?message=ItemDeleted');
            exit();
        } else {
            $error = "Error deleting record.";
            include 'templates/error.html.php';
        }
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
        include 'templates/error.html.php';
    }
} else {
    $error = "No Id parameter provided!";
    include 'templates/error.html.php';
}