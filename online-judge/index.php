<?php
require_once 'connect.php';

// Fetch only published problems
$sql = "SELECT id, title FROM problems WHERE is_published = 1 ORDER BY id DESC";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}

$problems = $result->fetch_all(MYSQLI_ASSOC);

// Get problem counts
$total = $conn->query("SELECT COUNT(*) FROM problems")->fetch_row()[0];
$published = count($problems);
$unpublished = $total - $published;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problem List - Online Judge</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .status-badge {
            font-size: 0.8rem;
            vertical-align: middle;
        }
        .problem-card {
            border-left: 4px solid var(--bs-primary);
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Problem List</h1>
            <span class="badge bg-secondary status-badge">
                <?= $published ?> published (<?= $unpublished ?> unpublished)
            </span>
        </div>

        <?php if (empty($problems)): ?>
            <div class="alert alert-warning">
                No published problems available. 
                <?php if ($unpublished > 0): ?>
                    <span class="fst-italic">(<?= $unpublished ?> problems awaiting publication)</span>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="row g-4">
                <?php foreach ($problems as $problem): ?>
                <div class="col-md-6">
                    <div class="card problem-card h-100">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($problem['title']) ?></h5>
                            <a href="view_problem.php?id=<?= $problem['id'] ?>" class="btn btn-primary btn-sm">
                                Solve Problem
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if ($unpublished > 0): ?>
        <div class="alert alert-info mt-4">
            <strong>Admin Notice:</strong> There are <?= $unpublished ?> unpublished problems in the system.
            <a href="admin/publish.php" class="alert-link">Manage publication status</a>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>