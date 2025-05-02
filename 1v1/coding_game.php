<?php
session_start();
include '../connect.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

$userId = $_SESSION['id'];
$username = $_SESSION['firstName'] . ' ' . $_SESSION['lastName'];
$error = '';

// Handle room creation
if (isset($_POST['create_room'])) {
    // Generate unique 6-digit room code
    $roomCode = substr(strtoupper(uniqid()), -6);
    
    // Create room
    $stmt = $conn->prepare("INSERT INTO coding_rooms (room_code, creator_id) VALUES (?, ?)");
    $stmt->bind_param("si", $roomCode, $userId);
    
    if ($stmt->execute()) {
        $_SESSION['room_code'] = $roomCode;
        header("Location: coding_room.php?room=" . $roomCode);
        exit();
    } else {
        $error = "Failed to create room. Please try again.";
    }
}

// Handle room joining
if (isset($_POST['join_room'])) {
    $roomCode = strtoupper(trim($_POST['room_code']));
    
    if (!empty($roomCode)) {
        // Check if room exists and has space
        $stmt = $conn->prepare("SELECT * FROM coding_rooms WHERE room_code = ? AND status = 'waiting' AND opponent_id IS NULL AND creator_id != ?");
        $stmt->bind_param("si", $roomCode, $userId);
        $stmt->execute();
        $room = $stmt->get_result()->fetch_assoc();
        
        if ($room) {
            // Join the room
            $stmt = $conn->prepare("UPDATE coding_rooms SET opponent_id = ? WHERE id = ?");
            $stmt->bind_param("ii", $userId, $room['id']);
            
            if ($stmt->execute()) {
                $_SESSION['room_code'] = $roomCode;
                header("Location: coding_room.php?room=" . $roomCode);
                exit();
            } else {
                $error = "Failed to join room. Please try again.";
            }
        } else {
            $error = "Invalid room code or room is full";
        }
    } else {
        $error = "Please enter a room code";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>1v1 Coding Battle</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .game-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .card {
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .card-header {
            background-color: #007bff;
            color: white;
            font-weight: bold;
        }
        .code-display {
            font-family: monospace;
            background-color: #f8f9fa;
            padding: 10px;
            border-radius: 4px;
            font-size: 1.2em;
            letter-spacing: 2px;
            text-align: center;
        }
    </style>
</head>
<body>
    
    <div class="container py-5">
        <div class="game-container">
            <h2 class="text-center mb-4">1v1 Python Coding Battle</h2>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Create a Room</div>
                        <div class="card-body">
                            <p>Create a new battle room and share the code with your opponent.</p>
                            <form method="POST">
                                <button type="submit" name="create_room" class="btn btn-primary">Create Room</button>
                            </form>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">Join a Room</div>
                        <div class="card-body">
                            <p>Join an existing room with a 6-digit code.</p>
                            <form method="POST">
                                <div class="mb-3">
                                    <label for="room_code" class="form-label">Room Code</label>
                                    <input type="text" id="room_code" name="room_code" class="form-control text-uppercase" 
                                           placeholder="Enter 6-digit code" maxlength="6" required>
                                </div>
                                <button type="submit" name="join_room" class="btn btn-success">Join Room</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="card">
                <div class="card-header">How It Works</div>
                <div class="card-body">
                    <ol>
                        <li><strong>Create</strong> a room or <strong>Join</strong> with a code</li>
                        <li>Both players must click <strong>Ready</strong> to start</li>
                        <li>A random Python problem will appear</li>
                        <li>Code your solution and submit</li>
                        <li>First correct submission wins!</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>