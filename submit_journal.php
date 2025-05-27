<?php
// Start session
session_start();

// Include database connection
include 'db_connection.php'; // Replace with your actual database connection file

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    die("Error: User not logged in.");
}

// Check if the form data is set
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id']; // Get the logged-in user's ID
    $title = $_POST['title'];
    $content = $_POST['content'];
    $is_anonymous = isset($_POST['is_anonymous']) ? 1 : 0;

    // Insert into the journals table
    $sql = "INSERT INTO journals (user_id, title, content, is_anonymous) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isss", $user_id, $title, $content, $is_anonymous);

    if ($stmt->execute()) {
        // Redirect back to manage_journals.php with a success message
        $_SESSION['message'] = "Journal entry added successfully!";
        header("Location: manage_journals.php");
        exit();
    } else {
        // Redirect back with an error message
        $_SESSION['error'] = "Error: " . $stmt->error;
        header("Location: manage_journals.php");
        exit();
    }
} else {
    die("Invalid request method.");
}
