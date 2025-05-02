<?php
require_once '../connect.php';

// Fetch all problems
$problems = $conn->query("SELECT id, title, is_published FROM problems ORDER BY id")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Publish Problems</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Publish Problems</h1>
        <form method="post">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Publish</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($problems as $problem): ?>
                    <tr>
                        <td><?= $problem['id'] ?></td>
                        <td><?= htmlspecialchars($problem['title']) ?></td>
                        <td>
                            <input type="checkbox" name="publish[]" value="<?= $problem['id'] ?>" 
                                <?= $problem['is_published'] ? 'checked' : '' ?>>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // First unpublish all
            $conn->query("UPDATE problems SET is_published = 0");
            
            // Publish selected ones
            if (!empty($_POST['publish'])) {
                $ids = implode(",", array_map('intval', $_POST['publish']));
                $conn->query("UPDATE problems SET is_published = 1 WHERE id IN ($ids)");
                echo "<div class='alert alert-success mt-3'>Published status updated!</div>";
            }
        }
        ?>
    </div>
</body>
</html>