<?php
session_start();
include 'connect.php';

// Redirect if already logged in
if(isset($_SESSION['id'])) {
    header("Location: " . ($_SESSION['role'] === 'admin' ? 'admin_dashboard.php' : 'homepage.php'));
    exit();
}

// Error messages
$error = $_GET['error'] ?? '';
$errorMessages = [
    'login' => "Incorrect email or password",
    'empty_fields' => "Please fill all fields",
    'email_exists' => "Email already exists",
    'invalid_email' => "Invalid email format",
    'database_error' => "Registration failed. Please try again.",
    'short_password' => "Password must be at least 6 characters",
    'invalid_role' => "Please select a valid role"
];

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['signIn'])) {
        $email = trim($conn->real_escape_string($_POST['email']));
        $password = trim($_POST['password']);

        if (empty($email) || empty($password)) {
            header("Location: login.php?error=empty_fields");
            exit();
        }

        $stmt = $conn->prepare("SELECT id, firstName, lastName, email, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['firstName'] = $user['firstName'];
                $_SESSION['lastName'] = $user['lastName'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['role'] = $user['role'];
                header("Location: " . ($user['role'] === 'admin' ? 'admin_dashboard.php' : 'homepage.php'));
                exit();
            }
        }
        header("Location: login.php?error=login");
        exit();
    } 
    elseif (isset($_POST['signUp'])) {
        $firstName = trim($conn->real_escape_string($_POST['firstName']));
        $lastName = trim($conn->real_escape_string($_POST['lastName']));
        $email = trim($conn->real_escape_string($_POST['email']));
        $password = trim($_POST['password']);
        $role = isset($_POST['role']) ? trim($conn->real_escape_string($_POST['role'])) : 'user';

        // Validation
        if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
            header("Location: login.php?error=empty_fields");
            exit();
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: login.php?error=invalid_email");
            exit();
        }

        if (strlen($password) < 6) {
            header("Location: login.php?error=short_password");
            exit();
        }

        if (!in_array($role, ['admin', 'user'])) {
            header("Location: login.php?error=invalid_role");
            exit();
        }

        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            header("Location: login.php?error=email_exists");
            exit();
        }

        // Hash password and insert user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $insertStmt = $conn->prepare("INSERT INTO users (firstName, lastName, email, password, role) VALUES (?, ?, ?, ?, ?)");
        $insertStmt->bind_param("sssss", $firstName, $lastName, $email, $hashedPassword, $role);

        if ($insertStmt->execute()) {
            $userId = $conn->insert_id;
            $_SESSION['id'] = $userId;
            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName'] = $lastName;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $role;
            header("Location: homepage.php");
            exit();
        } else {
            header("Location: login.php?error=database_error");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premier League - Sign In</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="login.css">
</head>
<body>
<div class="container">
        <div class="form-box active" id="login-form"> 
            <div class="logo-header">
                <img src="assets/images/club/BPL.png" alt="Premier League Logo">
            </div>
            <form id="loginForm" method="POST" action="login.php">
                <h2>Login</h2>
                <?php if(isset($errorMessages[$error])): ?>
                    <div class="message error" style="display: block;">
                        <?= $errorMessages[$error] ?>
                    </div>
                <?php endif; ?>
                
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                
                <button type="submit" class="form-button" name="signIn">Sign In</button>
                
                <div class="or-divider">
                    <span>OR</span>
                </div>
                
                <div class="social-icons">
                    <div class="social-icon">
                        <i class="fab fa-google"></i>
                    </div>
                    <div class="social-icon">
                        <i class="fab fa-facebook-f"></i>
                    </div>
                </div>
                
                <p class="form-footer">
                    Don't have an account? <a href="#" onclick="showForm('register-form')">Sign Up</a>
                </p>
            </form>
        </div>

        <div class="form-box" id="register-form">
            <div class="logo-header">
                <img src="assets/images/club/BPL.png" alt="Premier League Logo">
            </div>
            <form id="registerForm" method="POST" action="login.php">
                <h2>Register</h2>
                <?php if(isset($errorMessages[$error])): ?>
                    <div class="message error" style="display: block;">
                        <?= $errorMessages[$error] ?>
                    </div>
                <?php endif; ?>
                
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="firstName" class="form-control" placeholder="First Name" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-user"></i>
                    <input type="text" name="lastName" class="form-control" placeholder="Last Name" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" class="form-control" placeholder="Email" required>
                </div>
                
                <div class="input-group">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" class="form-control" placeholder="Password" required minlength="6">
                </div>
                
                <div class="input-group">
                    <i class="fas fa-user-tag"></i>
                    <select name="role" class="form-control" required size="1">
                        <option value="" disabled selected>Select Role</option>
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                
                <button type="submit" class="form-button" name="signUp">Sign Up</button>
                
                <div class="or-divider">
                    <span>OR</span>
                </div>
                
                <div class="social-icons">
                    <div class="social-icon">
                        <i class="fab fa-google"></i>
                    </div>
                    <div class="social-icon">
                        <i class="fab fa-facebook-f"></i>
                    </div>
                </div>
                
                <p class="form-footer">
                    Already have an account? <a href="#" onclick="showForm('login-form')">Sign In</a>
                </p>
            </form>
        </div>
    </div>

    <script>
      function showForm(formId) {
    document.querySelectorAll('.form-box').forEach(form => {
        form.classList.remove('active');
    });
    document.getElementById(formId).classList.add('active');
    return false;
}

// Enhanced native dropdown behavior
document.addEventListener('DOMContentLoaded', function() {
    const roleSelect = document.querySelector('select[name="role"]');
    
    if(roleSelect) {
        // Ensure proper dropdown behavior
        roleSelect.addEventListener('focus', function() {
            this.size = 4; // Shows all options with some padding
        });
        
        roleSelect.addEventListener('blur', function() {
            this.size = 1;
        });
        
        roleSelect.addEventListener('change', function() {
            this.size = 1;
            this.blur();
        });
        
        // Prevent spacebar from scrolling page when select is focused
        roleSelect.addEventListener('keydown', function(e) {
            if(e.keyCode === 32) { // Spacebar
                e.preventDefault();
            }
        });
    }
});
    </script>
</body>
</html>