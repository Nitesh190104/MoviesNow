<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "contactform");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$message = $_POST['message'];

// Prepare SQL query to insert data
$sql = "INSERT INTO messagess (name, email, message) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $name, $email, $message);

// Execute query and check if successful
if ($stmt->execute()) {
    echo "<script>alert('Message sent successfully!'); window.location.href='contact.html';</script>";
} else {
    echo "<script>alert('Error sending message.'); window.location.href='contact.html';</script>";
}

// Close connection
$stmt->close();
$conn->close();
?>
