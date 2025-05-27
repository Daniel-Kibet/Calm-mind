<?php
// This file will be the landing page for mental health resources.

// Database connection (Ensure this is correct based on your setup)
$servername = "localhost";
$username = "root";
$password = "12345678";  // your root password
$database = "calmmind";   // your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch resources categorized by type of problem
$sql = "SELECT * FROM mental_health_resources ORDER BY category";  // Add 'category' column in your table
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
            color: white;
        }
        video {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
        }
        .container {
            width: 90%;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.7); /* Transparent background for better readability */
            border-radius: 10px;
        }
        h1, h2 {
            text-align: center;
            color: #ffd700; /* Gold color for headers */
        }
        .category-section {
            margin-top: 20px;
        }
        .resource-card {
            border: 1px solid #ccc;
            padding: 15px;
            margin: 10px 0;
            border-radius: 5px;
            background-color: rgba(255, 255, 255, 0.1);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.5);
        }
        .resource-card h3 {
            margin: 0 0 10px;
            color: #ffd700;
        }
        .resource-card p {
            margin: 5px 0;
        }
        .resource-card a {
            color: #00ff00; /* Bright green for links */
            text-decoration: none;
        }
        .resource-card a:hover {
            text-decoration: underline;
        }
        .contact-details {
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <video autoplay muted loop>
        <source src="videos/mentalresources.mp4" type="video/mp4">
        Your browser does not support the video tag.
    </video>
    <div class="container">
        <h1>Mental Health Resources</h1>
        
        <?php if ($result->num_rows > 0): ?>
            <?php 
            $currentCategory = null; 
            while ($row = $result->fetch_assoc()): 
                if ($currentCategory !== $row['category']): 
                    $currentCategory = $row['category']; 
            ?>
                <div class="category-section">
                    <h2><?php echo htmlspecialchars($currentCategory); ?></h2>
                </div>
            <?php endif; ?>
                <div class="resource-card">
                    <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                    <p><?php echo htmlspecialchars($row['description']); ?></p>
                    <div class="contact-details">
                        <p><strong>Contact:</strong> <a href="tel:<?php echo htmlspecialchars($row['contact']); ?>"> <?php echo htmlspecialchars($row['contact']); ?></a></p>
                        <p><a href="<?php echo htmlspecialchars($row['website']); ?>" target="_blank">Visit Website</a></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <p>No resources available at the moment.</p>
        <?php endif; ?>
        
        <!-- Emergency Contacts Section -->
        <h2>Emergency Contacts</h2>
        <div class="resource-card">
            <h3>Kenya Red Cross Society</h3>
            <p>Provides emergency mental health support.</p>
            <div class="contact-details">
                <p><strong>Call:</strong> <a href="tel:0203950000">020 3950000</a></p>
                <p><a href="https://www.redcross.or.ke" target="_blank">Visit Website</a></p>
            </div>
        </div>
        <div class="resource-card">
            <h3>Mind Matters Kenya</h3>
            <p>A mental health organization offering therapy services and awareness programs.</p>
            <div class="contact-details">
                <p><strong>Call:</strong> <a href="tel:0103006811">0103 006811</a></p>
                <p><a href="https://app.wedonthavetime.org/profile/mindmatterske" target="_blank">Visit Website</a></p>
            </div>
        </div>
        <div class="resource-card">
            <h3>The Nairobi Counseling & Mental Health Centre</h3>
            <p>Provides professional mental health counseling and therapy services for individuals, couples, and families in Nairobi and beyond.</p>
            <div class="contact-details">
                <p><strong>Contact:</strong> <a href="tel:0714972228">0714 972228</a></p>
                <p><a href="https://psychologistrechaelmbugwa.com/" target="_blank">Visit Website</a></p>
            </div>
        </div>
        <div class="resource-card">
            <h3>Women’s Health Foundation Kenya</h3>
            <p>Specializes in mental health services for women, including psychiatric care, therapy, and counseling services in Nairobi.</p>
            <div class="contact-details">
                <p><strong>Contact:</strong> <a href="tel:0722760147">0722 760 147</a></p>
                <p><a href="https://www.teachandtreat.org/post/women-s-health-in-nairobi" target="_blank">Visit Website</a></p>
            </div>
        </div>
    </div>
</body>
</html>

<?php
// Close the database connection
$conn->close();
?>
