<?php 
// Include your database connection
include('db_connect.php');

// Fetch all affirmations from the database
$query = "SELECT id, text, author, category FROM affirmations";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Affirmations</title>
    <style>
        /* Global Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: url('images/view affirmations.jpeg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            color: white;
        }

        .container {
            width: 90%;
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7); /* Dark transparent background */
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(5px); /* Slight blur effect */
        }

        h1 {
            text-align: center;
            font-size: 2.8em;
            color: #FFD700;
            margin-bottom: 20px;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background-color: rgba(255, 255, 255, 0.1); /* Transparent rows */
            color: #fff;
            font-size: 1.1em;
        }

        th {
            background-color: rgba(0, 0, 0, 0.8);
            color: #FFD700;
            font-size: 1.2em;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        tr:nth-child(even) {
            background-color: rgba(255, 255, 255, 0.1);
        }

        tr:hover {
            background-color: rgba(255, 255, 255, 0.3);
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #FFD700;
            text-decoration: none;
            font-size: 1.2em;
            border: 2px solid #FFD700;
            padding: 10px 20px;
            border-radius: 8px;
            transition: background-color 0.3s, color 0.3s;
        }

        .back-link a:hover {
            background-color: #FFD700;
            color: #1e90ff;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>View Affirmations</h1>
        <?php if ($result && $result->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Affirmation</th>
                        <th>Author</th>
                        <th>Category</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['text']); ?></td>
                            <td><?php echo htmlspecialchars($row['author']); ?></td>
                            <td><?php echo htmlspecialchars($row['category']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p style="text-align: center; font-size: 1.5em;">No affirmations found!</p>
        <?php endif; ?>

        <div class="back-link">
            <a href="add_affirmation.php">Add a New Affirmation</a>
        </div>
    </div>
</body>
</html>
