<?php
session_start();
include('db_connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch all affirmations from the database
$query = "SELECT * FROM affirmations ORDER BY date DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Affirmations</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
</head>
<body>
    <div class="container">
        <h2>Your Daily Affirmations</h2>
        
        <table>
            <tr>
                <th>Date</th>
                <th>AFFIRMATION</th>
            </tr>
            <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['date']); ?></td>
                <td><?php echo htmlspecialchars($row['affirmation']); ?></td>
            </tr>
            <?php endwhile; ?>
        </table>

        <a href="add_affirmation.php" class="add-button">Add New Affirmation</a>
    </div>
</body>
</html>
