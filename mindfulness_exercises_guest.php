<?php
session_start();

// Check if the user is logged in as a guest
if (!isset($_SESSION['username']) || $_SESSION['username'] !== "Guest") {
    header("Location: login.php"); // Redirect to login if not logged in as guest
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mindfulness Exercises - Guest</title>
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
        select {
            padding: 10px;
            font-size: 16px;
            border-radius: 5px;
            border: 1px solid #ccc;
            width: 100%;
            margin-bottom: 20px;
        }
        .instructions {
            margin-top: 20px;
            background-color: #f2f2f2;
            padding: 15px;
            border-radius: 5px;
            font-size: 16px;
        }
        .back-button {
            background-color: #0078a6;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            text-decoration: none;
            display: inline-block;
            text-align: center;
            margin-top: 20px; /* Adjusted margin to add spacing */
        }
        .back-button:hover {
            background-color: #005b80;
        }
    </style>
</head>
<body>

<div class="content-container">
    <h2>Mindfulness Exercises</h2>

    <label for="exercise">Choose an Exercise</label>
    <select id="exercise" onchange="showInstructions()">
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

    <a href="homepagebeta.php" class="back-button">Back to Home</a>
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
