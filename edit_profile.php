<?php
session_start();
include 'connect.php';

// Redirect if not logged in
if(!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Get current user data
$userId = $_SESSION['id'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ?");
$stmt->bind_param("i", $userId);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Initialize variables
$firstName = $user['firstName'];
$lastName = $user['lastName'];
$email = $user['email'];
$bio = $user['bio'] ?? '';
$location = $user['location'] ?? '';
$website = $user['website'] ?? '';
$profilePicture = $user['profile_picture'] ?? 'https://via.placeholder.com/100';

$errors = [];
$success = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $bio = trim($_POST['bio']);
    $location = trim($_POST['location']);
    $website = trim($_POST['website']);

    // Validate inputs
    if (empty($firstName)) {
        $errors[] = "First name is required";
    }
    if (empty($lastName)) {
        $errors[] = "Last name is required";
    }

    // Handle file upload
    $uploadOk = true;
    if (!empty($_FILES['profile_picture']['name'])) {
        $targetDir = "uploads/profile_pictures/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = basename($_FILES['profile_picture']['name']);
        $targetFile = $targetDir . uniqid() . '_' . $fileName;
        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

        // Check if image file is a actual image
        $check = getimagesize($_FILES['profile_picture']['tmp_name']);
        if ($check === false) {
            $errors[] = "File is not an image.";
            $uploadOk = false;
        }

        // Check file size (max 2MB)
        if ($_FILES['profile_picture']['size'] > 2000000) {
            $errors[] = "Sorry, your file is too large (max 2MB).";
            $uploadOk = false;
        }

        // Allow certain file formats
        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        if (!in_array($imageFileType, $allowedTypes)) {
            $errors[] = "Only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = false;
        }

        // Upload file if no errors
        if ($uploadOk) {
            if (move_uploaded_file($_FILES['profile_picture']['tmp_name'], $targetFile)) {
                $profilePicture = $targetFile;
            } else {
                $errors[] = "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Update database if no errors
    if (empty($errors)) {
        $stmt = $conn->prepare("UPDATE users SET firstName = ?, lastName = ?, bio = ?, location = ?, website = ?, profile_picture = ? WHERE id = ?");
        $stmt->bind_param("ssssssi", $firstName, $lastName, $bio, $location, $website, $profilePicture, $userId);
        
        if ($stmt->execute()) {
            // Update session variables
            $_SESSION['firstName'] = $firstName;
            $_SESSION['lastName'] = $lastName;
            $success = true;
        } else {
            $errors[] = "Error updating profile: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - Coding Platform</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .profile-img-container {
            position: relative;
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
        }
        .profile-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }
        .upload-btn {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: #fff;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            cursor: pointer;
        }
        .upload-btn input {
            display: none;
        }
        .form-container {
            max-width: 800px;
            margin: 0 auto;
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            padding: 30px;
        }
    </style>
</head>
<body>
    <?php include 'navbar.php'; ?>

    <div class="container py-5">
        <div class="form-container">
            <h2 class="text-center mb-4">Edit Profile</h2>
            
            <?php if ($success): ?>
                <div class="alert alert-success">Profile updated successfully!</div>
            <?php endif; ?>
            
            <?php if (!empty($errors)): ?>
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        <?php foreach ($errors as $error): ?>
                            <li><?php echo htmlspecialchars($error); ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="profile-img-container">
                    <img src="<?php echo htmlspecialchars($profilePicture); ?>" class="profile-img" id="profile-preview">
                    <label class="upload-btn">
                        <i class="fas fa-camera"></i>
                        <input type="file" name="profile_picture" id="profile-upload" accept="image/*">
                    </label>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" 
                               value="<?php echo htmlspecialchars($firstName); ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="lastName" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" 
                               value="<?php echo htmlspecialchars($lastName); ?>" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($email); ?>" disabled>
                </div>
                
                <div class="mb-3">
                    <label for="bio" class="form-label">Bio</label>
                    <textarea class="form-control" id="bio" name="bio" rows="3"><?php echo htmlspecialchars($bio); ?></textarea>
                </div>
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" id="location" name="location" 
                               value="<?php echo htmlspecialchars($location); ?>">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="website" class="form-label">Website</label>
                        <input type="url" class="form-control" id="website" name="website" 
                               value="<?php echo htmlspecialchars($website); ?>">
                    </div>
                </div>
                
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                    <a href="explore.php" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Preview profile picture before upload
        document.getElementById('profile-upload').addEventListener('change', function(e) {
            if (e.target.files.length > 0) {
                const file = e.target.files[0];
                const reader = new FileReader();
                
                reader.onload = function(event) {
                    document.getElementById('profile-preview').src = event.target.result;
                };
                
                reader.readAsDataURL(file);
            }
        });
    </script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>