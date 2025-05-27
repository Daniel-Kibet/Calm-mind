<?php
// Include database connection
include('db_connect.php');

// Initialize variables
$message = '';

// Start session to access user_id (assuming the user is logged in)
session_start();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure user is logged in
    if (!isset($_SESSION['user_id'])) {
        $message = "You need to be logged in to submit a journal.";
    } else {
        $user_id = $_SESSION['user_id']; // Get user_id from the session
        $title = $_POST['title'];
        $content = $_POST['content'];
        $is_anonymous = isset($_POST['is_anonymous']) ? 1 : 0;

        // Insert journal entry into the database
        $query = "INSERT INTO journals (user_id, title, content, is_anonymous, created_at) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('isss', $user_id, $title, $content, $is_anonymous);

        if ($stmt->execute()) {
            $message = "Journal added successfully!";
        } else {
            $message = "Error: Could not add journal.";
        }
        $stmt->close();
    }
}

// Fetch past journal entries for the logged-in user
$query = "SELECT id, title, content, created_at FROM journals WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param('i', $_SESSION['user_id']); // Filter journals by user_id
$stmt->execute();
$result = $stmt->get_result();  // This will safely assign the result or null if no results
$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Journals</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-container {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            margin-top: 30px;
        }
        h2 {
            margin-bottom: 20px;
        }
        .form-container input,
        .form-container textarea,
        .form-container label {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .form-container input[type="checkbox"] {
            width: auto;
        }
        .form-container button {
            background-color: #0078a6;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        .form-container button:hover {
            background-color: #005b80;
        }
        .journal-list {
            margin-top: 30px;
        }
        .journal-list table {
            width: 100%;
            border-collapse: collapse;
        }
        .journal-list th,
        .journal-list td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        .journal-list th {
            background-color: #f2f2f2;
        }
        .journal-list tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .journal-list a {
            color: #0078a6;
            text-decoration: none;
            margin-right: 10px;
        }
        .journal-list a:hover {
            text-decoration: underline;
        }
        .back-button {
            background-color: #0078a6;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: auto;
            text-align: center;
            display: inline-block;
            margin-top: 20px;
            text-decoration: none;
        }
        .back-button:hover {
            background-color: #005b80;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>Manage Your Journals</h1>

    <!-- Show message if journal was successfully added -->
    <?php if (!empty($message)): ?>
        <div class="alert"><?php echo $message; ?></div>
    <?php endif; ?>

    <!-- Journal Submission Form -->
    <div class="form-container">
        <h2>Add New Journal Entry</h2>
        <form action="manage_journals.php" method="post">
            <label for="title">Journal Title</label>
            <input type="text" id="title" name="title" placeholder="Enter your journal title" required>

            <label for="content">Journal Content</label>
            <textarea id="content" name="content" rows="5" placeholder="Write your journal here..." required></textarea>

            <label>
                <input type="checkbox" name="is_anonymous"> Post Anonymously
            </label>

            <button type="submit">Submit Journal</button>
        </form>
    </div>

    <!-- Display Past Journal Entries -->
    <div class="journal-list">
        <h2>Your Past Journal Entries</h2>
        <table>
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($row['content'])); ?></td>
                        <td><?php echo $row['created_at']; ?></td>
                        <td>
                            <a href="edit_journal.php?id=<?php echo $row['id']; ?>">Edit</a> | 
                            <a href="delete_journal.php?id=<?php echo $row['id']; ?>">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4">No journal entries found.</td>
                </tr>
            <?php endif; ?>
        </table>
    </div>

    <!-- Back to Homepage Button -->
    <a href="homepage.php" class="back-button">Back to Homepage</a>

</div>

</body>
</html>
