<?php
session_start();
include('db_connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $title = $_POST['title'];
    $content = $_POST['content'];
    $is_anonymous = isset($_POST['is_anonymous']) ? 1 : 0;

    // Insert journal entry into the database
    $query = "INSERT INTO journals (user_id, title, content, is_anonymous) VALUES ('$user_id', '$title', '$content', '$is_anonymous')";
    $conn->query($query);
    header("Location: journals.php"); // Redirect to refresh the page
}

// Fetch all journal entries
$query = "SELECT * FROM journals ORDER BY created_at DESC";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Journals</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            color: #0078a6;
        }

        .form-container {
            margin-bottom: 30px;
        }

        label {
            font-size: 14px;
            color: #555;
        }

        input[type="text"], textarea {
            width: 100%;
            padding: 15px;
            margin-bottom: 15px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-sizing: border-box;
        }

        button {
            background-color: #0078a6;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 8px;
            width: 100%;
            margin-top: 15px;
        }

        button:hover {
            background-color: #005f77;
        }

        .table-container {
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border-radius: 8px;
            overflow: hidden;
        }

        table th, table td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            background-color: #0078a6;
            color: white;
        }

        .option-btn {
            background-color: #0078a6;
            color: white;
            text-decoration: none;
            padding: 10px 20px;
            margin-top: 20px;
            display: inline-block;
            border-radius: 8px;
            width: 100%;
            text-align: center;
        }

        .option-btn:hover {
            background-color: #005f77;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Manage Your Journals</h1>

    <!-- New Journal Entry Form -->
    <div class="form-container">
        <form action="journals.php" method="POST">
            <label for="title">Journal Title</label>
            <input type="text" name="title" id="title" placeholder="Enter your journal title" required>

            <label for="content">Journal Content</label>
            <textarea name="content" id="content" placeholder="Write your journal here..." required></textarea>
            
            <label>
                <input type="checkbox" name="is_anonymous"> Post Anonymously
            </label>
            
            <button type="submit">Submit Journal</button>
        </form>
    </div>

    <!-- Past Journal Entries -->
    <div class="table-container">
        <h2>Your Past Entries</h2>
        <table>
            <thead>
                <tr>
                    <th>User</th>
                    <th>Title</th>
                    <th>Content</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['is_anonymous'] ? 'Anonymous' : htmlspecialchars($_SESSION['username']); ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($row['content'])); ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
    
    <a href="homepage.php" class="option-btn">Back to Homepage</a>
</div>

</body>
</html>
