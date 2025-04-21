<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premier League Matchweek 33</title>
    <style>
        :root {
            --primary: #38003c; 
            --secondary: #00ff85; 
            --text: #333;
            --light-bg: #f8f9fa;
            --border: #e0e0e0;
        }
        
        body {
            font-family: 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--text);
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: var(--light-bg);
        }
        
        header {
            border-bottom: 3px solid var(--primary);
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        
        h1 {
            color: var(--primary);
            margin: 0;
        }
        
        .time-note {
            font-size: 0.9rem;
            color: #666;
            margin: 5px 0 20px;
        }
        
        .matchday {
            margin-bottom: 40px;
        }
        
        .matchday-header {
            font-weight: bold;
            margin-bottom: 15px;
            color: var(--primary);
        }
        
        .matches {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 15px;
        }
        
        .match {
            background: white;
            padding: 15px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .teams {
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .highlight {
            color: var(--secondary);
            font-size: 0.9rem;
        }
        
        .news-section {
            margin-top: 40px;
        }
        
        .news-section h2 {
            color: var(--primary);
            border-bottom: 2px solid var(--border);
            padding-bottom: 5px;
        }
        
        .news-item {
            background: white;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        
        .news-item h3 {
            margin-top: 0;
            color: var(--primary);
        }
        
        @media (max-width: 768px) {
            .matches {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <header>
        <h1>Matchweek 33</h1>
        <div class="time-note">All times shown are your local time</div>
    </header>
    
    <section class="matchday">
        <div class="matchday-header">Saturday 19 April</div>
        <div class="matches">
            <div class="match">
                <div class="teams">BRE vs BHA</div>
                <div class="highlight">Highlight Available</div>
            </div>
            <div class="match">
                <div class="teams">CRY vs DOU</div>
                <div class="highlight">Highlight Available</div>
            </div>
            <div class="match">
                <div class="teams">EVE vs HCI</div>
                <div class="highlight">Highlight Available</div>
            </div>
            <div class="match">
                <div class="teams">WHU vs SOU</div>
                <div class="highlight">Highlight Available</div>
            </div>
            <div class="match">
                <div class="teams">AVL vs NEW</div>
                <div class="highlight">Highlight Available</div>
            </div>
        </div>
    </section>
    
    <section class="matchday">
        <div class="matchday-header">Sunday 20 April</div>
        <div class="matches">
            <div class="match">
                <div class="teams">FUL vs CHE</div>
            </div>
            <div class="match">
                <div class="teams">IPS vs ARS</div>
            </div>
        </div>
    </section>
    
    <section class="news-section">
        <h2>News</h2>
        <div class="news-item">
            <h3>Trent Moments like this will live with me for ever</h3>
            <p>Alexander-Arnold savours celebrations with away fans after his goal takes Liverpool 'very close' to title.</p>
        </div>
        
        <div class="news-item">
            <h3>Arteta: We performed better against Ipswich than in beating Madrid</h3>
            <p>Manager reflects on recent performances as Arsenal push for European success.</p>
        </div>
    </section>
</body>
</html>