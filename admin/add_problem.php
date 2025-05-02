<?php
// Start session and database connection
session_start();
require_once __DIR__ . '/../connect.php'; // make sure connect.php is correct

// Initialize variables
$title = $description = $input_desc = $output_desc = $sample_input = $sample_output = '';
$success = $error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate and sanitize input
    $title = isset($_POST['title']) ? htmlspecialchars($_POST['title']) : '';
    $description = isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '';
    $input_desc = isset($_POST['input_description']) ? htmlspecialchars($_POST['input_description']) : '';
    $output_desc = isset($_POST['output_description']) ? htmlspecialchars($_POST['output_description']) : '';
    $sample_input = isset($_POST['sample_input']) ? htmlspecialchars($_POST['sample_input']) : '';
    $sample_output = isset($_POST['sample_output']) ? htmlspecialchars($_POST['sample_output']) : '';

    // Validate required fields
    if (empty($title) || empty($description) || empty($input_desc) || empty($output_desc)) {
        $error = "Please fill in all required fields!";
    } else {
        // Insert into database
        try {
            $stmt = $conn->prepare("INSERT INTO problems (title, description, input_description, output_description, sample_input, sample_output) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssssss", $title, $description, $input_desc, $output_desc, $sample_input, $sample_output);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                $success = "Problem added successfully!";
                // Clear form after successful submission
                $title = $description = $input_desc = $output_desc = $sample_input = $sample_output = '';
            } else {
                $error = "Failed to add problem. Please try again.";
            }

            $stmt->close(); // Always close statement
        } catch (mysqli_sql_exception $e) {
            $error = "Error adding problem: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Problem - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        .form-title {
            text-align: center;
            margin-bottom: 30px;
            color: #343a40;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="form-title">Add New Problem</h2>

            <?php if ($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="mb-3">
                    <label class="form-label">Problem Title*</label>
                    <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($title) ?>" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Description*</label>
                    <textarea name="description" class="form-control" rows="5" required><?= htmlspecialchars($description) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Input Description*</label>
                    <textarea name="input_description" class="form-control" rows="3" required><?= htmlspecialchars($input_desc) ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Output Description*</label>
                    <textarea name="output_description" class="form-control" rows="3" required><?= htmlspecialchars($output_desc) ?></textarea>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Sample Input</label>
                        <textarea name="sample_input" class="form-control" rows="3"><?= htmlspecialchars($sample_input) ?></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Sample Output</label>
                        <textarea name="sample_output" class="form-control" rows="3"><?= htmlspecialchars($sample_output) ?></textarea>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Add Problem</button>
                <a href="../admin_dashboard.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
