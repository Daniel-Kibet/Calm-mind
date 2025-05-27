<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "12345678"; // your password for root
$database = "calmmind"; // your database name

// Create a connection with error reporting enabled
$conn = new mysqli($servername, $username, $password, $database);

// Check connection and handle errors
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Set the charset to UTF-8 for proper encoding
if (!$conn->set_charset("utf8")) {
    die("Error loading character set utf8: " . $conn->error);
}

// Insert a new resource if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_user_input'])) {
    // Sanitize and get input values
    $name = isset($_POST['anonymous']) ? 'Anonymous' : htmlspecialchars($_POST['name']);
    $problem = htmlspecialchars($_POST['problem']);
    
    // Optional: You can store this in a separate table for user inquiries if needed.
    // For now, we'll just store it temporarily to display confirmation
    echo "<p>Thank you, $name. We’ve received your problem: '$problem'. Please see the available resources below for assistance.</p>";
    
    // Redirect to mental_resources_page.php after form submission
    header("Location: mental_resources_page.php");
    exit();
}

// Fetch resources from the database
$sql = "SELECT * FROM mental_health_resources";  // Ensure 'mental_health_resources' is your actual table name
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mental Health Resources</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #0078a6;
        }
        .form-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 40px;
        }
        .form-container input, .form-container select, .form-container textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 4px;
            border: 1px solid #ddd;
            font-size: 14px;
        }
        .form-container button {
            padding: 10px 20px;
            background-color: #0078a6;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .form-container button:hover {
            background-color: #005f7a;
        }
        .resource-card {
            border: 1px solid #ccc;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            background-color: #ffffff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .resource-card h3 {
            margin: 0 0 10px;
        }
        .resource-card p {
            margin: 5px 0;
        }
        .resource-card a {
            color: #0078a6;
            text-decoration: none;
        }
        .resource-card a:hover {
            text-decoration: underline;
        }
        .anonymous-checkbox {
            display: inline-block;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Mental Health Resources</h1>

        <!-- User Input Form -->
        <div class="form-container">
            <h2>Share Your Concerns</h2>
            <form method="POST">
                <label for="name">Your Name (Optional):</label>
                <input type="text" id="name" name="name" placeholder="Enter your name (Optional)">

                <label for="problem">Select a problem you're facing:</label>
                <select id="problem" name="problem">
                    <option value="anxiety">Anxiety</option>
                    <option value="depression">Depression</option>
                    <option value="stress">Stress</option>
                    <option value="relationship_issues">Relationship Issues</option>
                    <option value="substance_abuse">Substance Abuse</option>
                </select>

                <!-- Anonymous Option -->
                <div class="anonymous-checkbox">
                    <input type="checkbox" id="anonymous" name="anonymous">
                    <label for="anonymous">Remain Anonymous</label>
                </div>

                <button type="submit" name="submit_user_input">Proceed to Resources</button>
            </form>
        </div>

        <?php
        // Display resources after the form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit_user_input'])) {
            echo "<h2>Available Resources</h2>";
            if ($result->num_rows > 0) {
                // Loop through and display each resource
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='resource-card'>";
                    echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";  // Display name from DB
                    echo "<p>" . htmlspecialchars($row['description']) . "</p>";  // Display description from DB
                    if (!empty($row['contact'])) {
                        echo "<p>Contact: <a href='tel:" . htmlspecialchars($row['contact']) . "'>" . htmlspecialchars($row['contact']) . "</a></p>";
                    }
                    if (!empty($row['website'])) {
                        echo "<p><a href='" . htmlspecialchars($row['website']) . "' target='_blank'>Visit Website</a></p>";
                    }
                    echo "<p>If you need further assistance, please contact the resource above directly.</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No resources available at the moment.</p>";
            }
        }

        $conn->close();  // Close the database connection
        ?>
    </div>
</body>
</html>
