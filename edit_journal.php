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

// Fetch the journal details
$query = "SELECT * FROM journals WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $journal_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Journal not found.");
}

$journal = $result->fetch_assoc();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $content = trim($_POST['content']);
    $is_anonymous = isset($_POST['is_anonymous']) ? 1 : 0;

    if (!empty($title) && !empty($content)) {
        $update_query = "UPDATE journals SET title = ?, content = ?, is_anonymous = ?, updated_at = NOW() WHERE id = ? AND user_id = ?";
        $update_stmt = $conn->prepare($update_query);
        $update_stmt->bind_param("ssiii", $title, $content, $is_anonymous, $journal_id, $user_id);

        if ($update_stmt->execute()) {
            header("Location: manage_journals.php?success=Journal updated successfully.");
            exit();
        } else {
            $error = "Failed to update the journal. Please try again.";
        }
    } else {
        $error = "Both title and content are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Journal</title>
    <style>
        body {
            background: url('images/moods.jpeg') no-repeat center center fixed;
            background-size: cover;
            font-family: Arial, sans-serif;
            color: #fff;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 50px auto;
            background: rgba(0, 0, 0, 0.7);
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-top: 10px;
        }
        input[type="text"], textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            background-color: #0078a6;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 10px;
        }
        button:hover {
            background-color: #005f7e;
        }
        a {
            color: #5de0e6;
            text-decoration: none;
            display: inline-block;
            margin-top: 10px;
        }
        a:hover {
            text-decoration: underline;
        }
        .error {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Journal</h1>

        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="POST">
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($journal['title']); ?>" required>

            <label for="content">Content:</label>
            <textarea id="content" name="content" rows="8" required><?php echo htmlspecialchars($journal['content']); ?></textarea>

            <label>
                <input type="checkbox" name="is_anonymous" <?php echo $journal['is_anonymous'] ? 'checked' : ''; ?>> Post Anonymously
            </label>

            <button type="submit">Save Changes</button>
        </form>

        <a href="manage_journals.php">Back to Journals</a>
    </div>
</body>
</html>
