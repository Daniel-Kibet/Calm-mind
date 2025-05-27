<?php
include 'db_connect.php';

// Function to create a new user
function createUser($username, $password, $email) {
    global $conn;
    
    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    // Prepare SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $hashed_password, $email);

    if ($stmt->execute()) {
        $stmt->close();
        return "New user created successfully!";
    } else {
        $error = "Error: " . $stmt->error;
        $stmt->close();
        return $error;
    }
}

// Function to get all users
function getUsers() {
    global $conn;
    $sql = "SELECT * FROM users";
    $result = $conn->query($sql);
    return $result;
}

// Function to update a user's email
function updateUserEmail($id, $email) {
    global $conn;
    $stmt = $conn->prepare("UPDATE users SET email=? WHERE id=?");
    $stmt->bind_param("si", $email, $id);
    if ($stmt->execute()) {
        $stmt->close();
        return "User email updated successfully!";
    } else {
        $error = "Error: " . $stmt->error;
        $stmt->close();
        return $error;
    }
}

// Function to delete a user by ID
function deleteUser($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM users WHERE id=?");
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $stmt->close();
        return "User deleted successfully!";
    } else {
        $error = "Error: " . $stmt->error;
        $stmt->close();
        return $error;
    }
}

// Function to create a new mindfulness exercise
function createExercise($title, $description, $type) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO exercises (title, description, type) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $title, $description, $type);
    if ($stmt->execute()) {
        $stmt->close();
        return "New exercise created successfully!";
    } else {
        $error = "Error: " . $stmt->error;
        $stmt->close();
        return $error;
    }
}

// Function to get all mindfulness exercises
function getExercises() {
    global $conn;
    $sql = "SELECT * FROM exercises";
    $result = $conn->query($sql);
    return $result;
}
?>
