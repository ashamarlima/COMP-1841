<?php
session_start();

// Include the database configuration file to set up the PDO connection
require '../databaseconnection/config.php'; // Include the PDO setup

// Include the function file with the getAllUsers function
require '../function/postfunc.php'; 

// Now you can call getAllUsers with the $pdo variable, which should be initialized
$users = getAllUsers($pdo); 

// Start output buffering and include the template
ob_start();
include '../templates/users.html.php'; // View file will call showMessage()

// Get the buffered output and clean the buffer
$output = ob_get_clean();

// Display the final output
echo $output;
?>
