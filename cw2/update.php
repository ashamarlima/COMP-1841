<?php
require 'databaseconnection/config.php';
include 'function/postfunc.php';

try {
    if (!isset($_GET['Id'])) {
        throw new Exception('No card ID specified');
    }

    $cardId = $_GET['Id'];
    $card = getCardById($pdo, $cardId);
    $categories = getAllCategories($pdo);

    if (!$card) {
        throw new Exception('Card not found');
    }

    $output = [
        'card' => $card,
        'categories' => $categories,
    ];
    
    include 'templates/update.html.php';
} catch (Exception $e) {
    $_SESSION['error'] = $e->getMessage();
    header("Location: index.php");
    exit();
}
?>
