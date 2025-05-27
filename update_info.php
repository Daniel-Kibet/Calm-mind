<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('db_connect.php');
    $username = $_SESSION['username'];
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Update user info in the database
    $query = "UPDATE users SET name='$name', email='$email' WHERE username='$username'";
    if ($conn->query($query) === TRUE) {
        echo "Information updated successfully!";
        header("Location: homepage.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
?>
