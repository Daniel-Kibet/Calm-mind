<?php
session_start();
include('db_connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Check if the journal ID is provided
if (!isset($_GET['id'])) {
    die("Invalid request.");
}

$journal_id = intval($_GET['id']);

// Delete the journal
$query = "DELETE FROM journals WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $journal_id, $user_id);

if ($stmt->execute()) {
    header("Location: manage_journals.php?success=Journal deleted successfully.");
    exit();
} else {
    die("Failed to delete the journal.");
}
?>
