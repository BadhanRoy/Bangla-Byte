<?php
// Fetch all problems
$problems = $pdo->query("SELECT id, title FROM problems")->fetchAll();
?>

<div class="problem-list">
    <?php foreach ($problems as $problem): ?>
        <div class="problem-card">
            <div class="problem-header" onclick="toggleProblem(<?= $problem['id'] ?>)">
                <h3><?= htmlspecialchars($problem['title']) ?></h3>
            </div>
            
            <div class="problem-details" id="details-<?= $problem['id'] ?>" style="display:none">
                <div class="description">
                    <h4>Description</h4>
                    <p><?= nl2br(htmlspecialchars($problem['description'])) ?></p>
                </div>
                
                <div class="io-sample">
                    <h4>Sample Input</h4>
                    <pre><?= htmlspecialchars($problem['sample_input']) ?></pre>
                    
                    <h4>Sample Output</h4>
                    <pre><?= htmlspecialchars($problem['sample_output']) ?></pre>
                </div>
                
                <div class="submission-form">
                    <h4>Submit Solution</h4>
                    <form method="POST" action="submit.php">
                        <input type="hidden" name="problem_id" value="<?= $problem['id'] ?>">
                        <select name="language" class="form-select">
                           
                            <option value="python">Python</option>
                        </select>
                        <textarea name="code" class="form-control" rows="5"></textarea>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

<script>
function toggleProblem(id) {
    const details = document.getElementById(`details-${id}`);
    details.style.display = details.style.display === 'none' ? 'block' : 'none';
}
</script>