<?php
// Database connection
$host = "localhost";
$user = "root";
$password = "";
$database = "contactform";

// Create connection
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}

// Fetch all messages
$sql = "SELECT id, name, email, message, submitted_at FROM messagess ORDER BY submitted_at DESC";
$result = $conn->query($sql);

// Display in HTML table
echo "<h2>📩 Contact Messages</h2>";

if ($result && $result->num_rows > 0) {
    echo "<table border='1' cellpadding='10' cellspacing='0' style='border-collapse: collapse; font-family: Arial;'>";
    echo "<tr style='background-color: #f2f2f2;'>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Message</th>
            <th>Submitted At</th>
          </tr>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['id']}</td>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>" . htmlspecialchars($row['email']) . "</td>
                <td>" . nl2br(htmlspecialchars($row['message'])) . "</td>
                <td>{$row['submitted_at']}</td>
              </tr>";
    }

    echo "</table>";
} else {
    echo "<p>No messages found.</p>";
}

// Close connection
$conn->close();
?>
