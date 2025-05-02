<?php
require_once 'connect.php';

// Validate problem ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$problemId = (int)$_GET['id'];

// Fetch problem details
$stmt = $conn->prepare("SELECT * FROM problems WHERE id = ? AND is_published = 1");
$stmt->bind_param("i", $problemId);
$stmt->execute();
$result = $stmt->get_result();
$problem = $result->fetch_assoc();

if (!$problem) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($problem['title']) ?> - Online Judge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .problem-section {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        pre {
            background: #e9ecef;
            padding: 15px;
            border-radius: 5px;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <a href="index.php" class="btn btn-secondary mb-3">← Back to Problems</a>
        
        <h1 class="mb-4"><?= htmlspecialchars($problem['title']) ?></h1>
        
        <div class="problem-section">
            <h3>Description</h3>
            <div><?= nl2br(htmlspecialchars($problem['description'])) ?></div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="problem-section">
                    <h3>Input Format</h3>
                    <div><?= nl2br(htmlspecialchars($problem['input_description'])) ?></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="problem-section">
                    <h3>Output Format</h3>
                    <div><?= nl2br(htmlspecialchars($problem['output_description'])) ?></div>
                </div>
            </div>
        </div>
        
        <div class="row mt-3">
            <div class="col-md-6">
                <div class="problem-section">
                    <h3>Sample Input</h3>
                    <pre><?= htmlspecialchars($problem['sample_input']) ?></pre>
                </div>
            </div>
            <div class="col-md-6">
                <div class="problem-section">
                    <h3>Sample Output</h3>
                    <pre><?= htmlspecialchars($problem['sample_output']) ?></pre>
                </div>
            </div>
        </div>
        
        <div class="problem-section mt-4">
            <h3>Submit Your Solution (Python)</h3>
            <form action="submit.php" method="POST">
                <input type="hidden" name="problem_id" value="<?= $problem['id'] ?>">
                
                <div class="mb-3">
                    <label class="form-label">Python Code</label>
                    <textarea name="code" class="form-control" rows="10" required></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</body>
</html>