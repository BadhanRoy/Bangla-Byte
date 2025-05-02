<?php
session_start();
require_once '../connect.php';
require_once 'compiler.php';

if (!isset($_SESSION['id']) || !isset($_GET['room'])) {
    header("Location: login.php");
    exit();
}

// Initialize variables
$userId = $_SESSION['id'];
$roomCode = $_GET['room'];
$username = $_SESSION['firstName'] . ' ' . $_SESSION['lastName'];
$room = null;
$testCases = [];
$opponentName = '';
$opponentReady = false;
$isCreator = false;
$isOpponent = false;
$userResults = null;
$opponentResults = null;

// Database connection
$conn = new mysqli($host, $user, $pass, $db, $port);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Helper function for database queries
function dbQuery($conn, $query, $params = [], $types = '') {
    $stmt = $conn->prepare($query);
    if (!$stmt) return false;
    
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }
    
    $stmt->execute();
    return $stmt;
}

// Get room details
$stmt = dbQuery($conn, 
    "SELECT r.*, cq.id AS question_id, cq.title, cq.description, 
    cq.input_description, cq.output_description, cq.sample_input, 
    cq.sample_output, cq.test_input, cq.test_output, cq.difficulty
    FROM coding_rooms r
    LEFT JOIN coding_questions cq ON r.question_id = cq.id
    WHERE r.room_code = ?", 
    [$roomCode], "s");
    
