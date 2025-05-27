<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Educational Videos - CalmMind</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7f6;
            margin: 0;
            padding: 0;
        }
        .videos-container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background: #ffffff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        .videos-container h1 {
            text-align: center;
            color: #0078a6;
            margin-bottom: 20px;
        }
        .video-item {
            margin-bottom: 30px;
        }
        .video-item video {
            display: block;
            width: 100%;
            height: auto;
            border: 1px solid #ddd;
            border-radius: 5px;
            background: #000;
        }
        .video-title {
            margin-top: 10px;
            font-size: 18px;
            color: #333;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="videos-container">
        <h1>Educational Videos on Mental Health</h1>

        <div class="video-item">
            <video controls>
                <source src="videos/are_you_okay.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <p class="video-title">Are You Okay?</p>
        </div>

        <div class="video-item">
            <video controls>
                <source src="videos/talking_mental_health.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <p class="video-title">Talking Mental Health</p>
        </div>

        <div class="video-item">
            <video controls>
                <source src="videos/what_is_mental_health.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <p class="video-title">What is Mental Health?</p>
        </div>

        <div class="video-item">
            <video controls>
                <source src="videos/check_in_on_those_around_you.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <p class="video-title">Check in on Those Around You</p>
        </div>

        <div class="video-item">
            <video controls>
                <source src="videos/we_all_have_mental_health.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
            <p class="video-title">We All Have Mental Health</p>
        </div>
    </div>
</body>
</html>
