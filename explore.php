<?php
session_start();
include 'connect.php';

// Redirect to login if not logged in
if(!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$firstName = $_SESSION['firstName'] ?? '';
$lastName = $_SESSION['lastName'] ?? '';
$email = $_SESSION['email'] ?? '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Coding Platform</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .dashboard-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        .profile-img {
            width: 100px;
            height: 100px;
            object-fit: cover;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="#">CodingPlatform</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="homepage.php"><i class="fas fa-home"></i> Home</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-trophy"></i> Contests</a></li>
                    <li class="nav-item"><a class="nav-link" href="#"><i class="fas fa-question-circle"></i> Problems</a></li>
                    <li class="nav-item"><a class="nav-link active" href="#"><i class="fas fa-user"></i> Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Dashboard Content -->
    <div class="container py-5">
        <div class="row">
            <!-- User Profile Section -->
            <div class="col-md-4 mb-4">
    <div class="card dashboard-card bg-white p-4 text-center">
        <div class="profile-img-container mx-auto mb-3" style="width: 100px; height: 100px;">
            <img src="<?php echo htmlspecialchars($user['profile_picture'] ?? 'https://via.placeholder.com/100'); ?>" 
                 class="profile-img rounded-circle" alt="Profile">
        </div>
        <h4><?php echo htmlspecialchars($firstName . ' ' . $lastName); ?></h4>
        <p class="text-muted"><?php echo htmlspecialchars($email); ?></p>
        
        <?php if (!empty($user['bio'])): ?>
            <p class="mb-3"><?php echo htmlspecialchars($user['bio']); ?></p>
        <?php endif; ?>
        
        <div class="d-flex justify-content-around mt-3">
            <div>
                <h5 class="mb-0">150</h5>
                <small>Solved</small>
            </div>
            <div>
                <h5 class="mb-0">25</h5>
                <small>Contests</small>
            </div>
        </div>
        
        <?php if (!empty($user['location'])): ?>
            <div class="mt-2">
                <i class="fas fa-map-marker-alt"></i> 
                <small><?php echo htmlspecialchars($user['location']); ?></small>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($user['website'])): ?>
            <div class="mt-2">
                <i class="fas fa-globe"></i> 
                <small><a href="<?php echo htmlspecialchars($user['website']); ?>" target="_blank">Website</a></small>
            </div>
        <?php endif; ?>
        
        <hr>
        <a href="edit_profile.php" class="btn btn-primary btn-sm">Edit Profile</a>
    </div>
</div>

            <!-- Stats & Quick Actions -->
            <div class="col-md-8">
                <div class="row">
                    <!-- Quick Stats -->
                    <div class="col-md-6 mb-4">
                        <div class="card dashboard-card bg-white p-4">
                            <h5><i class="fas fa-chart-line text-primary"></i> Your Stats</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Problems Solved</span>
                                    <span class="fw-bold">150</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Accuracy</span>
                                    <span class="fw-bold">85%</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Rank</span>
                                    <span class="fw-bold">#42</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="col-md-6 mb-4">
                        <div class="card dashboard-card bg-white p-4">
                            <h5><i class="fas fa-bolt text-warning"></i> Quick Actions</h5>
                            <div class="d-grid gap-2 mt-3">
                                <a href="add_problem.php" class="btn btn-outline-primary">
                                    <i class="fas fa-plus-circle"></i> Add Problem
                                </a>
                                <a href="#" class="btn btn-outline-success">
                                    <i class="fas fa-play"></i> Join Contest
                                </a>
                                <a href="#" class="btn btn-outline-info">
                                    <i class="fas fa-book"></i> Practice
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="col-12 mb-4">
                        <div class="card dashboard-card bg-white p-4">
                            <h5><i class="fas fa-history text-info"></i> Recent Activity</h5>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Problem</th>
                                            <th>Verdict</th>
                                            <th>Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td><a href="#">Two Sum</a></td>
                                            <td><span class="badge bg-success">Accepted</span></td>
                                            <td>2 hours ago</td>
                                        </tr>
                                        <tr>
                                            <td><a href="#">Binary Search</a></td>
                                            <td><span class="badge bg-danger">Wrong Answer</span></td>
                                            <td>1 day ago</td>
                                        </tr>
                                        <tr>
                                            <td><a href="#">Linked List</a></td>
                                            <td><span class="badge bg-success">Accepted</span></td>
                                            <td>3 days ago</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>