<?php
include 'db_connect.php'; // Make sure the path is correct

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); // Exit and show the error message if connection fails
}

echo "Connected successfully"; // This will be displayed if the connection is successful

// Close the connection
$conn->close();
?>
