<?php
$problem_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Validate problem ID
if ($problem_id <= 0) {
    die("Invalid problem ID");
}

// Problem titles
$problem_titles = [
    1 => "Sum of Two Numbers",
    2 => "Factorial Calculation",
    3 => "Checking Even Odd"
];

// Check if problem exists
if (!isset($problem_titles[$problem_id])) {
    die("Problem not found");
}

// Load problem data
$problem_dir = "problems/$problem_id/";
$description = file_exists($problem_dir . "desc.txt") ? file_get_contents($problem_dir . "desc.txt") : "No description available.";
$sample_input = file_exists($problem_dir . "input.txt") ? file_get_contents($problem_dir . "input.txt") : "No input available.";
$sample_output = file_exists($problem_dir . "output.txt") ? file_get_contents($problem_dir . "output.txt") : "No output available.";

$title = $problem_titles[$problem_id];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problem <?php echo $problem_id; ?></title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Problem <?php echo $problem_id; ?>: <?php echo htmlspecialchars($title); ?></h1>
            <a href="index.php" class="back-button">Back to Problems</a>
        </div>
        
        <div class="problem-section">
            <h3>Description</h3>
            <pre><?php echo htmlspecialchars($description); ?></pre>
            
            <h3>Sample Input</h3>
            <pre><?php echo htmlspecialchars($sample_input); ?></pre>
            
            <h3>Sample Output</h3>
            <pre><?php echo htmlspecialchars($sample_output); ?></pre>
        </div>
        
        <div class="submission-section">
            <h2>Submit Solution</h2>
            <form action="submit.php" method="POST">
                <input type="hidden" name="problem_id" value="<?php echo $problem_id; ?>">
                
                <div class="form-group">
                    <label for="language">Language:</label>
                    <select name="language" id="language" required>
                     
                        <option value="python">Python</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="code">Your Code:</label>
                    <textarea name="code" id="code" rows="10" required></textarea>
                </div>
                
                <button type="submit" class="submit-button">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>