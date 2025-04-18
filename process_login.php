<?php
require_once __DIR__ . '/includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = sanitizeInput($_POST['email']);
    $password = sanitizeInput($_POST['password']);
    
    $result = loginUser($email, $password);
    
    header('Content-Type: application/json');
    echo json_encode($result);
    exit();
}

header('HTTP/1.1 400 Bad Request');
echo json_encode(['success' => false, 'message' => 'Invalid request']);
?>