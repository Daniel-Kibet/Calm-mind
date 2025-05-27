<?php
// Use environment variables or a separate config file for production
$servername = "localhost";
$username = "root";
$password = "12345678"; // your password for root
$database = "calmmind"; // your database name

// Create a connection with error reporting enabled
$conn = new mysqli($servername, $username, $password, $database);

// Check connection and handle errors
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Set the charset to UTF-8 for proper encoding
if (!$conn->set_charset("utf8")) {
    die("Error loading character set utf8: " . $conn->error);
}

// If using for production, consider turning off detailed error messages
// For production, replace the above error messages with a more generic message
?>
