<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "12345678"; // your password for root
$database = "calmmind"; // your database name

$conn = new mysqli($servername, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the selected problem from the query parameter
$problem = isset($_GET['problem']) ? $_GET['problem'] : '';

// Fetch resources based on the selected problem
$sql = "SELECT * FROM mental_health_resources WHERE category LIKE '%$problem%'";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mental Health Help - <?php echo ucfirst($problem); ?></title>
    <style>
        /* Add your styles here */
    </style>
</head>
<body>
    <h1>Find Help for <?php echo ucfirst($problem); ?></h1>

    <h2>Available Resources</h2>
    <?php
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<div class='resource-card'>";
            echo "<h3>" . htmlspecialchars($row['name']) . "</h3>";
            echo "<p>" . htmlspecialchars($row['description']) . "</p>";
            if (!empty($row['contact'])) {
                echo "<p>Contact: <a href='tel:" . htmlspecialchars($row['contact']) . "'>" . htmlspecialchars($row['contact']) . "</a></p>";
            }
            if (!empty($row['website'])) {
                echo "<p><a href='" . htmlspecialchars($row['website']) . "' target='_blank'>Visit Website</a></p>";
            }
            echo "</div>";
        }
    } else {
        echo "<p>No resources found for this problem.</p>";
    }

    $conn->close();
    ?>
</body>
</html>