if ($stmt) {
    $room = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

if (!$room) {
    $conn->close();
    header("Location: coding_game.php");
    exit();
}

$isCreator = ($room['creator_id'] == $userId);
$isOpponent = ($room['opponent_id'] == $userId);

// Get opponent details
if ($isCreator && $room['opponent_id']) {
    $stmt = dbQuery($conn, 
        "SELECT firstName, lastName FROM users WHERE id = ?", 
        [$room['opponent_id']], "i");
    if ($stmt) {
        $opponent = $stmt->get_result()->fetch_assoc();
        $opponentName = $opponent['firstName'] . ' ' . $opponent['lastName'];
        $opponentReady = $room['opponent_ready'];
        $stmt->close();
    }
} elseif ($isOpponent) {
    $stmt = dbQuery($conn, 
        "SELECT firstName, lastName FROM users WHERE id = ?", 
        [$room['creator_id']], "i");
    if ($stmt) {
        $creator = $stmt->get_result()->fetch_assoc();
        $opponentName = $creator['firstName'] . ' ' . $creator['lastName'];
        $opponentReady = $room['creator_ready'];
        $stmt->close();
    }
}

// Prepare test cases
if ($room['question_id'] && !empty($room['test_input']) && !empty($room['test_output'])) {
    $testCases = [
        [
            'input' => $room['test_input'],
            'output' => $room['test_output']
        ]
    ];
}

// Handle ready action
if (isset($_POST['ready'])) {
    $conn->begin_transaction();
    try {
        $query = $isCreator ? 
            "UPDATE coding_rooms SET creator_ready = TRUE WHERE id = ?" : 
            "UPDATE coding_rooms SET opponent_ready = TRUE WHERE id = ?";
        
        $stmt = dbQuery($conn, $query, [$room['id']], "i");
        $stmt->close();

        // Check if both are ready
        $stmt = dbQuery($conn, 
            "SELECT creator_ready, opponent_ready FROM coding_rooms WHERE id = ?", 
            [$room['id']], "i");
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        if ($result['creator_ready'] && $result['opponent_ready']) {
            // Get random question
            $stmt = dbQuery($conn, 
                "SELECT id, title, description, input_description, 
                output_description, sample_input, sample_output, 
                test_input, test_output 
                FROM coding_questions 
                WHERE is_published = 1 
                AND test_input IS NOT NULL
                AND test_output IS NOT NULL
                ORDER BY RAND() LIMIT 1");
            
            if ($stmt) {
                $question = $stmt->get_result()->fetch_assoc();
                $stmt->close();

                if ($question) {
                    $stmt = dbQuery($conn, 
                        "UPDATE coding_rooms 
                        SET question_id = ?, 
                            status = 'in_progress', 
                            creator_ready = FALSE, 
                            opponent_ready = FALSE,
                            creator_submitted = FALSE,
                            opponent_submitted = FALSE,
                            creator_code = NULL,
                            opponent_code = NULL
                        WHERE id = ?", 
                        [$question['id'], $room['id']], "ii");
                    $stmt->close();

                    // Refresh room data
                    $stmt = dbQuery($conn, 
                        "SELECT r.*, cq.title, cq.description, 
                        cq.input_description, cq.output_description, 
                        cq.sample_input, cq.sample_output, 
                        cq.test_input, cq.test_output
                        FROM coding_rooms r
                        LEFT JOIN coding_questions cq ON r.question_id = cq.id
                        WHERE r.id = ?", 
                        [$room['id']], "i");
                    $room = $stmt->get_result()->fetch_assoc();
                    $stmt->close();

                    // Update test cases
                    if ($room['test_input'] && $room['test_output']) {
                        $testCases = [
                            [
                                'input' => $room['test_input'],
                                'output' => $room['test_output']
                            ]
                        ];
                    }
                }
            }
        }
        $conn->commit();
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error'] = "Error: " . $e->getMessage();
        header("Location: coding_room.php?room=" . $roomCode);
        exit();
    }
}

// Handle code submission
// Handle code submission
if (isset($_POST['submit_code']) && $room['status'] == 'in_progress') {
    $code = $_POST['code'];
    
    $conn->begin_transaction();
    try {
        // Verify question exists
        $stmt = dbQuery($conn, 
            "SELECT id FROM coding_questions WHERE id = ? LIMIT 1", 
            [$room['question_id']], "i");
        
        if (!$stmt->get_result()->fetch_assoc()) {
            throw new Exception("Invalid question ID");
        }
        $stmt->close();

        // Run test cases
        $compiler = new PythonCompiler($code);
        $testResults = $compiler->runTestCases($testCases);
        
        // Prepare result data
        $isCorrect = ($testResults['passed_cases'] == $testResults['total_cases']);
        $verdict = $isCorrect ? "Accepted" : "Wrong Answer";
        $resultData = json_encode([
            'code' => $code,
            'test_results' => $testResults['results'],
            'is_correct' => $isCorrect,
            'verdict' => $verdict
        ]);
        
        $currentTime = date('Y-m-d H:i:s');
        
        // Insert into coding_results
        $stmt = dbQuery($conn, 
            "INSERT INTO coding_results 
            (room_id, user_id, question_id, code, test_cases_passed, 
            total_test_cases, result_data, submitted_at, verdict) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)", 
            [
                $room['id'], 
                $userId, 
                $room['question_id'], 
                $code, 
                $testResults['passed_cases'], 
                $testResults['total_cases'], 
                $resultData,
                $currentTime,
                $verdict
            ], 
            "iiisiisss");
        $stmt->close();
        
        // Update room with submission
        $query = $isCreator ? 
            "UPDATE coding_rooms 
            SET creator_code = ?, creator_submitted = TRUE, creator_time = ? 
            WHERE id = ?" :
            "UPDATE coding_rooms 
            SET opponent_code = ?, opponent_submitted = TRUE, opponent_time = ? 
            WHERE id = ?";
        
        $stmt = dbQuery($conn, $query, 
            [$code, $currentTime, $room['id']], "ssi");
        $stmt->close();
        
        // Check if both have submitted
        $stmt = dbQuery($conn, 
            "SELECT creator_submitted, opponent_submitted FROM coding_rooms WHERE id = ?", 
            [$room['id']], "i");
        $submissionResult = $stmt->get_result()->fetch_assoc();
        $stmt->close();
        
        if ($submissionResult['creator_submitted'] && $submissionResult['opponent_submitted']) {
            $stmt = dbQuery($conn, 
                "UPDATE coding_rooms SET status = 'completed' WHERE id = ?", 
                [$room['id']], "i");
            $stmt->close();
            
            // Get results for both players
            $stmt = dbQuery($conn, 
                "SELECT cr.*, u.firstName, u.lastName 
                FROM coding_results cr
                JOIN users u ON cr.user_id = u.id
                WHERE cr.room_id = ? AND cr.user_id = ? 
                ORDER BY cr.submitted_at DESC LIMIT 1", 
                [$room['id'], $userId], "ii");
            $userResults = $stmt->get_result()->fetch_assoc();
            $stmt->close();
            
            $opponentId = $isCreator ? $room['opponent_id'] : $room['creator_id'];
            $stmt = dbQuery($conn, 
                "SELECT cr.*, u.firstName, u.lastName 
                FROM coding_results cr
                JOIN users u ON cr.user_id = u.id
                WHERE cr.room_id = ? AND cr.user_id = ? 
                ORDER BY cr.submitted_at DESC LIMIT 1", 
                [$room['id'], $opponentId], "ii");
            $opponentResults = $stmt->get_result()->fetch_assoc();
            $stmt->close();
        }
        
        $conn->commit();
        $_SESSION['success'] = "Code submitted successfully!";
    } catch (Exception $e) {
        $conn->rollback();
        $_SESSION['error'] = "Submission failed: " . $e->getMessage();
    }
}

// Refresh room data
$stmt = dbQuery($conn, 
    "SELECT r.*, cq.title, cq.description, cq.input_description,
    cq.output_description, cq.sample_input, cq.sample_output, 
    cq.test_input, cq.test_output
    FROM coding_rooms r
    LEFT JOIN coding_questions cq ON r.question_id = cq.id
    WHERE r.id = ?", 
    [$room['id']], "i");
if ($stmt) {
    $room = $stmt->get_result()->fetch_assoc();
    $stmt->close();
}

// HTML Output
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Battle Room - <?= htmlspecialchars($roomCode) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/theme/dracula.min.css">
    <style>
        .room-container {
            max-width: 1200px;
            margin: 0 auto;
        }
        .player-status {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .player-card {
            width: 48%;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .creator-card {
            background-color: #e3f2fd;
            border: 2px solid #2196F3;
        }
        .opponent-card {
            background-color: #fff8e1;
            border: 2px solid #FFC107;
        }
        .ready-status {
            font-weight: bold;
            margin-top: 10px;
        }
        .ready-true {
            color: #4CAF50;
        }
        .ready-false {
            color: #F44336;
        }
        .problem-card, .editor-card {
            margin-bottom: 20px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #607D8B;
            color: white;
            font-weight: bold;
        }
        .CodeMirror {
            height: 400px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .test-case {
            margin-bottom: 10px;
            padding: 10px;
            border-radius: 4px;
        }
        .passed {
            background-color: #d4edda;
            border-left: 4px solid #28a745;
        }
        .failed {
            background-color: #f8d7da;
            border-left: 4px solid #dc3545;
        }
        .winner-banner {
            background-color: #28a745;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 1.5rem;
            animation: pulse 2s infinite;
        }
        .loser-banner {
            background-color: #dc3545;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        .tie-banner {
            background-color: #ffc107;
            color: #212529;
            padding: 15px;
            text-align: center;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 1.5rem;
        }
        .room-code-display {
            font-family: monospace;
            font-size: 1.5em;
            letter-spacing: 3px;
            text-align: center;
            margin: 20px 0;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        .waiting-section {
            padding: 20px;
        }
        .code-badge {
            margin: 15px 0;
        }
        .code-badge .badge {
            letter-spacing: 2px;
            font-family: monospace;
            font-size: 1.2rem;
        }
        pre {
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            white-space: pre-wrap;
            word-wrap: break-word;
        }
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.02); }
            100% { transform: scale(1); }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="room-container">
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></div>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']); unset($_SESSION['success']); ?></div>
            <?php endif; ?>
            
            <h2 class="text-center mb-4">Python Coding Battle</h2>
            
            <div class="room-code-display">
                Room Code: <strong><?= htmlspecialchars($roomCode) ?></strong>
            </div>
            
            <div class="player-status">
                <div class="player-card creator-card">
                    <h4><?= htmlspecialchars($username) ?></h4>
                    <p><?= $isCreator ? 'Creator' : 'Opponent' ?></p>
                    <div class="ready-status <?= ($isCreator ? $room['creator_ready'] : $room['opponent_ready']) ? 'ready-true' : 'ready-false' ?>">
                        <?= ($isCreator ? $room['creator_ready'] : $room['opponent_ready']) ? 'READY' : 'NOT READY' ?>
                    </div>
                    <?php if ($room['status'] == 'completed' && ($isCreator ? $room['creator_submitted'] : $room['opponent_submitted'])): ?>
                        <p>Submitted: <?= $isCreator ? $room['creator_time'] : $room['opponent_time'] ?></p>
                    <?php endif; ?>
                </div>
                
                <div class="player-card opponent-card">
                    <h4><?= htmlspecialchars($opponentName ?: 'Waiting for opponent...') ?></h4>
                    <p><?= $isCreator ? 'Opponent' : 'Creator' ?></p>
                    <?php if ($opponentName): ?>
                        <div class="ready-status <?= $opponentReady ? 'ready-true' : 'ready-false' ?>">
                            <?= $opponentReady ? 'READY' : 'NOT READY' ?>
                        </div>
                        <?php if ($room['status'] == 'completed' && ($isCreator ? $room['opponent_submitted'] : $room['creator_submitted'])): ?>
                            <p>Submitted: <?= $isCreator ? $room['opponent_time'] : $room['creator_time'] ?></p>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </div>
            
            <?php if ($room['status'] == 'completed'): ?>
    <?php
    // Create new connection for results display
    $resultsConn = new mysqli($host, $user, $pass, $db, $port);

    // Check for connection error
    if (!$resultsConn->connect_error) {

        // Get user results if not already available
        if (!$userResults) {
            $stmt = dbQuery($resultsConn, 
                "SELECT cr.*, u.firstName, u.lastName 
                 FROM coding_results cr
                 JOIN users u ON cr.user_id = u.id
                 WHERE cr.room_id = ? AND cr.user_id = ? 
                 ORDER BY cr.submitted_at DESC LIMIT 1", 
                [$room['id'], $userId], "ii");

            if ($stmt) {
                $userResults = $stmt->get_result()->fetch_assoc();
                $stmt->close();
            }
        }

        // Get opponent results if not already available
        if (!$opponentResults) {
            $opponentId = $isCreator ? $room['opponent_id'] : $room['creator_id'];

            $stmt = dbQuery($resultsConn, 
                "SELECT cr.*, u.firstName, u.lastName 
                 FROM coding_results cr
                 JOIN users u ON cr.user_id = u.id
                 WHERE cr.room_id = ? AND cr.user_id = ? 
                 ORDER BY cr.submitted_at DESC LIMIT 1", 
                [$room['id'], $opponentId], "ii");

            if ($stmt) {
                $opponentResults = $stmt->get_result()->fetch_assoc();
                $stmt->close();
            }
        }

        $resultsConn->close();

        // Determine winner
        $userCorrect = $userResults ? json_decode($userResults['result_data'], true)['is_correct'] : false;
        $opponentCorrect = $opponentResults ? json_decode($opponentResults['result_data'], true)['is_correct'] : false;

        $userTime = $isCreator ? $room['creator_time'] : $room['opponent_time'];
        $opponentTime = $isCreator ? $room['opponent_time'] : $room['creator_time'];

        if ($userCorrect && (!$opponentCorrect || strtotime($userTime) < strtotime($opponentTime))) {
            echo '<div class="winner-banner">You Won! 🎉</div>';
        } elseif ($opponentCorrect && (!$userCorrect || strtotime($opponentTime) < strtotime($userTime))) {
            echo '<div class="loser-banner">You Lost 😢</div>';
        } elseif ($userCorrect && $opponentCorrect) {
            echo '<div class="tie-banner">It\'s a Tie! 🤝</div>';
        } else {
            echo '<div class="tie-banner">No Winner - Both Solutions Failed</div>';
        }
    } else {
        echo "Database connection error: " . $resultsConn->connect_error;
    }
    ?>

                
                <div class="card mt-4">
                    <div class="card-header">
                        <h3>Battle Results</h3>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Your Submission</h4>
                                <?php if ($userResults): ?>
                                    <p><strong>Status:</strong> <?= $userCorrect ? 'Correct ✅' : 'Incorrect ❌' ?></p>
                                    <p><strong>Submitted At:</strong> <?= $userResults['submitted_at'] ?></p>
                                    <p><strong>Test Cases Passed:</strong> <?= $userResults['test_cases_passed'] ?>/<?= $userResults['total_test_cases'] ?></p>
                                    
                                    <?php if (isset(json_decode($userResults['result_data'], true)['test_results'])): ?>
                                        <div class="mt-3">
                                            <h5>Test Case Details:</h5>
                                            <?php foreach (json_decode($userResults['result_data'], true)['test_results'] as $i => $test): ?>
                                                <div class="test-case <?= $test['is_correct'] ? 'passed' : 'failed' ?>">
                                                    <strong>Test Case <?= $i+1 ?>: <?= $test['is_correct'] ? 'Passed' : 'Failed' ?></strong>
                                                    <div class="mt-2"><strong>Input:</strong> <pre><?= htmlspecialchars($test['input']) ?></pre></div>
                                                    <div><strong>Expected Output:</strong> <pre><?= htmlspecialchars($test['expected_output']) ?></pre></div>
                                                    <div><strong>Your Output:</strong> <pre><?= htmlspecialchars($test['actual_output']) ?></pre></div>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <p>No submission data available</p>
                                <?php endif; ?>
                            </div>
                            
                            <div class="col-md-6">
                                <h4>Opponent's Submission</h4>
                                <?php if ($opponentResults): ?>
                                    <p><strong>Name:</strong> <?= htmlspecialchars($opponentResults['firstName'] . ' ' . $opponentResults['lastName']) ?></p>
                                    <p><strong>Status:</strong> <?= $opponentCorrect ? 'Correct ✅' : 'Incorrect ❌' ?></p>
                                    <p><strong>Submitted At:</strong> <?= $opponentResults['submitted_at'] ?></p>
                                    <p><strong>Test Cases Passed:</strong> <?= $opponentResults['test_cases_passed'] ?>/<?= $opponentResults['total_test_cases'] ?></p>
                                <?php else: ?>
                                    <p>No submission data available</p>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <div class="text-center mt-4">
                            <a href="coding_game.php" class="btn btn-primary btn-lg">Return to Lobby</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <div class="row">
                <?php if ($room['status'] == 'waiting' || $room['status'] == 'ready'): ?>
                    <div class="col-12">
                        <div class="card problem-card">
                            <div class="card-header bg-primary text-white">
                                <i class="fas fa-hourglass-half me-2"></i>Waiting Room
                            </div>
                            <div class="card-body text-center">
                                <?php if (!$opponentName): ?>
                                    <div class="waiting-section">
                                        <i class="fas fa-user-clock fa-3x text-muted mb-3"></i>
                                        <h4 class="text-muted">Waiting for opponent to join...</h4>
                                        <div class="room-code-display mt-3">
                                            <p>Share this room code:</p>
                                            <div class="code-badge">
                                                <span class="badge bg-dark fs-4 p-3">
                                                    <i class="fas fa-door-open me-2"></i>
                                                    <?= htmlspecialchars($roomCode) ?>
                                                </span>
                                            </div>
                                            <p class="text-muted mt-2">
                                                <small>Give this code to your opponent to join</small>
                                            </p>
                                        </div>
                                    </div>
                                <?php else: ?>
                                    <div class="ready-section">
                                        <i class="fas fa-users fa-3x text-primary mb-3"></i>
                                        <h4 class="text-primary">Waiting for both players to be ready</h4>
                                        <p class="lead">Click the Ready button when you're prepared to start</p>
                                        
                                        <?php if (!($isCreator ? $room['creator_ready'] : $room['opponent_ready'])): ?>
                                            <form method="POST" class="mt-4">
                                                <button type="submit" name="ready" class="btn btn-success btn-lg py-3 px-4">
                                                    <i class="fas fa-check-circle me-2"></i>
                                                    I'm Ready!
                                                </button>
                                            </form>
                                        <?php else: ?>
                                            <div class="alert alert-info mt-4">
                                                <i class="fas fa-check me-2"></i>
                                                You're ready! Waiting for 
                                                <strong><?= htmlspecialchars($opponentName) ?></strong>...
                                            </div>
                                            <div class="progress mt-3" style="height: 10px;">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated" 
                                                     style="width: 50%"></div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="col-md-6">
                        <div class="card problem-card">
                            <div class="card-header">Problem Statement</div>
                            <div class="card-body">
                                <?php if ($room['status'] == 'in_progress' || $room['status'] == 'completed'): ?>
                                    <?php if ($room['question_id'] && !empty($room['title'])): ?>
                                        <h4><?= htmlspecialchars($room['title']) ?></h4>
                                        <div class="problem-description">
                                            <?= nl2br(htmlspecialchars($room['description'])) ?>
                                        </div>
                                        
                                        <?php if (!empty($room['input_description'])): ?>
                                            <h5 class="mt-4">Input Description</h5>
                                            <p><?= nl2br(htmlspecialchars($room['input_description'])) ?></p>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($room['output_description'])): ?>
                                            <h5>Output Description</h5>
                                            <p><?= nl2br(htmlspecialchars($room['output_description'])) ?></p>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($room['sample_input'])): ?>
                                            <h5 class="mt-4">Sample Input</h5>
                                            <pre><?= htmlspecialchars($room['sample_input']) ?></pre>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($room['sample_output'])): ?>
                                            <h5>Sample Output</h5>
                                            <pre><?= htmlspecialchars($room['sample_output']) ?></pre>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <div class="alert alert-warning">Problem details not available</div>
                                    <?php endif; ?>
                                    
                                    <div class="alert alert-info mt-3">
                                        <strong>Rules:</strong> First correct submission wins! If both are correct, the faster one wins.
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-md-6">
                        <?php if ($room['status'] == 'in_progress' && !($isCreator ? $room['creator_submitted'] : $room['opponent_submitted'])): ?>
                            <div class="card editor-card">
                                <div class="card-header">Python Code Editor</div>
                                <div class="card-body">
                                    <form method="POST">
                                        <textarea id="code" name="code" style="display:none;"><?php 
                                            echo htmlspecialchars($isCreator ? ($room['creator_code'] ?? '# Read input from stdin
# Example: n = int(input())
# Print output to stdout
# Example: print(result)

def main():
    # Your code here
    pass

if __name__ == "__main__":
    main()') : ($room['opponent_code'] ?? '# Read input from stdin
# Example: n = int(input())
# Print output to stdout
# Example: print(result)

def main():
    # Your code here
    pass

if __name__ == "__main__":
    main()'));
                                        ?></textarea>
                                        <div class="mb-3">
                                            <button type="submit" name="submit_code" class="btn btn-primary btn-lg">Submit Solution</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php elseif ($room['status'] == 'in_progress'): ?>
                            <div class="card">
                                <div class="card-header">Submission Complete</div>
                                <div class="card-body">
                                    <p>You've submitted your solution. Waiting for opponent...</p>
                                    <?php if (isset($userResults)): ?>
                                        <p>Your test cases passed: <?= $userResults['test_cases_passed'] ?>/<?= $userResults['total_test_cases'] ?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/codemirror.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.65.2/mode/python/python.min.js"></script>
    
    <script>
        // Initialize CodeMirror editor for Python
        const editor = CodeMirror.fromTextArea(document.getElementById('code'), {
            mode: 'python',
            theme: 'dracula',
            lineNumbers: true,
            indentUnit: 4,
            autofocus: true,
            extraKeys: {
                "Tab": function(cm) {
                    // Convert tabs to 4 spaces
                    cm.replaceSelection("    ", "end");
                },
                "Ctrl-Enter": function() {
                    // Run code on Ctrl+Enter
                    document.getElementById('codeForm').dispatchEvent(new Event('submit'));
                }
            }
        });
        
        // Set default Python code
        editor.setValue(`# Enter your Python code here
def main():
    print("Hello, World!")

if __name__ == "__main__":
    main()`);
        
        // Handle form submission
        document.getElementById('codeForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Get the code from the editor
            const code = editor.getValue();
            
            // Simulate code execution (in a real app, you'd send this to your server)
            document.getElementById('outputResult').textContent = "Executing code...";
            
            // For demo purposes, we'll just show the code
            setTimeout(() => {
                document.getElementById('outputResult').textContent = 
                    "Code submitted:\n\n" + code + 
                    "\n\n(Note: In a real application, this would be sent to your server for execution)";
            }, 500);
            
            // In a real implementation, you would:
            // 1. Send the code to your server via AJAX
            // 2. Handle the response from your compiler.php
            // 3. Display the actual output
        });
        
        // Auto-resize editor on window resize
        window.addEventListener('resize', function() {
            editor.refresh();
        });
        
        <?php if ($room['status'] != 'completed'): ?>
            // Refresh page every 5 seconds to check for updates
            setTimeout(function() {
                window.location.reload();
            }, 50000);
        <?php endif; ?>
    </script>
</body>
</html>
<?php
// Close main connection at the very end
$conn->close();
?>