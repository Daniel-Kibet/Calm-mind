<?php
session_start();

// Predefined affirmations categorized
$affirmations = [
    "Self-Esteem" => [
        "I embrace my flaws because I know that nobody is perfect.",
        "My self-worth is not determined by a number on a scale.",
        "I matter, and what I have to offer this world also matters."
    ],
    "Adversity" => [
        "I learn from my challenges and always find ways to overcome them.",
        "Everything works out for the best possible good.",
        "If I can conceive it and believe it, I can achieve it."
    ],
    "Reducing Comparisons" => [
        "I refrain from comparing myself to others.",
        "I see perfection in both my virtues and my flaws.",
        "I belong, and I am good enough."
    ],
    "Friendship" => [
        "I attract wonderful, positive people into my world.",
        "I am a supportive and dependable friend."
    ],
];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Affirmations</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: url('images/affirmation.jpeg') no-repeat center center fixed;
            background-size: cover;
            color: #333;
            margin: 0;
            padding: 0;
            text-align: center;
        }

        .content-container {
            width: 90%;
            max-width: 800px;
            margin: 20px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.8); /* Semi-transparent background */
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
        }

        h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            text-align: center;
            color: #0078a6;
        }

        .category {
            margin: 20px 0;
        }

        .category h3 {
            color: #333;
            font-size: 1.8rem;
            margin-bottom: 15px;
        }

        .affirmation {
            background: #ffffff;
            margin: 10px 0;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            font-size: 1.2rem;
            color: #555;
        }

        .affirmation-button {
            display: inline-block;
            background-color: #0078a6;
            color: #fff;
            padding: 12px 25px;
            border-radius: 30px;
            font-size: 1rem;
            font-weight: 600;
            text-decoration: none;
            margin-top: 20px;
            transition: background-color 0.3s ease;
        }

        .affirmation-button:hover {
            background-color: #005f7a;
        }
    </style>
</head>
<body>
    <div class="content-container">
        <h2>Daily Affirmations</h2>

        <?php foreach ($affirmations as $category => $quotes): ?>
            <div class="category">
                <h3><?php echo htmlspecialchars($category); ?></h3>
                <?php foreach ($quotes as $quote): ?>
                    <div class="affirmation">
                        <?php echo htmlspecialchars($quote); ?>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endforeach; ?>

        <a href="add_affirmation.php" class="affirmation-button">Add New Affirmation</a>
    </div>
</body>
</html>
