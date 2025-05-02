<?php
session_start();
include 'connect.php';

// Redirect to login if not logged in or if admin tries to access
if(!isset($_SESSION['id']) || $_SESSION['role'] === 'admin') {
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
    <title>User Dashboard - Virtual Striker</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
       
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("assets/images/club/backimg.webp");
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
            text-align: center;
        }

        .welcome-box {
            background: rgba(0, 0, 0, 0.8);
            padding: 40px;
            border-radius: 15px;
            margin: 50px auto;
            max-width: 800px;
            border: 2px solid #e0001a;
            top: 100px;
        }

        .welcome-title {
            font-size: 2.5rem;
            color: #fff;
            margin-bottom: 20px;
        }

        .user-name {
            color: #e0001a;
            font-weight: bold;
        }

        .btn-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-block;
            background: #e0001a;
            color: white;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .btn:hover {
            background: #c00018;
            transform: translateY(-3px);
        }

        @media (max-width: 768px) {
            .welcome-title {
                font-size: 1.8rem;
            }
            .btn-container {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="dashboard-container">
        <div class="welcome-box">
            <h1 class="welcome-title">
                Welcome User, <span class="user-name"><?php echo htmlspecialchars($firstName . ' ' . $lastName); ?></span>!
            </h1>
            <p>You have successfully logged in to Bangla Byte a regular user</p>
            
            <div class="btn-container">
            <div class="d-grid gap-2 mt-3">
    <!-- ... other buttons ... -->
    <a href="explore.php" class="btn btn-outline-secondary">
        <i class="fas fa-compass"></i> Explore More
    </a>
</div>
                <a href="logout.php" class="btn">Logout</a>
            </div>
        </div>
    </div>
</body>
</html>

