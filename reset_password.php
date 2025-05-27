<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include('db_connect.php');

    $token = $_GET['token']; // Get the token from the URL
    $new_password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $error = "";
    $success = "";

    if (empty($new_password) || empty($confirm_password)) {
        $error = "Please fill in both password fields.";
    } else if ($new_password != $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if the token is valid and not expired
        $query = "SELECT * FROM password_resets WHERE token='$token' AND expires_at > NOW() LIMIT 1";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $email = $row['email'];

            // Hash the new password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

            // Update the user's password in the users table
            $updateQuery = "UPDATE users SET password='$hashed_password' WHERE email='$email'";
            if ($conn->query($updateQuery)) {
                // Delete the token from password_resets table after use
                $deleteQuery = "DELETE FROM password_resets WHERE token='$token'";
                $conn->query($deleteQuery);

                $success = "Your password has been successfully reset. You can now log in with your new password.";
            } else {
                $error = "Failed to reset the password. Please try again.";
            }
        } else {
            $error = "Invalid or expired reset link.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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

        .reset-password-container {
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

        input[type="password"], input[type="email"] {
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
    <div class="reset-password-container">
        <h1>Reset Your Password</h1>

        <?php
        if (isset($error)) {
            echo "<p class='error'>$error</p>";
        }

        if (isset($success)) {
            echo "<p class='success'>$success</p>";
        }
        ?>

        <form method="POST" action="">
            <input type="password" name="password" placeholder="Enter new password" required>
            <input type="password" name="confirm_password" placeholder="Confirm new password" required>
            <button type="submit">Reset Password</button>
        </form>

        <a href="login.php" class="back-link">Back to Login</a>
    </div>
</body>
</html>
