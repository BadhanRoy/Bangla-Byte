<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Virtual Striker | Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #2C3E50;
            --secondary: #E74C3C;
            --accent: #3498DB;
            --bg-dark: #1A1A2E;
            --card-bg: #16213E;
            --text-light: #ECF0F1;
            --text-muted: #AAAAAA;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            background-color: var(--bg-dark);
            color: var(--text-light);
        }
        
        .navbar {
            background-color: var(--primary);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }
        
        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .logo img {
            height: 40px;
        }
        
        .nav-links {
            display: flex;
            gap: 20px;
        }
        
        .nav-links a {
            color: var(--text-light);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }
        
        .nav-links a:hover {
            color: var(--secondary);
        }
        
        .user-profile {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--accent);
        }
        
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }
        
        .welcome-banner {
            background: linear-gradient(135deg, var(--primary), var(--accent));
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .welcome-text h1 {
            font-size: 2rem;
            margin-bottom: 10px;
        }
        
        .welcome-text p {
            opacity: 0.9;
        }
        
        .quick-stats {
            display: flex;
            gap: 20px;
        }
        
        .stat-box {
            background-color: rgba(255,255,255,0.1);
            padding: 15px 20px;
            border-radius: 8px;
            text-align: center;
            min-width: 120px;
        }
        
        .stat-box .number {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--secondary);
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }
        
        .dashboard-card {
            background-color: var(--card-bg);
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transition: transform 0.3s ease;
        }
        
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            padding: 15px 20px;
            background-color: var(--primary);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .card-header h3 {
            font-size: 1.2rem;
        }
        
        .card-header .icon {
            color: var(--accent);
            font-size: 1.2rem;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .match-list {
            list-style: none;
        }
        
        .match-item {
            padding: 10px 0;
            border-bottom: 1px dashed rgba(255,255,255,0.1);
            display: flex;
            justify-content: space-between;
        }
        
        .match-item:last-child {
            border-bottom: none;
        }


        select option {
             background-color: var(--card-bg);
            color: var(--text-light);
            padding: 8px 12px;
        }

        select:focus {
            outline: none;
            border-color: var(--accent);
        }
        
        .team {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .team-logo {
            width: 20px;
            height: 20px;
        }
        
        .btn {
            display: inline-block;
            background-color: var(--accent);
            color: white;
            padding: 8px 15px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn:hover {
            background-color: #2980b9;
            transform: translateY(-2px);
        }
        
        .btn-secondary {
            background-color: var(--primary);
        }
        
        .btn-secondary:hover {
            background-color: #1E2A38;
        }
        
        .prediction-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        
        .form-group label {
            font-weight: 500;
        }
        
        .form-group select, .form-group input {
            padding: 8px 12px;
            border-radius: 5px;
            border: 1px solid rgba(255,255,255,0.2);
            background-color: rgba(255,255,255,0.1);
            color: white;
        }
        
        @media (max-width: 768px) {
            .navbar {
                flex-direction: column;
                gap: 15px;
                padding: 15px;
            }
            
            .welcome-banner {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
            
            .quick-stats {
                flex-wrap: wrap;
                justify-content: center;
            }
            
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <a href="#" class="logo">
            <img src="assets/images/club/BPL.png" alt="Virtual Striker Logo">
            <span>BPL</span>
        </a>
        
        <div class="nav-links">
            <a href="dashboard.html"><i class="fas fa-home"></i> Dashboard</a>
            <a href="#"><i class="fas fa-trophy"></i> Leagues</a>
            <a href="#"><i class="fas fa-users"></i> My Teams</a>
            <a href="#"><i class="fas fa-chart-line"></i> Predictions</a>
            <a href="#"><i class="fas fa-cog"></i> Settings</a>
        </div>
        
        <div class="user-profile">
            <img src="" alt="User Avatar" class="user-avatar">
            <span></span>
            <a href="logout.php" style="margin-left: 15px;"><i class="fas fa-sign-out-alt"></i></a>
        </div>
    </nav>
    
    <!-- Main Content -->
    <div class="container">
        <!-- Welcome Banner -->
        <div class="welcome-banner">
            <div class="welcome-text">
                <h1>Welcome back</h1>
                <p>Your latest football stats and predictions at a glance</p>
            </div>
            
            <div class="quick-stats">
                <div class="stat-box">
                    <div class="number">24</div>
                    <div>Predictions</div>
                </div>
                <div class="stat-box">
                    <div class="number">18</div>
                    <div>Correct</div>
                </div>
                <div class="stat-box">
                    <div class="number">75%</div>
                    <div>Accuracy</div>
                </div>
            </div>
        </div>
        
        <!-- Dashboard Grid -->
        <div class="dashboard-grid">
            <!-- Upcoming Matches Card -->
            <div class="dashboard-card">
            <div class="card-header">
                <h3><i class="fas fa-calendar-alt icon"></i> Upcoming Matches</h3>
                <a href="matchweek.html" class="btn btn-secondary">View All</a>
            </div>
                <div class="card-body">
                    <ul class="match-list">
                        <li class="match-item">
                            <div class="team">
                                <img src="https://via.placeholder.com/20" alt="Team Logo" class="team-logo">
                                <span>Bashundhara Kings</span>
                            </div>
                            <span>vs</span>
                            <div class="team">
                                <img src="https://via.placeholder.com/20" alt="Team Logo" class="team-logo">
                                <span>Abahani Ltd</span>
                            </div>
                            <span>Tomorrow, 4:30 PM</span>
                        </li>
                        <li class="match-item">
                            <div class="team">
                                <img src="https://via.placeholder.com/20" alt="Team Logo" class="team-logo">
                                <span>Mohammedan SC</span>
                            </div>
                            <span>vs</span>
                            <div class="team">
                                <img src="https://via.placeholder.com/20" alt="Team Logo" class="team-logo">
                                <span>Sheikh Russel</span>
                            </div>
                            <span>Jun 25, 7:00 PM</span>
                        </li>
                        <li class="match-item">
                            <div class="team">
                                <img src="https://via.placeholder.com/20" alt="Team Logo" class="team-logo">
                                <span>Dhaka Abahani</span>
                            </div>
                            <span>vs</span>
                            <div class="team">
                                <img src="https://via.placeholder.com/20" alt="Team Logo" class="team-logo">
                                <span>Rahmatganj</span>
                            </div>
                            <span>Jun 28, 4:30 PM</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Make Prediction Card -->
 <!-- Make Prediction Card -->
<div class="dashboard-card">
    <div class="card-header">
        <h3><i class="fas fa-bullseye icon"></i> Make a Prediction</h3>
    </div>
    <div class="card-body">
        <form class="prediction-form">
            <div class="form-group">
                <label for="match">Select Match:</label>
                <select id="match" name="match" required>
                    <option value="" disabled selected>Select a match</option>
                    <option value="match1">Bashundhara Kings vs Abahani Ltd</option>
                    <option value="match2">Mohammedan SC vs Sheikh Russel</option>
                    <option value="match3">Dhaka Abahani vs Rahmatganj</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="prediction">Your Prediction:</label>
                <select id="prediction" name="prediction" required>
                    <option value="" disabled selected>Select prediction</option>
                    <option value="home">Home Win</option>
                    <option value="draw">Draw</option>
                    <option value="away">Away Win</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="score">Predicted Score:</label>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <input type="number" id="home-score" name="home-score" min="0" max="10" style="width: 50px;">
                    <span>:</span>
                    <input type="number" id="away-score" name="away-score" min="0" max="10" style="width: 50px;">
                </div>
            </div>
            
            <button type="submit" class="btn">Submit Prediction</button>
        </form>
    </div>
</div>

            <!-- Recent Activity Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3><i class="fas fa-history icon"></i> Recent Activity</h3>
                </div>
                <div class="card-body">
                    <ul class="match-list">
                        <li class="match-item">
                            <span>Predicted Bashundhara Kings to win</span>
                            <span>2 days ago</span>
                        </li>
                        <li class="match-item">
                            <span>Correctly predicted Mohammedan SC vs Abahani</span>
                            <span>5 days ago</span>
                        </li>
                        <li class="match-item">
                            <span>Joined "BPL Experts" league</span>
                            <span>1 week ago</span>
                        </li>
                        <li class="match-item">
                            <span>Reached 75% prediction accuracy</span>
                            <span>2 weeks ago</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <!-- Leaderboard Card -->
            <div class="dashboard-card">
                <div class="card-header">
                    <h3><i class="fas fa-medal icon"></i> Your Leagues</h3>
                    <a href="#" class="btn btn-secondary">Join League</a>
                </div>
                <div class="card-body">
                    <ul class="match-list">
                        <li class="match-item" style="font-weight: 600;">
                            <span>League</span>
                            <span>Position</span>
                        </li>
                        <li class="match-item">
                            <span>BPL Experts</span>
                            <span>3rd</span>
                        </li>
                        <li class="match-item">
                            <span>Dhaka Predictors</span>
                            <span>7th</span>
                        </li>
                        <li class="match-item">
                            <span>Fantasy Kings</span>
                            <span>12th</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>