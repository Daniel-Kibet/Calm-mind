<?php
$servername = "localhost";
$username = "root";
$password = "12345678";
$database = "calmmind";

// Create connection with error reporting
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected successfully to MySQL";
}
?>
