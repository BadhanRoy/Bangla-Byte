<?php
require_once __DIR__ . '/includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = sanitizeInput($_POST['name']);
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
    $role = sanitizeInput($_POST['role']);
    
    $result = registerUser($name, $email, $password, $role);
    
    header('Content-Type: application/json');
    echo json_encode($result);
    exit();
}

header('HTTP/1.1 400 Bad Request');
echo json_encode(['success' => false, 'message' => 'Invalid request']);
?>