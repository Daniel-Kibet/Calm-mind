<?php
session_start();
include('db_connect.php');

// Redirect to login if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get data from form
    $exercise = $_POST['exercise'];
    $description = $_POST['description'];
    $date = date('Y-m-d'); // current date
    $user_id = $_SESSION['user_id'];

    // Insert new exercise into the database
    $query = "INSERT INTO exercises (exercise, description, date, user_id) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssi", $exercise, $description, $date, $user_id); // bind parameters
    if ($stmt->execute()) {
        $message = "Exercise added successfully!";
    } else {
        $message = "Error adding exercise.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Exercise</title>
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
        form {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        label {
            font-size: 18px;
            font-weight: bold;
        }
        select, input, textarea {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .textarea {
            resize: vertical;
        }
        .submit-button {
            background-color: #0078a6;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }
        .submit-button:hover {
            background-color: #005b80;
        }
        .message {
            padding: 15px;
            background-color: #28a745;
            color: white;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .instructions {
            margin-top: 20px;
            background-color: #f2f2f2;
            padding: 15px;
            border-radius: 5px;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="content-container">
    <h2>Add New Mindfulness Exercise</h2>

    <?php if (isset($message)): ?>
        <div class="message"><?php echo $message; ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="exercise">Choose an Exercise</label>
        <select name="exercise" id="exercise" required onchange="showInstructions()">
            <option value="Deep Breathing">Deep Breathing</option>
            <option value="Body Scan">Body Scan</option>
            <option value="Mindful Walking">Mindful Walking</option>
            <option value="Loving-Kindness Meditation">Loving-Kindness Meditation</option>
            <option value="Gratitude Practice">Gratitude Practice</option>
            <option value="Visualization">Visualization</option>
            <option value="Mindful Eating">Mindful Eating</option>
            <option value="Breathing with Sound">Breathing with Sound</option>
            <option value="Silent Mindfulness">Silent Mindfulness</option>
            <option value="Yoga for Relaxation">Yoga for Relaxation</option>
            <option value="Progressive Muscle Relaxation">Progressive Muscle Relaxation</option>
            <option value="Grounding Exercise">Grounding Exercise</option>
        </select>

        <div id="exercise-instructions" class="instructions">
            <!-- Instructions will be shown here based on exercise selection -->
        </div>

        <label for="description">Your Notes</label>
        <textarea name="description" id="description" rows="6" placeholder="Provide additional details..." required></textarea>

        <button type="submit" class="submit-button">Add Exercise</button>
    </form>
</div>

<script>
    // Instructions for each exercise
    const instructions = {
        "Deep Breathing": "Sit or lie down in a comfortable position. Close your eyes. Breathe in slowly through your nose, hold for a few seconds, then exhale slowly through your mouth. Repeat for 5-10 minutes.",
        "Body Scan": "Close your eyes and focus on each part of your body, starting from your toes and moving up to your head. Pay attention to any tension or sensations and relax each part of your body.",
        "Mindful Walking": "Find a quiet space to walk. Pay attention to your surroundings, the sensation of your feet touching the ground, and your breath. Walk slowly and mindfully.",
        "Loving-Kindness Meditation": "Sit comfortably and close your eyes. Think of someone you love, and silently say to them, 'May you be happy, may you be healthy, may you be at ease.' Repeat this for yourself and others.",
        "Gratitude Practice": "Take a few moments to reflect on what you're grateful for. Write down three things you're thankful for today and why.",
        "Visualization": "Close your eyes and picture a peaceful place, like a beach or forest. Focus on the sights, sounds, and smells of this place to help you relax.",
        "Mindful Eating": "Sit down with your food and take a few deep breaths before eating. Focus on the taste, texture, and smell of each bite. Eat slowly and mindfully.",
        "Breathing with Sound": "Sit comfortably and breathe deeply. As you exhale, make a soft sound like 'ah' or 'shhh'. Focus on the sound of your breath.",
        "Silent Mindfulness": "Sit in silence and focus on your breath. If your mind wanders, gently bring your focus back to your breathing. Sit for 10-15 minutes.",
        "Yoga for Relaxation": "Do a series of gentle yoga poses, focusing on deep breathing. Incorporate poses like Child's Pose, Cat-Cow, and Seated Forward Fold.",
        "Progressive Muscle Relaxation": "Start by tensing the muscles in your toes, then gradually work your way up the body, tensing and then relaxing each muscle group.",
        "Grounding Exercise": "Sit or stand and focus on the feeling of your feet on the ground. Pay attention to the sensation of the earth beneath you to feel grounded."
    };

    // Show instructions based on selected exercise
    function showInstructions() {
        const exercise = document.getElementById("exercise").value;
        document.getElementById("exercise-instructions").innerText = instructions[exercise] || "Select an exercise to see instructions.";
    }

    // Initialize instructions on page load
    window.onload = showInstructions;
</script>

</body>
</html>
