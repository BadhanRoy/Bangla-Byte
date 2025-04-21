<?php
session_start();
include 'connect.php';

// Handle Registration
if(isset($_POST['signUp'])) {
    // Get form data
    $firstName = trim($conn->real_escape_string($_POST['firstName']));
    $lastName = trim($conn->real_escape_string($_POST['lastName']));
    $email = trim($conn->real_escape_string($_POST['email']));
    $password = trim($_POST['password']);

    // Validate inputs
    $errors = [];
    
    if(empty($firstName)) $errors[] = "First name is required";
    if(empty($lastName)) $errors[] = "Last name is required";
    if(empty($email)) {
        $errors[] = "Email is required";
    } elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format";
    }
    if(empty($password)) $errors[] = "Password is required";
    elseif(strlen($password) < 6) $errors[] = "Password must be at least 6 characters";

    if(!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header("Location: homepage.php");
        exit();
    }

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if($stmt->num_rows > 0) {
        $_SESSION['errors'] = ["Email already exists"];
        header("Location: homepage.php");
        exit();
    }

    // Hash password
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $insertStmt = $conn->prepare("INSERT INTO users (firstName, lastName, email, password) VALUES (?, ?, ?, ?)");
    $insertStmt->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);

    if($insertStmt->execute()) {
        // Get the new user's ID
        $userId = $conn->insert_id;
        
        // Set session variables
        $_SESSION['id'] = $userId;
        $_SESSION['firstName'] = $firstName;
        $_SESSION['lastName'] = $lastName;
        $_SESSION['email'] = $email;
        
        header("Location: dashboard.php");
        exit();
    } else {
        $_SESSION['errors'] = ["Database error: " . $conn->error];
        header("Location: homepage.php");
        exit();
    }
}

// Handle Login
if(isset($_POST['signIn'])) {
    $email = trim($conn->real_escape_string($_POST['email']));
    $password = trim($_POST['password']);

    // Validate inputs
    if(empty($email) || empty($password)) {
        $_SESSION['errors'] = ["Email and password are required"];
        header("Location: homepage.php");
        exit();
    }

    // Get user from database
    $stmt = $conn->prepare("SELECT id, firstName, lastName, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        
        // Verify password
        if(password_verify($password, $user['password'])) {
            // Set session variables
            $_SESSION['id'] = $user['id'];
            $_SESSION['firstName'] = $user['firstName'];
            $_SESSION['lastName'] = $user['lastName'];
            $_SESSION['email'] = $user['email'];
            
            header("Location: dashboard.php");
            exit();
        } else {
            $_SESSION['errors'] = ["Invalid email or password"];
            header("Location: homepage.php");
            exit();
        }
    } else {
        $_SESSION['errors'] = ["Invalid email or password"];
        header("Location: homepage.php");
        exit();
    }
}

// Default redirect
header("Location: homepage.php");
exit();
?>