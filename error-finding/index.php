<?php
include 'problems.php';
$current_problem = getCurrentProblem();
?>
<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>বাংলা বাইট - পাইথন MCQ</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>বাংলা বাইট - পাইথন কোড ত্রুটি MCQ</h1>
            <div class="timer" id="timer">পরবর্তী সমস্যা: ২০:০০</div>
        </header>
        
        <div class="problem-container">
            <h2 id="problem-title"><?php echo $current_problem['title']; ?></h2>
            <p id="problem-desc"><?php echo $current_problem['description']; ?></p>
            
            <div class="code-block">
                <div class="code-header">
                    <span>Python</span>
                </div>
                <pre id="problem-code"><?php echo htmlspecialchars($current_problem['code']); ?></pre>
            </div>
            
            <form id="quiz-form">
                <?php foreach($current_problem['options'] as $key => $option): ?>
                    <div class="option">
                        <input type="radio" id="option<?php echo $key; ?>" name="answer" value="<?php echo $key[0]; ?>">
                        <label for="option<?php echo $key; ?>"><?php echo $option; ?></label>
                    </div>
                <?php endforeach; ?>
                
                <button type="button" id="submit-answer">জমা দিন</button>
            </form>
            
            <div class="solution" id="solution" style="display:none;">
                <h3>ব্যাখ্যা:</h3>
                <p id="explanation"><?php echo $current_problem['explanation']; ?></p>
                <p id="correct-answer">সঠিক উত্তর: <?php echo $current_problem['correct']; ?></p>
            </div>
        </div>
        
        <div class="controls">
            <button id="next-problem">পরবর্তী সমস্যা</button>
        </div>
    </div>

    <script src="script.js"></script>
</body>
</html>