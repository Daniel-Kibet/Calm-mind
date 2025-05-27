<?php
session_start();
include('db_connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize user input
    $mood = mysqli_real_escape_string($conn, $_POST['mood']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $date = date('Y-m-d');  // Use the current date

    // Get user ID from session
    $user_id = $_SESSION['user_id'];

    // Insert mood into the database
    $query = "INSERT INTO moods (user_id, mood, description, date) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isss", $user_id, $mood, $description, $date);

    if ($stmt->execute()) {
        // Redirect to the mood tracking page after success
        header("Location: mood_tracking.php");
        exit();
    } else {
        // Error handling if query fails
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Mood</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Add Your Mood</h2>
        <form action="add_mood.php" method="POST">
            <label for="mood">How are you feeling today?</label>
            <select name="mood" id="mood" required>
                <option value="">Select Mood</option>
                <option value="Happy">Happy</option>
                <option value="Sad">Sad</option>
                <option value="Angry">Angry</option>
                <option value="Excited">Excited</option>
                <option value="Calm">Calm</option>
                <option value="Stressed">Stressed</option>
                <option value="Relaxed">Relaxed</option>
            </select>

            <label for="description">Tell us more about your mood:</label>
            <textarea name="description" id="description" rows="4" placeholder="Describe your feelings..." required></textarea>

            <button type="submit" class="submit-btn">Save Mood</button>
        </form>

        <a href="mood_tracking.php" class="back-link">Back to Mood Tracking</a>
    </div>
</body>
</html>
