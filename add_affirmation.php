<?php
// Include your database connection
include('db_connect.php');

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $affirmation = $_POST['affirmation'];
    $author = $_POST['author'] ?? 'Unknown';  // Default to 'Unknown' if no author is provided
    $category = $_POST['category'] ?? 'General'; // Default to 'General' if no category is provided

    // Prepare the SQL query to insert the affirmation into the database
    $query = "INSERT INTO affirmations (text, author, category) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('sss', $affirmation, $author, $category);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect to the page displaying all affirmations after a successful insert
        header("Location: view_affirmations.php");
        exit();  // Ensure no further code is executed
    } else {
        echo "<p class='error-message'>Error: Could not add affirmation.</p>";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Affirmation</title>
    <style>
        /* Base styles for the page */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #FFD700 0%, #FF6347 100%);
            margin: 0;
            padding: 0;
            color: white;
        }

        .form-container {
            width: 100%;
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background-color: rgba(0, 0, 0, 0.3);
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(10px);
        }

        .form-container h2 {
            text-align: center;
            font-size: 2.5em;
            margin-bottom: 20px;
            color: #fff;
            font-weight: bold;
        }

        .form-container label {
            font-size: 1.2em;
            margin-bottom: 10px;
            display: block;
            color: #FFD700;
        }

        .form-container textarea,
        .form-container input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 1.1em;
            color: #333;
            background-color: rgba(255, 255, 255, 0.7);
        }

        .form-container textarea {
            height: 120px;
        }

        .form-container button {
            background-color: #4CAF50;
            color: white;
            font-size: 1.1em;
            padding: 12px;
            border: none;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .form-container button:hover {
            background-color: #45a049;
        }

        .form-container input:focus,
        .form-container textarea:focus {
            border: 1px solid #4CAF50;
            outline: none;
        }

        /* Success message */
        .success-message {
            text-align: center;
            color: #32CD32;
            font-weight: bold;
            font-size: 1.2em;
        }

        /* Error message */
        .error-message {
            text-align: center;
            color: #FF4500;
            font-weight: bold;
            font-size: 1.2em;
        }

        .form-footer {
            text-align: center;
            margin-top: 20px;
        }

        .form-footer a {
            color: #FFD700;
            font-size: 1.1em;
            text-decoration: none;
            border: 1px solid #FFD700;
            padding: 5px 10px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .form-footer a:hover {
            background-color: #FFD700;
            color: #FF6347;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Add a New Affirmation</h2>
        <form action="add_affirmation.php" method="POST">
            <label for="affirmation">Affirmation Text:</label>
            <textarea name="affirmation" id="affirmation" placeholder="Type your affirmation here..." required></textarea>

            <label for="author">Author (optional):</label>
            <input type="text" name="author" id="author" placeholder="Author (Optional)">

            <label for="category">Category (optional):</label>
            <input type="text" name="category" id="category" placeholder="Category (Optional)">

            <button type="submit">Add Affirmation</button>
        </form>

        <div class="form-footer">
            <a href="view_affirmations.php">View All Affirmations</a>
        </div>
    </div>
</body>
</html>
