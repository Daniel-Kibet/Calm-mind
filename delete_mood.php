<?php
session_start();
include('db_connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Check if the mood ID is provided in the URL
if (isset($_GET['id'])) {
    $mood_id = $_GET['id'];

    // Delete the mood record from the database
    $query = "DELETE FROM moods WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $mood_id, $_SESSION['user_id']);
    if ($stmt->execute()) {
        // Redirect to the mood tracking page after deletion
        header("Location: mood_tracking.php");
        exit();
    } else {
        echo "Error: Could not delete the mood. Please try again.";
    }
} else {
    // If no ID is provided, redirect to mood tracking page
    header("Location: mood_tracking.php");
    exit();
}
?>
