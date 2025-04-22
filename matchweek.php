<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Virtual Striker - Fixtures</title>
  <style>
    :root {
      --primary: #2C3E50;    /* Dark blue-gray */
      --secondary: #E74C3C;  /* Vibrant red */
      --accent: #3498DB;     /* Bright blue */
      --bg-dark: #1A1A2E;    /* Deep navy */
      --card-bg: #16213E;    /* Slightly lighter navy */
      --text-light: #ECF0F1; /* Soft white */
      --text-muted: #BDC3C7; /* Grayish text */
      --highlight: #F39C12;  /* Orange highlight */
      --success: #2ECC71;    /* Green for completed matches */
    }
    
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    
    body {
      background-color: var(--bg-dark);
      color: var(--text-light);
      font-family: 'Arial', sans-serif;
      line-height: 1.6;
      padding: 20px;
      background-image: 
        radial-gradient(circle at 25% 25%, rgba(44, 62, 80, 0.8) 0%, transparent 50%),
        radial-gradient(circle at 75% 75%, rgba(231, 76, 60, 0.6) 0%, transparent 50%);
    }
    
    .container {
      max-width: 900px;
      margin: 0 auto;
    }
    
    header {
      text-align: center;
      margin-bottom: 30px;
      padding: 20px 0;
      position: relative;
    }
    
    header::after {
      content: '';
      position: absolute;
      bottom: 0;
      left: 25%;
      width: 50%;
      height: 2px;
      background: linear-gradient(90deg, transparent, var(--accent), transparent);
    }
    
    .league-title {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 15px;
      margin-bottom: 10px;
    }
    
    .league-title img {
      height: 50px;
      filter: drop-shadow(0 0 5px rgba(52, 152, 219, 0.5));
    }
    
    h1 {
      font-size: 2.2rem;
      background: linear-gradient(to right, var(--accent), var(--secondary));
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      font-weight: 700;
      letter-spacing: 1px;
    }
    
    .date-range {
      color: var(--text-muted);
      font-size: 1rem;
      margin-bottom: 5px;
      font-weight: 300;
    }
    
    .matchday {
      background-color: var(--card-bg);
      border-radius: 12px;
      margin-bottom: 25px;
      overflow: hidden;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.3);
      border: 1px solid rgba(255, 255, 255, 0.05);
      transition: transform 0.3s ease;
    }
    
    .matchday:hover {
      transform: translateY(-3px);
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.4);
    }
    
    .matchday-header {
      background: linear-gradient(135deg, var(--primary), var(--bg-dark));
      padding: 14px 25px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }
    
    .matchday-date {
      font-size: 1.1rem;
      font-weight: 600;
      color: var(--text-light);
      letter-spacing: 0.5px;
    }
    
    .matchday-status {
      background-color: var(--secondary);
      color: white;
      padding: 4px 10px;
      border-radius: 20px;
      font-size: 0.8rem;
      font-weight: 600;
    }
    
    .matchday-matches {
      padding: 0 25px;
    }
    
    .match {
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 18px 0;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
      transition: background-color 0.3s ease;
    }
    
    .match:last-child {
      border-bottom: none;
    }
    
    .match:hover {
      background-color: rgba(255, 255, 255, 0.03);
    }
    
    .teams {
      flex: 1;
      display: flex;
      align-items: center;
      gap: 15px;
    }
    
    .team {
      display: flex;
      align-items: center;
      gap: 10px;
      width: 40%;
    }
    
    .home-team {
      justify-content: flex-end;
    }
    
    .away-team {
      justify-content: flex-start;
    }
    
    .team-logo {
      width: 28px;
      height: 28px;
      object-fit: contain;
      filter: drop-shadow(0 0 5px rgba(0, 0, 0, 0.3));
      transition: transform 0.3s ease;
    }
    
    .team:hover .team-logo {
      transform: scale(1.1);
    }
    
    .team-name {
      font-weight: 500;
      transition: color 0.3s ease;
    }
    
    .team:hover .team-name {
      color: var(--accent);
    }
    
    .match-time {
      background-color: rgba(52, 152, 219, 0.15);
      color: var(--highlight);
      padding: 8px 15px;
      border-radius: 20px;
      font-weight: 600;
      font-size: 0.9rem;
      min-width: 90px;
      text-align: center;
      border: 1px solid rgba(243, 156, 18, 0.2);
      transition: all 0.3s ease;
    }
    
    .match-time:hover {
      background-color: rgba(52, 152, 219, 0.25);
      transform: scale(1.05);
    }
    
    .match-vs {
      color: var(--text-muted);
      font-size: 0.8rem;
      margin: 0 10px;
      font-weight: 300;
    }
    
    .match-result {
      font-weight: 700;
      color: var(--highlight);
      margin: 0 10px;
    }
    
    /* Live match indicator */
    .live-indicator {
      display: none;
      width: 8px;
      height: 8px;
      background-color: #E74C3C;
      border-radius: 50%;
      margin-right: 5px;
      animation: pulse 1.5s infinite;
    }
    
    @keyframes pulse {
      0% { transform: scale(1); opacity: 1; }
      50% { transform: scale(1.3); opacity: 0.7; }
      100% { transform: scale(1); opacity: 1; }
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
      .match {
        flex-direction: column;
        gap: 12px;
        padding: 20px 0;
        text-align: center;
      }
      
      .teams {
        width: 100%;
        justify-content: center;
      }
      
      .team {
        width: auto;
        justify-content: center;
      }
      
      .home-team {
        order: 1;
      }
      
      .away-team {
        order: 3;
      }
      
      .match-vs {
        order: 2;
        margin: 5px 0;
      }
      
      .match-time {
        order: -1;
        margin-bottom: 10px;
      }
    }
  </style>
