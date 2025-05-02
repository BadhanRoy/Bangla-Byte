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
$conn->set_charset("utf8mb4");

// Modified query - removed is_published
$problems = [];
$sql = "SELECT id, title FROM problems ORDER BY id DESC";

$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $problems = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Problem Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <?php if (empty($problems)): ?>
            <div class="alert alert-warning">No problems found</div>
        <?php else: ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($problems as $problem): ?>
                    <tr>
                        <td><?= htmlspecialchars($problem['id']) ?></td>
                        <td><?= htmlspecialchars($problem['title']) ?></td>
                        <td>
                            <a href="view.php?id=<?= $problem['id'] ?>" class="btn btn-sm btn-primary">View</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>

<?php $conn->close(); ?>