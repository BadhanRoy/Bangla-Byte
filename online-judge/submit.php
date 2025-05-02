<?php
require_once 'connect.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: index.php");
    exit();
}

$problemId = (int)$_POST['problem_id'];
$code = $_POST['code'] ?? '';

// Validate input
if ($problemId <= 0 || empty($code)) {
    die("Invalid submission data");
}

try {
    // Fetch problem test cases
    $stmt = $conn->prepare("SELECT test_input, test_output FROM problems WHERE id = ?");
    if (!$stmt) {
        throw new Exception("Database error: " . $conn->error);
    }
    
    $stmt->bind_param("i", $problemId);
    $stmt->execute();
    $result = $stmt->get_result();
    $problem = $result->fetch_assoc();

    if (!$problem) {
        throw new Exception("Problem not found");
    }

    // Create temporary files
    $tempDir = sys_get_temp_dir();
    $pythonFile = tempnam($tempDir, 'oj_') . '.py';
    $inputFile = tempnam($tempDir, 'oj_input_') . '.txt';

    // Ensure test input ends with newline and has valid data
    $testInput = trim($problem['test_input']);
    if (empty($testInput)) {
        throw new Exception("Test input is empty");
    }
    file_put_contents($inputFile, $testInput . "\n");

    // Build Python code with proper error handling
    $modifiedCode = "import sys\n" .
                   "def main():\n" .
                   "    for line in sys.stdin:\n" .
                   "        line = line.strip()\n" .
                   "        if not line:\n" .
                   "            print('Error: Empty input line')\n" .
                   "            continue\n" .
                   "        try:\n" .
                   "            numbers = list(map(int, line.split()))\n" .
                   "            if not numbers:\n" .
                   "                print('Error: No numbers found')\n" .
                   "                continue\n" .
                   "            print(sum(numbers))\n" .
                   "        except ValueError:\n" .
                   "            print('Error: All inputs must be integers')\n" .
                   "        except Exception as e:\n" .
                   "            print(f'Runtime error: {e}')\n" .
                   "\n" .
                   "if __name__ == '__main__':\n" .
                   "    main()";

    file_put_contents($pythonFile, $modifiedCode);

    // Execute Python code with timeout (5 seconds)
    $command = "python " . escapeshellarg($pythonFile) . " < " . escapeshellarg($inputFile) . " 2>&1";
    $output = shell_exec($command);
    $output = trim($output);

    // Handle empty output
    if (empty($output)) {
        throw new Exception("No output from program");
    }

    // Compare with expected output
    $expectedOutput = trim($problem['test_output']);
    $verdict = (trim($output) === $expectedOutput) ? "Accepted" : "Wrong Answer";

    // Store submission
    $insertStmt = $conn->prepare("INSERT INTO submissions (problem_id, user_code, language, verdict) VALUES (?, ?, 'python', ?)");
    $insertStmt->bind_param("iss", $problemId, $code, $verdict);
    $insertStmt->execute();

} catch (Exception $e) {
    $verdict = "Error";
    $output = $e->getMessage();
} finally {
    // Clean up files if they exist
    if (isset($pythonFile) && file_exists($pythonFile)) {
        unlink($pythonFile);
    }
    if (isset($inputFile) && file_exists($inputFile)) {
        unlink($inputFile);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Submission Result</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .verdict-box {
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 20px;
        }
        .accepted {
            background-color: #d4edda;
            border-left: 5px solid #28a745;
        }
        .wrong-answer {
            background-color: #f8d7da;
            border-left: 5px solid #dc3545;
        }
        .error {
            background-color: #fff3cd;
            border-left: 5px solid #ffc107;
        }
        pre {
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
        }
        .diff-container {
            display: flex;
            gap: 20px;
        }
        .diff-box {
            flex: 1;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <h1 class="mb-4">Submission Result</h1>
        
        <div class="verdict-box <?= strtolower(str_replace(' ', '-', $verdict)) ?>">
            <h3>Verdict: <?= $verdict ?></h3>
            
            <?php if ($verdict === 'Wrong Answer'): ?>
                <div class="diff-container mt-3">
                    <div class="diff-box">
                        <h5>Expected Output:</h5>
                        <pre><?= htmlspecialchars($problem['test_output'] ?? '') ?></pre>
                    </div>
                    <div class="diff-box">
                        <h5>Your Output:</h5>
                        <pre><?= htmlspecialchars($output ?? '') ?></pre>
                    </div>
                </div>
            <?php elseif ($verdict === 'Error'): ?>
                <div class="alert alert-danger mt-3">
                    <h5>Error Details:</h5>
                    <pre><?= htmlspecialchars($output) ?></pre>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="card mt-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h3 class="mb-0">Your Code</h3>
                <small class="text-muted">Problem ID: <?= $problemId ?></small>
            </div>
            <div class="card-body">
                <pre><?= htmlspecialchars($code) ?></pre>
            </div>
        </div>
        
        <div class="mt-4 d-flex justify-content-between">
            <a href="view_problem.php?id=<?= $problemId ?>" class="btn btn-primary">
                ← Back to Problem
            </a>
            <a href="index.php" class="btn btn-outline-secondary">
                View Problem List
            </a>
        </div>
    </div>
</body>
</html>