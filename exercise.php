<?php
session_start();
include('db_connect.php');

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch exercises for the logged-in user
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM exercises WHERE user_id = ? ORDER BY date DESC";
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
    <title>Manage Exercises</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 0;
            padding: 0;
        }
        .content-container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }
        h2 {
            color: #333;
            text-align: center;
            font-size: 36px;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #0078a6;
            color: white;
            font-size: 16px;
        }
        td {
            background-color: #fafafa;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .actions {
            display: flex;
            gap: 10px;
        }
        .actions a {
            padding: 8px 15px;
            background-color: #0078a6;
            color: white;
            border-radius: 5px;
            text-decoration: none;
        }
        .actions a:hover {
            background-color: #005b80;
        }
        .add-button {
            display: inline-block;
            background-color: #28a745;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            margin-top: 20px;
        }
        .add-button:hover {
            background-color: #218838;
        }
        .message {
            padding: 15px;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="content-container">
    <h2>Your Mindfulness Exercises</h2>

    <?php if (isset($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Exercise</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['date']); ?></td>
                    <td><?php echo htmlspecialchars($row['exercise']); ?></td>
                    <td><?php echo nl2br(htmlspecialchars($row['description'])); ?></td>
                    <td class="actions">
                        <a href="edit_exercise.php?id=<?php echo $row['id']; ?>">Edit</a>
                        <a href="delete_exercise.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this exercise?');">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" style="text-align:center;">No exercises found. <a href="add_exercise.php">Add a new exercise</a></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="add_exercise.php" class="add-button">Add New Exercise</a>
</div>

</body>
</html>
