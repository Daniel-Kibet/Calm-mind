<?php
session_start();

// Handle login request
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('db_connect.php');

    if (isset($_POST['guest_login'])) {
        // Login as Guest
        $_SESSION['username'] = "Guest";
        $_SESSION['is_guest'] = true; // Indicate guest login
        header("Location: homepagebeta.php"); // Redirect to guest homepage
        exit();
    } else {
        // Regular login
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Prepare query to get user from the database
        $query = "SELECT * FROM users WHERE username='$username' LIMIT 1";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // User found
            $row = $result->fetch_assoc();
            if (password_verify($password, $row['password'])) {
                $_SESSION['username'] = $username;
                $_SESSION['user_id'] = $row['id'];
                unset($_SESSION['is_guest']); // Remove guest flag if exists
                header("Location: homepage.php"); // Redirect to full homepage
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "User not found.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - CalmMind</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* General styling */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f4f4;
        }

        .login-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .login-box h1 {
            font-size: 2rem;
            color: #0078a6;
            margin-bottom: 20px;
        }

        .login-box input[type="text"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        .login-btn {
            width: 100%;
            padding: 10px;
            background-color: #0078a6;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .login-btn:hover {
            background-color: #005f7a;
        }

        .signup-link a {
            color: #0078a6;
            text-decoration: none;
        }

        .signup-link a:hover {
            text-decoration: underline;
        }

        .forgot-password {
            margin-top: 10px;
            display: block;
            font-size: 14px;
            color: #0078a6;
        }

        .guest-login {
            margin-top: 20px;
            text-align: center;
        }

        .guest-login button {
            width: 100%;
            background-color: black; /* Black button */
            color: white; /* White text */
            padding: 12px;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .guest-login button:hover {
            background-color: #333; /* Lighter black for hover effect */
        }

        .error {
            color: red;
            font-size: 14px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-box">
            <h1>CalmMind</h1>
            <?php if (isset($error)) { echo '<p class="error">' . $error . '</p>'; } ?>
            <form method="POST">
                <input type="text" name="username" placeholder="Username" required>
                <input type="password" name="password" placeholder="Password" required>
                <button type="submit" class="login-btn">Log In</button>
            </form>
            <div class="signup-link">
                <p>Don't have an account? <a href="signup.php">Sign up</a></p>
                <a href="forgot_password.php" class="forgot-password">Forgot Password?</a>
            </div>
            <div class="guest-login">
                <form method="POST">
                    <button type="submit" name="guest_login">Login as Guest</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
