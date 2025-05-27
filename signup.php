<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('db_connect.php');

    // Collect form data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Validate inputs
    if (!empty($username) && !empty($email) && !empty($password)) {
        // Hash the password for security
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        // Check if username or email already exists
        $checkQuery = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
        $result = $conn->query($checkQuery);

        if ($result->num_rows > 0) {
            $error = "Username or email already exists.";
        } else {
            // Insert user into the database
            $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$hashedPassword')";
            if ($conn->query($query)) {
                $success = "Account created successfully. You can now <a href='login.php'>log in</a>.";
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    } else {
        $error = "All fields are required.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - CalmMind</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Basic styling for the sign-up page */
        body {
            font-family: 'Arial', sans-serif;
            background-color: #fafafa;
            margin: 0;
            padding: 0;
        }

        .signup-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .signup-box {
            background: #fff;
            padding: 40px 30px;
            width: 350px;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .signup-box h1 {
            font-size: 30px;
            margin-bottom: 20px;
            color: #0078a6;
        }

        .signup-box input {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            transition: all 0.3s;
        }

        .signup-box input:focus {
            border-color: #0078a6;
            box-shadow: 0 0 8px rgba(0, 120, 166, 0.2);
        }

        .signup-box button {
            width: 100%;
            padding: 12px;
            border: none;
            background-color: #0078a6;
            color: white;
            font-size: 16px;
            font-weight: bold;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s;
        }

        .signup-box button:hover {
            background-color: #005f82;
        }

        .signup-box .error {
            color: red;
            margin: 10px 0;
            font-size: 14px;
        }

        .signup-box .success {
            color: green;
            margin: 10px 0;
            font-size: 14px;
        }

        .signup-box .signup-link {
            margin-top: 20px;
        }

        .signup-box .signup-link a {
            color: #0078a6;
            text-decoration: none;
            font-size: 14px;
        }

        .signup-box .signup-link a:hover {
            text-decoration: underline;
        }

        /* Responsive design for mobile */
        @media (max-width: 480px) {
            .signup-box {
                width: 90%;
            }
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <div class="signup-box">
            <h1>CalmMind</h1>
            <?php
            if (isset($error)) {
                echo "<p class='error'>$error</p>";
            } elseif (isset($success)) {
                echo "<p class='success'>$success</p>";
            }
            ?>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="email" placeholder="Email" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit">Sign Up</button>
            </form>
            <div class="signup-link">
                <p>Already have an account? <a href="login.php">Login here</a></p>
            </div>
        </div>
    </div>
</body>
</html>
