<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirect to login if not logged in
    exit();
}

include('db_connect.php');

// Fetch user details for display
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM users WHERE id='$user_id'";
$result = $conn->query($query);
$user = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to CalmMind</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        /* Global Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Lora', serif;
            color: #fff;
            overflow: hidden;
            background-color: #1e1e1e;
        }

        /* Full-Screen Background Video */
        .background-video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }

        /* Main Container */
        .main-container {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            height: 100vh;
            text-align: center;
            padding: 40px;
            background: rgba(0, 0, 0, 0.5); /* Slight dark overlay for readability */
        }

        /* Header Section */
        .header {
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 60px;
            font-weight: 700;
            color: #ffffff;
            text-transform: capitalize;
            text-shadow: 3px 3px 5px rgba(0, 0, 0, 0.5);
            margin: 0;
            transition: transform 0.3s ease-in-out;
        }

        .header p {
            font-size: 24px;
            color: #ffffff;
            margin-top: 10px;
            font-weight: 300;
            text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.5);
        }

        /* Elegant Card Section */
        .cards-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1000px;
            margin: 40px auto;
            padding: 0 20px;
        }

        /* Individual Card */
        .card {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
            backdrop-filter: blur(10px);
            color: #ffffff;
        }

        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
        }

        .card h3 {
            font-size: 30px;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .card a {
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            color: #0078a6;
            background-color: #ffffff;
            padding: 15px 30px;
            border-radius: 50px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .card a:hover {
            background-color: #0078a6;
            color: #ffffff;
        }

        /* Logout Button */
        .logout-btn {
            font-size: 16px;
            background-color: #e74c3c;
            color: white;
            padding: 12px 30px;
            border-radius: 50px;
            margin-top: 30px;
            transition: background-color 0.3s ease;
        }

        .logout-btn:hover {
            background-color: #c0392b;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .cards-container {
                grid-template-columns: 1fr;
                padding: 0 10px;
            }

            .header h1 {
                font-size: 40px;
            }

            .header p {
                font-size: 20px;
            }
        }

    </style>
</head>
<body>
    <!-- Background Video -->
    <video class="background-video" autoplay muted loop>
        <source src="videos/homepagevid.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>

    <!-- Main Content -->
    <div class="main-container">
        <!-- Header Section -->
        <div class="header">
            <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?></h1>
            <p>Your personalized dashboard to mental wellness</p>
        </div>

        <!-- Cards Section -->
        <div class="cards-container">
            <!-- Manage Journals -->
            <div class="card">
                <h3>Manage Journals</h3>
                <a href="manage_journals.php"><i class="fa-solid fa-book"></i> View Journals</a>
            </div>
            <!-- Mindfulness Exercises -->
            <div class="card">
                <h3>Mindfulness Exercises</h3>
                <a href="mindfulness_exercises.php"><i class="fa-solid fa-spa"></i> Start Exercise</a>
            </div>
            <!-- Educational Videos -->
            <div class="card">
                <h3>Educational Videos</h3>
                <a href="educational_videos.php"><i class="fa-solid fa-video"></i> Watch Videos</a>
            </div>
            <!-- Mood Tracking -->
            <div class="card">
                <h3>Mood Tracking</h3>
                <a href="mood_tracking.php"><i class="fa-solid fa-smile"></i> Track Mood</a>
                </div>
               <!-- Mental Health Resources -->
              <div class="card">
                <h3>Mental Health Resources</h3>
                <a href="view_mental_resources.php"><i class="fa-solid fa-hands-helping"></i> View Resources</a>
              </div>
              <!-- Daily Affirmations -->
            <div class="card">
                <h3>Daily Affirmations</h3>
                <a href="daily_affirmations.php"><i class="fa-solid fa-comment"></i> View Affirmations</a>
            </div>
        </div>

        <!-- Logout Button -->
        <div>
            <a href="logout.php" class="logout-btn"><i class="fa-solid fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
</body>
</html>
