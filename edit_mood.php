<?php
session_start();
include('db_connect.php');

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get the mood record to edit
if (isset($_GET['id'])) {
    $mood_id = $_GET['id'];
    $query = "SELECT * FROM moods WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $mood_id, $_SESSION['user_id']);
    $stmt->execute();
    $result = $stmt->get_result();
    $mood = $result->fetch_assoc();
} else {
    header("Location: mood_tracking.php");
    exit();
}

// Update mood record if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mood = $_POST['mood'];
    $description = $_POST['description'];

    $update_query = "UPDATE moods SET mood = ?, description = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssi", $mood, $description, $mood_id);
    if ($update_stmt->execute()) {
        header("Location: mood_tracking.php");
        exit();
    } else {
        $error = "Failed to update mood. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Mood - CalmMind</title>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <style>
        /* Global Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Arial', sans-serif;
            background: url('images/moods.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: #fff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .container {
            background: rgba(0, 0, 0, 0.6);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            max-width: 500px;
            width: 100%;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
            font-size: 36px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            font-size: 18px;
            color: #FFD700;
        }

        .form-group input,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 16px;
        }

        .form-group textarea {
            resize: vertical;
            height: 150px;
        }

        .mood-selector {
            display: flex;
            justify-content: space-between;
            font-size: 20px;
            color: #FFD700;
            margin-bottom: 20px;
        }

        .mood-selector input[type="radio"] {
            margin-right: 10px;
        }

        .submit-btn {
            display: block;
            width: 100%;
            padding: 15px;
            background-color: #0078a6;
            color: white;
            font-size: 18px;
            border: none;
            border-radius: 50px;
            cursor: pointer;
            margin-top: 20px;
        }

        .submit-btn:hover {
            background-color: #005b80;
        }

        .error-message {
            color: #FF4500;
            font-size: 18px;
            margin-bottom: 20px;
            text-align: center;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Edit Your Mood</h2>
    
    <?php if (isset($error)): ?>
        <p class="error-message"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <form method="POST">
        <div class="form-group">
            <label for="mood">Select Mood</label>
            <div class="mood-selector">
                <label>
                    <input type="radio" name="mood" value="Happy" <?php echo ($mood['mood'] == 'Happy') ? 'checked' : ''; ?>> 😊 Happy
                </label>
                <label>
                    <input type="radio" name="mood" value="Sad" <?php echo ($mood['mood'] == 'Sad') ? 'checked' : ''; ?>> 😢 Sad
                </label>
                <label>
                    <input type="radio" name="mood" value="Angry" <?php echo ($mood['mood'] == 'Angry') ? 'checked' : ''; ?>> 😡 Angry
                </label>
                <label>
                    <input type="radio" name="mood" value="Neutral" <?php echo ($mood['mood'] == 'Neutral') ? 'checked' : ''; ?>> 😐 Neutral
                </label>
                <label>
                    <input type="radio" name="mood" value="Anxious" <?php echo ($mood['mood'] == 'Anxious') ? 'checked' : ''; ?>> 😰 Anxious
                </label>
            </div>
        </div>

        <div class="form-group">
            <label for="description">Mood Description</label>
            <textarea name="description" id="description" required><?php echo htmlspecialchars($mood['description']); ?></textarea>
        </div>

        <button type="submit" class="submit-btn">Save Mood</button>
    </form>
</div>

</body>
</html>
