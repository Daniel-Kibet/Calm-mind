<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('db_connect.php');

    $email = trim($_POST['email']);
    $error = "";
    $success = "";

    if (empty($email)) {
        $error = "Please enter your email address.";
    } else {
        // Check if email exists in the users table
        $query = "SELECT * FROM users WHERE email='$email' LIMIT 1";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            // Generate a secure token
            $token = bin2hex(random_bytes(50));
            $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

            // Store the token in the password_resets table
            $insertQuery = "INSERT INTO password_resets (email, token, expires_at) VALUES ('$email', '$token', '$expires_at')";
            if ($conn->query($insertQuery)) {
                // Send reset link to user's email
                $resetLink = "http://yourwebsite.com/reset_password.php?token=$token";
                $subject = "Password Reset Request";
                $message = "Click the link below to reset your password:\n\n$resetLink";
                $headers = "From: no-reply@yourwebsite.com";

                if (mail($email, $subject, $message, $headers)) {
                    $success = "Password reset link sent to your email address.";
                } else {
                    $error = "Failed to send email. Please try again later.";
                }
            } else {
                $error = "Failed to process your request. Please try again later.";
            }
        } else {
            $error = "No account found with that email address.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .forgot-password-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }

        h1 {
            color: #333;
            font-size: 24px;
            margin-bottom: 20px;
            text-align: center;
        }

        input[type="email"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            font-size: 16px;
        }

        button {
            width: 100%;
            padding: 14px;
            background-color: #0078a6;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #005f7a;
        }

        .error, .success {
            font-size: 14px;
            text-align: center;
            margin-top: 10px;
        }

        .error {
            color: red;
        }

        .success {
            color: green;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #0078a6;
            text-decoration: none;
            font-size: 14px;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="forgot-password-container">
        <h1>Forgot Password</h1>

        <?php
        if (isset($error)) {
            echo "<p class='error'>$error</p>";
        }

        if (isset($success)) {
            echo "<p class='success'>$success</p>";
        }
        ?>

        <form method="POST" action="">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit">Send Reset Link</button>
        </form>

        <a href="login.php" class="back-link">Back to Login</a>
    </div>
</body>
</html>
