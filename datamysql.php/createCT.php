<?php
$link = mysqli_connect("localhost", "root", "", "contactform");

if ($link === false) {
    die("Error: Could not connect. " . mysqli_connect_error());
}

$sql = "CREATE TABLE messagess (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) NOT NULL UNIQUE,
    message TEXT NOT NULL,
    submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP

)";

if (mysqli_query($link, $sql)) {
    echo "Table created successfully";
} else {
    echo "Error creating table: " . mysqli_error($link);
}
?>
