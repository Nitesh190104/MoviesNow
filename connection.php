<?php
// connection.php

// Database configuration
$servername = "localhost";
$dbusername = "root";            // Use your DB username
$dbpassword = "";                // Use your DB password
$dbname     = "userotb";         // Your DB name (make sure it matches your project)

// Create MySQLi connection
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

// Check for connection errors
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set charset to utf8mb4 for enhanced security and Unicode support
if (!$conn->set_charset("utf8mb4")) {
    die("Error loading character set utf8mb4: " . $conn->error);
}
?>
