<?php
session_start();
include('db_connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch moods associated with the logged-in user
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM moods WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Your Moods</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f1f1f1;
            margin: 0;
            padding: 0;
        }
        .content-container {
            width: 80%;
            margin: 30px auto;
            padding: 20px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
            font-size: 36px;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            margin: 20px 0;
            border-collapse: collapse;
        }
        table th, table td {
            padding: 12px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        table th {
            background-color: #0078a6;
            color: white;
        }
        .mood-emoji {
            font-size: 24px;
        }
        .mood-description {
            font-style: italic;
            color: #555;
        }
        .actions a {
            color: #0078a6;
            text-decoration: none;
            padding: 5px 10px;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        .add-button {
            display: block;
            text-align: center;
            background-color: #0078a6;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 18px;
            width: 200px;
            margin: 20px auto;
        }
        .add-button:hover {
            background-color: #005b80;
        }
    </style>
</head>
<body>

<div class="content-container">
    <h2>Your Mood Tracking</h2>

    <table>
        <tr>
            <th>Date</th>
            <th>Mood</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?php echo htmlspecialchars($row['date']); ?></td>
                <td>
                    <?php 
                        // Display mood emoji based on mood
                        switch ($row['mood']) {
                            case 'Happy':
                                echo "<span class='mood-emoji'>😊</span> Happy";
                                break;
                            case 'Sad':
                                echo "<span class='mood-emoji'>😢</span> Sad";
                                break;
                            case 'Angry':
                                echo "<span class='mood-emoji'>😡</span> Angry";
                                break;
                            case 'Neutral':
                                echo "<span class='mood-emoji'>😐</span> Neutral";
                                break;
                            case 'Anxious':
                                echo "<span class='mood-emoji'>😰</span> Anxious";
                                break;
                            default:
                                echo "<span class='mood-emoji'>🤔</span> Unknown";
                        }
                    ?>
                </td>
                <td class="mood-description"><?php echo htmlspecialchars($row['description']); ?></td>
                <td class="actions">
                    <a href="edit_mood.php?id=<?php echo $row['id']; ?>">Edit</a> |
                    <a href="delete_mood.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this mood?');">Delete</a>
                </td>
            </tr>
        <?php endwhile; ?>

    </table>

    <a href="add_mood.php" class="add-button">Add New Mood</a>
</div>

</body>
</html>