</head>
<body>
  <div class="container">
    <header>
      <div class="league-title">
        <img src="assets/images/club/BPL.png" alt="BPL">
        <h1>Bangladesh premier league</h1>
      </div>
      <div class="date-range">Matchweek 12 • Apr 26 - Apr 27</div>
    </header>

    <div class="matchday">
      <div class="matchday-header">
        <div class="matchday-date">Saturday, April 26</div>
        
      </div>
      <div class="matchday-matches">
        <div class="match">
          <div class="teams">
            <div class="team home-team">
              <span class="team-name">Abahani</span>
              <img src="assets/images/club/abahani.png" alt="" class="team-logo">
            </div>
            <span class="match-vs">vs</span>
            <div class="team away-team">
              <img src="assets/images/club/fakirapool.png" alt="" class="team-logo">
              <span class="team-name">Fakirapool</span>
            </div>
          </div>
          <div class="match-time"><span class="live-indicator"></span>5:00 PM</div>
        </div>
        
        <div class="match">
          <div class="teams">
            <div class="team home-team">
              <span class="team-name">Chittagong Abahani</span>
              <img src="assets/images/club/ctgabahani.png" alt="" class="team-logo">
            </div>
            <span class="match-vs">vs</span>
            <div class="team away-team">
              <img src="assets/images/club/brothers.png" alt="" class="team-logo">
              <span class="team-name">Brothers Union</span>
            </div>
          </div>
          <div class="match-time">7:00 PM</div>
        </div>
        
        <div class="match">
          <div class="teams">
            <div class="team home-team">
              <span class="team-name">Mohammedan SC</span>
              <img src="assets/images/club/mohamedan.png" alt="" class="team-logo">
            </div>
            <span class="match-result">2 - 1</span>
            <div class="team away-team">
              <img src="assets/images/club/kings.png" alt="Roma" class="team-logo">
              <span class="team-name">Bashundhara Kings</span>
            </div>
          </div>
          <div class="match-time" style="color: var(--success)">COMPLETED</div>
        </div>
      </div>
    </div>

    <div class="matchday">
      <div class="matchday-header">
        <div class="matchday-date">Sunday, April 27</div>
      </div>
      <div class="matchday-matches">
        <div class="match">
          <div class="teams">
            <div class="team home-team">
              <span class="team-name">Police FC</span>
              <img src="assets/images/club/police.png" alt="" class="team-logo">
            </div>
            <span class="match-vs">vs</span>
            <div class="team away-team">
              <img src="assets/images/club/rahmatgonj.png" alt="" class="team-logo">
              <span class="team-name">Rahmatgonj</span>
            </div>
          </div>
          <div class="match-time">3:00 PM</div>
        </div>
        
        <div class="match">
          <div class="teams">
            <div class="team home-team">
              <span class="team-name">Fortis FC</span>
              <img src="assets/images/club/fortis.png" alt="" class="team-logo">
            </div>
            <span class="match-vs">vs</span>
            <div class="team away-team">
              <img src="assets/images/club/dhaka wenders.png" alt="" class="team-logo">
              <span class="team-name">Dhaka Wenders</span>
            </div>
          </div>
          <div class="match-time">5:30 PM</div>
        </div>
      </div>
    </div>
  </div>
</body>
</html> 