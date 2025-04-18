<?php
session_start();
require_once __DIR__ . '/includes/functions.php';

if (!isLoggedIn()) {
    redirect('login.html');
}

$username = $_SESSION['username'];
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Premier League</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Your existing header -->
    <header>
        <?php include 'header.php'; ?>
    </header>

    <main class="dashboard-container">
        <h1>Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
        <p>You are logged in as: <?php echo htmlspecialchars($role); ?></p>
        
        <?php if ($role === 'admin'): ?>
            <div class="admin-panel">
                <h2>Admin Controls</h2>
                <ul>
                    <li><a href="manage_users.php">Manage Users</a></li>
                    <li><a href="edit_content.php">Edit Website Content</a></li>
                </ul>
            </div>
        <?php endif; ?>
        
        <div class="user-actions">
            <a href="logout.php" class="logout-btn">Logout</a>
        </div>
    </main>

    <!-- Your existing footer -->
    <footer>
        <?php include 'footer.php'; ?>
    </footer>
</body>
</html>