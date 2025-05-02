<?php
session_start();
include '../connect.php';

// Redirect to game if already logged in
if (isset($_SESSION['id'])) {
    header("Location: coding_game.php");
    exit();
}

$error = '';
$success = '';

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT id, firstName, lastName, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['id'] = $user['id'];
                $_SESSION['firstName'] = $user['firstName'];
                $_SESSION['lastName'] = $user['lastName'];
                header("Location: coding_game.php");
                exit();
            } else {
                $error = "Invalid email or password";
            }
        } else {
            $error = "Invalid email or password";
        }
    } else {
        $error = "Please fill in all fields";
    }
}

// Handle registration
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])) {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);
    
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password)) {
        $error = "Please fill in all fields";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters";
    } else {
        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        
        if ($stmt->get_result()->num_rows > 0) {
            $error = "Email already registered";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (firstName, lastName, email, password) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $firstName, $lastName, $email, $hashedPassword);
            
            if ($stmt->execute()) {
                $success = "Registration successful! Please login";
            } else {
                $error = "Registration failed. Please try again";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Python Coding Battle - 1v1 Challenge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            background-image: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .auth-container {
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }
        .auth-card {
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .auth-header {
            background-color: #4a6baf;
            color: white;
            padding: 20px;
            text-align: center;
        }
        .auth-body {
            padding: 30px;
            background-color: white;
        }
        .auth-tabs {
            border-bottom: none;
            margin-bottom: 20px;
        }
        .auth-tabs .nav-link {
            border: none;
            color: #6c757d;
            font-weight: 600;
            padding: 12px 25px;
        }
        .auth-tabs .nav-link.active {
            color: #4a6baf;
            background-color: transparent;
            border-bottom: 3px solid #4a6baf;
        }
        .btn-primary {
            background-color: #4a6baf;
            border-color: #4a6baf;
        }
        .hero-section {
            text-align: center;
            padding: 60px 0;
            background-color: rgba(255,255,255,0.8);
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
        }
        .feature-icon {
            font-size: 2.5rem;
            color: #4a6baf;
            margin-bottom: 15px;
        }
        .feature-card {
            padding: 20px;
            border-radius: 10px;
            background-color: white;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            height: 100%;
            transition: transform 0.3s;
        }
        .feature-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <!-- Hero Section -->
        <div class="hero-section">
            <h1 class="display-4 mb-4">Python Coding Battle</h1>
            <p class="lead mb-4">Challenge your friends to a 1v1 Python coding duel. Fastest correct solution wins!</p>
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="auth-card">
                        <div class="auth-header">
                            <h3>Join the Battle</h3>
                        </div>
                        <div class="auth-body">
                            <ul class="nav nav-tabs auth-tabs" id="authTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">Login</button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">Register</button>
                                </li>
                            </ul>
                            
                            <?php if (!empty($error)): ?>
                                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
                            <?php endif; ?>
                            
                            <?php if (!empty($success)): ?>
                                <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
                            <?php endif; ?>
                            
                            <div class="tab-content" id="authTabsContent">
                                <div class="tab-pane fade show active" id="login" role="tabpanel">
                                    <form method="POST">
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" required>
                                        </div>
                                        <div class="d-grid">
                                            <button type="submit" name="login" class="btn btn-primary">Login</button>
                                        </div>
                                    </form>
                                </div>
                                
                                <div class="tab-pane fade" id="register" role="tabpanel">
                                    <form method="POST">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="firstName" class="form-label">First Name</label>
                                                <input type="text" class="form-control" id="firstName" name="firstName" required>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="lastName" class="form-label">Last Name</label>
                                                <input type="text" class="form-control" id="lastName" name="lastName" required>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Password (min 6 characters)</label>
                                            <input type="password" class="form-control" id="password" name="password" required minlength="6">
                                        </div>
                                        <div class="mb-3">
                                            <label for="confirmPassword" class="form-label">Confirm Password</label>
                                            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                                        </div>
                                        <div class="d-grid">
                                            <button type="submit" name="register" class="btn btn-primary">Register</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Features Section -->
        <h2 class="text-center mb-4">How It Works</h2>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="text-center">
                        <div class="feature-icon">
                            <i class="fas fa-user-plus"></i>
                        </div>
                        <h4>1. Create or Join</h4>
                        <p>Create a battle room or join an existing one with a room code.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="text-center">
                        <div class="feature-icon">
                            <i class="fas fa-code"></i>
                        </div>
                        <h4>2. Solve the Problem</h4>
                        <p>When both players are ready, a random Python problem appears.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="text-center">
                        <div class="feature-icon">
                            <i class="fas fa-trophy"></i>
                        </div>
                        <h4>3. Win the Battle</h4>
                        <p>First player to submit a correct solution wins!</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Switch to register tab if there was a registration error
        <?php if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['register'])): ?>
            const registerTab = new bootstrap.Tab(document.getElementById('register-tab'));
            registerTab.show();
        <?php endif; ?>
    </script>
</body>
</html>