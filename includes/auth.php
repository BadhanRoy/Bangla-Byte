<?php
require_once __DIR__ . '/functions.php';

function registerUser($name, $email, $password, $role) {
    $conn = getDBConnection();
    
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        return ['success' => false, 'message' => 'Email already exists'];
    }
    $stmt->close();
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    $stmt = $conn->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashedPassword, $role);
    
    if ($stmt->execute()) {
        return ['success' => true, 'message' => 'Registration successful!'];
    } else {
        return ['success' => false, 'message' => 'Registration failed: ' . $conn->error];
    }
}

function loginUser($email, $password) {
    $conn = getDBConnection();
    
    $stmt = $conn->prepare("SELECT id, username, email, password, role FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        if (password_verify($password, $user['password'])) {
            session_start();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];
            
            return [
                'success' => true, 
                'message' => 'Login successful!',
                'redirect' => 'index.html'
            ];
        }
    }
    
    return ['success' => false, 'message' => 'Invalid email or password'];
}
?>