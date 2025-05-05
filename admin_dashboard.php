<?php
session_start();
include 'connect.php';

// Redirect to login if not logged in or not admin
if(!isset($_SESSION['id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

$firstName = $_SESSION['firstName'] ?? '';
$lastName = $_SESSION['lastName'] ?? '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Virtual Striker</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("assets/images/club/stadium/kings.jpg");
            background-size: cover;
            background-position: center;
            color: white;
            min-height: 100vh;
            position: relative;
        }
        
        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            z-index: 0;
        }

        .dashboard-container {
            position: relative;
            z-index: 1;
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }

        .admin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .welcome-box {
            background: rgba(0, 0, 0, 0.8);
            padding: 40px;
            border-radius: 15px;
            margin-bottom: 30px;
            border: 2px solid green;
        }

        .welcome-title {
            font-size: 2.5rem;
            color: #fff;
            margin-bottom: 20px;
        }

        .user-name {
            color: green;
            font-weight: bold;
        }

        .admin-panel {
            background: rgba(0, 0, 0, 0.8);
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            border: 2px solid #0a2240;
        }

        .panel-title {
            font-size: 1.8rem;
            color: #fff;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .admin-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .admin-card {
            background: rgba(10, 34, 64, 0.7);
            padding: 20px;
            border-radius: 10px;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .admin-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
        }

        .card-title {
            font-size: 1.2rem;
            margin-bottom: 15px;
            
        }

        .card-desc {
            margin-bottom: 15px;
            color: rgba(255, 255, 255, 0.8);
        }

        .btn {
            display: inline-block;
            background: green;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn:hover {
           
            transform: translateY(-2px);
        }

        .btn-secondary {
            background: green;
        }

        .btn-secondary:hover {
            background: #081b38;
        }

        @media (max-width: 768px) {
            .welcome-title {
                font-size: 1.8rem;
            }
            
            .admin-header {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="admin-header">
            <div class="welcome-box">
                <h1 class="welcome-title">
                    Welcome Admin, <span class="user-name"><?php echo htmlspecialchars($firstName . ' ' . $lastName); ?></span>!
                </h1>
                <p>You have full administrative privileges</p>
            </div>
            <a href="logout.php" class="btn">Logout</a>
        </div>

        <div class="admin-panel">
            <h2 class="panel-title">Administration Panel</h2>
            
            <div class="admin-actions">
                <div class="admin-card">
                    <h3 class="card-title">Set problems</h3>
                    <p class="card-desc">View, edit, and manage all problems.</p>
                    <a href="admin/add_problem.php" class="btn">Manage problems</a>
                </div>
                
                <div class="admin-card">
                    <h3 class="card-title">Watch all problems</h3>
                    <p class="card-desc">Control all website content, including news and updates.</p>
                    <a href="admin/problems/index.php" class="btn">Manage Content</a>
                </div>
                
                <div class="admin-card">
                    <h3 class="card-title">Contests</h3>
                    <p class="card-desc">Configure system-wide settings and preferences.</p>
                    <a href="contest/problem.php" class="btn btn-secondary">contest</a>
                </div>
                
                <div class="admin-card">
                    <h3 class="card-title">Reports</h3>
                    <p class="card-desc">View system reports and analytics.</p>
                    <a href="reports.php" class="btn btn-secondary">View Reports</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>