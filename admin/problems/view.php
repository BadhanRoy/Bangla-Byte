<?php
// Database Configuration
$host = "localhost";
$user = "root";
$pass = "";
$db = "login";
$port = 3306;

// Establish Connection
$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate Problem ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$problemId = (int)$_GET['id'];

// Fetch Problem
$stmt = $conn->prepare("SELECT * FROM problems WHERE id = ?");
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
    <title><?= htmlspecialchars($problem['title']) ?></title>
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
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <a href="index.php" class="btn btn-secondary mb-3">← Back to Problems</a>
        
        <h1 class="mb-4"><?= htmlspecialchars($problem['title']) ?></h1>
        
        <div class="problem-section">
            <h3>Description</h3>
            <p><?= nl2br(htmlspecialchars($problem['description'])) ?></p>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="problem-section">
                    <h3>Input</h3>
                    <p><?= nl2br(htmlspecialchars($problem['input_description'])) ?></p>
                </div>
            </div>
            <div class="col-md-6">
                <div class="problem-section">
                    <h3>Output</h3>
                    <p><?= nl2br(htmlspecialchars($problem['output_description'])) ?></p>
                </div>
            </div>
        </div>
        
        <div class="row mt-4">
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
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>